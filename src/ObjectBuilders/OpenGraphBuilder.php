<?php

namespace TractorCow\OpenGraph\ObjectBuilders;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Storage\DBFile;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\HTTP;
use SilverStripe\Core\Convert;
use SilverStripe\Core\Extensible;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\SS_List;
use TractorCow\OpenGraph\InspectionTrait;
use TractorCow\OpenGraph\Interfaces\IOGApplication;
use TractorCow\OpenGraph\Interfaces\IOpenGraphObjectBuilder;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\IOGObject;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\IOGObjectExplicit;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\IOGProfile;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\Relations\IMediaFile;

/**
 * @author Damian Mooyman
 */
class OpenGraphBuilder implements IOpenGraphObjectBuilder
{
    use Injectable;
    use Extensible;
    use InspectionTrait;

    protected $mimeTypes = null;

    protected function isValueIterable($value)
    {
        return is_array($value) || $value instanceof SS_List;
    }

    protected function isValueLinkable($value)
    {
        return $this->implementsType($value, IOGObject::class)
            || $value instanceof SiteTree;
    }

    /**
     * Provides better fallbackfor {@link HTTP::getMimeType}
     * @param string $file File name or path
     * @return string|null Mime type of the passed in file, if known
     */
    protected function getMimeType($file)
    {
        return HTTP::get_mime_type($file);
    }

    public function AppendTag(&$tags, $name, $content)
    {
        if (empty($content)) {
            return null;
        }

        // Handle repeated elements
        if ($this->isValueIterable($content)) {
            foreach ($content as $item) {
                $this->AppendTag($tags, $name, $item);
            }
            return null;
        }

        // Handle links to resources (either IOGObject or basic SiteTree
        if ($this->isValueLinkable($content)) {
            $this->AppendTag($tags, $name, $content->AbsoluteLink());
            return null;
        }

        // check tag type
        if (is_scalar($content)) {
            return $tags .= sprintf(
                "<meta property=\"%s\" content=\"%s\" />\n",
                Convert::raw2att($name),
                Convert::raw2att($content)
            );
        }

        trigger_error('Invalid tag type: ' . gettype($content), E_USER_ERROR);
    }

    /**
     * Append a list of tags, which may be either an array, or a comma-separated string
     * @param string       $tags  The current tag string to append these to
     * @param string       $name  Meta name attribute value
     * @param array|string $value Tag list
     */
    protected function appendRelatedTags(&$tags, $name, $value)
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        }

        $this->AppendTag($tags, $name, $value);
    }

    /**
     * Generates a <link /> element and appends it to a set of header tags
     * @param string $tags The current tag string to append these to
     * @param string $rel  The rel attribute value
     * @param string $link URL to the linked resource
     * @param string $type Mime type of the resource, if known
     */
    protected function appendLink(&$tags, $rel, $link, $type = null)
    {
        if (empty($rel) || empty($link)) {
            return;
        }

        $tags .= sprintf(
            "<link rel=\"%s\" href=\"%s\" type=\"%s\" />\n",
            Convert::raw2att($rel),
            Convert::raw2att($link),
            $type
                ? $type
                : $this->getMimeType($link)
        );
    }

    /**
     * Builds a list of profile links
     * @param string                                  $tags      The current tag string to append these two
     * @param string                                  $namespace The namespace to use for this element
     * @param IOGProfile[]|IOGProfile|string[]|string $value     A single, or list of profiles
     * @return null|string
     */
    protected function appendRelatedProfileTags(&$tags, $namespace, $value)
    {
        // Treat profiles as generic objects
        return $this->AppendTag($tags, $namespace, $value);
    }

    /**
     * Build a list of linked file tags for the specified value and append them to a string
     * @param string                                              $tags      The current tag string to append these to
     * @param string                                              $namespace The namespace to use for this element
     * @param IMediaFile[]|IMediaFile|File[]|File|string[]|string $value     Either an File object, string to the (non https) image url, or a list of the former
     * @param string                                              $https     The HTTPS url if available
     * @param string                                              $mimeType  type to use, or null to auto detect
     */
    protected function appendMediaMetaTags(&$tags, $namespace, $value, $https = null, $mimeType = null)
    {
        if (empty($value)) {
            return;
        }

        // Handle situation where multiple items are presented
        if ($this->isValueIterable($value)) {
            foreach ($value as $file) {
                $this->appendMediaMetaTags($tags, $namespace, $file, null, $mimeType);
            }
            return;
        }

        // Handle File objects
        /** @var DBFile|File $value */
        if ($value instanceof File || $value instanceof DBFile) {
            if (!$value->exists()) {
                return;
            }

            $this->appendMediaMetaTags($tags, $namespace, $value->getAbsoluteURL(), $https, $mimeType);
            /**
             * If you have the mediadata extension installed, this should correctly populate video width/height elements
             * @link https://github.com/tractorcow/silverstripe-mediadata
             */
            $this->AppendTag($tags, "$namespace:width", $value->getWidth());
            $this->AppendTag($tags, "$namespace:height", $value->getHeight());
            return;
        }

        // Handle IMediaFile objects
        if ($this->implementsType($value, IMediaFile::class)) {
            $this->appendMediaMetaTags($tags, $namespace, $value->getAbsoluteURL(), $value->getSecureURL(), $value->getType());
            $this->AppendTag($tags, "$namespace:width", $value->getWidth());
            $this->AppendTag($tags, "$namespace:height", $value->getHeight());
            return;
        }

        // Handle image URL being given
        if (is_string($value)) {
            // Populate HTTPS url if $value is set to the HTTPS url
            if (preg_match('/^https:/i', $value) && empty($https)) {
                $https = $value;
            }

            // Ensure the main image tag only contains the unsecure url
            $value = preg_replace('/^https:/i', 'http:', $value);

            // Attempt to auto-detect mime type if missing
            if (empty($mimeType)) {
                $mimeType = $this->getMimeType($value);
            }

            // Append image_src meta tag if not present yet
            if (preg_match('/^image.*/', $mimeType) && !strstr($tags, 'rel="image_src"')) {
                $this->appendLink($tags, 'image_src', $value);
            }

            // Build tags
            $this->AppendTag($tags, $namespace, $value);
            if ($https) {
                $this->AppendTag($tags, "$namespace:secure_url", $https);
            }
            $this->AppendTag($tags, "$namespace:type", $mimeType);
            return;
        }

        // Fail if could not determine presented value type
        trigger_error('Invalid file type: ' . gettype($value), E_USER_ERROR);
    }

    protected function appendLocales(&$tags, $locales)
    {
        if (empty($locales)) {
            return;
        }

        // handle case with multiple locales
        if (is_array($locales)) {
            // Loop through all locales
            $mainLocale = array_shift($locales);
            $this->appendLocales($tags, $mainLocale);
            foreach ($locales as $locale) {
                $this->AppendTag($tags, 'og:locale:alternate', $locale);
            }
        } else {
            $this->AppendTag($tags, 'og:locale', $locales);
        }
    }

    /**
     * @param string            $tags
     * @param IOGObjectExplicit $object
     */
    protected function appendDefaultMetaTags(&$tags, $object)
    {
        $this->AppendTag($tags, 'og:title', $object->getOGTitle());
        $this->AppendTag($tags, 'og:type', $object->getOGType());
        $this->AppendTag($tags, 'og:url', $object->AbsoluteLink());
        $this->appendMediaMetaTags($tags, 'og:image', $object->getOGImage());

        // Media fields
        $this->appendMediaMetaTags($tags, 'og:audio', $object->getOGAudio());
        $this->appendMediaMetaTags($tags, 'og:video', $object->getOGVideo());

        // Other optional fields
        $this->AppendTag($tags, 'og:description', $object->getOGDescription());
        $this->AppendTag($tags, 'og:determiner ', $object->getOGDeterminer());
        $this->AppendTag($tags, 'og:site_name', $object->getOGSiteName());
        $this->appendLocales($tags, $object->getOGLocales());

        // Entrypoint for extensions to object tags
        $this->extend('updateDefaultMetaTags', $tags, $object);
    }

    /**
     * @param string         $tags
     * @param IOGApplication $config
     */
    protected function appendApplicationMetaTags(&$tags, $config)
    {
        $this->AppendTag($tags, 'fb:admins', $config->getOGAdminID());
        $this->AppendTag($tags, 'fb:app_id', $config->getOGApplicationID());

        // Entrypoint for extensions to application tags
        $this->extend('updateApplicationMetaTags', $tags, $config);
    }

    protected function appendDateTag(&$tags, $name, $date)
    {
        if (empty($date)) {
            return;
        }

        if (!($date instanceof DBDateTime)) {
            $date = DBDatetime::create_field(DBDatetime::class, $date);
        }

        $this->AppendTag($tags, $name, $date->Rfc3339());
    }

    public function BuildTags(&$tags, $object, $config)
    {
        $this->appendDefaultMetaTags($tags, $object);
        $this->appendApplicationMetaTags($tags, $config);
    }
}

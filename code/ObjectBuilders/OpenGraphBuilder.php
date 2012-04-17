<?php

/**
 * @author Damian Mooyman
 */
abstract class OpenGraphBuilder implements IOpenGraphObjectBuilder
{

    protected $mimeTypes = null;

    protected function isValueIterable($value)
    {
        return is_array($value) || $value instanceof DataObjectSet;
    }
    
    protected function isValueLinkable($value)
    {
        return $value instanceof IOGObject || $value instanceof SiteTree;
    }

    protected function loadMimeTypes()
    {
        if ($this->mimeTypes)
            return;

        $mimePath = realpath(dirname(__FILE__) . '/../etc/mime.types');
        if (!$mimePath || !@file_exists($mimePath))
            return;

        $mimeTypes = file($mimePath);
        $mimeData = array();
        foreach ($mimeTypes as $typeSpec)
        {
            if (!($typeSpec = trim($typeSpec)) || substr($typeSpec, 0, 1) == "#")
                continue;

            $parts = preg_split("/[ \t\r\n]+/", $typeSpec);
            if (sizeof($parts) <= 1)
                continue;

            $mimeType = array_shift($parts);
            foreach ($parts as $ext)
            {
                $ext = strtolower($ext);
                $mimeData[$ext] = $mimeType;
            }
        }

        $this->mimeTypes = $mimeData;
    }

    /**
     * Provides better fallbackfor {@link HTTP::getMimeType}
     * @param string $file File name or path
     * @return string|null Mime type of the passed in file, if known
     */
    protected function getMimeType($file)
    {
        // Check if this file has an extension
        if (strstr($file, '.') === false)
            return null;

        // Use silverstripe mime mechanism
        if ($type = HTTP::getMimeType($file))
            return $type;

        // Load our personal mime cache
        $this->loadMimeTypes();

        $extension = strtolower(substr($file, strrpos($file, '.') + 1));
        if (isset($this->mimeTypes[$extension]))
            return $this->mimeTypes[$extension];
    }

    /**
     * Generates a <meta /> element and appends it to a set of header tags
     * @param string $tags The current tag string to append these to
     * @param string $name Meta name attribute value
     * @param mixed $content Meta content attribute value(s)
     */
    protected function appendTag(&$tags, $name, $content)
    {
        if (empty($content))
            return;

        // Handle repeated elements
        if ($this->isValueIterable($content))
        {
            foreach ($content as $item)
                $this->appendTag($tags, $name, $item);
            return;
        }

        // Handle links to resources (either IOGObject or basic SiteTree
        if ($this->isValueLinkable($content))
            return $this->appendTag($tags, $name, $content->AbsoluteLink());

        // check tag type
        if (is_scalar($content))
            return $tags .= sprintf("<meta name=\"%s\" content=\"%s\" />\n", Convert::raw2att($name),
                    Convert::raw2att($content));

        trigger_error('Invalid tag type: ' . gettype($content), E_USER_ERROR);
    }

    /**
     * Append a list of tags, which may be either an array, or a comma-separated string
     * @param string $tags The current tag string to append these to
     * @param string $name Meta name attribute value
     * @param array|string $value Tag list
     */
    protected function appendRelatedTags(&$tags, $name, $value)
    {
        if (is_string($value))
            $value = explode(',', $value);

        $this->appendTag($tags, $name, $value);
    }

    /**
     * Generates a <link /> element and appends it to a set of header tags
     * @param string $tags The current tag string to append these to
     * @param string $rel The rel attribute value
     * @param string $link URL to the linked resource
     * @param string $type Mime type of the resource, if known
     */
    protected function appendLink(&$tags, $rel, $link, $type = null)
    {
        if (empty($rel) || empty($link))
            return;
        $tags .= sprintf("<link rel=\"%s\" href=\"%s\" type=\"%s\" />\n", Convert::raw2att($rel),
                Convert::raw2att($link),
                $type
                        ? $type
                        : $this->getMimeType($link)
        );
    }

    /**
     * Builds a list of profile links
     * @param string $tags The current tag string to append these two
     * @param string $namespace The namespace to use for this element
     * @param IOGProfile[]|IOGProfile|string[]|string $value A single, or list of profiles
     */
    protected function appendRelatedProfileTags(&$tags, $namespace, $value)
    {
        // Treat profiles as generic objects
        return $this->appendTag($tags, $namespace, $value);
    }

    /**
     * Build a list of linked file tags for the specified value and append them to a string
     * @param string $tags The current tag string to append these to
     * @param string $namespace The namespace to use for this element
     * @param IMediaFile[]|IMediaFile|File[]|File|string[]|string $value Either an File object, string to the (non https) image url, or a list of the former
     * @param string $https The HTTPS url if available
     */
    protected function appendMediaMetaTags(&$tags, $namespace, $value, $https = null)
    {
        if (empty($value))
            return;

        // Handle situation where multiple items are presented
        if ($this->isValueIterable($value))
        {
            foreach ($value as $file)
                $this->appendMediaMetaTags($tags, $namespace, $file);
            return;
        }

        // Handle File objects
        if ($value instanceof File)
        {
            /* @var $value IMediaFile */
            if (!$value->exists())
                return;

            $this->appendMediaMetaTags($tags, $namespace, $value->getAbsoluteURL());
            /**
             * If you have the mediadata extension installed, this should correctly populate video width/height elements
             * @link https://github.com/tractorcow/silverstripe-mediadata
             */
            $this->appendTag($tags, "$namespace:width", $value->Width);
            $this->appendTag($tags, "$namespace:height", $value->Height);
            return;
        }

        // Handle IMediaFile objects
        if ($value instanceof IMediaFile)
        {
            $this->appendMediaMetaTags($tags, $namespace, $value->getAbsoluteURL());
            $this->appendTag($tags, "$namespace:width", $value->getWidth());
            $this->appendTag($tags, "$namespace:height", $value->getHeight());
            return;
        }

        // Handle image URL being given
        if (is_string($value))
        {
            // Populate HTTPS url if $value is set to the HTTPS url
            if (preg_match('/^https:/i', $value) && empty($https))
                $https = $value;

            // Ensure the main image tag only contains the unsecure url
            $value = preg_replace('/^https:/i', 'http:', $value);

            $mimeType = $this->getMimeType($value);

            // Append image_src meta tag if not present yet
            if (preg_match('/^image.*/', $mimeType) && !strstr($tags, 'rel="image_src"'))
                $this->appendLink($tags, 'image_src', $value);

            // Build tags
            $this->appendTag($tags, $namespace, $value);
            if ($https)
                $this->appendTag($tags, "$namespace:secure_url", $https);
            $this->appendTag($tags, "$namespace:type", $mimeType);
            return;
        }

        // Fail if could not determine presented value type
        trigger_error('Invalid file type: ' . gettype($value), E_USER_ERROR);
    }

    protected function appendLocales(&$tags, $locales)
    {
        if (empty($locales))
            return;

        // handle case with multiple locales
        if (is_array($locales))
        {
            // Loop through all locales
            $mainLocale = array_shift($locales);
            $this->appendLocales($tags, $mainLocale);
            foreach ($locales as $locale)
                $this->appendTag($tags, 'og:locale:alternate', $locale);
        }
        else
            $this->appendTag($tags, 'og:locale', $locales);
    }

    protected function appendDefaultMetaTags(&$tags, DataObject $object)
    {
        /* @var $object IOGObjectExplicit */
        $this->appendTag($tags, 'og:title', $object->getOGTitle());
        $this->appendTag($tags, 'og:type', $object->getOGType());
        $this->appendTag($tags, 'og:url', $object->AbsoluteLink());
        $this->appendMediaMetaTags($tags, 'og:image', $object->OGImage());

        // Media fields
        $this->appendMediaMetaTags($tags, 'og:audio', $object->OGAudio());
        $this->appendMediaMetaTags($tags, 'og:video', $object->OGVideo());

        // Other optional fields
        $this->appendTag($tags, 'og:description', $object->getOGDescription());
        $this->appendTag($tags, 'og:determiner ', $object->getOGDeterminer());
        $this->appendTag($tags, 'og:site_name', $object->getOGSiteName());
        $this->appendLocales($tags, $object->getOGLocales());
    }

    protected function appendApplicationMetaTags(&$tags, SiteConfig $config)
    {
        /* @var $config IOGApplication */
        $this->appendTag($tags, 'fb:admins', $config->getOGAdminID());
        $this->appendTag($tags, 'fb:app_id', $config->getOGApplicationID());
        
        //optional OG fields from SiteConfig
        $this->appendTag($tags, 'og:locality', $config->getOGlocality());
        $this->appendTag($tags, 'og:country-name', $config->getOGcountryName());
    }

    protected function appendDateTag(&$tags, $name, $date)
    {
        if (empty($date))
            return;

        if (!($date instanceof DateTime))
            $date = new DateTime($date);

        $this->appendTag($tags, $name, $date->format(DateTime::ISO8601));
    }

    public function BuildTags(&$tags, $object, $config)
    {
        $this->appendDefaultMetaTags($tags, $object);
        $this->appendApplicationMetaTags($tags, $config);
    }

}
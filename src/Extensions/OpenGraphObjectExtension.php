<?php

namespace TractorCow\OpenGraph\Extensions;

use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\SSViewer;
use TractorCow\OpenGraph\Constants\OGDeterminers;
use TractorCow\OpenGraph\Constants\OGTypes;
use TractorCow\OpenGraph\Interfaces\IOpenGraphObjectBuilder;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\IOGObjectExplicit;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Music\IOGMusic;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\IOGArticle;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\IOGBook;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\IOGProfile;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\IOGWebsite;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Video\IOGVideo;
use TractorCow\OpenGraph\OpenGraph;

/**
 * Adds open graph functionality to a page or data object
 *
 * @author Damian Mooyman
 * @property DataObject|OpenGraphObjectExtension $owner
 */
class OpenGraphObjectExtension extends DataExtension implements IOGObjectExplicit
{
    use Configurable;

    /**
     * The default image to use
     *
     * @config
     * @var string
     */
    private static $default_image = 'tractorcow/silverstripe-opengraph: images/logo.gif';

    /**
     * Property for retrieving the opengraph namespace html tag(s).
     * This should be inserted into your Page.SS template as: "<html $OGNS>"
     * @return string The HTML tag to use for the opengraph namespace(s)
     */
    public function getOGNS()
    {
        // todo : Should custom namespace be injected here, or left up to user code?
        $ns = ' prefix="og: http://ogp.me/ns#  fb: http://www.facebook.com/2008/fbml';
        if ($this->owner instanceof IOGMusic) {
            $ns .= ' music: http://ogp.me/ns/music#';
        }
        if ($this->owner instanceof IOGVideo) {
            $ns .= ' video: http://ogp.me/ns/video#';
        }
        if ($this->owner instanceof IOGArticle) {
            $ns .= ' article: http://ogp.me/ns/article#';
        }
        if ($this->owner instanceof IOGBook) {
            $ns .= ' book: http://ogp.me/ns/book#';
        }
        if ($this->owner instanceof IOGProfile) {
            $ns .= ' profile: http://ogp.me/ns/profile#';
        }
        if ($this->owner instanceof IOGWebsite || $this->owner->getOGType() == OGTypes::DEFAULT_TYPE) {
            $ns .= ' website: http://ogp.me/ns/website#';
        }
        $ns .= '"';

        return $ns;
    }


    /**
     * Determines the tag builder to use for this object
     * @return IOpenGraphObjectBuilder
     */
    public function getTagBuilder()
    {
        // Determine type
        $type = $this->owner->getOGType();

        // Case for non-types
        if (empty($type)) {
            return null;
        }

        // Determine type, if configured
        $prototype = OpenGraph::get_prototype($type);
        if (!empty($prototype['tagbuilder'])) {
            $class = $prototype['tagbuilder'];
        } else {
            $class = OpenGraph::get_default_tagbuilder();
        }

        // Construct instance from type
        return new $class();
    }

    public function MetaTags(&$tags)
    {
        // Generate tag builder
        $builder = $this->owner->getTagBuilder();
        if (!$builder) {
            return;
        }

        $config = SiteConfig::current_site_config();
        // Default tags
        $builder->BuildTags($tags, $this->owner, $config);
    }

    /**
     * Determines the opengraph type identifier for this object
     * @return string
     */
    public function getOGType()
    {
        if ($type = OpenGraph::get_object_type($this->owner)) {
            return $type;
        }

        return OGTypes::DEFAULT_TYPE;
    }

    public function getOGTitle()
    {
        /**
         * @see DataObject::getTitle()
         */
        return $this->owner->Title;
    }

    public function getOGSiteName()
    {
        $config = SiteConfig::current_site_config();
        return $config->Title;
    }

    public function getOGImage()
    {
        // If a theme is in use, check if a default image is provided (theme_name_default_image)
        // This is useful to have a different default image on sub sites
        if (SSViewer::config()->uninherited('theme_enabled') === true) {
            $themes = SSViewer::get_themes();
            if (isset($themes[0])) {
                $themeName = preg_replace('/[^\w ]+/ ', '_', strtolower($themes[0]));
                $config = $themeName . '_default_image';

                if ($image = self::config()->{$config}) {
                    return Director::absoluteURL(ModuleResourceLoader::resourceURL($image));
                }
            }
        }

        // Since og:image is a required property, provide a reasonable default
        if ($image = self::config()->default_image) {
            return Director::absoluteURL(ModuleResourceLoader::resourceURL($image));
        }
        return '';
    }

    public function AbsoluteLink()
    {
        // Left blank by default. Implement this in the decorated class to determine correct value
    }

    public function getOGAudio()
    {
        // No audio by default
    }

    public function getOGVideo()
    {
        // No video by default
    }

    public function getOGDescription()
    {
        // Check MetaDescription has given content
        if ($this->owner->hasField('MetaDescription')) {
            $description = trim($this->owner->MetaDescription);
            if (!empty($description)) {
                return $description;
            }
        }

        // Intelligent fallback for SiteTree instances
        $contentField = $this->owner->dbObject('Content');
        if ($contentField instanceof DBText) {
            return $contentField->Summary(100);
        }
        return $contentField;
    }

    public function getOGDeterminer()
    {
        return OGDeterminers::DEFAULT_VALUE;
    }

    public function getOGLocales()
    {
        // Use current locale
        $locale = i18n::get_locale();

        // Check locale is valid
        if (OpenGraph::is_locale_valid($locale)) {
            return $locale;
        }

        // Return default
        return OpenGraph::get_default_locale();
    }
}

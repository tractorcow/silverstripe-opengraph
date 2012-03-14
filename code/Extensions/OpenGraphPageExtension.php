<?php

/**
 * Adds open graph functionality to a page or data object
 *
 * @author Damian Mooyman
 */
class OpenGraphPageExtension extends DataObjectDecorator implements IOGObjectExplicit
{
    public static $default_image = '/opengraph/images/logo.gif';
    public static $builder_class = 'OpenGraphTagBuilder';
    
    /**
     * @var IMetaTagBuilder
     */
    protected $tagBuilder = null;
    
    public function __construct()
    {
        parent::__construct();
        $this->tagBuilder = new self::$builder_class();
    }

    /**
     * Property for retrieving the opengraph namespace html tag(s).
     * This should be inserted into your Page.SS template as: "<html $OGNS>"
     * @return string The HTML tag to use for the opengraph namespace(s)
     */
    public function getOGNS()
    {
        $ns = ' xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml"';
        if ($this->owner instanceof IOGMusic)
            $ns .= ' xmlns:music="http://ogp.me/ns/music#"';
        if ($this->owner instanceof IOGVideo)
            $ns .= ' xmlns:video="http://ogp.me/ns/video#"';
        if ($this->owner instanceof IOGArticle)
            $ns .= ' xmlns:article="http://ogp.me/ns/article#"';
        if ($this->owner instanceof IOGBook)
            $ns .= ' xmlns:book="http://ogp.me/ns/book#"';
        if ($this->owner instanceof IOGProfile)
            $ns .= ' xmlns:profile="http://ogp.me/ns/profile#"';

        // Since the default type is website we should make sure that the correct namespace is applied in the default case
        if ($this->owner instanceof IOGWebsite || $this->owner->getOGType() == OGTypes::DefaultType)
            $ns .= ' xmlns:website="http://ogp.me/ns/website#"';

        return $ns;
    }


    public function MetaTags(&$tags)
    {
        // Default tags
        $this->tagBuilder->BuildTags($tags, $this->owner);
    }

    /**
     * Determines the opengraph type identifier for this object
     * @return string
     */
    public function getOGType()
    {
        // music types
        if ($this->owner instanceof IOGMusicAlbum)
            return OGTypes::Music_Album;
        if ($this->owner instanceof IOGMusicPlaylist)
            return OGTypes::Music_Playlist;
        if ($this->owner instanceof IOGMusicRadioStation)
            return OGTypes::Music_RadioStation;
        if ($this->owner instanceof IOGMusicSong)
            return OGTypes::Music_Song;

        // video types
        if ($this->owner instanceof IOGVideoEpisode)
            return OGTypes::Video_Episode;
        if ($this->owner instanceof IOGVideoTVShow)
            return OGTypes::Video_TVShow;
        if ($this->owner instanceof IOGVideoMovie)
            return OGTypes::Video_Movie;
        if ($this->owner instanceof IOGVideoOther)
            return OGTypes::Video_Other;

        // no-vertical types
        if ($this->owner instanceof IOGProfile)
            return OGTypes::Profile;
        if ($this->owner instanceof IOGArticle)
            return OGTypes::Article;
        if ($this->owner instanceof IOGBook)
            return OGTypes::Book;
        if ($this->owner instanceof IOGWebsite)
            return OGTypes::Website;

        return OGTypes::DefaultType;
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

    public function OGImage()
    {
        // Since og:image is a required property, provide a reasonable default
        if (self::$default_image)
            return Director::absoluteURL(self::$default_image);
    }

    public function AbsoluteLink()
    {
        // Left blank by default. Implement this in the decorated class to determine correct value
    }

    public function OGAudio()
    {
        // No audio by default
    }

    public function OGVideo()
    {
        // No video by defalut
    }

    public function getOGDescription()
    {
        // Intelligent fallback for SiteTree instances
        $contentField = $this->owner->dbObject('Content');
        if ($contentField instanceof Text)
            return $contentField->FirstParagraph();
    }

    public function getOGDeterminer()
    {
        return OGDeterminers::DefaultValue;
    }

    public function getOGLocales()
    {
        return i18n::get_locale();
    }

}
<?php

class OpenGraph
{
    /**
     * Flag to indicate whether this module should attempt to automatically load itself
     * @var boolean
     */
    public static $auto_load = true;
    public static $page_extension_class = 'OpenGraphPageExtension';
    public static $siteconfig_extension_class = 'OpenGraphSiteConfigExtension';
    
    /**
     * registration of all object types. The key is the value of the og:type tag, and the value 
     * is an array containing any required interface for the implemented object, and the
     * classname which will be used to generate tags from the properties of that interface 
     */
    public static $object_types = array(
        // Music types
        OGTypes::Music_Album => array('IOGMusicAlbum', 'OGMusicAlbum'),
        OGTypes::Music_Playlist => array('IOGMusicPlaylist', 'OGMusicPlaylist'),
        OGTypes::Music_RadioStation => array('IOGMusicRadioStation', 'OGMusicRadioStation'),
        OGTypes::Music_Song => array('IOGMusicSong', 'OGMusicSong'),
        
        // Video types
        OGTypes::Video_Episode => array('IOGVideoEpisode', 'OGVideoEpisode'),
        OGTypes::Video_TVShow => array('IOGVideoTVShow', 'OGVideoTVShow'),
        OGTypes::Video_Movie => array('IOGVideoMovie', 'OGVideoMovie'),
        OGTypes::Video_Other => array('IOGVideoOther', 'OGVideoOther'),
        
        // Non-vertical types
        OGTypes::Profile => array('IOGProfile', 'OGProfile'),
        OGTypes::Article => array('IOGArticle', 'OGArticle'),
        OGTypes::Book => array('IOGBook', 'OGBook'),
        OGTypes::Website => array('IOGWebsite', 'OGWebsite')
    );
    
    /**
     * Registers a new Opengraph object type
     * @param string $type The value of the og:type property
     * @param string $requiredInterface The name of the interface required for objects. Must extend {@link IOGObject}
     * @param string $tagBuilderClass The class name which takes an object implementing the $requiredInterface interface
     * and generates meta tags. Must implement {@link IOpenGraphObjectBuilder}
     */
    public static function register_type($type, $requiredInterface, $tagBuilderClass)
    {
        self::$object_types[$type] = array($requiredInterface, $tagBuilderClass);
    }
    
    public static function load()
    {
        Object::add_extension('Page', self::$page_extension_class);
        Object::add_extension('SiteConfig', self::$siteconfig_extension_class);
    }
    
    /**
     * Configure the site to use an application ID. Specifying no $applicationID
     * will cause the app to be managed via a SiteConfig field
     * @param string $applicationID The appID for this site, or left blank if this should be
     * configured via the site config
     */
    public static function set_application($applicationID = 'SiteConfig')
    {
        OpenGraphSiteConfigExtension::$application_id = $applicationID;
    }
    
    /**
     * Configure the site to use an admin ID. Specifying no $adminID
     * will cause the app to be managed via a SiteConfig field
     * @param string $adminID The adminID(s) for this site, or left blank if this should be
     * configured via the site config
     */
    public static function set_admin($adminID = 'SiteConfig')
    {
        OpenGraphSiteConfigExtension::$admin_id = $adminID;
    }
}
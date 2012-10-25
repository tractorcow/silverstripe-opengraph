<?php

class OpenGraph {
	/**
	 * Flag to indicate whether this module should attempt to automatically load itself
	 * @var boolean
	 */
	public static $auto_load = true;

	public static $page_extension_class = 'OpenGraphPageExtension';

	public static $siteconfig_extension_class = 'OpenGraphSiteConfigExtension';

	/**
	 * Registers a new Opengraph object type
	 * @param string $type The value of the og:type property
	 * @param string $requiredInterface The name of the interface required for objects. Must extend {@link IOGObject}
	 * @param string $tagBuilderClass The class name which takes an object implementing the $requiredInterface interface
	 * and generates meta tags. Must implement {@link IOpenGraphObjectBuilder}
	 */
	public static function register_type($type, $requiredInterface, $tagBuilderClass) {
		Config::inst()->update('OpenGraph', 'types', array(
			$type => array(
				'interface' => $requiredInterface,
				'tagbuilder' => $tagBuilderClass
			)
		));
	}

	/**
	 * Retrieve the prototype (identifying interface and tag builder class) given an opengraph type
	 * @param string $type Open Graph type identifier
	 * @return array Prototype in the form of as associative array with the keys "interface" and "tagbuilder"
	 */
	public static function get_prototype($type) {
		$types = Config::inst()->get('OpenGraph', 'types');
		Debug::dump($types); die;
		if(isset($types[$type])) return $types[$type];
	}

	/**
	 * Determines the type of the object by the interfaces that it implements
	 * @param object $object Open Graph object
	 * @return string the Open Graph type identifier
	 */
	public static function get_object_type($object) {
		
		$types = Config::inst()->get('OpenGraph', 'types');
		
		foreach ($types as $type => $details) {
			$interface = $details['interface'];
			if ($object instanceof $interface) return $type;
		}
	}

	public static function load() {
		Object::add_extension('Page', self::$page_extension_class);
		Object::add_extension('SiteConfig', self::$siteconfig_extension_class);
	}

	/**
	 * Configure the site to use an application ID. Specifying no $applicationID
	 * will cause the app to be managed via a SiteConfig field
	 * @param string $applicationID The appID for this site, or left blank if this should be
	 * configured via the site config
	 */
	public static function set_application($applicationID = 'SiteConfig') {
		OpenGraphSiteConfigExtension::$application_id = $applicationID;
	}

	/**
	 * Configure the site to use an admin ID. Specifying no $adminID
	 * will cause the app to be managed via a SiteConfig field
	 * @param string $adminID The adminID(s) for this site, or left blank if this should be
	 * configured via the site config
	 */
	public static function set_admin($adminID = 'SiteConfig') {
		OpenGraphSiteConfigExtension::$admin_id = $adminID;
	}

}
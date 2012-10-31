<?php

/**
 * Simple wrapper for opengraph settings
 */
class OpenGraph {

	/**
	 * Registers a new Opengraph object type
	 * @param string $type The value of the og:type property
	 * @param string $identifyingInterface The name of the interface required to identify objects. Must extend {@link IOGObject}
	 * @param string $tagBuilderClass The class name which takes an object implementing the $requiredInterface interface
	 * and generates meta tags. Must implement {@link IOpenGraphObjectBuilder}. The default builder will be used if none
	 * is given
	 */
	public static function register_type($type, $identifyingInterface, $tagBuilderClass = null) {
		self::set_config('types', array(
			$type => array(
				'interface' => $identifyingInterface,
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
		$types = self::get_config('types');
		if(isset($types[$type])) return $types[$type];
	}

	/**
	 * Determines the type of the object by the interfaces that it implements
	 * @param object $object Open Graph object
	 * @return string the Open Graph type identifier
	 */
	public static function get_object_type($object) {
		
		$types = self::get_config('types');
		
		foreach ($types as $type => $details) {
			$interface = $details['interface'];
			if ($object instanceof $interface) return $type;
		}
	}
	
	/**
	 * Retrieves the configured field, or "SiteConfig" if this should be
	 * managed through the siteconfig instead of yaml configuration
	 * @return string Value of the configured field
	 */
	public static function get_config($field) {
		return Config::inst()->get('OpenGraph', $field);
	}

	/**
	 * Configure the site to use a specified value for a field. Specifying 'SiteConfig'
	 * will cause the value for this field to be managed via the SiteConfig
	 * @param string $field
	 * @param string $value 
	 */
	public static function set_config($field, $value = 'SiteConfig') {
		Config::inst()->update('OpenGraph', $field, $value);
	}
	
	/**
	 * Sets the application ID of this site, or 'SiteConfig' to manage in CMS
	 * @param string $value 
	 */
	public static function set_application($value) {
		self::set_config('application_id', $value);
	}
	
	/**
	 * Sets the admin ID of this site, or 'SiteConfig' to manage in CMS
	 * @param string $value 
	 */
	public static function set_admin($value) {
		self::set_config('admin_id', $value);
	}
	
	/**
	 * Retrieves the default class used to build tags
	 * @return type 
	 */
	public static function get_default_tagbuilder() {
		return self::get_config('default_tagbuilder');
	}
	
	/**
	 * Retrieves the list of all allowed opengraph locales
	 * @return array Associative array of locale to name. E.g. en_UK => 'English (UK)'
	 */
	public static function get_locales() {
		return self::get_config('locales');
	}
	
	public static function get_default_locale() {
		return self::get_config('default_locale');
	}
	
	/**
	 * Check if a given locale is valid
	 * @param string $locale Locale to test in en_NZ format
	 * @return boolean
	 */
	public static function is_locale_valid($locale) {
		$locales = self::get_locales();
		return isset($locales[$locale]);
	}

}
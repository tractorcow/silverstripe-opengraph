<?php

/**
 * @author Damian Mooyman
 */
interface IOpenGraphObjectBuilder
{   
	/**
	 * Generates meta tags for the object
	 * @param string $tags The current tag string to append these to
	 * @param mixed $object The entity to extract opengraph data from. {@see IOGObjectExplicit}
	 * @param mixed $config The SiteConfig representing the application. {@see IOGApplication}
	 */
	public function BuildTags(&$tags, $object, $config);
	
	
	/**
	 * Generates a <meta /> element and appends it to a set of header tags.
	 * Public to allow use by extensions to OpenGraphbuilder
	 * @param string $tags The current tag string to append these to
	 * @param string $name Meta name attribute value
	 * @param mixed $content Meta content attribute value(s)
	 */
	public function AppendTag(&$tags, $name, $content);
}
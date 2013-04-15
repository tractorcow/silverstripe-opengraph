<?php

/**
 * Interface encompassing required fields for an opengraph object.
 * This interface may be used on any data object that explicitly defines mandatory methods, as opposed to 
 * classes that may instead implement those methods in decorators, but it is not necessary to do so as long
 * as these are implemented in those decorators.
 * @author Damian Mooyman
 * @see IOGObject
 */
interface IOGObjectRequired extends IOGObject
{
	/**
	 * Determines the OpenGraph Title
	 * 
	 * @return string|null|false Title of this object, false to omit this field, or null to fall back to intelligent default
	 */
	function getOGTitle();
	
	/**
	 * Determines the OpenGraph type as defined at {@link http://ogp.me/#types}
	 * 
	 * @link http://ogp.me/#types
	 * @link http://graph.facebook.com/schema/og/music
	 * @return string|null|false Title of this object, false to omit this field, or null to fall back to intelligent default
	 */
	function getOGType();
	
	/**
	 * Determines the image(s) to use for this object
	 * Image should be at least 200px by 200px, with 1500px by 1500px preferred, and less than 5MB in size.
	 * 
	 * @return Image[]|Image|string[]|string The image(s) or url(s) to image(s)
	 */
	function getOGImage();
}

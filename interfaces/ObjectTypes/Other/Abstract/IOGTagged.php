<?php

/**
 * @author Damian Mooyman
 */
interface IOGTagged extends IOGObject
{
	/**
	 * The tag, comma-separated list of tags, or array of tags associated with this object
	 * @return string[]|string 
	 */
	function getOGTags();
}
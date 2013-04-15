<?php

/**
 * @author Damian Mooyman
 */
interface IOGAuthoredTagged extends IOGTagged
{
	/**
	 * The author(s) of this object
	 * @return IOGProfile[]|IOGProfile|string[]|string Author object(s) or url(s) to profile of author(s)
	 */
	function getOGAuthors();
}
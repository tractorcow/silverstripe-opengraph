<?php

/**
 * @author Damian Mooyman
 */
interface IOGBook extends IOGAuthoredTagged
{
	/**
	 * Returns the release date of this book
	 * @return DateTime|string The date of release 
	 */
	function getOGBookReleaseDate();
	
	/**
	 * Returns the ISBN of this book
	 * @return string The ISBN 
	 */
	function getOGBookISBN();
}

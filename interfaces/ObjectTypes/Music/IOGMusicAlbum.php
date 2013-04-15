<?php

/**
 *
 * @author Damian Mooyman
 */
interface IOGMusicAlbum extends IOGMusicSongList {
	
	/**
	 * Returns the release date of this album
	 * @return DateTime|string The date of release 
	 */
	function getOGMusicReleaseDate();
	
	/**
	 * The musician(s) who composed this object
	 * @return IOGProfile[]|IOGProfile|string[]|string Musican profile(s) or url(s) to profile(s)
	 */
	function getOGMusicMusicians();
}
<?php

/**
 * @author Damian Mooyman
 */
interface IOGSongAlbum
{
	/**
	 * The song
	 * @return IOGMusicSong|string Song or url to song
	 */
	function getOGSong();
	
	/**
	 * The album
	 * @return IOGMusicAlbum|string Album or url to album
	 */
	function getOGAlbum();
	
	/**
	 * The disc number where this song appears on this album
	 * @return integer The disc number
	 */
	function getOGDisc();
	
	/**
	 * The track number where this song appears on this album
	 * @return integer The track number
	 */
	function getOGTrack();
	
}
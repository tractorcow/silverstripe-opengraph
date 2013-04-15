<?php

/**
 * @author Damian Mooyman
 */
interface IOGMusicSong extends IOGMusic {
	
	/**
	 * The duration of the song in seconds
	 * @return int Duration in seconds 
	 */
	function getOGMusicDuration();
	
	/**
	 * The album(s) this song belongs to
	 * @return IOGSongAlbum[]|IOGSongAlbum|IOGMusicAlbum[]|IOGMusicAlbum|string[]|string Album(s) related to this 
	 * song or url(s) to album(s)
	 */
	function getOGMusicAlbums();
	
	/**
	 * The musician(s) who composed this object
	 * @return IOGProfile[]|IOGProfile|string[]|string Musican profile(s) or url(s) to profile(s)
	 */
	function getOGMusicMusicians();
}
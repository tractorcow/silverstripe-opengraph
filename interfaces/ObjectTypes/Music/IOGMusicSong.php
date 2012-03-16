<?php

/**
 * @author Damian Mooyman
 */
interface IOGMusicSong extends IOGMusicComposed {
    
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
    function OGMusicAlbums();
}
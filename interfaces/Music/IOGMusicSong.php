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
     * @return IOGSongAlbum[]|IOGSongAlbum|IOGMusicAlbum[]|IOGMusicAlbum Either a single albumn or list of albums
     */
    function OGMusicAlbums();
}
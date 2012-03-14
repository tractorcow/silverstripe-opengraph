<?php

/**
 *
 * @author Damian Mooyman
 */
interface IOGMusicAlbum extends IOGMusicSongList, IOGMusicComposed {
    
    /**
     * Returns the release date of this album
     * @return DateTime The date of release 
     */
    function getOGMusicReleaseDate();
}
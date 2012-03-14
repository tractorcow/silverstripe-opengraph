<?php

/**
 * @author Damian Mooyman
 */
interface IOGSongAlbum
{
    /**
     * The song
     * @return IOGMusicSong 
     */
    function OGSong();
    
    /**
     * The album
     * @return IOGMusicAlbum 
     */
    function OGAlbum();
    
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
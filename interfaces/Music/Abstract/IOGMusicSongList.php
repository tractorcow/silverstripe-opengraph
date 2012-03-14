<?php

/**
 * @author Damian Mooyman
 */
interface IOGMusicSongList extends IOGMusic
{
    /**
     * The song(s) in this list
     * @return IOGSongAlbum[]|IOGSongAlbum|IOGMusicSong[]|IOGMusicSong Either a single song or list of songs
     */
    function OGMusicSongs();
}

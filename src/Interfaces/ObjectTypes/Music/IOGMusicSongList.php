<?php

namespace TractorCow\OpenGraph\Interfaces\ObjectTypes\Music;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Music\Relations\IOGSongAlbum;

/**
 * @author Damian Mooyman
 */
interface IOGMusicSongList extends IOGMusic
{
    /**
     * The song(s) in this list
     * @return IOGSongAlbum[]|IOGSongAlbum|IOGMusicSong[]|IOGMusicSong|string[]|string Song object(s) or url(s) to object(s)
     */
    function getOGMusicSongs();
}

<?php

namespace TractorCow\OpenGraph\Interfaces\ObjectTypes\Music;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\IOGProfile;

/**
 *
 * @author Damian Mooyman
 */
interface IOGMusicRadioStation extends IOGMusic
{

    /**
     * The creator(s) of this object
     * @return IOGProfile[]|IOGProfile|string[]|string Creator profile object(s) or url(s) to profile(s)
     */
    function getOGMusicCreators();
}

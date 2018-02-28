<?php

namespace TractorCow\OpenGraph\Interfaces\ObjectTypes\Video;

/**
 *
 * @author Damian Mooyman
 */
interface IOGVideoEpisode extends IOGVideo
{
    /**
     * Determines the serious this episode belongs to
     * @return IOGVideoTVShow|string The series object or url to series
     */
    function getOGVideoSeries();
}

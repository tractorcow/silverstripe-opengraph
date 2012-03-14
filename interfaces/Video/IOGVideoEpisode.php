<?php

/**
 *
 * @author Damian Mooyman
 */
interface IOGVideoEpisode extends IOGVideo
{
    /**
     * Determines the serious this episode belongs to
     * @return IOGVideoTVShow
     */
    function OGVideoSeries();
}

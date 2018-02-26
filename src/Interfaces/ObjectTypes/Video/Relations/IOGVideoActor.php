<?php

namespace TractorCow\OpenGraph\Interfaces\ObjectTypes\Video\Relations;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\IOGProfile;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Video\IOGVideo;

/**
 * Represents
 * @author Damian Mooyman
 */
interface IOGVideoActor
{
    /**
     * The role this actor played in this movie
     * @return string The role name
     */
    function getOGRole();

    /**
     * The video
     * @return IOGVideo|string The video object or url to video
     */
    function getOGVideo();

    /**
     * The profile of the actor
     * @return IOGProfile|string The profile object or url to profile
     */
    function getOGActor();
}

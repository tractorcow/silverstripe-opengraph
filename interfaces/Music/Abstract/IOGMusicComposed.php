<?php

/**
 * @author Damian Mooyman
 */
interface IOGMusicComposed extends IOGMusic
{
    /**
     * The musician(s) who composed this object
     * @return IOGProfile[]|IOGProfile Either a single profile or list of profiles 
     */
    function OGMusicMusicians();
}
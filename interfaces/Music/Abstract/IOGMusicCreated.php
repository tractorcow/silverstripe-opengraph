<?php

/**
 * @author Damian Mooyman
 */
interface IOGMusicCreated extends IOGMusic
{
    /**
     * The creator(s) of this object
     * @return IOGProfile[]|IOGProfile Either a single profile or list of profiles 
     */
    function OGMusicCreators();
}

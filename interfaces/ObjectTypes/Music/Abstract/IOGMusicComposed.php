<?php

/**
 * @author Damian Mooyman
 */
interface IOGMusicComposed extends IOGMusic
{
    /**
     * The musician(s) who composed this object
     * @return IOGProfile[]|IOGProfile|string[]|string Musican profile(s) or url(s) to profile(s)
     */
    function OGMusicMusicians();
}
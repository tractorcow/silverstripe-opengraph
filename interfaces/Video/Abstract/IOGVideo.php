<?php

/**
 * Represents a video opengraph type
 * @author Damian Mooyman
 */
interface IOGVideo extends IOGTagged
{
    /**
     * Determines the actor(s) in this video
     * @return IOGVideoActor[]|IOGVideoActor|IOGProfile[]|IOGProfile Either a single or list of profiles or actors.
     */
    function OGVideoActors();
    
    /**
     * Determines the director(s) for this video
     * @return IOGProfile|IOGProfile[] Either a single or list of profiles
     */
    function OGVideoDirectors();
    
    /**
     * Determines the writer(s) for this video
     * @return IOGProfile[]
     */
    function OGVideoWriters();
    
    /**
     * The length of the video in seconds 
     * @return integer The length of this video in seconds
     */
    function getOGVideoDuration();
    
    /**
     * The release date of this movie
     * @return DateTime 
     */
    function getOGVideoReleaseDate();
}
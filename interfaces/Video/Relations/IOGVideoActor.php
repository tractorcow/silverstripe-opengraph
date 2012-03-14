<?php


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
     * @return IOGVideo 
     */
    function OGVideo();
    
    /**
     * The profile of the actor
     * @return IOGProfile 
     */
    function OGActor();
}

<?php

/**
 * @author Damian Mooyman
 */
interface IOGAuthored extends IOGObject
{
    /**
     * The author(s) of this object
     * @return IOGProfile[]|IOGProfile Either a single profile or list of profiles 
     */
    function OGAuthors();
}
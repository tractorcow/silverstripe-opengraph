<?php

/**
 * @author Damian Mooyman
 */
interface IOGBook extends IOGTagged, IOGAuthored
{
    /**
     * Returns the release date of this book
     * @return DateTime The date of release 
     */
    function getOGBookReleaseDate();
    
    /**
     * Returns the ISBN of this book
     * @return string The ISBN 
     */
    function getOGBookISBN();
}

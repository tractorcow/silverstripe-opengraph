<?php

namespace TractorCow\OpenGraph\Interfaces\ObjectTypes\Other;

use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * @author Damian Mooyman
 */
interface IOGBook extends IOGAuthoredTagged
{
    /**
     * Returns the release date of this book
     * @return DBDateTime|string The date of release
     */
    function getOGBookReleaseDate();

    /**
     * Returns the ISBN of this book
     * @return string The ISBN
     */
    function getOGBookISBN();
}

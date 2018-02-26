<?php

namespace TractorCow\OpenGraph\Interfaces\ObjectTypes\Other;

use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * @author Damian Mooyman
 */
interface IOGArticle extends IOGAuthoredTagged
{
    /**
     * When the article was first published.
     * @return DBDateTime|string The time of publish.
     */
    function getOGArticlePublishedTime();

    /**
     * When the article was last changed.
     * @return DBDateTime|string The time of last change.
     */
    function getOGArticleModifiedTime();

    /**
     * When the article is out of date after.
     * @return DBDateTime|string The time this article expires.
     */
    function getOGArticleExpirationTime();

    /**
     * A high-level section name. E.g. Technology
     * @return string The section name
     */
    function getOGArticleSection();
}

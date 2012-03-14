<?php

/**
 * @author Damian Mooyman
 */
interface IOGArticle extends IOGTagged, IOGAuthored
{
    /**
     * When the article was first published.
     * @return DateTime The time of publish.
     */
    function getOGArticlePublishedTime();
    
    /**
     * When the article was last changed.
     * @return DateTime The time of last change.
     */
    function getOGArticleModifiedTime();
    
    /**
     * When the article is out of date after.
     * @return DateTime The time this article expires.
     */
    function getOGArticleExpirationTime();
    
    /**
     * A high-level section name. E.g. Technology
     * @return string The section name 
     */
    function getOGArticleSection();
}
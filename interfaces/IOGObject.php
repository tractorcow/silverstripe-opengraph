<?php

/**
 * Defines a basic open graph object
 * @author Damian Mooyman
 */
interface IOGObject
{
    /**
     * Determines the OpenGraph Title
     * @return string|null|false Title of this object, false to omit this field, or null to fall back to intelligent default
     */
    function getOGTitle();
    
    /**
     * Determines the OpenGraph type as defined at {@link http://ogp.me/#types}
     * @link http://ogp.me/#types
     * @link http://graph.facebook.com/schema/og/music
     * @return string|null|false Title of this object, false to omit this field, or null to fall back to intelligent default
     */
    function getOGType();
    
    /**
     * Determines the image(s) to use for this object
     * @return Image[]|Image
     */
    function OGImage();
    
    /**
     * URI to this object
     * Named as below to prevent having to wrap the {@link SiteTree::AbsoluteLink} method explicitly
     */
    function AbsoluteLink();
}
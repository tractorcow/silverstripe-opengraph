<?php

/**
 * @author Damian Mooyman
 */
interface IOpenGraphObjectBuilder
{   
    /**
     * Generates meta tags for the object
     * @param string $tags The current tag string to append these to
     * @param mixed $object The entity to extract opengraph data from. {@see IOGObjectExplicit}
     * @param mixed $config The SiteConfig representing the application. {@see IOGApplication}
     */
    public function BuildTags(&$tags, $object, $config);
}
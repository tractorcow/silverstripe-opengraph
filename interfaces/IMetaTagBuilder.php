<?php

/**
 * @author Damian Mooyman
 */
interface IMetaTagBuilder
{
     /**
     * Generatse a <meta /> element and appends it to a set of header tags
     * @param string $tags The current tag string to append these to
     * @param string $name Meta name attribute value
     * @param string $content Meta content attribute value
     */
    public function AppendTag(&$tags, $name, $content);

    /**
     * Generates a <link /> element and appends it to a set of header tags
     * @param string $tags The current tag string to append these to
     * @param string $rel The rel attribute value
     * @param string $link URL to the linked resource
     * @param string $type Mime type of the resource, if known
     */
    public function AppendLink(&$tags, $rel, $link, $type = null);
    
    /**
     * Generates meta tags for the object
     * @param string $tags The current tag string to append these to
     * @param DataObject $object The entity to extract opengraph data from
     */
    public function BuildTags(&$tags, DataObject $object);
}
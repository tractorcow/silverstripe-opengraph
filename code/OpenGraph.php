<?php

class OpenGraph
{
    /**
     * Flag to indicate whether this module should attempt to automatically load itself
     * @var boolean
     */
    public static $auto_load = true;
    
    public static function load()
    {
        Object::add_extension('Page', 'OpenGraphPageExtension');
    }
}
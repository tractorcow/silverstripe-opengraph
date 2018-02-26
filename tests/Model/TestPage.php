<?php

namespace TractorCow\OpenGraph\Tests\Model;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Dev\TestOnly;
use TractorCow\OpenGraph\Extensions\OpenGraphObjectExtension;

class TestPage extends SiteTree implements TestOnly
{
    private static $extensions = [
        OpenGraphObjectExtension::class
    ];

    private static $table_name = 'OG_TestPage';
}

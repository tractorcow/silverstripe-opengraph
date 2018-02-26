<?php

namespace TractorCow\OpenGraph\Tests;

use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use TractorCow\OpenGraph\OpenGraph;

class OpenGraphTest extends SapphireTest
{
    protected function setUp()
    {
        parent::setUp();
        Config::modify()
            ->set(OpenGraph::class, 'application_id', 'SiteConfig')
            ->set(OpenGraph::class, 'admin_id', 'SiteConfig')
            ->set(OpenGraph::class, 'default_locale', 'en_US')
            ->set(OpenGraph::class, 'default_tagbuilder', 'TractorCow\OpenGraph\ObjectBuilders\OpenGraphBuilder');
    }

    public function testConfig()
    {
        $this->assertEquals('SiteConfig', OpenGraph::get_config('application_id'));
        $this->assertEquals('SiteConfig', OpenGraph::get_config('admin_id'));
        $this->assertEquals('en_US', OpenGraph::get_default_locale());
        $this->assertEquals('TractorCow\OpenGraph\ObjectBuilders\OpenGraphBuilder', OpenGraph::get_default_tagbuilder());
    }

    public function testLocaleValid()
    {
        $this->assertTrue(OpenGraph::is_locale_valid('en_US'));
        $this->assertFalse(OpenGraph::is_locale_valid('en_EN'));
    }
}

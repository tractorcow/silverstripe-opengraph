<?php

namespace TractorCow\OpenGraph\Tests\ObjectBuilders;

use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\i18n\i18n;
use SilverStripe\SiteConfig\SiteConfig;
use TractorCow\OpenGraph\ObjectBuilders\OpenGraphBuilder;
use TractorCow\OpenGraph\Tests\Model\TestPage;
use TractorCow\OpenGraph\Tests\Model\TestProfile;

class OpenGraphBuilderTest extends SapphireTest
{
    protected static $fixture_file = '../fixtures.yml';

    protected static $extra_dataobjects = [
        TestPage::class,
        TestProfile::class
    ];

    public function setUp()
    {
        parent::setUp();
        Config::modify()->set(i18n::class, 'default_locale', 'en_US');
        i18n::set_locale('en_US');
    }

    public function testBuildTags()
    {
        $builder = OpenGraphBuilder::create();
        $tags = '';
        $cfg = SiteConfig::current_site_config();
        $builder->BuildTags($tags, $this->objFromFixture(TestPage::class, 'page1'), $cfg);

        $this->assertContains('<meta property="og:title" content="Testpage" />', $tags);
        $this->assertContains('<meta property="og:type" content="website" />', $tags);
        $this->assertRegExp('{<meta property="og:url" content=".*?" />}', $tags);
        $this->assertRegExp('{<meta property="og:image" content=".*?/logo.gif.*?" />}', $tags);
        $this->assertContains('<meta property="og:site_name" content="Test Website" />', $tags);
        $this->assertContains('<meta property="og:locale" content="en_US" />', $tags);
    }
}

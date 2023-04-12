<?php

namespace TractorCow\OpenGraph\Tests\ObjectBuilders;

use PHPUnit\Framework\Constraint\RegularExpression;
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

    public function setUp(): void
    {
        parent::setUp();
        Config::modify()->set(i18n::class, 'default_locale', 'en_US');
        i18n::set_locale('en_US');
    }

    public function testBuildTags(): void
    {
        $builder = OpenGraphBuilder::create();
        $tags = '';
        $cfg = SiteConfig::current_site_config();
        $builder->BuildTags($tags, $this->objFromFixture(TestPage::class, 'page1'), $cfg);


        $this->assertStringContainsString('<meta property="og:title" content="Testpage" />', $tags);
        $this->assertStringContainsString('<meta property="og:type" content="website" />', $tags);
        static::assertThat($tags, new RegularExpression('{<meta property="og:url" content=".*?" />}'));
        static::assertThat($tags, new RegularExpression('{<meta property="og:image" content=".*?/logo.gif.*?" />}'));
        $this->assertStringContainsString('<meta property="og:site_name" content="Test Website" />', $tags);
        $this->assertStringContainsString('<meta property="og:locale" content="en_US" />', $tags);
    }
}

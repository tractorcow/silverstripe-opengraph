<?php

namespace TractorCow\OpenGraph\Tests\ObjectBuilders;

use SilverStripe\Dev\SapphireTest;
use SilverStripe\SiteConfig\SiteConfig;
use TractorCow\OpenGraph\ObjectBuilders\Other\OGProfile;
use TractorCow\OpenGraph\Tests\Model\TestPage;
use TractorCow\OpenGraph\Tests\Model\TestProfile;

class OGProfileTest extends SapphireTest
{
    protected static $fixture_file = '../fixtures.yml';

    protected static $extra_dataobjects = [
        TestPage::class,
        TestProfile::class
    ];

    public function testBuildTags(): void
    {
        $builder = OGProfile::create();
        $tags = '';
        $cfg = SiteConfig::current_site_config();
        $builder->BuildTags($tags, $this->objFromFixture(TestProfile::class, 'tractorcow'), $cfg);

        $this->assertStringContainsString('<meta property="og:title" content="Damian Mooyman" />', $tags);
        $this->assertStringContainsString('<meta property="og:type" content="profile" />', $tags);
        $this->assertStringContainsString('<meta property="og:url" content="http://example.com/profile/tractorcow" />', $tags);
        $this->assertStringContainsString('<meta property="og:image" content="http://example.com/pic/tractorcow.jpg" />', $tags);
        $this->assertStringContainsString('<meta property="profile:first_name" content="Damian" />', $tags);
        $this->assertStringContainsString('<meta property="profile:last_name" content="Mooyman" />', $tags);
        $this->assertStringContainsString('<meta property="profile:username" content="TractorCow" />', $tags);
        $this->assertStringContainsString('<meta property="profile:gender" content="male" />', $tags);
    }
}

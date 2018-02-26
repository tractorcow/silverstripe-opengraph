<?php

namespace TractorCow\OpenGraph\Tests\Extensions;

use SilverStripe\Dev\SapphireTest;
use TractorCow\OpenGraph\Tests\Model\TestPage;
use TractorCow\OpenGraph\Tests\Model\TestProfile;

class OpenGraphObjectExtensionTest extends SapphireTest
{
    protected static $fixture_file = '../fixtures.yml';

    protected static $extra_dataobjects = [
        TestPage::class,
        TestProfile::class
    ];

    public function testOGNS()
    {
        $page = $this->objFromFixture(TestPage::class, 'page1');
        $this->assertEquals(
            ' prefix="og: http://ogp.me/ns#  fb: http://www.facebook.com/2008/fbml website: http://ogp.me/ns/website#"',
            $page->getOGNS()
        );
    }

    public function testOGType()
    {
        $page = $this->objFromFixture(TestPage::class, 'page1');
        $this->assertEquals('website', $page->getOGType());

        $profile = $this->objFromFixture(TestProfile::class, 'catwoman');
        $this->assertEquals('profile', $profile->getOGType());
    }
}

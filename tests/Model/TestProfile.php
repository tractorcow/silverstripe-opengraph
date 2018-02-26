<?php

namespace TractorCow\OpenGraph\Tests\Model;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;
use TractorCow\OpenGraph\Extensions\OpenGraphObjectExtension;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\IOGProfile;

class TestProfile extends DataObject implements IOGProfile, TestOnly
{
    private static $db = [
        'FirstName' => 'Varchar(255)',
        'Surname' => 'Varchar(255)',
        'Nickname' => 'Varchar(64)',
        'Gender' => "Enum('Male,Female','Female')"
    ];

    private static $extensions = [
        OpenGraphObjectExtension::class
    ];

    private static $table_name = 'OG_TestProfile';

    public function getTitle()
    {
        return $this->FirstName . ' ' . $this->Surname;
    }

    public function getOGImage()
    {
        return sprintf('http://example.com/pic/%s.jpg', strtolower($this->Nickname));
    }

    /**
     * URI to this object
     * Named as below to prevent having to wrap the {@link SiteTree::AbsoluteLink} method explicitly
     */
    public function AbsoluteLink()
    {
        return 'http://example.com/profile/' . strtolower($this->Nickname);
    }

    /**
     * @return string This person's first name
     */
    public function getOGFirstName()
    {
        return $this->FirstName;
    }

    /**
     * @return string This person's last name
     */
    public function getOGLastName()
    {
        return $this->Surname;
    }

    /**
     * @return string A short unique string to identify them.
     */
    public function getOGUserName()
    {
        return $this->Nickname;
    }

    /**
     * @return string Their gender (male or female only)
     */
    public function getOGGender()
    {
        return strtolower($this->Gender);
    }
}

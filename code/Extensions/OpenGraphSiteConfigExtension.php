<?php

class OpenGraphSiteConfigExtension extends DataExtension implements IOGApplication
{
    public static $application_id = 'SiteConfig';
    public static $admin_id = 'SiteConfig';
    public static $default_country = '';
    public static $allowed_countries = null;
	
	public static function get_extra_config($class, $extensionClass, $args) {
		
        $db = array();
        if (self::$application_id === 'SiteConfig')
            $db['OGApplicationID'] = 'Varchar(255)';
		
        if (self::$admin_id === 'SiteConfig')
            $db['OGAdminID'] = 'Varchar(255)';
        
        $db['OGlocality'] = 'Varchar(255)';
        $db['OGcountry-name'] = 'Varchar(255)';

        return array(
            'db' => $db
        );
    }
	
	public function updateCMSFields(FieldList $fields) {
		
        if (self::$application_id === 'SiteConfig') {
            $fields->addFieldToTab('Root.Facebook', new TextField('OGApplicationID', 'FB Application ID', null, 255));
		}
		
        if (self::$admin_id === 'SiteConfig') {
            $fields->addFieldToTab('Root.Facebook', new TextField('OGAdminID', 'FB Admin ID(s)', null, 255));
		}
        
        $fields->addFieldsToTab('Root.OpenGraph', array(
			new TextField('OGlocality', 'Locality', null, 255),
			new CountryDropdownField('OGcountry-name', 'Country', self::$allowed_countries, self::$default_country)
		));
    }

    public function getOGAdminID()
    {
        if (self::$admin_id === 'SiteConfig')
            return $this->owner->getField('OGAdminID');
        return self::$admin_id;
    }

    public function getOGApplicationID()
    {
        if (self::$application_id === 'SiteConfig')
            return $this->owner->getField('OGApplicationID');
        return self::$application_id;
    }
    
    public function getOGlocality()
    {
        return $this->owner->getField('OGlocality');
    }
    
    public function getOGcountryName()
    {
        return $this->owner->getField('OGcountry-name');
    }

}
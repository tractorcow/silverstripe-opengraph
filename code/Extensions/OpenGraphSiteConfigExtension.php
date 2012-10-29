<?php

class OpenGraphSiteConfigExtension extends DataExtension implements IOGApplication
{
    public static $default_country = '';
    public static $allowed_countries = null;
	
	public static function get_extra_config($class, $extensionClass, $args) {
		
        $db = array();
		
        if (OpenGraph::get_config('application_id') == 'SiteConfig') {
            $db['OGApplicationID'] = 'Varchar(255)';
		}
		
        if (OpenGraph::get_config('admin_id') == 'SiteConfig') {
            $db['OGAdminID'] = 'Varchar(255)';
		}
        
        if (OpenGraph::get_config('locality') == 'SiteConfig') {
			$db['OGLocality'] = 'Varchar(255)';
		}
		
        if (OpenGraph::get_config('country_name') == 'SiteConfig') {
			$db['OGCountryName'] = 'Varchar(255)';
		}

        return array(
            'db' => $db
        );
    }
	
	public function updateCMSFields(FieldList $fields) {
		
        if (OpenGraph::get_config('application_id') == 'SiteConfig') {
            $fields->addFieldToTab(
				'Root.Facebook', 
				new TextField('OGApplicationID', 'Facebook Application ID', null, 255)
			);
		}
		
        if (OpenGraph::get_config('admin_id') == 'SiteConfig') {
            $fields->addFieldToTab(
				'Root.Facebook',
				new TextField('OGAdminID', 'Facebook Admin ID(s)', null, 255)
			);
		}
        
        if (OpenGraph::get_config('locality') == 'SiteConfig') {
			$fields->addFieldToTab(
				'Root.Facebook', 
				new TextField('OGLocality', 'Open Graph Locality', null, 255)
			);
		}
		
        if (OpenGraph::get_config('country_name') == 'SiteConfig') {
			$fields->addFieldToTab('Root.Facebook',
				new CountryDropdownField(
					'OGCountryName', 
					'Open Graph Country', 
					self::$allowed_countries, 
					self::$default_country
				)
			);
		}
    }
	
	protected function getConfigurableField($dbField, $configField) {
		$value = OpenGraph::get_config($configField);
        if ($value == 'SiteConfig') {
            return $this->owner->getField($dbField);
		}
        return $value;
	}

    public function getOGAdminID()
    {
		return $this->getConfigurableField('OGAdminID', 'admin_id');
    }

    public function getOGApplicationID()
    {
		return $this->getConfigurableField('OGApplicationID', 'application_id');
    }
    
    public function getOGLocality()
    {
		return $this->getConfigurableField('OGLocality', 'locality');
    }
    
    public function getOGCountryName()
    {
		return $this->getConfigurableField('OGCountryName', 'country_name');
    }

}
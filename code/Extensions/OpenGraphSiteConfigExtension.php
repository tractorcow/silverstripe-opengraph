<?php

class OpenGraphSiteConfigExtension extends DataExtension implements IOGApplication
{	
	public static function get_extra_config($class, $extensionClass, $args) {
		
		$db = array();
		
		if (OpenGraph::get_config('application_id') == 'SiteConfig') {
			$db['OGApplicationID'] = 'Varchar(255)';
		}
		
		if (OpenGraph::get_config('admin_id') == 'SiteConfig') {
			$db['OGAdminID'] = 'Varchar(255)';
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
}
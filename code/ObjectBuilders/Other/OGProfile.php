<?php

class OGProfile extends OpenGraphBuilder
{
	
	protected function appendProfileTags(&$tags, IOGProfile $profile)
	{
		$this->AppendTag($tags, 'profile:first_name', $profile->getOGFirstName());
		$this->AppendTag($tags, 'profile:last_name', $profile->getOGLastName());
		$this->AppendTag($tags, 'profile:username', $profile->getOGUserName());
		$this->AppendTag($tags, 'profile:gender', $profile->getOGGender());
	}

	public function BuildTags(&$tags, $object, $config)
	{
		parent::BuildTags($tags, $object, $config);
		$this->appendProfileTags($tags, $object);
	}
}
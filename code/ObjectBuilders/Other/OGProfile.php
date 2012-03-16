<?php

class OGProfile extends OpenGraphBuilder
{
    
    protected function appendProfileTags(&$tags, IOGProfile $profile)
    {
        $this->appendTag($tags, 'profile:first_name', $profile->getOGFirstName());
        $this->appendTag($tags, 'profile:last_name', $profile->getOGLastName());
        $this->appendTag($tags, 'profile:username', $profile->getOGUserName());
        $this->appendTag($tags, 'profile:gender', $profile->getOGGender());
    }

    public function BuildTags(&$tags, $object, $config)
    {
        parent::BuildTags($tags, $object, $config);
        $this->appendProfileTags($tags, $object);
    }
}
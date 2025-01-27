<?php

namespace TractorCow\OpenGraph\ObjectBuilders\Music;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Music\IOGMusicRadioStation;

class OGMusicRadioStation extends AbstractOGMusic
{
    /**
     * @param string               $tags
     * @param IOGMusicRadioStation $station
     */
    protected function appendRadioStationTags(&$tags, $station)
    {
        $this->appendRelatedProfileTags($tags, 'music:creator', $station->getOGMusicCreators());
    }

    public function BuildTags(&$tags, $object, $config)
    {
        parent::BuildTags($tags, $object, $config);
        $this->appendRadioStationTags($tags, $object);
    }
}

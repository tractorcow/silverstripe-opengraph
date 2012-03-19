<?php

class OGMusicRadioStation extends OGMusic
{
    protected function appendRadioStationTags(&$tags, IOGMusicRadioStation $station)
    {
        $this->appendRelatedProfileTags($tags, 'music:creator', $station->OGMusicCreators());
    }

    public function BuildTags(&$tags, $object, $config)
    {
        parent::BuildTags($tags, $object, $config);
        $this->appendRadioStationTags($tags, $object);
    }
}
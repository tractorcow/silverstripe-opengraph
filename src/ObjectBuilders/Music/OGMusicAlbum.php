<?php

namespace TractorCow\OpenGraph\ObjectBuilders\Music;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Music\IOGMusicAlbum;

class OGMusicAlbum extends AbstractOGMusic
{
    /**
     * @param string        $tags
     * @param IOGMusicAlbum $album
     */
    protected function appendAlbumTags(&$tags, $album)
    {
        $this->appendRelatedSongList($tags, 'music:song', $album->getOGMusicSongs());
        $this->appendRelatedProfileTags($tags, 'music:musician', $album->getOGMusicMusicians());
        $this->appendDateTag($tags, 'music:release_date', $album->getOGMusicReleaseDate());
    }

    public function BuildTags(&$tags, $object, $config)
    {
        parent::BuildTags($tags, $object, $config);
        $this->appendAlbumTags($tags, $object);
    }
}

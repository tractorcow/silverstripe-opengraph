<?php

namespace TractorCow\OpenGraph\ObjectBuilders\Music;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Music\IOGMusicPlaylist;

class OGMusicPlaylist extends AbstractOGMusic
{
    protected function appendPlaylistTags(&$tags, IOGMusicPlaylist $playlist)
    {
        $this->appendRelatedSongList($tags, 'music:song', $playlist->getOGMusicSongs());
        $this->appendRelatedProfileTags($tags, 'music:creator', $playlist->getOGMusicCreators());
    }

    public function BuildTags(&$tags, $object, $config)
    {
        parent::BuildTags($tags, $object, $config);
        $this->appendPlaylistTags($tags, $object);
    }
}

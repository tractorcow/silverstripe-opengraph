<?php

namespace TractorCow\OpenGraph\ObjectBuilders\Music;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Music\IOGMusicPlaylist;

class OGMusicPlaylist extends AbstractOGMusic
{
    /**
     * @param string           $tags
     * @param IOGMusicPlaylist $playlist
     */
    protected function appendPlaylistTags(&$tags, $playlist)
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

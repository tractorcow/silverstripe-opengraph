<?php

class OGMusicPlaylist extends OGMusic
{
    protected function appendPlaylistTags(&$tags, IOGMusicPlaylist $playlist)
    {
        $this->appendRelatedSongList($tags, 'music:song', $playlist->OGMusicSongs());
        $this->appendRelatedProfileTags($tags, 'music:creator', $playlist->OGMusicCreators());
    }

    public function BuildTags(&$tags, $object, $config)
    {
        parent::BuildTags($tags, $object, $config);
        $this->appendPlaylistTags($tags, $object);
    }
}
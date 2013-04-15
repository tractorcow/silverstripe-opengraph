<?php

class OGMusicAlbum extends OGMusic
{
	protected function appendAlbumTags(&$tags, IOGMusicAlbum $album)
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
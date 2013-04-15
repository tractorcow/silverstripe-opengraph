<?php

class OGMusicSong extends OGMusic
{
	/**
	 * Builds a list of song/album links links
	 * @param string $tags The current tag string to append these two
	 * @param string $namespace The namespace to use for this element
	 * @param IOGSongAlbum[]|IOGSongAlbum|IOGMusicAlbum[]|IOGMusicAlbum|string[]|string $value Related album(s) or link(s) to album(s)
	 */
	protected function appendRelatedAlbumList(&$tags, $namespace, $value)
	{
		if (empty($value))
			return;

		// Handle situation where multiple items are presented
		if ($this->isValueIterable($value))
		{
			foreach ($value as $album)
				$this->appendRelatedAlbumList($tags, $namespace, $album);
			return;
		}

		// Handle explicit profile object
		if ($value instanceof IOGSongAlbum)
		{
			/* @var $value IOGSongAlbum */
			$this->appendRelatedAlbumList($tags, $namespace, $value->getOGAlbum());
			$this->AppendTag($tags, "$namespace:disc", $value->getOGDisc());
			$this->AppendTag($tags, "$namespace:track", $value->getOGTrack());
			return;
		}
		
		if ($value instanceof IOGMusicAlbum) /* @var $value IOGMusicAlbum */
			return $this->AppendTag($tags, $namespace, $value->AbsoluteLink());

		// Handle image URL being given
		if (is_string($value))
			return $this->AppendTag($tags, $namespace, $value);

		// Fail if could not determine presented value type
		trigger_error('Invalid album type: ' . gettype($value), E_USER_ERROR);
	}

	protected function appendSongTags(&$tags, IOGMusicSong $song)
	{
		$this->AppendTag($tags, 'music:duration', $song->getOGMusicDuration());
		$this->appendRelatedProfileTags($tags, 'music:musician', $song->getOGMusicMusicians());
		$this->appendRelatedAlbumList($tags, 'music:album', $song->getOGMusicAlbums());
	}

	public function BuildTags(&$tags, $object, $config)
	{
		parent::BuildTags($tags, $object, $config);
		$this->appendSongTags($tags, $object);
	}

}
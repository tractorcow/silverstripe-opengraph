<?php

/**
 * @author Damo
 */
class OGVideoEpisode extends OGVideo
{
	protected function appendEpisodeTags(&$tags, IOGVideoEpisode $video)
	{
		$this->AppendTag($tags, 'video:series', $video->getOGVideoSeries());
	}

	public function BuildTags(&$tags, $object, $config)
	{
		parent::BuildTags($tags, $object, $config);
		
		$this->appendEpisodeTags($tags, $object);
	}
}
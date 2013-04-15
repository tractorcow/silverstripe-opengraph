<?php

/**
 * @author Damo
 */
abstract class OGVideo extends OpenGraphBuilder
{
	
	/**
	 * Builds a list of actor links
	 * @param string $tags The current tag string to append these two
	 * @param string $namespace The namespace to use for this element
	 * @param IOGVideoActor[]|IOGVideoActor|IOGProfile[]|IOGProfile|string[]|string Song object(s) or url(s) to profile(s)
	 */
	protected function appendRelatedActorList(&$tags, $namespace, $value)
	{
		if (empty($value))
			return;

		// Handle situation where multiple items are presented
		if ($this->isValueIterable($value))
		{
			foreach ($value as $actor)
				$this->appendRelatedActorList($tags, $namespace, $actor);
			return;
		}

		// Handle explicit song/album mapping object
		if ($value instanceof IOGVideoActor) /* @var $value IOGVideoActor */
		{
			$this->appendRelatedActorList($tags, $namespace, $value->getOGActor());
			$this->AppendTag($tags, "$namespace:role", $value->getOGRole());
			return;
		}
		
		// Handle single song object
		if($value instanceof IOGProfile) /* @var $value IOGProfile */
			return $this->AppendTag($tags, $namespace, $value->AbsoluteLink());

		// Handle image URL being given
		if (is_string($value))
			return $this->AppendTag($tags, $namespace, $value);

		// Fail if could not determine presented value type
		trigger_error('Invalid song type: ' . gettype($value), E_USER_ERROR);
	}
	
	protected function appendVideoTags(&$tags, IOGVideo $video)
	{
		$this->appendRelatedActorList($tags, 'video:actor', $video->getOGVideoActors());
		$this->appendRelatedProfileTags($tags, 'video:director', $video->getOGVideoDirectors());
		$this->appendRelatedProfileTags($tags, 'video:writer', $video->getOGVideoWriters());
		$this->AppendTag($tags, 'video:duration', $video->getOGVideoDuration());
		$this->appendDateTag($tags, 'video:release_date', $video->getOGVideoReleaseDate());
		$this->appendRelatedTags($tags, 'video:tag', $video->getOGTags());
	}

	public function BuildTags(&$tags, $object, $config)
	{
		parent::BuildTags($tags, $object, $config);
		
		$this->appendVideoTags($tags, $object);
	}
}
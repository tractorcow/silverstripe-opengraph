<?php

namespace TractorCow\OpenGraph\ObjectBuilders\Video;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Video\IOGVideoEpisode;

/**
 * @author Damo
 */
class OGVideoEpisode extends AbstractOGVideo
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

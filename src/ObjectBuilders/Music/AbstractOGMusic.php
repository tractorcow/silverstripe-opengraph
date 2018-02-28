<?php

namespace TractorCow\OpenGraph\ObjectBuilders\Music;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Music\IOGMusicSong;
use TractorCow\OpenGraph\Interfaces\ObjectTypes\Music\Relations\IOGSongAlbum;
use TractorCow\OpenGraph\ObjectBuilders\OpenGraphBuilder;

/**
 * Description of OGMusic
 *
 * @author Damo
 */
abstract class AbstractOGMusic extends OpenGraphBuilder
{

    /**
     * Builds a list of song links
     * @param string $tags The current tag string to append these two
     * @param string $namespace The namespace to use for this element
     * @param IOGSongAlbum[]|IOGSongAlbum|IOGMusicSong[]|IOGMusicSong|string[]|string Song object(s) or url(s) to object(s)
     */
    protected function appendRelatedSongList(&$tags, $namespace, $value)
    {
        if (empty($value)) {
            return;
        }

        // Handle situation where multiple items are presented
        if ($this->isValueIterable($value)) {
            foreach ($value as $song) {
                $this->appendRelatedSongList($tags, $namespace, $song);
            }
            return;
        }

        // Handle explicit song/album mapping object
        if ($value instanceof IOGSongAlbum) { /* @var $value IOGSongAlbum */
            $this->appendRelatedSongList($tags, $namespace, $value->getOGSong());
            $this->AppendTag($tags, "$namespace:disc", $value->getOGDisc());
            $this->AppendTag($tags, "$namespace:track", $value->getOGTrack());
            return;
        }

        // Handle single song object
        if ($value instanceof IOGMusicSong) {
            /* @var $value IOGMusicSong */
            $this->AppendTag($tags, $namespace, $value->AbsoluteLink());
            return;
        }

        // Handle image URL being given
        if (is_string($value)) {
            $this->AppendTag($tags, $namespace, $value);
            return;
        }

        // Fail if could not determine presented value type
        trigger_error('Invalid song type: ' . gettype($value), E_USER_ERROR);
    }
}

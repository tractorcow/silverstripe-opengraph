<?php

namespace TractorCow\OpenGraph\Constants;

/**
 * Defines the list of standard opengraph object types.
 * User types may be substitude in place of any of these for the og:type property,
 * as long as the namespace is correctly implemented
 */
class OGTypes
{
    const MUSIC_SONG = 'music.song';
    const MUSIC_ALBUM = 'music.album';
    const MUSIC_PLAYLIST = 'music.playlist';
    const MUSIC_RADIOSTATION = 'music.radio_station';

    const VIDEO_MOVIE = 'video.movie';
    const VIDEO_EPISODE = 'video.episode';
    const VIDEO_TV_SHOW = 'video.tv_show';
    const VIDEO_OTHER = 'video.other';

    const ARTICLE = 'article';
    const BOOK = 'book';
    const PROFILE = 'profile';
    const WEBSITE = 'website';

    /**
     * @link http://developers.facebook.com/docs/opengraph/music/
     */
    const METADATA = 'metadata';

    const DEFAULT_TYPE = self::WEBSITE;
}

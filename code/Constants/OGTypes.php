<?php

/**
 * Defines the list of standard opengraph object types.
 * User types may be substitude in place of any of these for the og:type property,
 * as long as the namespace is correctly implemented 
 */
class OGTypes
{
	const Music_Song = 'music.song';
	const Music_Album = 'music.album';
	const Music_Playlist = 'music.playlist';
	const Music_RadioStation = 'music.radio_station';
	
	const Video_Movie = 'video.movie';
	const Video_Episode = 'video.episode';
	const Video_TVShow = 'video.tv_show';
	const Video_Other = 'video.other';
	
	const Article = 'article';
	const Book = 'book';
	const Profile = 'profile';
	const Website = 'website';
	
	/**
	 * @link http://developers.facebook.com/docs/opengraph/music/ 
	 */
	const MetaData = 'metadata';
	
	const DefaultType = self::Website;
}
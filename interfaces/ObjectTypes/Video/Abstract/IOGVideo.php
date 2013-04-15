<?php

/**
 * Represents a video opengraph type
 * @author Damian Mooyman
 */
interface IOGVideo extends IOGTagged
{
	/**
	 * Determines the actor(s) in this video
	 * @return IOGVideoActor[]|IOGVideoActor|IOGProfile[]|IOGProfile|string[]|string Actor/Profile object(s) or url(s) to actor/profile(s)
	 */
	function getOGVideoActors();
	
	/**
	 * Determines the director(s) for this video
	 * @return IOGProfile[]|IOGProfile|string[]|string Profile object(s) or url(s) to director(s)
	 */
	function getOGVideoDirectors();
	
	/**
	 * Determines the writer(s) for this video
	 * @return IOGProfile[]|IOGProfile|string[]|string Profile object(s) or url(s) to profile(s)
	 */
	function getOGVideoWriters();
	
	/**
	 * The length of the video in seconds 
	 * @return integer The length of this video in seconds
	 */
	function getOGVideoDuration();
	
	/**
	 * The release date of this movie
	 * @return DateTime|string
	 */
	function getOGVideoReleaseDate();
}
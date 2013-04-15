<?php

/**
 *
 * @author Damian Mooyman
 */
interface IOGVideoEpisode extends IOGVideo
{
	/**
	 * Determines the serious this episode belongs to
	 * @return IOGVideoTVShow|string The series object or url to series
	 */
	function getOGVideoSeries();
}

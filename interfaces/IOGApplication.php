<?php

/**
 * Defines properties of the application
 * @author Damian Mooyman
 */
interface IOGApplication
{
	/**
	 * Defines the fb:admins of this application 
	 * @return string|null Admin id(s), or null if empty
	 */
	public function getOGAdminID();
	
	/**
	 * Defines the fb:app_id of this application 
	 * @return string|null Application id(s), or null if empty
	 */
	public function getOGApplicationID();
}
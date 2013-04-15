<?php

/**
 * @author Damian Mooyman
 */
interface IOGProfile extends IOGObject
{
	/**
	 * @return string This person's first name
	 */
	function getOGFirstName();
	
	/**
	 * @return string This person's last name 
	 */
	function getOGLastName();
	
	/**
	 * @return string A short unique string to identify them.
	 */
	function getOGUserName();
	
	/**
	 * @return string Their gender (male or female only)
	 */
	function getOGGender();
}
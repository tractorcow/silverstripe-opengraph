<?php

/**
 * Defines a basic open graph object
 * Only non-decorator methods are defined here, as any implementing classes may instead define these methods in a decorator
 * @author Damian Mooyman
 */
interface IOGObject
{
	
	/**
	 * URI to this object
	 * Named as below to prevent having to wrap the {@link SiteTree::AbsoluteLink} method explicitly
	 */
	function AbsoluteLink();
}
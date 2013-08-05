<?php

/**
 * Can be used in place of the File object to refer to Video/Image files
 * 
 * @author Damo
 * @link Image
 */
interface IMediaFile {
	
	/**
	 * Media width in pixels
	 * 
	 * @return integer
	 */
	function getWidth();
	
	/**
	 * Media height in pixels
	 * 
	 * @return integer
	 */
	function getHeight();
	
	/**
	 * Media URL
	 * 
	 * @return string
	 */
	function getAbsoluteURL();
	
	/**
	 * Media mime type
	 * 
	 * @return string
	 */
	function getType();
}

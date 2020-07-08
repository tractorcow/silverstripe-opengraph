<?php

namespace TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\Relations;

/**
 * Can be used in place of the File object to refer to Video/Image files
 *
 * @author Damo
 * @link   Image
 */
interface IMediaFile
{

    /**
     * Media width in pixels
     *
     * @return integer
     */
    public function getWidth();

    /**
     * Media height in pixels
     *
     * @return integer
     */
    public function getHeight();

    /**
     * Media URL
     *
     * @return string
     */
    public function getAbsoluteURL();

    /**
     * Secure URL, if different from absolute URL
     *
     * @return mixed
     */
    public function getSecureURL();

    /**
     * Media mime type
     *
     * @return string
     */
    public function getType();
}

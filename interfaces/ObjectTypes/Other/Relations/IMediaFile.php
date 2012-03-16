<?php

/**
 * Can be used in place of the File object to refer to Video/Image files
 * @author Damo
 * @link Image
 */
interface IMediaFile
{
    function getWidth();
    function getHeight();
    function getAbsoluteURL();
}

<?php

namespace TractorCow\OpenGraph\Constants;

/**
 * @author Damian Mooyman
 */
class OGDeterminers
{
    const A = 'a';
    const AN = 'an';
    const AUTO = 'auto';
    const BLANK = '';

    const DEFAULT_VALUE = null; // Generally og:determiner causes validation
    // errors, so do not enable unless explicitly set in an application
}

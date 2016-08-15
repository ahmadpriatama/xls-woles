<?php
/**
 * StringLowercaseFilter class file
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */

namespace XLSWoles\filters;

/**
 * Class StringLowercaseFilter
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */
class StringLowercaseFilter
{
    const KEYWORD = 'string-lowercase';

    /**
     * @param string $input Text.
     * @return string
     */
    public function process($input)
    {
        return strtolower($input);
    }
}
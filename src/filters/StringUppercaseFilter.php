<?php
/**
 * StringUppercaseFilter class file
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */

namespace XLSWoles\filters;

/**
 * Class StringUppercaseFilter
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */
class StringUppercaseFilter
{
    const KEYWORD = 'string-uppercase';

    /**
     * @param string $input Text.
     * @return string
     */
    public function process($input)
    {
        return strtoupper($input);
    }
}

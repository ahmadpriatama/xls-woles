<?php
/**
 * NullOnEmptyFilter class file
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */

namespace XLSWoles\filters;

/**
 * Class NullOnEmptyFilter
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */
class NullOnEmptyFilter
{
    const KEYWORD = 'null-on-empty';

    /**
     * @param string $input Text data.
     * @return mixed
     */
    public function process($input)
    {
        return empty($input) ? null : $input;
    }
}

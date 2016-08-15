<?php
/**
 * StringToTimeFilter class file
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */

namespace XLSWoles\filters;

/**
 * Class StringToTimeFilter
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */
class StringToTimeFilter
{
    const KEYWORD = 'string-to-time';

    /**
     * @var @array
     */
    public $exceptions = [];

    /**
     * @param string $input Text.
     * @return mixed
     */
    public function process($input)
    {
        if (in_array($input, $this->exceptions)) {
            return $input;
        } else {
            return strtotime($input);
        }
    }
}

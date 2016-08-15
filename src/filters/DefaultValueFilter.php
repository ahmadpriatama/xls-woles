<?php
/**
 * DefaultValueFilter class file
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */

namespace XLSWoles\filters;

/**
 * Class DefaultValueFilter
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.18
 */
class DefaultValueFilter
{
    const KEYWORD = 'default-value';

    /**
     * @var mixed
     */
    public $value;

    /**
     * @param string $input Text.
     * @return mixed
     */
    public function process($input)
    {
        return empty($input) ? $this->value : $input;
    }
}
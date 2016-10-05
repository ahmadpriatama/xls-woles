<?php
/**
 * MapFilter class file
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.09.25
 */

namespace XLSWoles\filters;

/**
 * Class MapFilter
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.09.25
 */
class MapFilter
{
    const KEYWORD = 'map';

    /**
     * @var array
     */
    public $values = [];

    /**
     * @param string $input Text.
     * @return mixed
     */
    public function process($input)
    {
        return isset($this->values[$input]) ? $this->values[$input] : $input;
    }
}
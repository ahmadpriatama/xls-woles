<?php
/**
 * RegexFilter class file
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.16
 */

namespace XLSWoles\filters;

/**
 * Class RegexFilter
 * @package XLSWoles\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.16
 */
class RegexFilter
{
    const KEYWORD = 'regex';

    /**
     * @var string
     */
    public $input;

    /**
     * @var string
     */
    public $output;

    /**
     * @param string $input Text.
     * @return string
     */
    public function process($input)
    {
        return preg_replace("/{$this->input}/", $this->output, $input);
    }
}
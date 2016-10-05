<?php
/**
 * InValidator class file
 * @package XLSWoles\validators
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.09.25
 */

namespace XLSWoles\validators;

/**
 * Class InValidator
 * @package XLSWoles\validators
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.09.25
 */
class InValidator
{
    const KEYWORD = 'in';

    /**
     * @var array
     */
    public $values = [];

    /**
     * @var string
     */
    public $message = 'Not a valid value';

    /**
     * @param $input
     * @return string
     */
    public function check($input)
    {
        if (!in_array($input, $this->values)) {
            return $this->message;
        }
    }
}
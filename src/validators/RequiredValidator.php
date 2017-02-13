<?php
/**
 * RequiredValidator class file
 * @package XLSWoles\validators
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.29
 */

namespace XLSWoles\validators;

/**
 * Class RequiredValidator
 * @package XLSWoles\validators
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.29
 */
class RequiredValidator
{
    const KEYWORD = 'required';

    /**
     * @var string
     */
    public $message = 'Required';

    public function check($input)
    {
        if (is_null($input)) {
            return $this->message;
        }
    }
}
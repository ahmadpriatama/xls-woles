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
    public function check($input)
    {
        if (empty($input)) {
            return 'Required';
        }
    }
}
<?php
/**
 * SingleColumn class file
 * @package XLSWoles\src\columns
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */

namespace XLSWoles\columns;

/**
 * Class SingleColumn
 * @package XLSWoles\src\columns
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */
class SingleColumn extends BaseColumn
{
    /**
     * @param \PHPExcel\Worksheet $worksheet Worksheet instance.
     * @param string              $column    Column name.
     * @param integer             $row       Row index.
     * @return mixed
     */
    public function getValue(\PHPExcel\Worksheet $worksheet, $column, $row)
    {
        $val = trim($worksheet->getCell("{$column}{$row}")->getFormattedValue());
        if (in_array($val, $this->asEmptyValue)) {
            $val = '';
        }
        $value = $this->runThroughFilters($val);
        $error = $this->runThroughValidators($value);
        return [
            'value' => $value,
            'error' => $error,
        ];
    }
}

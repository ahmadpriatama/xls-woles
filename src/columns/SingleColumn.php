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
     * @param array               $rowData   Row data.
     * @return mixed
     */
    public function getValue($worksheet, $column, $row, &$rowData)
    {
        $this->rowData = &$rowData;
        $val = trim($worksheet->getCell("{$column}{$row}")->getFormattedValue());
        if (in_array($val, $this->asEmptyValue)) {
            $val = '';
        }
        $value = $this->runThroughFilters($val);
        $error = $this->runThroughValidators($value);
        $rowData[$this->name] = $value;
        return [
            'value' => $value,
            'error' => $error,
        ];
    }
}

<?php
/**
 * MultipleColumn class file
 * @package XLSWoles\columns
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */

namespace XLSWoles\columns;

use XLSWoles\Spreadsheet;

/**
 * Class MultipleColumn
 * @package XLSWoles\columns
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */
class MultipleColumn extends BaseColumn
{
    /**
     * @var integer
     */
    public $columnCount;

    /**
     * @var array
     */
    public $translate;

    /**
     * @param \PHPExcel\Worksheet $worksheet Worksheet instance.
     * @param string              $column    Column name.
     * @param integer             $row       Row index.
     * @return mixed
     */
    public function getValue(\PHPExcel\Worksheet $worksheet, $column, $row)
    {
        foreach (range(0, $this->columnCount - 1) as $index) {
            $col = Spreadsheet::increment($column, $index);
            $val = $worksheet->getCell("{$col}{$row}")->getValue();
            if (in_array($val, $this->asEmptyValue)) {
                $val = '';
            }
            if (!empty($val)) {
                return [
                    'value' => $this->translate[$index],
                    'jump' => $this->columnCount - 1,
                ];
            }
        }
    }
}
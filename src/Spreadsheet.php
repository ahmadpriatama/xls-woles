<?php
/**
 * Spreadsheet class file
 * @package XLSWoles
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */

namespace XLSWoles;

use XLSWoles\columns\BaseColumn;

/**
 * Class Spreadsheet
 * @package XLSWoles
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */
class Spreadsheet /*extends \PHPExcel\Spreadsheet*/
{
    /**
     * @var string
     */
    public $sheetName;

    /**
     * @var array
     */
    public $columnConfig;

    /**
     * @var string
     */
    public $dataRange;

    /**
     * @var \PHPExcel\Spreadsheet
     */
    private $_object;

    /**
     * @var \PHPExcel\Worksheet
     */
    private $_sheetInstance;

    /**
     * @var BaseColumn
     */
    private $_columns;

    /**
     * Spreadsheet constructor.
     * @param \PHPExcel\Spreadsheet $object Actual Spreadsheet instance.
     */
    public function __construct($object)
    {
        $this->_object = $object;
    }

    /**
     * @param string $name      Function name.
     * @param mixed  $arguments Function arguments.
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->_object, $name], $arguments);
    }

    /**
     * @param string $sheetName Sheet name.
     * @return $this
     */
    public function setSheetName($sheetName)
    {
        $this->sheetName = $sheetName;
        $this->_sheetInstance = $this->_object->getSheetByName($sheetName);
        return $this;
    }

    /**
     * @return \PHPExcel\Worksheet
     */
    public function getInstance()
    {
        return $this->_sheetInstance;
    }

    /**
     * @param string $index Sheet index.
     * @return integer
     */
    public function getHighestRow()
    {
        return $this->_sheetInstance->getHighestRow();
    }

    /**
     * @param string $columnConfig Column config.
     * @return $this
     */
    public function setColumnConfig($columnConfig)
    {
        $this->columnConfig = $columnConfig;
        return $this;
    }

    /**
     * @param integer $index Sheet index.
     * @return $this
     */
    public function setActiveSheetIndex($index)
    {
        $this->_sheetInstance = $this->_object->setActiveSheetIndex($index);
        return $this;
    }

    /**
     * @param string $dataRange Data range.
     * @return $this
     */
    public function setDataRange($dataRange)
    {
        $this->dataRange = $dataRange;
        return $this;
    }

    /**
     * @return mixed
     */
    public function fetch()
    {
        $this->initColumns();
        $range = static::calcRange($this->dataRange);

        $data = [
           'values' => [],
           'errors' => [],
        ];
        foreach (range($range['start']['row'], $range['end']['row']) as $index => $row) {
            $col = $range['start']['column'];
            $errors = [];
            $rowData = [];
            foreach ($this->_columns as $column) {
                $return = $column->getValue($this->_sheetInstance, $col, $row, $rowData);
                if (isset($return['jump'])) {
                    $col = static::increment($col, $return['jump']);
                }
                if (!empty($return['error'])) {
                    $errors[$column->name] = $return['error'];
                }
                $col = static::increment($col, 1);
            }

            if (empty($errors)) {
                $data['values'][$index] = $rowData;
            } else {
                $data['errors'][$index] = [
                    'values' => $rowData,
                    'errors' => $errors
                ];
            }
        }
        return $data;
    }

    /**
     * @param string  $col   Column Name.
     * @param integer $count Increment Count.
     * @return string
     */
    public static function increment($col, $count)
    {
        if ($count == 0) {
            return $col;
        }

        if ($col[strlen($col) - 1] == 'Z') {
            if (preg_match('/^Z+$/', $col)) {
                $ret = 'A' . preg_replace('/./', 'A', $col);
            } else {
                preg_match('/([^Z]*)(Z+)/', $col, $match);
                $ret = ++$match[1] . preg_replace('/./', 'A', $match[2]);
            }
            if ($count == 1) {
                return $ret;
            } else {
                return static::increment($ret, $count - 1);
            }
        } else {
            if ($count == 1) {
                return ++$col;
            } else {
                return static::increment(++$col, $count - 1);
            }
        }
    }

    /**
     * @param string $dataRange XLS range string.
     * @return array
     */
    public static function calcRange($dataRange)
    {
        $cells = explode(':', $dataRange);
        preg_match('/([a-zA-Z]+)(\d+)/', $cells[0], $start);
        preg_match('/([a-zA-Z]+)(\d+)/', $cells[1], $end);

        return [
            'start' => [
                'column' => strtoupper($start[1]),
                'row' => $start[2],
            ],
            'end' => [
                'column' => strtoupper($end[1]),
                'row' => $end[2],
            ]
        ];
    }

    /**
     * @return void
     */
    private function initColumns()
    {
        foreach ($this->columnConfig as $key => $config) {
            $this->_columns[] = columns\BaseColumn::factory($key, $config);
        }
    }
}

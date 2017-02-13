<?php
/**
 * BaseColumn class file
 * @package XLSWoles\columns
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */

namespace XLSWoles\columns;

use XLSWoles\filters\DefaultValueFilter;
use XLSWoles\filters\NullOnEmptyFilter;
use XLSWoles\filters\RegexFilter;
use XLSWoles\filters\StringLowercaseFilter;
use XLSWoles\filters\StringToTimeFilter;
use XLSWoles\filters\StringUppercaseFilter;
use XLSWoles\validators\InValidator;
use XLSWoles\validators\RequiredValidator;

/**
 * Class BaseColumn
 * @package XLSWoles\columns
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */
class BaseColumn
{
    const TYPE_SINGLE_COLUMN = 'singleColumn';
    const TYPE_MULTI_COLUMN = 'multiColumn';

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $format;

    /**
     * @var array
     */
    public $asEmptyValue;

    /**
     * @var array
     */
    public $filters;

    /**
     * @var array
     */
    public $validators;

    /**
     * @var array
     */
    public $_filters = [];

    /**
     * @var array
     */
    public $_validators = [];

    /**
     * @var array
     */
    public static $defaultConfig = [
        'type' => 'singleColumn',
        'format' => 'regex:.*',
        'asEmptyValue' => [
            'N/A',
            'TBA'
        ],
        'filters' => [],
        'validators' => [],
    ];

    /**
     * @var array
     */
    protected $rowData;

    /**
     * @param string $key    Column name.
     * @param array  $config Column configuration.
     * @return static
     */
    public static function factory($key, array $config)
    {
        $config = array_merge(static::$defaultConfig, $config);
        if ($config['type'] == static::TYPE_SINGLE_COLUMN) {
            $obj = new SingleColumn();
            $obj->format = $config['format'];
        } elseif ($config['type'] == static::TYPE_MULTI_COLUMN) {
            $obj = new MultipleColumn();
            $obj->columnCount = $config['columnCount'];
            $obj->translate = $config['translate'];
        }
        $obj->name = $key;
        $obj->filters = $config['filters'];
        $obj->validators = $config['validators'];
        $obj->asEmptyValue = $config['asEmptyValue'];
        $obj->initFilters();
        $obj->initValidators();

        return $obj;
    }

    /**
     * @return void
     */
    public function initValidators()
    {
        foreach ($this->validators as $validator) {
            if (is_string($validator)) {
                $obj = $this->createValidator($validator);
            } else {
                $class = $validator['class'];
                unset($validator['class']);
                $obj = $this->createValidator($class, $validator, true);
            }
            $this->_validators[] = $obj;
        }
    }

    /**
     * @return void
     */
    public function initFilters()
    {
        foreach ($this->filters as $filter) {
            if (is_string($filter)) {
                $arr = explode('||', $filter);
                $obj = $this->createFilter($arr[0], $arr);
            } else {
                $class = $filter['class'];
                unset($filter['class']);
                $obj = $this->createFilter($class, $filter, true);
            }
            $this->_filters[] = $obj;
        }

        $this->_filters[] = new NullOnEmptyFilter();
    }

    /**
     * @param string  $class Class Name
     * @param array   $config
     * @param boolean $configExplicit
     * @return object
     */
    private function createValidator($class, $config = [], $configExplicit = false)
    {
        if ($class == RequiredValidator::KEYWORD) {
            $class = 'XLSWoles\validators\RequiredValidator';
        } elseif ($class == InValidator::KEYWORD) {
            $class = 'XLSWoles\validators\InValidator';
        }
        $validator = new $class();
        foreach ($config as $key => $value) {
           $validator->{$key} = $value;
        }
        return $validator;
    }

    /**
     * @param string  $class Class Name
     * @param array   $config
     * @param boolean $configExplicit
     * @return object
     */
    private function createFilter($class, $config = [], $configExplicit = false)
    {
        if ($class == StringLowercaseFilter::KEYWORD) {
            $class = 'XLSWoles\filters\StringLowercaseFilter';
        } elseif ($class == StringUppercaseFilter::KEYWORD) {
            $class = 'XLSWoles\filters\StringUppercaseFilter';
        } elseif ($class == StringToTimeFilter::KEYWORD) {
            $class = 'XLSWoles\filters\StringToTimeFilter';
        } elseif ($class == DefaultValueFilter::KEYWORD) {
            $class = 'XLSWoles\filters\DefaultValueFilter';
            if (!$configExplicit) {
                $config = [
                    'value' => $config[1]
                ];
            }
        } elseif ($class == RegexFilter::KEYWORD) {
            $class = 'XLSWoles\filters\RegexFilter';
            if (!$configExplicit) {
                $config = [
                    'input' => $config[1],
                    'output' => $config[2]
                ];
            }
        }
        $filter = new $class();
        foreach ($config as $key => $value) {
            $filter->{$key} = $value;
        }
        return $filter;
    }

    /**
     * @param string $string Text.
     * @return string
     */
    public function runThroughFilters($string)
    {
        foreach ($this->_filters as $filter) {
            $string = $filter->process($string, $this->rowData);
        }
        return $string;
    }

    /**
     * @param string $string Text.
     * @return string
     */
    public function runThroughValidators($string)
    {
        foreach ($this->_validators as $validator) {
            $error = $validator->check($string);
            if (!empty($error)) {
               return $error;
            }
        }
    }
}

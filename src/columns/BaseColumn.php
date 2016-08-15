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
    public $_filters = [];

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
        'filters' => []
    ];

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
        $obj->asEmptyValue = $config['asEmptyValue'];
        $obj->initFilters();

        return $obj;
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
     * @param array $config
     * @return object
     */
    private function createFilter($class, $config, $configExplicit = false)
    {
        if ($class == StringLowercaseFilter::KEYWORD) {
            $class = StringLowercaseFilter::class;
        } elseif ($class == StringUppercaseFilter::KEYWORD) {
            $class = StringUppercaseFilter::class;
        } elseif ($class == StringToTimeFilter::KEYWORD) {
            $class = StringToTimeFilter::class;
        } elseif ($class == DefaultValueFilter::KEYWORD) {
            $class = DefaultValueFilter::class;
            if (!$configExplicit) {
                $config = [
                    'value' => $config[1]
                ];
            }
        } elseif ($class == RegexFilter::KEYWORD) {
            $class = RegexFilter::class;
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
            $string = $filter->process($string);
        }
        return $string;
    }
}

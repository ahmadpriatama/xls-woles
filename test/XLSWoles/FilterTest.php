<?php
/**
 * FilterTest class file
 * @package XLSWoles\Test\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.19
 */
namespace XLSWoles\Test;

use XLSWoles\filters\DefaultValueFilter;
use XLSWoles\filters\NullOnEmptyFilter;
use XLSWoles\filters\RegexFilter;
use XLSWoles\filters\StringLowercaseFilter;
use XLSWoles\filters\StringToTimeFilter;
use XLSWoles\filters\StringUppercaseFilter;

/**
 * Class FilterTest
 * @package XLSWoles\Test\filters
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.19
 */
class FilterTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultValueFilterProcess()
    {
        $obj = new DefaultValueFilter();
        $obj->value = 'Some Value';
        $this->assertSame('Some Value', $obj->process(null));
        $this->assertSame('Some Value', $obj->process(0));
        $this->assertSame('Some Value', $obj->process(''));
        $this->assertSame('Other Value', $obj->process('Other Value'));
    }

    public function testNullOnEmptyFilterProcess()
    {
        $obj = new NullOnEmptyFilter();
        $this->assertSame(null, $obj->process(null));
        $this->assertSame(null, $obj->process(0));
        $this->assertSame(null, $obj->process(''));
        $this->assertSame('Other Value', $obj->process('Other Value'));
    }

    public function testRegexFilterProcess()
    {
        $obj = new RegexFilter();
        $obj->input = '(\d)(\d)';
        $obj->output = '$2$1';
        $this->assertSame('21', $obj->process('12'));
    }

    public function testStringLowercaseProcess()
    {
        $obj = new StringLowercaseFilter();
        $this->assertSame('a string', $obj->process('A String'));
    }

    public function testStringUppercaseProcess()
    {
        $obj = new StringUppercaseFilter();
        $this->assertSame('A STRING', $obj->process('A String'));
    }

    public function testStringToTimeProcess()
    {
        $obj = new StringToTimeFilter();
        $this->assertSame(time(), $obj->process('Now'));
    }
}
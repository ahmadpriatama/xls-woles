<?php

namespace XLSWoles\Test;

use XLSWoles\Spreadsheet;

class SpreadsheetTest extends \PHPUnit_Framework_TestCase
{
    public function testSpreadsheetIncrement()
    {
        $this->assertSame('A', Spreadsheet::increment('A', 0));
        $this->assertSame('B', Spreadsheet::increment('A', 1));
        $this->assertSame('AA', Spreadsheet::increment('Z', 1));
        $this->assertSame('AB', Spreadsheet::increment('Z', 2));
        $this->assertSame('BB', Spreadsheet::increment('AZ', 2));
    }

    public function testSpreadsheetCalcRange()
    {
        $this->assertSame([
            'start' => [
                'column' => 'A',
                'row' => '1'
            ],
            'end' => [
                'column' => 'B',
                'row' => '5'
            ],
        ], Spreadsheet::calcRange('a1:b5'));
    }
}

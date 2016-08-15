<?php
/**
 * Reader class file
 * @package XLSWoles\src
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */

namespace XLSWoles;

/**
 * Class Reader
 * @package XLSWoles\src
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.15
 */
class Reader extends \PHPExcel\IOFactory
{
    /**
     * @param string $fileName File path.
     * @return Spreadsheet
     */
    public static function load($fileName)
    {
        $spreadsheet = parent::load($fileName);

        return new Spreadsheet($spreadsheet);
    }
}
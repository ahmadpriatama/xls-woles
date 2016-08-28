<?php

/**
 * Class SplitNameFilter
 * @author Ahmad Priatama <ahmad.priatama@gmail.com>
 * @since 2016.08.28
 */
class SplitNameFilter
{

    /**
     * @param string $input Input String
     * @return array
     */
    public function process($input)
    {
        $arr = explode(' ', $input);
        $count = count($arr);
        if ($count == 1) {
            return [
                'first-name' => $arr[0],
                'last-name' => null,
            ];
        } else {
            return [
                'first-name' => implode(' ', array_slice($arr, 0, $count-1)),
                'last-name' => $arr[$count-1],
            ];
        }
    }
}
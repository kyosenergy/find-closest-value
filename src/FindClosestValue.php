<?php

namespace Kyos\FindClosestValue;

class FindClosestValue
{
    /**
     * Finds the closest arithmetic match on an array
     *
     * @param int[]|float[] $arr
     * @param int|float     $target
     *
     * @return int|float
     *
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function findClosest(array $arr, $target)
    {
        if (empty($arr)) {
            throw new \InvalidArgumentException('Provided array cannot be empty');
        }

        // Exact match
        if (array_search($target, $arr) !== false) {
            return $target;
        }

        sort($arr);

        // Lower boundary
        if ($target <= $arr[0]) {
            return $arr[0];
        }

        $arraySize = count($arr);

        // Higher boundary
        if ($target >= $arr[$arraySize - 1]) {
            return $arr[$arraySize - 1];
        }

        $low = 0;
        $high = $arraySize;
        while ($low < $high) {
            $mid = intdiv(($low + $high), 2);

            // If target is less than mid array element
            if ($target < $arr[$mid]) {
                // If target is greater than previous to mid, return closest of two
                if ($mid > 0 && $target > $arr[$mid - 1]) {
                    return $this->getClosest($arr[$mid - 1], $arr[$mid], $target);
                }

                // Move high to the left boundary
                $high = $mid;
            } else {
                // If target is higher than next to mid, return closest of two
                if ($mid < $arraySize - 1 && $target < $arr[$mid + 1]) {
                    return $this->getClosest($arr[$mid], $arr[$mid + 1], $target);
                }

                // Move low to the right boundary
                $low = $mid + 1;
            }
        }

        throw new \Exception('Closest match could not be found');
    }

    /**
     * Finds the closest arithemtic match, between 2 numbers and a given target.
     * On equidistant, it retunrs the lower value
     *
     * This works with the assumption that target is between $val1 and $val2 and $val1 <= $val2
     *
     * @param int|float $val1
     * @param int|float $val2
     * @param int|float $target
     *
     * @return int|float
     */
    private function getClosest($val1, $val2, $target)
    {
        return ($target - $val1 <= $val2 - $target) ? $val1 : $val2;
    }
}

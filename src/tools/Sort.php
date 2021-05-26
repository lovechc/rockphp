<?php
/**
 * 排序
 */

namespace tools;
class Sort
{
    /**
     * 二分查找
     * @param array $arr 数据源
     * @param string $find 要查找的元素
     * @param int $offset 偏移量 - 从哪个开始查
     * @param bool $end 查到什么位置结果 - 默认结尾
     * @return int 返回下标 如果没有返回-1
     */
    public static function binSearch(array $arr, string $find, int $offset = 0, bool $end = false): int
    {
        if (false === $end)
            $end = count($arr);
        if ($end < $offset) {
            return -1;
        }
        $mid = intval(($offset + $end) / 2);
        if ($find == $arr[$mid]) {
            return $mid;
        } else if ($find > $arr[$mid]) {
            return self::binSearch($arr, $find, ++$mid, $end);
        } else {
            return self::binSearch($arr, $find, $offset, --$mid);
        }
    }

    /**
     * 冒泡排序
     * @param array $arr 数据源
     * @return array 结果集
     */
    public static function bubbleSort(array $arr): array
    {
        // 每次让最大或最小的一个排到最前面，排count-1次；
        for ($i = 0; $i < count($arr) - 1; $i++) {
            // 假设当前次数的下标元素就是最大或最小 $arr[$i]
            $flag = true;
            for ($j = $i + 1; $j < count($arr); $j++) {
                if ($arr[$i] > $arr[$j]) {
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$i];
                    $arr[$i] = $tmp;
                    $flag = false;  // 如果每次遍历的时候，没有发生位置交换，意味着本身有序，就不需要再次遍历了
                }
            }
            if ($flag)
                break;
        }
        return $arr;
    }

    /**
     * 插入排序法
     * @param array $arr 数据源
     * @return array 结果集
     */
    public static function insertSort(array $arr): array
    {
        $tmp = [];
        // 每次取最大的一个，依次放到新数组；取元素个数的次数。
        $num = count($arr);
        for ($n = 0; $n < $num; $n++) {
            $now = $arr[$n]; // 假如每次都是当前次下标元素最大或者最小
            for ($i = $n + 1; $i < $num; $i++) {
                if ($now > $arr[$i]) {  // 每次取最小
                    $t = $arr[$i];
                    $arr[$i] = $now;
                    $now = $t;
                }
            }
            $tmp[] = $now;
        }
        return $tmp;
    }

    /**
     * 快速排序
     * @param array $arr
     * @return array
     */
    public static function quickSort(array $arr): array
    {
        if (count($arr) <= 1) {
            return $arr;
        }
        // 以第一个为参照，分为左中右三部分
        $mid = $arr[0];
        $lArr = [];
        $rArr = [];
        for ($i = 1; $i < count($arr); $i++) {
            if ($mid <= $arr[$i]) {
                $rArr[] = $arr[$i];
            } else {
                $lArr[] = $arr[$i];
            }
        }
        return array_merge(self::quickSort($lArr), [$mid], self::quickSort($rArr));
    }
}
<?php
/**
 * 时间
 */

namespace tools;

class Time
{
    /**
     * 获取13位时间戳
     * @return int
     */
    public static function get13TimeStamp(): int
    {
        list($t1, $t2) = explode(' ', microtime());
        return $t2 . ceil($t1 * 1000);
    }

    /**
     * 计算两个日期相隔多少年，多少月，多少天
     * @param $date1 [格式如：2011-11-5]
     * @param $date2
     * @return array array('年','月','日');
     */
    public static function diffDate(string $date1, string $date2): array
    {
        if (strtotime($date1) > strtotime($date2)) {
            $tmp = $date2;
            $date2 = $date1;
            $date1 = $tmp;
        }
        list($Y1, $m1, $d1) = explode('-', $date1);
        list($Y2, $m2, $d2) = explode('-', $date2);
        $Y = $Y2 - $Y1;
        $m = $m2 - $m1;
        $d = $d2 - $d1;
        if ($d < 0) {
            $d += (int)date('t', strtotime("-1 month $date2"));
            $m--;
        }
        if ($m < 0) {
            $m += 12;
            $Y--;
        }
        return ['year' => $Y, 'month' => $m, 'day' => $d];
    }
}
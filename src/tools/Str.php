<?php
/**
 * 字符串操作
 */

namespace tools;
class Str
{
    /**
     * 验证邮箱
     * @param $email
     * @return bool
     */
    public static function isEmail(string $email): bool
    {
        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        if (preg_match($pattern, $email)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获得随机字符串
     * @param $len
     * @param bool $special 是否包含特殊字符
     * @return string
     */
    public static function getRandomStr(int $len = 6, bool $special = true): string
    {
        $chars = [
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        ];

        if ($special) {
            $chars = array_merge($chars, [
                "!", "@", "#", "$", "?", "|", "{", "/", ":", ";",
                "%", "^", "&", "*", "(", ")", "-", "_", "[", "]",
                "}", "<", ">", "~", "+", "=", ",", "."
            ]);
        }

        $charsLen = count($chars) - 1;
        shuffle($chars);
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $charsLen)];
        }
        return $str;
    }

    /**
     * 将字符串转为utf8编码
     * @param string $str
     * @return false|string|string[]|null
     */
    public static function strToUtf8(string $str = ''): string
    {
        $encode = mb_detect_encoding($str, ['GBK', 'ASCII', 'UTF-8', 'GB2312', 'BIG5']);
        if ($encode == 'UTF-8') {
            return $str;
        } else {
            return mb_convert_encoding($str, 'UTF-8', $encode);
        }
    }

    /**
     * 根据经纬度算距离
     * 返回结果单位是公里，先纬度，后经度
     * @param $lat1
     * @param $lng1
     * @param $lat2
     * @param $lng2
     * @return float|int
     */
    public static function getDistance($lat1, $lng1, $lat2, $lng2)
    {
        function rad($d)
        {
            return $d * M_PI / 180.0;
        }

        $EARTH_RADIUS = 6378.137;
        $radLat1 = rad($lat1);
        $radLat2 = rad($lat2);
        $a = $radLat1 - $radLat2;
        $b = rad($lng1) - rad($lng2);
        $s = $EARTH_RADIUS * 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
        $s = round($s * 10000) / 10000;
        return $s;
    }

}
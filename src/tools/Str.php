<?php

namespace tools;
class Str
{
    public static function strToUpper(string $str)
    {
        return strtoupper($str) . '_UPPER';
    }
}
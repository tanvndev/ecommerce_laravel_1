<?php

if (!function_exists('formatToCommas')) {
    function formatToCommas($nStr)
    {
        $nStr = strval($nStr);
        $nStr = str_replace('.', '', $nStr);
        $str = "";
        for ($i = strlen($nStr); $i > 0; $i -= 3) {
            $a = $i - 3 < 0 ? 0 : $i - 3;
            $str = substr($nStr, $a, $i - $a) . "." . $str;
        }
        $str = substr($str, 0, -1);
        return $str;
    }
}
if (!function_exists('convertPrice')) {

    function convertPrice($priceString)
    {
        $priceWithoutDots = str_replace('.', '', $priceString);
        // Chuyển đổi chuỗi thành số nguyên
        $price = intval($priceWithoutDots);
        return $price;
    }
}

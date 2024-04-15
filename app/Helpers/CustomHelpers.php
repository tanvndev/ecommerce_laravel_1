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

if (!function_exists('recursive')) {

    function recursive($data, $parent_id = 0)
    {
        $result = [];
        if (!is_null($data) && count($data) > 0) {
            foreach ($data as $key => $value) {
                if ($value->parent_id == $parent_id) {
                    $result[] = [
                        'item' => $value,
                        'children' => recursive($data, $value->id)
                    ];
                }
            }
        }

        return $result;
    }
}

if (!function_exists('recursive_menu')) {
    function recursive_menu($data)
    {
        $html = '';
        foreach ($data as $value) {
            $itemId = $value['item']->id;
            $itemName = $value['item']->languages->first()->pivot->name;
            $itemUrl = route('menu.children', $itemId);

            $html .= "<li class=\"dd-item\" data-id=\"{$itemId}\">";
            $html .= "<div class=\"dd-handle\">{$itemName}</div>";
            $html .= "<a class=\"link-info create-children-menu\" href=\"{$itemUrl}\">Quản lý menu con</a>";

            if (!empty($value['children'])) {
                $html .= "<ol class=\"dd-list\">" . recursive_menu($value['children']) . "</ol>";
            }

            $html .= "</li>";
        }
        return $html;
    }
}

if (!function_exists('buildMenu')) {
    function buildMenu($menus = [], $parentId = 0, $prefix = '')
    {
        $output = [];
        $count = 1;

        if (count($menus) > 0) {
            foreach ($menus as $key => $value) {
                if ($value->parent_id  == $parentId) {
                    $value->position = $prefix . $count;
                    $output[] = $value;
                    $output = array_merge($output, buildMenu($menus, $value->id, $prefix . $count . '.'));
                    $count++;
                }
            }
        }
        return $output;
    }
}

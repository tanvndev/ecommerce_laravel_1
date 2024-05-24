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
if (!function_exists('formatCurrency')) {

    function formatCurrency($amount, $currencyCode = 'vn')
    {
        switch (strtoupper($currencyCode)) {
            case 'VN':
                // Định dạng cho tiền tệ Việt Nam (VND)
                return number_format($amount, 0, ',', '.') . ' ₫';
            case 'CN':
                // Định dạng cho tiền tệ Trung Quốc (CNY)
                return '¥' . number_format($amount, 2, '.', ',');
            case 'EN':
                // Định dạng cho tiền tệ Hoa Kỳ (USD)
                return '$' . number_format($amount, 2, '.', ',');
            default:
                // Nếu mã tiền tệ không được hỗ trợ, trả về số tiền gốc
                return $amount;
        }
    }
}

if (!function_exists('getPrice')) {
    function getPrice($product)
    {
        $result = [
            'price' => $product->price,
            'priceSale' => $product->price,
            'percent' => 0,
            'priceHtml' => '',
            'discountHtml' => '',
        ];

        $price = formatCurrency($result['price']);

        if ($product->promotions->isNotEmpty()) {
            $promotion = $product->promotions[0];

            if ($promotion->discount_type == 'percent') {
                $result['percent'] = $promotion->discount_value;
                $result['priceSale'] = $result['price'] * (1 - $result['percent'] / 100);
            } else {
                $result['priceSale'] = $result['price'] - $promotion->discount_value;
                $result['percent'] = ($promotion->discount_value / $result['price']) * 100;
            }

            $result['priceSale'] = formatCurrency($result['priceSale']);

            $result['priceHtml'] = "
            <span class='price current-price'>{$result['priceSale']}</span>
            <span class='price old-price'>{$price}</span>
            ";

            $result['discountHtml'] = "
            <div class='label-block label-right'>
                <div class='product-badget'>Giảm {$result['percent']}%</div>
            </div>
            ";
        } else {
            $result['priceHtml'] = "<span class='price current-price'>{$price}</span>";
        }

        return $result;
    }
}

if (!function_exists('getReview')) {
    function getReview($product)
    {
        $number = rand(1, 5);
        $filledStars = round($number);
        $starArray = array();

        for ($index = 0; $index < 5; $index++) {
            if ($index < $filledStars) {
                $starArray[] = '<i class="fas fa-star"></i>';
            } else {
                $starArray[] = '<i class="far fa-star"></i>';
            }
        }
        return [
            'star' => implode(' ', $starArray),
            'count' => rand(1, 999)
        ];
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

if (!function_exists('client_recursive_menu')) {
    function client_recursive_menu($data, $parentId = 0, $type = 'html')
    {
        $html = '';
        if (count($data) > 0) {
            if ($type == 'html') {
                foreach ($data as $key => $value) {
                    $name = $value['item']->languages->first()->pivot->name;
                    $canonical = write_url($value['item']->languages->first()->pivot->canonical);

                    if (count($value['children']) > 0) {
                        $html .= '<li class="menu-item-has-children">';
                        $html .= "<a title=\"{$name}\" href=\"{$canonical}\">{$name}</a>";
                        $html .= '<ul class="axil-submenu">';
                        $html .= client_recursive_menu($value['children'], $value['item']->parent_id);
                        $html .= '</ul>';
                        $html .= '</li>';
                    } else {
                        $html .= "<li><a title=\"{$name}\" href=\"{$canonical}\">{$name}</a></li>";
                    }
                }
                return $html;
            }
        }
        return $data;
    }
}

if (!function_exists('write_url')) {
    function write_url($canonical = '', $fullDomain = true, $suffix = false)
    {
        if (strpos($canonical, 'http') !== false) {
            return $canonical;
        }

        $fullUrl = (($fullDomain === true) ? config('app.url') : '') . $canonical . ($suffix === true ? config('apps.general.suffix') : '');

        return $fullUrl;
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

if (!function_exists('convertArrayByKey')) {
    function convertArrayByKey($data = null, $fields)
    {
        $outputs = [];

        foreach ($data as $key => $value) {
            foreach ($fields as $field) {
                if (is_array($data)) {
                    $outputs[$field][] = $value[$field] ?? null;
                } else {
                    $extract = explode('.', $field);
                    if (count($extract) == 2) {
                        $outputs[$extract[0]][] = $value->{$extract[1]}->first()->pivot->{$extract[0]};
                    } else {
                        $outputs[$field][] = $value->{$field} ?? null;
                    }
                }
            }
        }
        return $outputs;
    }
}

if (!function_exists('convertDateTime')) {
    function convertDateTime($dateTime = '', $format = 'd/m/Y H:i')
    {
        return date($format, strtotime($dateTime));
    }
}
if (!function_exists('renderDiscountInfomation')) {
    function renderDiscountInfomation($promotion = null)
    {
        if ($promotion->method == 'product_and_quantity') {
            $discountValue = $promotion->discount_infomation['info']['discount_value'];
            $discountType = $promotion->discount_infomation['info']['discount_type'] == 'percent' ? '%' : 'đ';

            return "<span class='badge bg-success px-3 py-2 fs-12'>$discountValue$discountType</span>";
        }
        return "<a class='link-primary' href='" . route('promotion.edit', $promotion->id) . "'>Xem chi tiết</a>";
    }
}


if (!function_exists('renderQuickView')) {
    function renderQuickView($product, $canonical, $name)
    {
        $html = "
        <li class='select-option'>
            <a ";

        if (isset($product->product_variants) && count($product->product_variants) > 0) {
            $html .= "data-bs-toggle='modal' data-bs-target='#quick-view-modal' ";
        }

        $html .= "href='{{ $canonical }}' title='{{$name}}'>
                Thêm vào giỏ hàng
            </a>
        </li>
        ";

        return $html;
    }
}

if (!function_exists('seo')) {
    function seo($model)
    {
        $seo = [
            'meta_title' => ($model->meta_title) ?? $model->name,
            'meta_description' => ($model->meta_description) ?? cut_string_and_decode($model->description),
            'meta_keywords' => ($model->meta_keywords) ?? $model->name,
            'meta_image' => ($model->image) ?? '',
            'canonical' => (write_url($model->canonical)) ?? '',
        ];

        return $seo;
    }
}

if (!function_exists('cut_string_and_decode')) {
    function cut_string_and_decode($str = null, $n = 200)
    {
        $str = html_entity_decode($str);
        $str = strip_tags($str);
        if (mb_strlen($str) > $n) {
            $str = mb_substr($str, 0, $n) . '...';
        }
        return $str;
    }
}

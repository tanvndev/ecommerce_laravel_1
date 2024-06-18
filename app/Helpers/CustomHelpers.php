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
if (!function_exists('sortString')) {
    function sortString($string)
    {
        if ($string == '') {
            return '';
        }

        $array = explode(", ", $string);
        sort($array, SORT_NUMERIC);
        $sortedNumbers = implode(", ", $array);
        return $sortedNumbers;
    }
}

if (!function_exists('getPrice')) {
    function getPrice($product)
    {
        $promotion = null;

        if (isset($product->promotion)) {
            if (!is_null($product->promotion[0])) {
                $promotion = $product->promotion[0];
            } elseif (!is_null($product->promotion)) {
                $promotion = $product->promotion;
            }
        }

        $result = calculatePrice($product->price, $promotion);
        return $result;
    }
}


if (!function_exists('getVariantPrice')) {
    function getVariantPrice($variant, $variantPromotion)
    {
        $result = calculatePrice($variant->price, $variantPromotion);
        return $result;
    }
}

if (!function_exists('calculatePrice')) {
    function calculatePrice($price, $promotion = null)
    {
        $result = [
            'price' => $price,
            'priceSale' => $price,
            'percent' => 0,
            'priceHtml' => '',
            'discountHtml' => '',
        ];

        $formattedPrice = formatCurrency($price);

        if (!is_null($promotion)) {

            if ($promotion->discount_type == 'percent') {
                $result['percent'] = $promotion->discount_value;
            } else {
                $result['percent'] = ($promotion->discount_value / $result['price']) * 100;
            }

            // dd($promotion);

            $result['priceSale'] = $result['price'] - $promotion->discount;
            $priceSale = formatCurrency($result['priceSale']);

            $result['priceHtml'] = "
                <span class='price current-price'>{$priceSale}</span>
                <span class='price old-price'>{$formattedPrice}</span>
            ";

            $result['discountHtml'] = "
                <div class='label-block label-right product-variant-disocunt'>
                    <div class='product-badget'>Giảm {$result['percent']}%</div>
                </div>
            ";

            if ($promotion->discount > $price) {
                $result['priceHtml'] = "<span class='price current-price'>{$formattedPrice}</span>";
                $result['discountHtml'] = "";
            }
        } else {
            $result['priceHtml'] = "<span class='price current-price'>{$formattedPrice}</span>";
        }

        return $result;
    }
}

if (!function_exists('getReview')) {
    function getReview($model)
    {
        $number = $rate ?? rand(1, 5);
        $filledStars = round($number, 0);
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
            'count' => $count ?? rand(1, 999)
        ];
    }
}

if (!function_exists('generateStar')) {
    function generateStar($rate)
    {
        $filledStars = round($rate, 0);
        $starArray = array();

        for ($index = 0; $index < 5; $index++) {
            if ($index < $filledStars) {
                $starArray[] = '<i class="fas fa-star"></i>';
            } else {
                $starArray[] = '<i class="far fa-star"></i>';
            }
        }
        return implode(' ', $starArray);
    }
}

if (!function_exists('generateStarPercent')) {
    function generateStarPercent($rate = 100)
    {
        $percent =  round(100 - ($rate / 5 * 100));

        // Start building the HTML string
        $html = '
        <div class="stars-percent lh-1">
        ';

        // Generate 5 stars
        for ($i = 0; $i < 5; $i++) {
            $html .= '
            <svg viewBox="0 0 940.688 940.688">
                <path d="M885.344,319.071l-258-3.8l-102.7-264.399c-19.8-48.801-88.899-48.801-108.6,0l-102.7,264.399l-258,3.8 c-53.4,3.101-75.1,70.2-33.7,103.9l209.2,181.4l-71.3,247.7c-14,50.899,41.1,92.899,86.5,65.899l224.3-122.7l224.3,122.601 c45.4,27,100.5-15,86.5-65.9l-71.3-247.7l209.2-181.399C960.443,389.172,938.744,322.071,885.344,319.071z"/>
            </svg>
            ';
        }

        // Add overlay with dynamic width
        $html .= '
            <div class="overlay" style="width: ' . htmlspecialchars($percent) . '%;"></div>
        </div>
        ';

        return $html;
    }
}

if (!function_exists('renderProress')) {
    function renderProress($rate = 100)
    {
        $percent =  round(100 - ($rate / 5 * 100));

        // Start building the HTML string
        $html = '
        <div class="stars-percent">
        ';

        // Generate 5 stars
        for ($i = 0; $i < 5; $i++) {
            $html .= '
            <svg width="auto" height="auto" viewBox="0 0 940.688 940.688">
                <path d="M885.344,319.071l-258-3.8l-102.7-264.399c-19.8-48.801-88.899-48.801-108.6,0l-102.7,264.399l-258,3.8 c-53.4,3.101-75.1,70.2-33.7,103.9l209.2,181.4l-71.3,247.7c-14,50.899,41.1,92.899,86.5,65.899l224.3-122.7l224.3,122.601 c45.4,27,100.5-15,86.5-65.9l-71.3-247.7l209.2-181.399C960.443,389.172,938.744,322.071,885.344,319.071z"/>
            </svg>
            ';
        }

        // Add overlay with dynamic width
        $html .= '
            <div class="overlay" style="width: ' . htmlspecialchars($percent) . '%;"></div>
        </div>
        ';

        return $html;
    }
}





if (!function_exists('sortAttributeId')) {
    function sortAttributeId($attributeId)
    {
        sort($attributeId, SORT_NUMERIC);
        $attributeId = implode(", ", $attributeId);
        return $attributeId;
    }
}


if (!function_exists('renderOrderStatusDropdown')) {
    function renderOrderStatusDropdown($order, $name, $class = 'w-100 init-nice-select update-order')
    {
        $html = '<div class="update-order-wrap">';

        $html .= ' <select name="' . $name . '" id="' . $name . '" data-field="' . $name . '" class="' . $class . '">';
        foreach (__("cart.{$name}") as $value => $label) {
            if ($value == '') continue;
            $isSelected = ($order->{$name} == $value) ? 'selected' : '';
            $html .= '<option value="' . $value . '" ' . $isSelected . '>' . $label . '</option>';
        }
        $html .= '</select>';

        $html .= '</div>';

        if ($order->confirm === 'cancel') {
            return '<span class="badge text-center bg-danger">Đơn hàng đã hủy</span>';
        }
        return $html;
    }
}


if (!function_exists('convertVndTo')) {

    function convertVndTo($amountVnd, $currency = 'USD')
    {
        // Example exchange rates; in a real application, you would get these from an API or a config file.
        $exchangeRates = [
            'USD' => 0.000043,
            'EUR' => 0.000038,
            // Add more currencies as needed
        ];

        if (!isset($exchangeRates[$currency])) {
            throw new Exception("Exchange rate for currency '{$currency}' not found.");
        }

        $result = number_format($amountVnd * $exchangeRates[$currency], 2, '.', '');
        return $result;
    }
}

if (!function_exists('abbreviateName')) {
    function abbreviateName($fullName)
    {
        $parts = explode(' ', $fullName);
        $abbreviation = '';
        foreach ($parts as $part) {
            $abbreviation .= strtoupper(substr($part, 0, 1));
        }
        return $abbreviation;
    }
}


if (!function_exists('renderRatingFilter')) {
    function renderRatingFilter()
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            $html .= '<div class="mb-3 ps-0 form-check filter-star">';
            $html .= '<input type="checkbox" class="form-check-input filtering" name="rate[]" value="' . $i . '" id="rate_' . $i . '">';
            $html .= '<label class="form-check-label" for="rate_' . $i . '">';
            for ($j = 0; $j < 5; $j++) {
                $html .= '<i class="flaticon-star me-1 ' . ($i > $j ? 'active' : '') . '"></i>';
            }
            $html .= '</label>';
            $html .= '</div>';
        }
        return $html;
    }
}

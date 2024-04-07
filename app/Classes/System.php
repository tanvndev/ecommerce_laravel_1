<?php

namespace App\Classes;

class System
{
    public function config()
    {

        $data['homePage'] = [
            'label' => 'Thông tin chung',
            'description' => 'Cài đặt đầy đủ cấu hình thông tin chung của website. Tên thương hiệu, logo, ...',
            'value' => [
                'company' => ['type' => 'text', 'label' => 'Tên công ty'],
                'brand' => ['type' => 'text', 'label' => 'Tên công ty'],
                'slogan' => ['type' => 'text', 'label' => 'Slogan'],
                'logo' => ['type' => 'image', 'label' => 'Logo website', 'title' => 'Click vào ô phía dưới để tải logo'],
                'copyright' => ['type' => 'text', 'label' => 'Copyright'],
            ],
        ];
        return $data;
    }
}

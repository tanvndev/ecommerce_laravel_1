<?php

namespace App\Classes;

class System
{
    public function config()
    {

        $data['homePage'] = [
            'name' => 'Home Page',
            'label' => 'Thông tin chung',
            'description' => 'Cài đặt đầy đủ cấu hình thông tin chung của website. Tên thương hiệu, logo, ...',
            'value' => [
                'company' => ['type' => 'text', 'label' => 'Tên công ty'],
                'brand' => ['type' => 'text', 'label' => 'Tên thương hiệu'],
                'slogan' => ['type' => 'text', 'label' => 'Slogan'],
                'logo' => ['type' => 'image', 'label' => 'Logo website', 'title' => 'Click vào ô phía dưới để tải logo.'],
                'copyright' => ['type' => 'text', 'label' => 'Copyright'],
                'website' =>
                [
                    'type' => 'select',
                    'label' => 'Tình trạng website',
                    'options' => [
                        'open' => 'Mở cửa website',
                        'close' => 'Webite đang bảo trì',
                    ],
                ],
                'short_intro' => ['type' => 'editor', 'label' => 'Giới thiệu ngắn'],
                'qrApp' => ['type' => 'image', 'label' => 'QR app', 'title' => 'Click vào ô phía dưới để tải QR.'],
                'AppstoreApp' => ['type' => 'image', 'label' => 'Appstore app', 'title' => 'Click vào ô phía dưới để tải Appstore.'],
                'PlaystoreApp' => ['type' => 'image', 'label' => 'Playstore app', 'title' => 'Click vào ô phải dưới để tải Playstore.'],
                'method_payment' => ['type' => 'image', 'mutiple' => true,  'label' => 'Phương thức thanh toán'],
            ],
        ];


        $data['contactPage'] = [
            'name' => 'Contact Page',
            'label' => 'Thông tin liên hệ',
            'description' => 'Cài đặt đầy đủ cấu hình thông tin liên hệ. Địa chỉ công ty, Văn phòng giao dịch, ...',
            'value' => [
                'office' => ['type' => 'text', 'label' => 'Địa chỉ công ty'],
                'address' => ['type' => 'text', 'label' => 'Văn phòng giao dịch'],
                'hotline' => ['type' => 'text', 'label' => 'Hotline'],
                'technical_phone' => ['type' => 'text', 'label' => 'Hotline kỹ thuật'],
                'sell_phone' => ['type' => 'text', 'label' => 'Hotline kinh doanh'],
                'fax' => ['type' => 'text', 'label' => 'Fax'],
                'email' => ['type' => 'email', 'label' => 'Email'],
                'tax' => ['type' => 'text', 'label' => 'Mã số thuế'],
                'map' =>
                [
                    'type' => 'textarea',
                    'label' => 'Bản đồ',
                    'link' => ['text' => 'Hướng dẫn thiết lập bản đồ.', 'href' => 'https://manhan.vn/hoc-website-nang-cao/huong-dan-nhung-ban-do-vao-website']
                ],
            ],
        ];

        $data['seo'] = [
            'name' => 'Seo Setting',
            'label' => 'Cấu hình SEO dành cho trang chủ',
            'description' => 'Cài đặt đầy đủ cấu hình thông tin chung của website. Tiêu đề SEO, từ khoá, ...',
            'value' => [
                'meta_title' => ['type' => 'text', 'label' => 'Tiêu đề SEO'],
                'meta_keyword' => ['type' => 'text', 'label' => 'Từ khoá SEO'],
                'meta_description' => ['type' => 'textarea', 'label' => 'Mô tả SEO'],
                'meta_image' => ['type' => 'image', 'label' => 'Ảnh SEO', 'title' => 'Click vào ô phía dưới để tải ảnh.'],
                'meta_url' => ['type' => 'text', 'label' => 'Đường dẫn'],
                'description' => ['type' => 'textarea', 'label' => 'Mô tả'],
                'favicon' => ['type' => 'image', 'label' => 'Favicon', 'title' => 'Click vào ô phía dưới để tải ảnh.'],
            ],
        ];

        $data['social'] = [
            'name' => 'Social',
            'label' => 'Cau hinh mang xa hoi',
            'description' => 'Cau hinh cac mang xa hoi hien nay',
            'value' => [
                'facebook' => ['type' => 'text', 'label' => 'Facebook'],
                'twitter' => ['type' => 'text', 'label' => 'Twitter'],
                'youtube' => ['type' => 'text', 'label' => 'Youtube'],
                'instagram' => ['type' => 'text', 'label' => 'Instagram'],
                'pinterest' => ['type' => 'text', 'label' => 'Pinterest'],
                'tiktok' => ['type' => 'text', 'label' => 'Tiktok'],
                'linkedin' => ['type' => 'text', 'label' => 'Linkedin'],
                'skype' => ['type' => 'text', 'label' => 'Skype'],
            ],
        ];

        return $data;
    }
}

<?php
return [
    'dashboard' => [
        'index' => [
            'title' => 'Bảng điều khiển',
        ],
    ],
    'system' => [
        'index' => [
            'title' => 'Cài đặt cấu hình hệ thống',
            'table' => 'Thông tin nhóm hình ảnh',
            'create' => 'Tạo mới nhóm hình ảnh'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm hình ảnh',
            'success' => 'Tạo mới nhóm hình ảnh thành công.',
            'error' => 'Tạo mới nhóm hình ảnh thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập cấu hình hệ thống',
            'success' => 'Cập nhập cấu hình hệ thống thành công.',
            'error' => 'Cập nhập cấu hình hệ thống thất bại.',
        ],
        'delete' => [
            'title' => 'Cập nhập nhóm hình ảnh',
            'success' => 'Xoá nhóm hình ảnh thành công.',
            'error' => 'Xoá nhóm hình ảnh thất bại.',
        ],

    ],
    'menu' => [
        'index' => [
            'table' => 'Thông tin menu',
            'create' => 'Tạo mới menu'
        ],
        'show' => [
            'title' => 'Danh sách menu',
            'success' => 'Cập nhập danh sách menu thành công.',
            'error' => 'Cập nhập danh sách menu thất bại.',

        ],
        'create' => [
            'title' => 'Tạo mới menu',
            'success' => 'Tạo mới menu thành công.',
            'error' => 'Tạo mới menu thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập menu cấp 1',
            'success' => 'Cập nhập menu thành công.',
            'error' => 'Cập nhập menu thất bại.',
        ],
        'children' => [
            'title' => 'Cập nhập menu con cho mục',
            'success' => 'Cập nhập menu con thành công.',
            'error' => 'Cập nhập menu con thất bại.',
        ],
        'translate' => [
            'title' => 'Cập nhật bản dịch cho menu',
            'success' => 'Cập nhập bản dịch thành công.',
            'error' => 'Cập nhập bản dịch thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá menu thành công.',
            'error' => 'Xoá menu thất bại.',
        ],

    ],
    'menuCatalogue' => [
        'index' => [
            'table' => 'Thông tin nhóm menu',
            'create' => 'Tạo mới nhóm menu'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm menu',
            'success' => 'Tạo mới nhóm menu thành công.',
            'error' => 'Tạo mới nhóm menu thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm menu',
            'success' => 'Cập nhập nhóm menu thành công.',
            'error' => 'Cập nhập nhóm menu thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá nhóm menu thành công.',
            'error' => 'Xoá nhóm menu thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm menu',
        ]

    ],
    'attributeCatalogue' => [
        'index' => [
            'title' => 'Danh sách nhóm thuộc tính',
            'table' => 'Thông tin nhóm thuộc tính',
            'create' => 'Tạo mới nhóm thuộc tính'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm thuộc tính',
            'success' => 'Tạo mới nhóm thuộc tính thành công.',
            'error' => 'Tạo mới nhóm thuộc tính thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm thuộc tính',
            'success' => 'Cập nhập nhóm thuộc tính thành công.',
            'error' => 'Cập nhập nhóm thuộc tính thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá nhóm thuộc tính thành công.',
            'error' => 'Xoá nhóm thuộc tính thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm',
            'keyword' => 'Từ khoá '
        ],

    ],

    'attribute' => [
        'index' => [
            'title' => 'Danh sách thuộc tính',
            'table' => 'Thông tin thuộc tính',
            'create' => 'Tạo mới thuộc tính'
        ],
        'create' => [
            'title' => 'Tạo mới thuộc tính',
            'success' => 'Tạo mới thuộc tính thành công.',
            'error' => 'Tạo mới thuộc tính thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập thuộc tính',
            'success' => 'Cập nhập thuộc tính thành công.',
            'error' => 'Cập nhập thuộc tính thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá thuộc tính thành công.',
            'error' => 'Xoá thuộc tính thất bại.',
        ],
        'table' => [
            'name' => 'Tiêu đề thuộc tính',
            'attributeCatalogue' => 'Chọn nhóm thuộc tính',
        ]
    ],

    'productCatalogue' => [
        'index' => [
            'title' => 'Danh sách nhóm sản phẩm',
            'table' => 'Thông tin nhóm sản phẩm',
            'create' => 'Tạo mới nhóm sản phẩm'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm sản phẩm',
            'success' => 'Tạo mới nhóm sản phẩm thành công.',
            'error' => 'Tạo mới nhóm sản phẩm thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm sản phẩm',
            'success' => 'Cập nhập nhóm sản phẩm thành công.',
            'error' => 'Cập nhập nhóm sản phẩm thất bại.',
        ],
        'delete' => [
            'title' => 'Cập nhập nhóm sản phẩm',
            'success' => 'Xoá nhóm sản phẩm thành công.',
            'error' => 'Xoá nhóm sản phẩm thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm',

        ]
    ],
    'product' => [
        'index' => [
            'title' => 'Danh sách sản phẩm',
            'table' => 'Thông tin sản phẩm',
            'create' => 'Tạo mới sản phẩm'
        ],
        'create' => [
            'title' => 'Tạo mới sản phẩm',
            'success' => 'Tạo mới sản phẩm thành công.',
            'error' => 'Tạo mới sản phẩm thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập sản phẩm',
            'success' => 'Cập nhập sản phẩm thành công.',
            'error' => 'Cập nhập sản phẩm thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá sản phẩm thành công.',
            'error' => 'Xoá sản phẩm thất bại.',
        ],
        'table' => [
            'name' => 'Tiêu đề sản phẩm',
            'productCatalogue' => 'Chọn nhóm sản phẩm',
        ]
    ],
    'postCatalogue' => [
        'index' => [
            'title' => 'Danh sách nhóm bài viết',
            'table' => 'Thông tin nhóm bài viết',
            'create' => 'Tạo mới nhóm bài viết'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm bài viết',
            'success' => 'Tạo mới nhóm bài viết thành công.',
            'error' => 'Tạo mới nhóm bài viết thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm bài viết',
            'success' => 'Cập nhập nhóm bài viết thành công.',
            'error' => 'Cập nhập nhóm bài viết thất bại.',
        ],
        'delete' => [
            'title' => 'Cập nhập nhóm bài viết',
            'success' => 'Xoá nhóm bài viết thành công.',
            'error' => 'Xoá nhóm bài viết thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm',
        ]
    ],
    'post' => [
        'index' => [
            'title' => 'Danh sách bài viết',
            'table' => 'Thông tin bài viết',
            'create' => 'Tạo mới bài viết'
        ],
        'create' => [
            'title' => 'Tạo mới bài viết',
            'success' => 'Tạo mới bài viết thành công.',
            'error' => 'Tạo mới bài viết thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập bài viết',
            'success' => 'Cập nhập bài viết thành công.',
            'error' => 'Cập nhập bài viết thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá bài viết thành công.',
            'error' => 'Xoá bài viết thất bại.',
        ],
        'table' => [
            'name' => 'Tiêu đề bài viết',
            'postCatalogue' => 'Chọn nhóm bài viết',
        ]
    ],
    'userCatalogue' => [
        'index' => [
            'title' => 'Danh sách nhóm thành viên',
            'table' => 'Thông tin nhóm thành viên',
            'create' => 'Tạo mới nhóm thành viên'
        ],
        'create' => [
            'title' => 'Tạo mới nhóm thành viên',
            'success' => 'Tạo mới nhóm thành viên thành công.',
            'error' => 'Tạo mới nhóm thành viên thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập nhóm thành viên',
            'success' => 'Cập nhập nhóm thành viên thành công.',
            'error' => 'Cập nhập nhóm thành viên thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá nhóm thành viên thành công.',
            'error' => 'Xoá nhóm thành viên thất bại.',
        ],
        'table' => [
            'name' => 'Tên nhóm thành viên',
            'countUser' => 'Số thành viên'
        ],
        'permission' => [
            'title' => 'Cập nhập quyền',
            'success' => 'Cập nhập quyền thành công.',
            'error' => 'Cập nhập quyền thất bại.',
        ]
    ],
    'user' => [
        'index' => [
            'title' => 'Danh sách thành viên',
            'table' => 'Thông tin thành viên',
            'create' => 'Tạo mới thành viên'
        ],
        'create' => [
            'title' => 'Tạo mới thành viên',
            'success' => 'Tạo mới thành viên thành công.',
            'error' => 'Tạo mới thành viên thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập thành viên',
            'success' => 'Cập nhập thành viên thành công.',
            'error' => 'Cập nhập thành viên thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá thành viên thành công.',
            'error' => 'Xoá thành viên thất bại.',
        ],
        'table' => [
            'name' => 'Tên thành viên',
            'userGroup' => 'Nhóm thành viên',
            'userGroupSelect' => 'Chọn nhóm thành viên',
        ]
    ],

    'permission' => [
        'index' => [
            'title' => 'Danh sách quyền',
            'table' => 'Thông tin quyền',
            'create' => 'Tạo mới quyền',
            'success' => 'Thay đổi quyền thành công.',
            'error' => 'Thay đổi quyền thất bại.'
        ],
        'create' => [
            'title' => 'Tạo mới quyền',
            'success' => 'Tạo mới quyền thành công.',
            'error' => 'Tạo mới quyền thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập quyền',
            'success' => 'Cập nhập quyền thành công.',
            'error' => 'Cập nhập quyền thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá quyền thành công.',
            'error' => 'Xoá quyền thất bại.',
        ],
        'table' => [
            'name' => 'Tên quyền',
        ]
    ],
    'language' => [
        'index' => [
            'title' => 'Danh sách ngôn ngữ',
            'table' => 'Thông tin ngôn ngữ',
            'create' => 'Tạo mới ngôn ngữ',
            'success' => 'Thay đổi ngôn ngữ thành công.',
            'error' => 'Thay đổi ngôn ngữ thất bại.'
        ],
        'create' => [
            'title' => 'Tạo mới ngôn ngữ',
            'success' => 'Tạo mới ngôn ngữ thành công.',
            'error' => 'Tạo mới ngôn ngữ thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập ngôn ngữ',
            'success' => 'Cập nhập ngôn ngữ thành công.',
            'error' => 'Cập nhập ngôn ngữ thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá ngôn ngữ thành công.',
            'error' => 'Xoá ngôn ngữ thất bại.',
        ],
        'table' => [
            'name' => 'Tên ngôn ngữ',
        ],
        'switch' => [
            'success' => 'Thay đổi ngôn ngữ thành công.',
            'error' => 'Thay đổi ngôn ngữ thất bại.',
        ],
        'translate' => [
            'success' => 'Cập nhập bản dịch thành công.',
            'error' => 'Cập nhập bản dịch thất bại.',
        ]
    ],
    'generate' => [
        'index' => [
            'title' => 'Danh sách module',
            'table' => 'Thông tin module',
            'create' => 'Tạo mới module',
            'success' => 'Thay đổi module thành công.',
            'error' => 'Thay đổi module thất bại.'
        ],
        'create' => [
            'title' => 'Tạo mới module',
            'success' => 'Tạo mới module thành công.',
            'error' => 'Tạo mới module thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập module',
            'success' => 'Cập nhập module thành công.',
            'error' => 'Cập nhập module thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá module thành công.',
            'error' => 'Xoá module thất bại.',
        ],
        'table' => [
            'name' => 'Tên model',
            'module' => 'Tên chức năng',
            'path' => 'Đường dẫn'
        ]
    ],
    'slide' => [
        'index' => [
            'title' => 'Danh sách slide & banner',
            'table' => 'Thông tin slide & banner',
            'create' => 'Tạo mới slide & banner'
        ],
        'create' => [
            'title' => 'Tạo mới slide & banner',
            'success' => 'Tạo mới slide & banner thành công.',
            'error' => 'Tạo mới slide & banner thất bại.',
        ],
        'update' => [
            'title' => 'Cập nhập slide & banner',
            'success' => 'Cập nhập slide & banner thành công.',
            'error' => 'Cập nhập slide & banner thất bại.',
        ],
        'delete' => [
            'success' => 'Xoá slide & banner thành công.',
            'error' => 'Xoá slide & banner thất bại.',
        ],
        'drag' => [
            'success' => 'Cập nhập vị trí slide thành công.',
            'error' => 'Cập nhập vị trí slide thất bại.',
        ],
        'table' => [
            'name' => 'Tiêu đề slide & banner',
            'attributeCatalogue' => 'Chọn nhóm slide & banner',
        ]
    ],
    'errorChildDelete' => 'Không thể xoá do vẫn còn danh mục con.',
    'parentId' => 'Danh mục cha',
    'catalogueSub' => 'Danh mục phụ',
    'permissionName' => 'Phân quyền',
    'parentIdNotice' => 'Chọn [Root] nếu không có danh mục cha',
    'image' => 'Chọn ảnh đại diện',
    'advance' => 'Cấu hình nâng cao',
    'basic' => 'Cấu hình cơ bản',
    'width' => 'Chiều rộng',
    'effect' => 'Hiệu ứng',
    'runAuto' => 'Tự động chạy',
    'openNewTab' => 'Mở trong tab mới',
    'notSlideYet' => 'Chưa có hình ảnh được chọn...',
    'stopOnHover' => 'Dừng khi di chuột',
    'changeScene' => 'Chuyển cảnh',
    'effectSpeed' => 'Tốc độ hiệu ứng',
    'arrow' => 'Mũi tên',
    'height' => 'Chiều cao',
    'status' => 'Trạng thái',
    'slideList' => 'Danh sách slides',
    'on' => 'Bật',
    'off' => 'Tắt',
    'publish' => 'Tình trạng',
    'follow' => 'Điều hướng',
    'noteNotice' => ['Lưu ý:', 'là các trường bắt buộc'],
    'generalInfomation' => 'Thông tin chung',
    'perpage' => 'bản ghi',
    'keywordPlaceholder' => 'Tìm kiếm',
    'name' => 'Tiêu đề',
    'description' => 'Mô tả',
    'content' => 'Nội dung',
    'uploadMultipleImage' => 'Tải lên nhiều ảnh',
    'seo' => [
        'info' => 'Cấu hình SEO',
        'title' => 'Tiêu đề SEO',
        'keyword' => 'Từ khoá SEO',
        'description' => 'Mô tả SEO',
        'canonical' => 'Đường dẫn',
    ],
    'slideName' => 'Tên Slide',
    'addSlide' => 'Thêm slide',
    'keyword' => 'Từ khoá',
    'seoExample' => ['duong-dan-cua-ban', 'Bạn chưa nhập tiêu đề', 'Bạn
    chưa nhập mô tả'],
    'album' => 'Chọn ảnh album',
    'email' => 'Email',
    'phone' => 'Số điện thoại',
    'fullname' => 'Họ và tên',
    'birthday' => 'Ngày sinh',
    'password' => 'Mật khẩu',
    'rePassword' => 'Nhập lại mật khẩu',
    'cities' => 'Tỉnh/Thành phố',
    'districts' => 'Quận/Huyện',
    'wards' => 'Phường/Xã',
    'address' => 'Địa chỉ',
    'notes' => 'Ghi chú',
    'canonical' => 'Canonical',
    'contactInfo' => 'Thông tin liên hệ',
    'albumNotice' => 'Sử dụng nút chọn ảnh hoặc chọn vào đây để thêm hình ảnh.',
    'tableStatus' => 'Tình trạng',
    'tableAction' => 'Thực thi',
    'tableOrder' => 'Vị trí',
    'tableDescription' => 'Mô tả',
    'tablePhone' => 'Mô tả',
    'tableEmail' => 'Email',
    'tableAddress' => 'Địa chị',
    'tableCanonical' => 'Canonical',
    'person' => 'người',
    'creator' => 'người tạo',
    'publishAll' => 'Xuất bản toàn bộ',
    'unpublishAll' => 'Huỷ xuất bản toàn bộ',
    'tableDisplayGroup' => 'Nhóm hiển thị',
    'deleteModalTitle' => 'Bạn có chắc không! Muốn xóa bản ghi này?',
    'deleteModalDescription' => 'Bạn có thực sự muốn xóa những bản ghi này? Bạn không thể khôi phục bản ghi trong danh sách của mình nữa nếu bạn xóa!',
    'cancelButton' => 'Huỷ bỏ',
    'agreeButton' => 'Đồng ý',
    'saveButton' => 'Lưu lại',

];

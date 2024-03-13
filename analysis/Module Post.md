Module Post:
    - post_catalogues: Lưu các nhóm bài viết (Tin tức, Thời sự, Bóng đá,...)
    - posts: Lưu chi tiết bài viết
    - post_catalogue_post: pivot quan hệ giữa hai bảng post_catalogues và posts
    - languages: Lưu ngôn ngữ
    - post_catalogue_translate: pivot quan hệ languages và post_catalogue_post
    - post_translate: pivot quan hệ languages và posts



- languages:
    + id
    + name (Tieng viet)
    + canonical (vn)
    + image
    + user_id
    + deleted_at


- post_catalogues: 
    + id
    + parent_id (lưu mã danh mục cha)
    + left (giá trị bên trái của node)
    + right (giá trị bên trái của node)
    + level (cấp của node đó)
    + image (ảnh đại diện)
    + icon (ảnh nhỏ)
    + album (danh sách ảnh)
    + publish (trạng thái)
    + order (sắp xếp các danh mục)
    + user_id (người tạo ra danh mục)
    + deleted_at 


- post_catalogue_translate
    + post_catalogue_id
    + language_id
    + name (tên bài viết)
    + description (mô tả ngắn)
    + canonical (đường dẫn truy cập danh mục)
    + content (nội dung bài viết)
    + meta_title (tiêu đề SEO)
    + meta_description (mô tả SEO)
    + meta_keyword (từ khoá SEO)


-posts
    + id
    + post_catalogue_id
    + image
    + album
    + icon
    + order
    + publish
    + deleted_at
    + user_id


- post_catalogue_post
    + post_id
    + language_id
    + viewed
    + name (tên bài viết)
    + description (mô tả ngắn)
    + canonical (đường dẫn truy cập danh mục)
    + content (nội dung bài viết)
    + meta_title (tiêu đề SEO)
    + meta_description (mô tả SEO)
    + meta_keyword (từ khoá SEO)


 Nested set
                                                      1 điện tử (level 1) 23

  2 Điện thoại di động 11  (level 2)             12  Máy tính sách tay  13    (level 2)             14 Máy ảnh 22 (level 2)  

     3 iPhone 4 5 Samsung 6 7 Galaxy 8 9 Xiaomi 10   (level 3)                 15 Nikon 16 Canon 17 18 Sony 19 20 Fujifilm (level 3)  21

Breadcumb
Trang chủ > Điện tử > Điện thoại di động > Xiaomi

-->truy vấn lấy ra tất cả các danh mục có (node bên trái bé hơn node bên trái của xiaomi và node bên phải lớn hơn node bên phải của xiaomi)
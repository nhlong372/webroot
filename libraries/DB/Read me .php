<?php 
// Giỏ hàng nâng cao x
// Mã giảm giá x
// sản phẩm yêu thích
// sản phẩm đã xem
// lọc tìm kiếm sản phẩm
// thông báo sinh nhật thành viên x
// 
// Nhiều chi nhánh footer
// Popup bản đồ
// Popup form báo giá
// 
// 
// 
// 
// 
// 
// 
// 
// 
// 
////////////////////// trong file config.php ///////////////////////////
/* Cấu hình bản quyền cho phép copy */
define('COPYSITE', true); // true cho phép copy .
/* Cấu hình giỏ hàng */
define('CARTSITE', false); // mở giỏ hàng
define('DDPRODUCT', false); // mở đóng dấu sản phẩm
define('SEARCHPRODUCT', false); // tìm kiếm sản phẩm
////////////////////// trong file config_type.php ///////////////////////////
$config['order']['advance'] = false; // mở giỏ hàng nâng cao
// làm giỏ hàng nâng cao mở thêm một số chỗ trong app.js 
////////////////////// trong file index_tpl.php ///////////////////////////
// 1.Sản phẩm nổi bật phân trang
// 2.Sản phẩm nổi bật phân trang theo danh mục cấp 1
// 3.Sản phẩm nổi bật phân trang theo tab danh mục cấp 1
// 4.Sản phẩm nổi bật phân trang theo tab cố định
// 5.Sản phẩm nổi bật phân trang theo for cấp 1 tab cấp 2

// 6.Sản phẩm nổi bật có nút xem thêm
// 7.Sản phẩm nổi bật có nút xem thêm for danh mục cấp 1
// 8.Sản phẩm nổi bật có nút xem thêm tab danh mục cấp 1
// 9.Sản phẩm nổi bật có nút xem thêm tab cố định

// 10.Chạy slick theo tab loại cố định
// 11.Chạy slick theo tab cấp 1
// 12.Chạy slick theo for cấp 1 tab cấp 2


////////////////////// popup bản đồ với form báo giá ///////////////////////////
?>
<a class="icon-map"><i class="fas fa-map-marker-alt"></i> Xem bản đồ</a>
<a class="icon-baogia"><i class="fas fa-map-marker-alt"></i> Báo giá</a>

Xử lý phần thêm qrcode vào cơ sở dữ liệu.
Kiểm tra đã bật $config['website']['debug-developer'] và kiểm tra com của admin phải là setting.
Bắt thẻ card vị trí thứ 4 của form để add code xử lý.

Bỏ thư mục này vào libraries.
Thêm $config['setting']['soqrzalo'] = "1" vào config_type; // số lượng mã QR zalo
Thêm include LIBRARIES . 'ZaloQR/qrcodejs.php'; dưới include TEMPLATE . LAYOUT . "js.php"; trong templates/index
Thêm require_once LIBRARIES . 'ZaloQR/qrcode.php'; dưới include TEMPLATE . LAYOUT . "js.php"; trong admin/index
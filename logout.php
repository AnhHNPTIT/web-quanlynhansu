<?php
session_start();  // Bắt đầu session

// Xóa tất cả các biến session
session_unset();

// Hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: form-login.php");
exit; // Dừng mã để không tiếp tục thực thi sau khi chuyển hướng
?>

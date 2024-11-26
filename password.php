<?php
include_once "connect-to-sql.php";
include_once "constant.php";
header('Content-type: application/json');

session_start();
$newpassword = $_POST['newpassword'];
$renewpassword = $_POST['renewpassword'];

// Kiểm tra mật khẩu mới và xác nhận mật khẩu có khớp không
if ($newpassword != $renewpassword) {
    echo json_encode(['is' => 'fail', 'mess' => 'Mật khẩu không khớp']);
} else {
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (isset($_SESSION['maNV'])) {
        $maNV = $_SESSION['maNV'];

        // Mã hóa mật khẩu mới bằng password_hash
        $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);

        // Cập nhật mật khẩu trong cơ sở dữ liệu
        $sql = "UPDATE TaiKhoan SET matKhau = ? WHERE maNV = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $maNV); // "s" cho string và "i" cho integer

        if ($stmt->execute()) {
            // Thay đổi mật khẩu thành công
            // Xóa hết session
            session_unset();  // Xóa tất cả các biến session
            session_destroy(); // Hủy session

            echo json_encode(['is' => 'success', 'mess' => 'Đã thay đổi mật khẩu!']);
        } else {
            echo json_encode(['is' => 'fail', 'mess' => 'Thay đổi không thành công!']);
        }

        // Đóng statement sau khi sử dụng
        $stmt->close();
    }
}
?>

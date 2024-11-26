<?php
include_once "connect-to-sql.php";
include_once "constant.php";

// Xóa tất cả các biến session
session_unset();

// Hủy session
session_destroy();

session_start();

if (isset($_POST['tenDN']) && isset($_POST['matKhau'])) {
  
  $tenDN = $_POST['tenDN'];
  $matKhau = $_POST['matKhau'];

  // Truy vấn để lấy thông tin tài khoản với tên đăng nhập
  $sql = "SELECT * FROM TaiKhoan WHERE tenDN = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("s", $tenDN); // "s" cho string
  $stmt->execute();
  $result = $stmt->get_result();
  
  header('Content-type: application/json');

  if ($result->num_rows > 0) {
    $tai_khoan = $result->fetch_assoc();

    // Xác minh mật khẩu với password_verify
    if (password_verify($matKhau, $tai_khoan['matKhau'])) {
      // Mật khẩu hợp lệ, bắt đầu phiên đăng nhập
      if ($tai_khoan['loaiTK'] == 'NHANVIEN') {
        $_SESSION['tenDN'] = $tenDN;
        $_SESSION['maNV'] = $tai_khoan['maNV'];
        echo json_encode(['is' => 'success', 'loaiTK' => 'NHANVIEN']);
      } else {
        $_SESSION['tenDN'] = $tenDN;  
        $_SESSION["Admin"] = "Admin";
        echo json_encode(['is' => 'success', 'loaiTK' => 'ADMIN']);
      }
    } else {
      // Mật khẩu không hợp lệ
      echo json_encode(['is' => 'fail', 'mess' => 'Mật khẩu không đúng']);
    }
  } else {
    // Tên đăng nhập không tồn tại
    echo json_encode(['is' => 'fail', 'mess' => 'Tài khoản không tồn tại']);
  }

  $stmt->close();
}
?>

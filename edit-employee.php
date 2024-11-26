<?php
include_once "connect-to-sql.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nhanvien = $_POST;

        // Kiểm tra mã nhân viên có tồn tại không
        $stmt_check = $connection->prepare("SELECT * FROM NhanVien WHERE id = ?");
        $stmt_check->bind_param("s", $nhanvien['maNV']);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows === 0) {
            echo json_encode(['is' => 'fail', 'message' => 'Mã nhân viên không tồn tại!']);
            $stmt_check->close();
            exit;
        }

        // Lấy ảnh thẻ hiện có từ cơ sở dữ liệu
        $row = $result->fetch_assoc();
        $anhTheCurrent = $row['anhThe'];
        $ngaySinh = $row['ngaySinh'];
        $stmt_check->close();

        if(!isset($nhanvien['ngaySinh']) || $nhanvien['ngaySinh'] === null || empty($nhanvien['ngaySinh'])){
            $nhanvien['ngaySinh'] = $ngaySinh;
        }

        // Xử lý ảnh thẻ nếu có
        $anhThe = '';
        if (isset($_FILES['anhThe']['name']) && $_FILES['anhThe']['name'] != '') {
            $target_file = "public/images/" . 'img_' . date('Y-m-d-H-s') . '.png';
            if (!move_uploaded_file($_FILES["anhThe"]["tmp_name"], $target_file)) {
                throw new Exception("Lỗi khi tải lên ảnh.");
            }
            $anhThe = $target_file;
        }
        else{
            $anhThe = $anhTheCurrent;
        }

        // Cập nhật thông tin nhân viên
        $stmt_update = $connection->prepare(
            "UPDATE NhanVien 
            SET maPB = ?, hoTen = ?, email = ?, soDT = ?, anhThe = ?, gioiTinh = ?, ngaySinh = ?, diaChi = ?, bangCap = ?, soCMND = ?, maBHXH = ?, maBHYT = ?, luong = ?
            WHERE id = ?"
        );

        $stmt_update->bind_param(
            "isssssssssssis", // Loại dữ liệu
            $nhanvien['maPB'],
            $nhanvien['hoTen'],
            $nhanvien['email'],
            $nhanvien['soDT'],
            $anhThe,
            $nhanvien['gioiTinh'],
            $nhanvien['ngaySinh'],
            $nhanvien['diaChi'],
            $nhanvien['bangCap'],
            $nhanvien['soCMND'],
            $nhanvien['maBHXH'],
            $nhanvien['maBHYT'],
            $nhanvien['luong'],
            $nhanvien['maNV']
        );

        if ($stmt_update->execute()) {
            echo json_encode(['is' => 'success', 'message' => 'Cập nhật thành công!']);
        } else {
            throw new Exception('Lỗi khi cập nhật nhân viên: ' . $stmt_update->error);
        }

        $stmt_update->close();
    }
} catch (Exception $e) {
    // Xử lý ngoại lệ
    echo json_encode(['is' => 'fail', 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
}
?>

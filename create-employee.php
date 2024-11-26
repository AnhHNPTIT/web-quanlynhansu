<?php
include_once "connect-to-sql.php";
include_once "constant.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nhanvien = $_POST;

        // Kiểm tra tính duy nhất của tài khoản trong bảng TaiKhoan
        $stmt_check = $connection->prepare("SELECT * FROM TaiKhoan WHERE tenDN = ?");
        $stmt_check->bind_param("s", $nhanvien['taiKhoan']);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(['is' => 'fail', 'message' => 'Tài khoản đã tồn tại!']);
            $stmt_check->close();
            exit;
        }
        $stmt_check->close();

        // Kiểm tra tính duy nhất của tài khoản trong bảng TaiKhoan
        $stmt_check = $connection->prepare("SELECT * FROM TaiKhoan WHERE maNV = ?");
        $stmt_check->bind_param("s", $nhanvien['maNV']);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            echo json_encode(['is' => 'fail', 'message' => 'Mã nhân viên đã tồn tại!']);
            $stmt_check->close();
            exit;
        }
        $stmt_check->close();

        // Chèn vào bảng nhanvien
        if (isset($_FILES['anhThe']['name']) && $_FILES['anhThe']['name'] != '') {
            $target_file = "public/images/" . 'img_' . date('Y-m-d-H-s') . '.png';
            if (!move_uploaded_file($_FILES["anhThe"]["tmp_name"], $target_file)) {
                throw new Exception("Lỗi khi tải lên ảnh.");
            }
            $nhanvien['anhThe'] = $target_file;
        } else {
            $nhanvien['anhThe'] = '';
        }

        // Ensure the 'maPB' and 'gioiTinh' are passed correctly, with defaults if necessary
        $maPB = isset($nhanvien['maPB']) ? $nhanvien['maPB'] : null;
        $gioiTinh = isset($nhanvien['gioiTinh']) ? $nhanvien['gioiTinh'] : '1'; // Default to '1' (gender 1)

        // Prepare and execute INSERT query for NhanVien
        $stmt_nhanvien = $connection->prepare("INSERT INTO NhanVien 
            (maPB, hoTen, email, soDT, anhThe, gioiTinh, ngaySinh, diaChi, bangCap, soCMND, maBHXH, maBHYT, luong) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt_nhanvien->bind_param(
            "isssssssssssi", // Types: integer, string, string, string, string, enum, date, string, string, string, string, string, int
            $maPB,      
            $nhanvien['hoTen'],      
            $nhanvien['email'],      
            $nhanvien['soDT'],      
            $nhanvien['anhThe'],     
            $gioiTinh,              
            $nhanvien['ngaySinh'],  
            $nhanvien['diaChi'],    
            $nhanvien['bangCap'],   
            $nhanvien['soCMND'],    
            $nhanvien['maBHXH'],    
            $nhanvien['maBHYT'],    
            $nhanvien['luong']      
        );

        if ($stmt_nhanvien->execute()) {
            $maNV = $stmt_nhanvien->insert_id;

            // Mã hóa mật khẩu trước khi chèn vào bảng TaiKhoan
            $hashedPassword = password_hash($nhanvien['matKhau'], PASSWORD_DEFAULT);

            // Chèn vào bảng TaiKhoan
            $stmt_taikhoan = $connection->prepare("INSERT INTO TaiKhoan (maNV, tenDN, matKhau) VALUES (?, ?, ?)");
            $stmt_taikhoan->bind_param("sss", $maNV, $nhanvien['taiKhoan'], $hashedPassword);

            if (!$stmt_taikhoan->execute()) {
                throw new Exception('Lỗi khi thêm tài khoản: ' . $stmt_taikhoan->error);
            }

            $stmt_taikhoan->close();
            echo json_encode(['is' => 'success', 'message' => 'Thêm mới thành công!']);
        } else {
            throw new Exception('Lỗi khi thêm nhân viên: ' . $stmt_nhanvien->error);
        }

        $stmt_nhanvien->close();
    }
} catch (Exception $e) {
    // Catching any exception thrown during the execution
    echo json_encode(['is' => 'fail', 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
}
?>

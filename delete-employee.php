<?php
include_once "connect-to-sql.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['maNV'])) {
        $id = $_POST['maNV'];
        
        // Sử dụng prepared statement để đảm bảo an toàn
        $stmt = $connection->prepare("SELECT id, anhThe FROM NhanVien WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra nếu không tìm thấy nhân viên
        if ($result->num_rows <= 0) {
            echo json_encode(['is' => 'fail', 'uncomplete' => 'Không tìm thấy nhân viên!']);
            exit;
        }

        $nhanvien = $result->fetch_assoc();
        $stmt->close();

        // Xoá file ảnh nếu có
        if (!empty($nhanvien['anhThe']) && file_exists($nhanvien['anhThe'])) {
            unlink($nhanvien['anhThe']);
        }

        // Xóa dữ liệu trong bảng `NhanVien` và `TaiKhoan` bằng transaction
        $connection->begin_transaction();
        try {
            $stmt1 = $connection->prepare("DELETE FROM NhanVien WHERE id = ?");
            $stmt1->bind_param("s", $id);
            $stmt1->execute();

            $stmt2 = $connection->prepare("DELETE FROM TaiKhoan WHERE maNV = ?");
            $stmt2->bind_param("s", $id);
            $stmt2->execute();

            $connection->commit();
            echo json_encode(['is' => 'success', 'complete' => 'Đã xoá!']);
        } catch (Exception $e) {
            $connection->rollback();
            echo json_encode(['is' => 'fail', 'uncomplete' => 'Xoá thất bại!']);
        } finally {
            $stmt1->close();
            $stmt2->close();
        }
    } else {
        echo json_encode(['is' => 'fail', 'uncomplete' => 'Dữ liệu không hợp lệ!']);
    }
}
?>

<?php
include_once "connect-to-sql.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $experience = $_POST;

    // Kiểm tra mã nhân viên có tồn tại không
    $stmt_check = $connection->prepare("SELECT * FROM NhanVien WHERE id = ?");
    $stmt_check->bind_param("s", $experience['maNV']);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['is' => 'fail', 'message' => 'Mã nhân viên không tồn tại!']);
        $stmt_check->close();
        exit;
    }

    $row = $result->fetch_assoc();
    $experience['maPB'] = $row['maPB'];

    // Prepare the SQL statement to prevent SQL injection
    $sql = $connection->prepare("INSERT INTO QTCongTac (maNV, maPB, ngayDenCT, ngayChuyenCT, moTaCongViec) VALUES (?, ?, ?, ?, ?)");

    // Bind parameters to the prepared statement
    $sql->bind_param("sssss", $experience['maNV'], $experience['maPB'], $experience['ngayDenCT'], $experience['ngayChuyenCT'], $experience['moTaCongViec']);

    header('Content-Type: application/json');

    if ($sql->execute()) {
        echo json_encode(['is' => 'success', 'complete' => 'Đã thêm!']);
    } else {
        echo json_encode(['is' => 'fail', 'uncomplete' => 'Thất bại!', 'error' => $sql->error]);
    }

    $sql->close(); // Close the prepared statement
}

$connection->close(); // Close the database connection
?>

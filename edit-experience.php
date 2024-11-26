<?php
include_once "connect-to-sql.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $experience = $_POST;

    // Kiểm tra mã phòng ban có tồn tại không
    $stmt_check = $connection->prepare("SELECT * FROM PhongBan WHERE id = ?");
    $stmt_check->bind_param("s", $experience['maPB']);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['is' => 'fail', 'message' => 'Mã phòng ban không tồn tại!']);
        $stmt_check->close();
        exit;
    }

    $row = $result->fetch_assoc();

    // Prepare the SQL statement to prevent SQL injection
    $sql = $connection->prepare("UPDATE QTCongTac SET maPB = ?, ngayDenCT = ?, ngayChuyenCT = ?, moTaCongViec = ? WHERE id = ?");

    // Bind parameters to the prepared statement
    $sql->bind_param("sssss", $experience['maPB'], $experience['ngayDenCT'], $experience['ngayChuyenCT'], $experience['moTaCongViec'], $experience['id']);

    header('Content-Type: application/json');

    if ($sql->execute()) {
        echo json_encode(['is' => 'success', 'complete' => 'Cập nhật thành công!']);
    } else {
        echo json_encode(['is' => 'fail', 'uncomplete' => 'Thất bại!', 'error' => $sql->error]);
    }

    $sql->close(); // Close the prepared statement
}

$connection->close(); // Close the database connection
?>

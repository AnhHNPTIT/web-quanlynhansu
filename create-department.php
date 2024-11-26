<?php
include_once "connect-to-sql.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phongban = $_POST;

    // Prepare the SQL statement to prevent SQL injection
    $sql = $connection->prepare("INSERT INTO PhongBan (tenPB, soDT, diaChi) VALUES (?, ?, ?)");

    // Bind parameters to the prepared statement
    $sql->bind_param("sss", $phongban['tenPB'], $phongban['soDT'], $phongban['diaChi']);

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

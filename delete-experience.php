<?php
include_once "connect-to-sql.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    if (isset($_POST['id'])) {
        // Sanitize and validate input
        $id = $connection->real_escape_string($_POST['id']);

        // Check if the record exists
        $stmt = $connection->prepare("SELECT * FROM QTCongTac WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows <= 0) {
            echo json_encode(['is' => 'fail', 'uncomplete' => 'Không tìm thấy quá trình công tác!']);
            exit();
        }

        // Delete the record
        $stmt = $connection->prepare("DELETE FROM QTCongTac WHERE id = ?");
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
			echo json_encode(['is' => 'success', 'complete' => 'Đã xoá!']);
		}
		else{
			echo json_encode(['is' => 'fail', 'uncomplete' => 'Thất bại!']);	
		}

        $stmt->close();
    } else {
        echo json_encode(['is' => 'fail', 'uncomplete' => 'Không tìm thấy quá trình công tác!']);
    }
}

$connection->close();
?>

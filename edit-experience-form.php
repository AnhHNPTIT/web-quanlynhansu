<?php
session_start();
if (!isset($_SESSION['tenDN'])) {
  header("Location: form-login.php");
}

include_once "connect-to-sql.php";

$dsNhanVien = $connection->query("SELECT NV.* FROM TaiKhoan AS T JOIN NhanVien AS NV ON T.maNV = NV.id WHERE loaiTK = 'NHANVIEN'");
$dsPhongBan = $connection->query("SELECT * FROM PhongBan");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qtct = $connection->query("SELECT * FROM QTCongTac WHERE id = '" . $id . "'");
    if ($qtct->num_rows <= 0) {
        header("Location: experience.php");
    }
    $qtct = $qtct->fetch_assoc();
}

if (isset($_POST['submit'])) {
    $payload = $_POST;

    // Kiểm tra mã nhân viên có tồn tại không
    $stmt_check = $connection->prepare("SELECT * FROM NhanVien WHERE id = ?");
    $stmt_check->bind_param("s", $payload['maNV']);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['is' => 'fail', 'message' => 'Mã nhân viên không tồn tại!']);
        $stmt_check->close();
        exit;
    }

    $row = $result->fetch_assoc();
    $payload['maPB'] = $row['maPB'];

    // Prepare the SQL query to avoid SQL injection
    $sql = "UPDATE QTCongTac 
            SET maNV = ?, maPB = ?, ngayDenCT = ?, ngayChuyenCT = ?, moTaCongViec = ?  
            WHERE id = ?";

    $stmt = $connection->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bind_param(
        "ssss", 
        $payload['maNV'], 
        $payload['maPB'], 
        $payload['ngayDenCT'], 
        $payload['ngayChuyenCT'],
        $payload['moTaCongViec'],
        $payload['id']
    );

    // Execute the query
    if ($stmt->execute()) {
        header("Location: experience.php");
        exit();
    } else {
        // Handle errors gracefully
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="ctl00_favicon" rel="shortcut icon" type="image/x-icon" href="http://qldt.ptit.edu.vn/Images/Edusoft.gif">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
</head>
<body>

 <nav class="navbar navbar-inverse container-fluid">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="">Quản lý phòng ban</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION["Admin"]; ?></a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Đăng xuất</a></li>
        </ul>
    </div>
</nav>
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-primary"><b>Sửa QT công tác</b></h2>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-12">
                <form class="form-horizontal" enctype="multipart/form-data">
                    <fieldset>
                        <legend></legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="phongBan">Phòng ban</label>
                            <div class="col-md-4">
                            <select id="phongBan" name="phongBan" class="form-control">
                                <?php foreach ($dsPhongBan as $item): ?>
                                    <option value="<?= $item['id'] ?>" <?= $item['id'] == $qtct['maPB'] ? 'selected' : '' ?>>
                                        <?= $item['tenPB'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="ngayDenCT">Ngày đến công tác</label>
                            <div class="col-md-4">
                                <input id="ngayDenCT" name="ngayDenCT" class="form-control input-md"
                                required="" type="date" value="<?= $qtct['ngayDenCT'] ?>">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="ngayChuyenCT">Ngày chuyển công tác</label>
                            <div class="col-md-4">
                                <input id="ngayChuyenCT" name="ngayChuyenCT" class="form-control input-md"
                                required="" type="date" value="<?= $qtct['ngayChuyenCT'] ?>">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="moTaCongViec">Mô tả công việc</label>
                            <div class="col-md-4">
                                <input id="moTaCongViec" name="moTaCongViec" class="form-control input-md"
                                required="" type="text" value="<?= $qtct['moTaCongViec'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-4">
                                <button type="button" class="btn btn-primary" id="btn-update" data-id="<?= $qtct['id'] ?>">Cập nhật</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>

</body>
<script src="public/js/sweetalert.min.js"></script>
<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
</html>

<script>
    $('#btn-update').click(function(){
        var _this = $(this);
        var form_data = new FormData();
        var id = $(this).attr('data-id');

        form_data.append("id", id);
        form_data.append("maPB", $('#phongBan').val());
        form_data.append("ngayDenCT", $('#ngayDenCT').val());
        form_data.append("ngayChuyenCT", $('#ngayChuyenCT').val());
        form_data.append("moTaCongViec", $('#moTaCongViec').val());
        $.ajax({
            type: 'POST',
            url: 'edit-experience.php',
            data: form_data,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response){
                if(response.is === 'success'){
                    swal({
                        title: response.complete,
                        text: response.message,
                        icon: "success"
                    })

                    setTimeout(() => {
                        window.location.href = 'experience.php';
                    }, 600);
                }
                if(response.is === 'fail'){
                    swal({
                        text: response.message,
                        icon: "error"
                    })
                }
          }
      })
    })
</script>
<?php
session_start();
if (!isset($_SESSION['tenDN'])) {
    header("Location: form-login.php");
}
include_once "connect-to-sql.php";

if (isset($_SESSION['maNV'])) {
    $id = $_SESSION['maNV'];

    // Sửa câu truy vấn và đảm bảo an toàn với SQL injection
    $stmt = $connection->prepare("SELECT * FROM NhanVien AS NV JOIN PhongBan AS PB ON NV.maPB = PB.id WHERE NV.id = ?");
    $stmt->bind_param("i", $id);  // "i" là kiểu integer cho $id

    // Thực thi câu truy vấn
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->get_result();

    // Kiểm tra và xử lý kết quả
    if ($result->num_rows > 0) {
        $nhanvien = $result->fetch_assoc();
        // Tiến hành xử lý dữ liệu từ $nhanvien
    } else {
        echo "Không tìm thấy thông tin nhân viên.";
    }

    // Đóng statement
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Thông tin nhân viên</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="ctl00_favicon" rel="shortcut icon" type="image/x-icon" href="http://qldt.ptit.edu.vn/Images/Edusoft.gif">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="public/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="public/css/detail_product.css"/>
</head>
<body>

<nav class="navbar navbar-inverse container-fluid">
    <div class="container">
      <div class="dropdown navbar-right" style="margin-top: 8px;">
        <button class="btn btn-primary dropdown-toggle" type="button" id="about-us" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo strtoupper($_SESSION['tenDN']); ?>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="about-us" style="margin-top: 7px;">
            <li style="padding-top: 2px;">
                <a class="dropdown-item" href="change-password.php">
                    <i class="glyphicon glyphicon-refresh"></i>
                    Đổi mật khẩu
                </a>
            </li>
            <li style="padding-top: 2px;">
                <a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> 
                    Đăng xuất
                </a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center text-primary"><b>Thông tin nhân viên</b></h2>
        </div>
    </div>
    <legend></legend>
    <div class="card">
        <div class="container-fliud">
            <div class="wrapper row">
                <div class="preview col-md-6">
                    <div class="preview-pic tab-content">
                        <div class="tab-pane active" id="pic-1"><img src="<?= $nhanvien['anhThe']?>"/></div>
                    </div>
                </div>
                <div class="details col-md-6">
                    <p class="price" style="color: red;font-size: xx-large;"><?= $nhanvien['hoTen']?></p>
                    <h3 class="">Phòng ban: <b><?= $nhanvien['tenPB']?></b></h3>
                    <h3 class="">Giới tính: <b><?= $nhanvien['gioiTinh'] ?></b></h3>
                    <h3 class="">Ngày sinh: <b><?php $d=strtotime($nhanvien['ngaySinh']);
                    echo date("d-m-Y", $d); ?></b></span></h3>
                    <h3 class="">Địa chỉ: <b><?= $nhanvien['diaChi'] ?></b></h3>
                    <h3 class="">Email: <b><?= $nhanvien['email'] ?></b></h3>
                    <h3 class="">Lương: <b><?= $nhanvien['luong'] ?></b></h3>
                    <h3 class="">Số CMND: <b><?= $nhanvien['soCMND'] ?></b></h3>
                    <h3 class="">Mã BHXH: <b><?= $nhanvien['maBHXH'] ?></b></h3>
                    <h3 class="">Mã BHYT: <b><?= $nhanvien['maBHYT'] ?></b></h3>
                </div>
            </div>
        </div>

    </div>

</body>
<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
</html>

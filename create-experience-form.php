<?php
session_start();
if (!isset($_SESSION['tenDN'])) {
    header("Location: form-login.php");
}
include_once "connect-to-sql.php";

$dsNhanVien = $connection->query("SELECT NV.* FROM TaiKhoan AS T JOIN NhanVien AS NV ON T.maNV = NV.id WHERE loaiTK = 'NHANVIEN'");

if (isset($_POST['submit'])){
    $instance = $_POST;
    $sql = "INSERT INTO QTCongTac VALUES 
    ('".$instance['maNV']."','".$instance['maPB']."','".$instance['ngayDenCT']."','".$instance['ngayChuyenCT']."','".$instance['moTaCongViec']."')";
    if ($connection->query($sql)){
        header("Location: experience.php");
    }
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
                <a class="navbar-brand" href="">Quản lý QT công tác</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index-admin.php"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION["Admin"]; ?></a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Đăng xuất</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center text-primary"><b>Thêm QT công tác</b></h2>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-12">
                <form class="form-horizontal" enctype="multipart/form-data">
                    <fieldset>
                        <legend></legend>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="nhanVien">Nhân viên</label>
                            <div class="col-md-4">
                                <select id="nhanVien" name="nhanVien" class="form-control">
                                    <?php foreach ($dsNhanVien as $item): ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['hoTen'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="ngayDenCT">Ngày đến công tác</label>
                            <div class="col-md-4">
                                <input id="ngayDenCT" name="ngayDenCT" class="form-control input-md"
                                required="" type="date">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="ngayChuyenCT">Ngày chuyển công tác</label>
                            <div class="col-md-4">
                                <input id="ngayChuyenCT" name="ngayChuyenCT" class="form-control input-md"
                                required="" type="date">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="moTaCongViec">Mô tả công việc</label>
                            <div class="col-md-4">
                                <input id="moTaCongViec" name="moTaCongViec" class="form-control input-md"
                                required="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-4 col-md-4">
                                <button type="button" class="btn btn-primary" id="btn-create">Thêm mới</button>
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
<script>
    $('#btn-create').click(function(){
        var _this = $(this);
        var form_data = new FormData();
        form_data.append("maNV", $('#nhanVien').val());
        form_data.append("ngayDenCT", $('#ngayDenCT').val());
        form_data.append("ngayChuyenCT", $('#ngayChuyenCT').val());
        form_data.append("moTaCongViec", $('#moTaCongViec').val());
        $.ajax({
            type: 'POST',
            url: 'create-experience.php',
            data: form_data,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response){
                if(response.is === 'success'){
                    swal({
                        title: response.complete,
                        text: "Đã thêm thành công",
                        icon: "success"
                    })

                    window.location.href = "experience.php";
              }
              if(response.is === 'fail'){
                  swal({
                    title: response.uncomplete,
                    text: "Thêm không thành công",
                    icon: "error"
                })
              }
          }
      })
    })
</script>
</html>




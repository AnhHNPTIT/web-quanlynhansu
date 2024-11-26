<?php
session_start();
if (!isset($_SESSION['tenDN'])) {
    header("Location: form-login.php");
}
include_once "connect-to-sql.php";

if (isset($_POST['submit'])){
    $phongban = $_POST;
    $sql = "INSERT INTO PhongBan VALUES 
    ('".$phongban['tenPB']."','".$phongban['soDT']."','".$phongban['diaChi']."')";
    if ($connection->query($sql)){
        header("Location: department.php");
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
                <a class="navbar-brand" href="">Quản lý phòng ban</a>
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
                <h2 class="text-center text-primary"><b>Thêm phòng ban</b></h2>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-12">
                <form class="form-horizontal" enctype="multipart/form-data">
                    <fieldset>
                        <legend></legend>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="tenPB">Tên phòng ban</label>
                            <div class="col-md-4">
                                <input id="tenPB" name="tenPB" class="form-control input-md"
                                required="" type="text">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="soDT">Số điện thoại</label>
                            <div class="col-md-4">
                                <input id="soDT" name="soDT" class="form-control input-md"
                                required="" type="text">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="diaChi">Địa chỉ</label>
                            <div class="col-md-4">
                                <input id="diaChi" name="diaChi" class="form-control input-md"
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
        form_data.append("tenPB", $('#tenPB').val());
        form_data.append("diaChi", $('#diaChi').val());
        form_data.append("soDT", $('#soDT').val());
        $.ajax({
            type: 'POST',
            url: 'create-department.php',
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

                    window.location.href = "department.php";
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




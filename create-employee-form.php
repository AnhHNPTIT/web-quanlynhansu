<?php
session_start();
if (!isset($_SESSION['tenDN'])) {
    header("Location: form-login.php");
    exit();
}

include_once "connect-to-sql.php";

// Lấy danh sách pb
$dsphongban = $connection->query("SELECT * FROM PhongBan");

if (isset($_POST['submit'])) {
    $sinhvien = $_POST;

    // Xử lý upload ảnh
    if (isset($_FILES['Anh']['name']) && !empty($_FILES['Anh']['name'])) {
        $target_file = "public/images/" . 'img_' . date('Y-m-d-H-i-s') . '.png';
        if (move_uploaded_file($_FILES["Anh"]["tmp_name"], $target_file)) {
            $sinhvien['Anh'] = $target_file;
        } else {
            $sinhvien['Anh'] = ''; // Nếu upload thất bại, để trống
        }
    } else {
        $sinhvien['Anh'] = ''; // Không có file upload
    }

    // Sử dụng prepared statements để tránh SQL injection
    $sql = "INSERT INTO sinhvien (maNV, hoTen, gioiTinh, ngaySinh, diaChi, Email, phongBan, Anh) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param(
            "ssssssss",
            $sinhvien['maNV'],
            $sinhvien['hoTen'],
            $sinhvien['gioiTinh'],
            $sinhvien['ngaySinh'],
            $sinhvien['diaChi'],
            $sinhvien['Email'],
            $sinhvien['phongBan'],
            $sinhvien['Anh']
        );

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            header("Location: employee.php");
            exit();
        } else {
            echo "Đã xảy ra lỗi trong quá trình thêm sinh viên.";
        }

        $stmt->close();
    } else {
        echo "Không thể chuẩn bị câu lệnh SQL.";
    }
}

$connection->close();
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
                <a class="navbar-brand" href="">Quản lý nhân viên</a>
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
                <h2 class="text-center text-primary"><b>Thêm nhân viên</b></h2>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="col-md-12">
                <form class="form-horizontal" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="phongBan">Phòng ban</label>
                            <div class="col-md-4">
                                <select id="phongBan" name="phongBan" class="form-control">
                                    <?php foreach ($dsphongban as $item): ?>
                                        <option value="<?= $item['id'] ?>"><?= $item['tenPB'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Text input-->
                        <div class="form-group">
                        <label class="col-md-4 control-label" for="taiKhoan">Tài khoản</label>
                        <div class="col-md-4">
                            <input id="taiKhoan" name="taiKhoan" class="form-control input-md"
                            required="" type="text">
                        </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                        <label class="col-md-4 control-label" for="matKhau">Mật khẩu</label>
                        <div class="col-md-4">
                            <input id="matKhau" name="matKhau" class="form-control input-md"
                            required="" type="text">
                        </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="maNV">Mã nhân viên</label>
                            <div class="col-md-4">
                                <input id="maNV" name="maNV" class="form-control input-md"
                                required="" type="text">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="hoTen">Họ và tên</label>
                            <div class="col-md-4">
                                <input id="hoTen" name="hoTen" class="form-control input-md"
                                required="" type="text">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="anh">Ảnh thẻ</label>
                            <div class="col-md-4">
                                <div class="col-md-4">
                                    <input id="anh" name="Anh" class="input-file" type="file">
                                </div>
                            </div>
                        </div>
                        <!-- Select Basic -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="gioiTinh">Giới tính</label>
                            <div class="col-md-4">
                                <select id="gioiTinh" name="gioiTinh" class="form-control">
                                    <option value="Nam">Nam</option>
                                    <option value="Nữ">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="ngaySinh">Ngày sinh</label>
                            <div class="col-md-4">
                                <input id="ngaySinh" name="ngaySinh" class="form-control input-md"
                                required="" type="date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="diaChi">Địa chỉ</label>
                            <div class="col-md-4">
                                <input id="diaChi" name="diaChi" class="form-control input-md"
                                required="" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="email">Email</label>
                            <div class="col-md-4">
                                <input id="email" name="email" class="form-control input-md"
                                required="" type="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="soDT">Số ĐT</label>
                            <div class="col-md-4">
                                <input id="soDT" name="soDT" class="form-control input-md"
                                required="" type="soDT">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="bangCap">Bằng cấp</label>
                            <div class="col-md-4">
                                <input id="bangCap" name="bangCap" class="form-control input-md"
                                required="" type="bangCap">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="soCMND">Số CMND</label>
                            <div class="col-md-4">
                                <input id="soCMND" name="soCMND" class="form-control input-md"
                                required="" type="soCMND">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="maBHXH">Số BHXH</label>
                            <div class="col-md-4">
                                <input id="maBHXH" name="maBHXH" class="form-control input-md"
                                required="" type="maBHXH">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="maBHYT">Số BHYT</label>
                            <div class="col-md-4">
                                <input id="maBHYT" name="maBHYT" class="form-control input-md"
                                required="" type="maBHYT">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="luong">Lương</label>
                            <div class="col-md-4">
                                <input id="luong" name="luong" class="form-control input-md"
                                required="" type="luong">
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
        form_data.append("maPB", $('#phongBan').val());
        form_data.append("taiKhoan", $('#taiKhoan').val());
        form_data.append("matKhau", $('#matKhau').val());
        form_data.append("maNV", $('#maNV').val());
        form_data.append("hoTen", $('#hoTen').val());
        form_data.append("anhThe", $('#anh')[0].files[0]); // Lấy tệp từ input type="file"
        form_data.append("gioiTinh", $('#gioiTinh').val());
        form_data.append("ngaySinh", $('#ngaySinh').val());
        form_data.append("diaChi", $('#diaChi').val());
        form_data.append("email", $('#email').val());
        form_data.append("soDT", $('#soDT').val());
        form_data.append("bangCap", $('#bangCap').val());
        form_data.append("soCMND", $('#soCMND').val());
        form_data.append("maBHXH", $('#maBHXH').val());
        form_data.append("maBHYT", $('#maBHYT').val());
        form_data.append("luong", $('#luong').val());
        $.ajax({
            type: 'POST',
            url: 'create-employee.php',
            data: form_data,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(res){
                let response;
                try {
                    response = JSON.parse(res);
                } catch (error) {
                    response = res;
                }
                if(response.is === 'success'){
                    swal({
                        title: response.complete,
                        text: "Đã thêm thành công",
                        icon: "success"
                    })

                    setTimeout(() => {
                        window.location.href = 'employee.php';
                    }, 600);
                }
                if(response.is === 'fail'){
                    swal({
                        title: response.message,
                        text: "Thêm không thành công",
                        icon: "error"
                    })
                }
          }
      })
    })
</script>
</html>




<?php
session_start();
if (!isset($_SESSION['tenDN'])) {
    header("Location: form-login.php");
    exit();
}

include_once "connect-to-sql.php";

$data = $connection->query("SELECT NV.* FROM TaiKhoan AS T JOIN NhanVien AS NV ON T.maNV = NV.id WHERE loaiTK = 'NHANVIEN'");

if (isset($_GET['id'])) {
    $id = $connection->real_escape_string($_GET['id']);
    $stmt = $connection->prepare("SELECT * FROM TaiKhoan WHERE id = ?");
    $stmt->bind_param("s", $delete_sv);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows <= 0) {
        header("Location: employee.php");
        exit();
    }

    $nhan_vien = $result->fetch_assoc();

    // Xóa file ảnh nếu tồn tại
    if (!empty($nhan_vien['anhThe']) && file_exists($nhan_vien['anhThe'])) {
        unlink($nhan_vien['anhThe']);
    }

    $stmt = $connection->prepare("DELETE FROM TaiKhoan WHERE id = ?");
    $stmt->bind_param("s", $delete_sv);
    $stmt->execute();

    // Chuyển hướng về trang chính
    header("Location: employee.php");
    exit();
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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="public/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="public/css/datatables.min.css"/>
  <link rel="stylesheet" type="text/css" href="public/css/back-top.css"/>
  <link rel="stylesheet" type="text/css" href="public/css/back-down.css"/>
<!-- lib jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

  <nav class="navbar navbar-inverse container-fluid">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="">Quản lý nhân viên</a>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index-admin.php"><span class="glyphicon glyphicon-user"></span><?php echo $_SESSION["Admin"]; ?>  </a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Đăng xuất</a></li>
      </ul>
    </div>
  </nav>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center text-primary"><b>Danh sách nhân viên</b></h2>
      </div>
      <div class="col-md-12">
        <a href="create-employee-form.php" type="button" class="btn btn-success">Thêm nhân viên</a>
      </div>
    </div>
    <legend></legend>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered table-striped dataTable" id="myTable">
          <thead>
            <tr>
             <th>Mã nhân viên</th>
             <th>Họ tên</th>
             <th>Ảnh</th>
             <th>SĐT</th>
             <th>Ngày sinh</th>
             <th>Số CMND</th>
             <th>Lương</th>
             <th>Hành động</th>
           </tr>
         </thead>
         <tfoot>
          <tr>
              <th>Mã nhân viên</th>
             <th>Họ tên</th>
             <th>Ảnh</th>
             <th>SĐT</th>
             <th>Ngày sinh</th>
             <th>Số CMND</th>
             <th>Lương</th>
             <th>Hành động</th>
          </tr>
        </tfoot>
        <tbody>
         <?php
         if ($data->num_rows > 0) {
          while ($row = $data->fetch_assoc()) { ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['hoTen'] ?></td>
              <td><img src="<?= $row['anhThe'] ?>" style= "width: 100px; height: auto;"/></td>
              <td><?= $row['soDT'] ?></td>
              <td><?php $d=strtotime($row['ngaySinh']);
              echo date("d-m-Y", $d); ?></td>
              <td><?= $row['soCMND'] ?></td>
              <td><?= $row['luong'] ?></td>
              <td>
                <a href="show-employee-form.php?id=<?= $row['id'] ?>" type="button"
                  class="btn btn-success btn-status" title="Xem"><i class="fa fa-eye"></i></a>
                  <a href="edit-employee-form.php?id=<?= $row['id'] ?>" type="button" class="btn btn-warning btn-edit" title="Sửa"><i class="glyphicon glyphicon-edit"></i></a>
                  <button type="button" data-id="<?= $row['id'] ?>"
                    class="btn btn-danger btn-delete" title="Xoá"><i class="glyphicon glyphicon-trash"></i></button>
                  </td>
                </tr>
                <?php
              }
            }
            ?>
          </tbody>
        </table>
        <style>
          tr th{
            text-align: center;
          }
          tr td{
            text-align: center;
          }
        </style>
      </div>
    </div>
  </div>             
  <p id="back-top" style=""><a id="top" href="javascript:void(0)"></a></p>
  <p id="back-down" style=""><a id="down" href="javascript:void(0)"></a></p>
  <script>
          // back-top
          $(document).scroll(function() {
           if($(window).scrollTop() > 200) {
             $('#back-top').css({ display: "block" });
           }
           else{
            $('#back-top').css({ display: "none" });
          }
        });
          $('#top').click(function(){
            window.scrollTo({top: 0, behavior: 'smooth'});
          })
          // back-down
          $(document).scroll(function(){
            if($(document).height() - $(document).scrollTop() > 1000){
              $('#back-down').css({display: "block"});
            }
            else{
              $('#back-down').css({display: "none"});
            }
          });
          $('#down').click(function(){
            window.scrollTo({top: $(document).height(), behavior: 'smooth'});
          })
        </script>                       
      </div> 
    </div>

  </body>
  <script src="public/js/sweetalert.min.js"></script>
  <script src="public/js/jquery.min.js"></script>
  <script src="public/js/bootstrap.min.js"></script>
  <script src="public/js/datatables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });

    $('.btn-delete').click(function(){
      var _this = $(this);
      var maNV = $(this).attr('data-id');
      var form_data = new FormData();
      form_data.append("maNV", maNV);
      swal({
        title: "Bạn chắc chắn?",
        text: "Bạn có thực sự muốn xóa không?",
        icon: "warning",
        buttons: true,
        buttons: ["Hủy", "Đồng ý"]
      })
      .then(confirm => {
        if(confirm){
          $.ajax({
            type: 'post',
            url : 'delete-employee.php',
            data: form_data,
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
        }
      })
    })
  </script>
  </html>




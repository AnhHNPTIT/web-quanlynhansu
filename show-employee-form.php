<?php
session_start();

// Kiểm tra đăng nhập
if (empty($_SESSION['tenDN'])) {
    header("Location: form-login.php");
    exit;
}

include_once "connect-to-sql.php";

// Kiểm tra và lấy thông tin `id`
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $connection->prepare("SELECT NV.*, QT.id AS qTCTID, QT.ngayDenCT, QT.ngayChuyenCT, QT.moTaCongViec, PB.tenPB 
        FROM QTCongTac AS QT 
        JOIN NhanVien AS NV ON QT.maNV = NV.id 
        JOIN PhongBan AS PB ON PB.id = QT.maPB 
        WHERE NV.id = ?");
        $stmt->bind_param("i", $id); // "i" stands for integer
        $stmt->execute();
        $data = $stmt->get_result();


    // Sử dụng prepared statement để bảo mật
    $stmt = $connection->prepare("SELECT * FROM NhanVien WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Nếu không tìm thấy nhân viên
    if ($result->num_rows <= 0) {
        header("Location: employee.php");
        exit;
    }

    $nhanvien = $result->fetch_assoc();
    $stmt->close();

    // Lấy danh sách phòng ban
    $stmt = $connection->prepare("SELECT * FROM PhongBan");
    $stmt->execute();
    $dsphongban = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    header("Location: employee.php");
    exit;
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
                <h2 class="text-center text-primary"><b>Thông tin nhân viên</b></h2>
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
                                    <option value="<?= $item['id'] ?>" <?= $item['id'] == $nhanvien['maPB'] ? 'selected' : '' ?>>
                                        <?= $item['tenPB'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                        </div>
                        
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="maNV">Mã nhân viên</label>
                            <div class="col-md-4">
                                <input id="maNV" name="maNV" class="form-control input-md"
                                required="" type="text" value="<?= $nhanvien['id'] ?>">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="hoTen">Họ và tên</label>
                            <div class="col-md-4">
                                <input id="hoTen" name="hoTen" class="form-control input-md"
                                required="" type="text" value="<?= $nhanvien['hoTen'] ?>">
                            </div>
                        </div>
                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="anh">Ảnh thẻ</label>
                            <div class="col-md-4">
                                <div class="col-md-4">
                                    <img src="<?= $nhanvien['anhThe'] ?>" alt="">
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
                                required="" type="text" value="<?= $nhanvien['diaChi'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="email">Email</label>
                            <div class="col-md-4">
                                <input id="email" name="email" class="form-control input-md"
                                required="" type="email" value="<?= $nhanvien['email'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="soDT">Số ĐT</label>
                            <div class="col-md-4">
                                <input id="soDT" name="soDT" class="form-control input-md"
                                required="" type="soDT" value="<?= $nhanvien['soDT'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="bangCap">Bằng cấp</label>
                            <div class="col-md-4">
                                <input id="bangCap" name="bangCap" class="form-control input-md"
                                required="" type="bangCap" value="<?= $nhanvien['bangCap'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="soCMND">Số CMND</label>
                            <div class="col-md-4">
                                <input id="soCMND" name="soCMND" class="form-control input-md"
                                required="" type="soCMND" value="<?= $nhanvien['soCMND'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="maBHXH">Số BHXH</label>
                            <div class="col-md-4">
                                <input id="maBHXH" name="maBHXH" class="form-control input-md"
                                required="" type="maBHXH" value="<?= $nhanvien['maBHXH'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="maBHYT">Số BHYT</label>
                            <div class="col-md-4">
                                <input id="maBHYT" name="maBHYT" class="form-control input-md"
                                required="" type="maBHYT" value="<?= $nhanvien['maBHYT'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label" for="luong">Lương</label>
                            <div class="col-md-4">
                                <input id="luong" name="luong" class="form-control input-md"
                                required="" type="luong" value="<?= $nhanvien['luong'] ?>">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="row">
      <div class="col-md-12" style="margin-bottom: 20px;">
        <table class="table table-bordered table-striped dataTable" id="myTable">
          <thead>
            <tr>
             <th>Tên phòng ban</th>
             <th>Ngày đến CT</th>
             <th>Ngày chuyển CT</th>
             <th>Mô tả công việc</th>
             <th>Hành động</th>
           </tr>
         </thead>
         <tfoot>
          <tr>
             <th>Tên phòng ban</th>
             <th>Ngày đến CT</th>
             <th>Ngày chuyển CT</th>
             <th>Mô tả công việc</th>
             <th>Hành động</th>
          </tr>
        </tfoot>
        <tbody>
         <?php
         if ($data->num_rows > 0) {
          while ($row = $data->fetch_assoc()) { ?>
            <tr>
              <td><?= $row['tenPB'] ?></td>
              <td><?= $row['ngayDenCT'] ?></td>
              <td><?= $row['ngayChuyenCT'] ?></td>
              <td><?= $row['moTaCongViec'] ?></td>
              <td>
                  <a href="edit-experience-form.php?id=<?= $row['qTCTID'] ?>" type="button" class="btn btn-warning btn-edit" title="Sửa">
                    <i class="glyphicon glyphicon-edit"></i>
                  </a>
                  <button type="button" data-id="<?= $row['qTCTID'] ?>"
                    class="btn btn-danger btn-delete" title="Xoá"><i class="glyphicon glyphicon-trash"></i></button>
                  </td>
                </tr>
                <?php
              }
            }
            ?>
          </tbody>
        </table>
        <div class="form-group">
                            <div class="col-md-offset-5 col-md-5">
                            <a href="employee.php" type="button"
                                class="btn btn-danger btn-status" title="Xem">Quay lại</a>
                            </div>
                        </div>
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
    </div>
</body>
</html>

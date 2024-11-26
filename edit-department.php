<?php
session_start();
if (!isset($_SESSION['tenDN'])) {
  header("Location: form-login.php");
}

include_once "connect-to-sql.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $phong_ban = $connection->query("SELECT * FROM PhongBan WHERE id = '" . $id . "'");
    if ($phong_ban->num_rows <= 0) {
        header("Location: department.php");
    }
    $phong_ban = $phong_ban->fetch_assoc();
}

if (isset($_POST['submit'])) {
    $payload = $_POST;

    // Prepare the SQL query to avoid SQL injection
    $sql = "UPDATE PhongBan 
            SET tenPB = ?, soDT = ?, diaChi = ? 
            WHERE id = ?";

    $stmt = $connection->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bind_param(
        "ssss", 
        $payload['tenPB'], 
        $payload['soDT'], 
        $payload['diaChi'], 
        $payload['id']
    );

    // Execute the query
    if ($stmt->execute()) {
        header("Location: department.php");
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
            <h2 class="text-center text-primary"><b>Sửa phòng ban</b></h2>
        </div>
    </div>

    <div class="row" style="margin-top: 10px">
        <div class="col-md-12">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <fieldset>
                    <input style="display: none;" name="id" class="form-control input-md"
                            required="" type="text" value="<?= $phong_ban['id'] ?>">
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="product_name">Tên phòng ban</label>
                        <div class="col-md-4">
                            <input id="product_name" name="tenPB" class="form-control input-md"
                            required="" type="text" value="<?= $phong_ban['tenPB'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tutorial">Số điện thoại</label>
                        <div class="col-md-4">
                            <input id="gia" name="soDT" class="form-control input-md"
                            required="" type="text" value="<?= $phong_ban['soDT'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="tutorial">Địa chỉ</label>
                        <div class="col-md-4">
                            <input id="gia" name="diaChi" class="form-control input-md"
                            required="" type="diaChi" value="<?= $phong_ban['diaChi'] ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-4">
                            <button name="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="employee.php"><button type="button" class="btn btn-primary">Hủy</button></a>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

</body>
<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
</html>




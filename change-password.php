<?php 
  session_start();
  if (!isset($_SESSION['tenDN'])) {
    header("Location: form-login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Thay đổi mật khẩu</title>

  <!-- Custom fonts for this template-->
  <link id="ctl00_favicon" rel="shortcut icon" type="image/x-icon" href="http://qldt.ptit.edu.vn/Images/Edusoft.gif">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="public/css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Thay đổi mật khẩu!</h1>
              </div>
              <form class="user">
                <div class="form-group">
             
                  <input type="password" class="form-control form-control-user" id="newpassword" placeholder="Mật khẩu mới"><br>
                  <input type="password" class="form-control form-control-user" id="renewpassword" placeholder="Nhập lại mật khẩu mới"><br>
                  <button type="button" class="btn btn-primary btn-change">
                    Thay đổi mật khẩu
                  </button>
                </div>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="form-login.php">Bạn có sẵn một tài khoản? Đăng nhập!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>
<script src="public/js/sweetalert.min.js"></script>
<script src="public/js/jquery.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/datatables.min.js"></script>
<script>
  $('.btn-change').click(function(){
    if($('#newpassword').val() != null && $('#renewpassword').val() != null){
      form_data = new FormData();

      form_data.append("newpassword", $('#newpassword').val());
      form_data.append("renewpassword", $('#renewpassword').val());
      $.ajax({
       type: "POST",
       url: "password.php",
       data: form_data,
       contentType: false,
       processData: false,
       success: function(response){
        if(response.is === 'fail'){
            swal({
              title: "Thất bại!",
              text: response.mess,
              icon: "error",
              buttons: false,
              timer: 3000,
          })
        }
        if(response.is === 'success'){
            swal({
              title: "Thành công!",
              text: response.mess,
              icon: "success",
              buttons: false,
              timer: 500,
          })

          setTimeout(() => {
              window.location.href = 'form-login.php';
          }, 600);
        }
       }
      })
    }
    else{
      swal({
          title: "Thất bại!",
          text: "Bạn cần nhập mật khẩu",
          icon: "error",
          buttons: false,
          timer: 3000,
      })
    }
  })
</script>
</html>

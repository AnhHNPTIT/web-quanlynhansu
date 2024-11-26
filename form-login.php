<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link id="ctl00_favicon" rel="shortcut icon" type="image/x-icon" href="http://qldt.ptit.edu.vn/Images/Edusoft.gif">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Custom styles for this template-->
  <link href="public/css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
             <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
             <div class="col-lg-6"> 
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Đăng nhập</h1>
                </div>
                <form class="user" action="" >
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="tenDN" name="tenDN" placeholder="Tên đăng nhập">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="matKhau" name="matKhau" placeholder="Mật khẩu">
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox small">
                      <input type="checkbox" class="custom-control-input" id="customCheck">
                      <label class="custom-control-label" for="customCheck">Nhớ mật khẩu</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button id = "btn-login" type="button" class="btn btn-primary">Đăng nhập</button>
                  </div>
                  <hr>
                </form>
                <div class="text-center">
                  <a class="small" href="forgot-password.html">Quên mật khẩu?</a>
                </div>
              </div>
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
 $('#btn-login').click(function(){
  var _this = $(this);
  var form_data = new FormData();
  form_data.append("tenDN", $('#tenDN').val());
  form_data.append("matKhau", $('#matKhau').val());
  $.ajax({
   type: "POST",
   url: "login.php",
   data: form_data,
   contentType: false,
   processData: false,
   success: function(response){
    if(response.is === 'fail'){
        swal({
          title: "Thất bại!",
          text: "Tên đăng nhập hoặc mật khẩu không chính xác",
          icon: "error",
          buttons: false,
          timer: 3000,
      })
    }
    if(response.is === 'success'){
        if(response.loaiTK === 'NHANVIEN'){
          window.location.href = 'index-employee.php';
        }
        if(response.loaiTK === 'ADMIN'){
          window.location.href = 'index-admin.php';
        }
    }
}
})


})
</script>
</html>

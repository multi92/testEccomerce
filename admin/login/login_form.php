<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>AdminPanel | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="cdn/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="cdn/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <?php $backgrounds=array("bg1.jpg","bg2.jpg","bg3.jpg","bg4.jpg","bg5.jpg","bg6.jpg","bg7.jpg","bg8.jpg");
        

  ?>
  <body class="login-page image-responsive" style="background-image: url('cdn/img/login_page_backgrounds/<?php echo $backgrounds[rand(0, count($backgrounds) - 1)];?>'); background-repeat: no-repeat;
    background-size: cover; background-position: center;height: 100%;  ">
    <div class="login-box">
      <div class="login-logo">
        <a ><b>Admin Panel</b> Login </a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <form action="" method="post" >
          <div class="form-group has-feedback">
            <input type="email" class="form-control" name="username" placeholder="Email" />
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password" />
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Zapamti me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat" name="submit_login_form">Uloguj se</button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="" class="text-center unavaibleOption">Zaboravili ste lozinku?</a><br>
        <a class="text-center unavaibleOption">Registracija novog korisnika</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="cdn/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
		$(".unavaibleOption").on("click", function(){
			alert("Ova opcija nije trenutno dostupna."); 
		});
    </script>
  </body>
</html>

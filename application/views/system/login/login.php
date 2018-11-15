
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <title>Login | Astoil SRL</title>

  <!-- Meta -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Favicon -->
  <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');?>">

  <!-- Web Fonts -->
  <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin'>

  <!-- CSS Global Compulsory -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">

  <!-- CSS Implementing Plugins -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/plugins/animate.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/line-icons/line-icons.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/plugins/font-awesome/css/font-awesome.min.css');?>">

  <!-- CSS Page Style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/pages/page_log_reg_v2.css');?>">

  <!-- CSS Theme -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/theme-colors/aqua.css');?>" id="style_color">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/theme-skins/dark.css');?>">

  <!-- JS Global Compulsory -->
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery/jquery.min.js');?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery/jquery-migrate.min.js');?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap/bootstrap.min.js');?>"></script>

</head>

<body>
  <!--=== Content Part ===-->
  <div class="container">
    <!--Reg Block-->
    <div class="reg-block">
      <div class="reg-block-header">
        <h2>Iniciar sesión</h2>
        <ul class="social-icons text-center">
          <li><a class="rounded-x social_facebook" data-original-title="Facebook" href="#"></a></li>
          <li><a class="rounded-x social_twitter" data-original-title="Twitter" href="#"></a></li>
          <li><a class="rounded-x social_googleplus" data-original-title="Google Plus" href="#"></a></li>
          <li><a class="rounded-x social_linkedin" data-original-title="Linkedin" href="#"></a></li>
        </ul>
        <!-- <p>Don't Have Account? Click <a class="color-green" href="page_registration1.html">Sign Up</a> to registration.</p>  -->
      </div>

      <form action="<?php echo base_url('index.php/Login/login');?>" method="POST" id="formLogin">
        <div class="input-group margin-bottom-20">
          <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
          <input type="text" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="input-group margin-bottom-20">
          <span class="input-group-addon"><i class="fa fa-lock"></i></span>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <hr>
        <!--
        <div class="checkbox">
          <label>
            <input type="checkbox">
            <p>Always stay signed in</p>
          </label>
        </div>
        -->

        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <button type="submit" class="btn-u btn-block">Loguearse</button>
          </div>
        </div>
      </form>
    </div>
    <!--End Reg Block-->
    <?php $this->load->view('includes/flash_msg');?>
  </div><!--/container-->
  <!--=== End Content Part ===-->


  <!-- JS Implementing Plugins -->
  <script type="text/javascript" src="<?php echo base_url('assets/js/back-to-top.js');?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/plugins/backstretch/jquery.backstretch.min.js');?>"></script>

  <!-- JS Page Level -->
  <script type="text/javascript" src="<?php echo base_url('assets/js/app.js');?>"></script>

  <script type="text/javascript">
    jQuery(document).ready(function() {
      App.init();
    });
  </script>
  <script type="text/javascript">
    $.backstretch([
      "assets/img/bg/19.jpg",
      "assets/img/bg/18.jpg",
      ], {
        fade: 1000,
        duration: 7000
      });
  </script>

  <script>
    $(document).ready(function(){
        $('#formLogin').validate({
          rules: {
            email:    {required: true, email: true},
            password: {required: true}
          }
        });

    });
  </script>
  <!--[if lt IE 9]>
  <script src="assets/plugins/respond.js"></script>
  <script src="assets/plugins/html5shiv.js"></script>
  <script src="assets/plugins/placeholder-IE-fixes.js"></script>
  <![endif]-->
</body>
</html>

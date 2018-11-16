<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <title>Login | Unify - Responsive Website Template</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Web Fonts -->
    <link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin'>

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">

    <!-- CSS Header and Footer -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/headers/header-default.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/footers/footer-v1.css');?>">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/animate.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/line-icons/line-icons.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/font-awesome/css/font-awesome.min.css');?>">

    <!-- CSS Page Style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/pages/page_log_reg_v1.css');?>">

    <!-- CSS Theme -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/theme-colors/default.css');?>" id="style_color">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/theme-skins/dark.css');?>">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
</head>

<body>


<div class="wrapper">
    <!--=== Header ===-->
    <div class="header">
        <div class="container">
            <!-- Logo -->
            <a class="logo" href="<?php echo base_url();?>">
                <img src="<?php echo base_url('assets/img/logo.png');?>" alt="Logo">
            </a>
            <!-- End Logo -->
        </div><!--/end container-->
      <?php if (!empty($this->session->flashdata('error-login'))): ?>
        <!-- Alert Danger -->
        <div class="alert fade show g-bg-red-opacity-0_1 g-color-lightred rounded-0" role="alert">
          <button type="button" class="close u-alert-close--light g-ml-10 g-mt-1" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>

          <div class="media">
            <div class="media-body">
              <p class="m-0"> <?php echo $this->session->flashdata('error-login');?> </p>
            </div>
          </div>
        </div>
        <!-- End Alert Danger -->
      <?php endif ?>
    </div>
    <!--=== End Header ===-->



    <!--=== Content Part ===-->
    <div class="container content">
      <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
          <form class="reg-page" method="POST" action="<?php echo base_url('Login/login');?>">
              <input id="token" name="token" type="hidden" value="<?php echo $token;?>">
              <div class="reg-header">
                  <h2> Ingreso al sistema </h2>
              </div>

              <div class="input-group margin-bottom-20">
                  <span class="input-group-addon"><i class="fa fa-user"></i></span>
                  <input type="text" placeholder="Email" class="form-control" id="email">
              </div>
              <div class="input-group margin-bottom-20">
                  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                  <input type="password" placeholder="Contraseña" class="form-control" id="password">
              </div>

              <div class="row">
                  <div class="col-md-6 checkbox">

                  </div>
                  <div class="col-md-6">
                      <button class="btn-u pull-right" type="submit">Ingresar</button>
                  </div>
              </div>
          </form>
        </div>
      </div><!--/row-->
    </div><!--/container-->
    <!--=== End Content Part ===-->
</div><!--/wrapper-->

<!-- JS Global Compulsory -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery/jquery.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery/jquery-migrate.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>
<!-- JS Implementing Plugins -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/back-to-top.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/smoothScroll.js');?>"></script>
<!-- JS Customization -->
<script type="text/javascript" src="<?php echo base_url('assets/js/custom.js');?>"></script>
<!-- JS Page Level -->
<script type="text/javascript" src="<?php echo base_url('assets/js/app.js');?>"></script>

<script type="text/javascript">
    jQuery(document).ready(function() {
        App.init();
    });
</script>
<!--[if lt IE 9]>
    <script src="assets/plugins/respond.js"></script>
    <script src="assets/plugins/html5shiv.js"></script>
    <script src="assets/plugins/placeholder-IE-fixes.js"></script>
<![endif]-->

</body>
</html>

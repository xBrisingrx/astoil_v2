<div class="wrapper">
    <!--=== Header ===-->
    <div class="header">
        <div class="container">
            <!-- Logo -->
            <a class="logo" href="index.html">
                <img src="<?php echo base_url('assets/img/logo.png');?>" alt="Logo">
            </a>
            <!-- End Logo -->

            <!-- Topbar -->
            <div class="topbar">
                <ul class="loginbar pull-right">
                    <li class="hoverSelector">
                        <i class="fa fa-globe"></i>
                        <a>Languages</a>
                        <ul class="languages hoverSelectorBlock">
                            <li class="active">
                                <a href="#">English <i class="fa fa-check"></i></a>
                            </li>
                            <li><a href="#">Spanish</a></li>
                            <li><a href="#">Russian</a></li>
                            <li><a href="#">German</a></li>
                        </ul>
                    </li>
                    <li class="topbar-devider"></li>
                    <li><a href="page_faq.html">Help</a></li>
                    <li class="topbar-devider"></li>
                    <li><a href="page_login.html">Login</a></li>
                </ul>
            </div>
            <!-- End Topbar -->

            <!-- Toggle get grouped for better mobile display -->
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="fa fa-bars"></span>
            </button>
            <!-- End Toggle -->
        </div><!--/end container-->

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse mega-menu navbar-responsive-collapse">
            <div class="container">
                <ul class="nav navbar-nav">
                    <!-- Productos -->
                    <li class="dropdown">
                        <a href="<?php echo base_url('');?>" class="dropdown-toggle" data-toggle="dropdown">
                            Productos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('');?>">Admin productos</a></li>
                            <li><a href="<?php echo base_url('');?>">Admin rubros</a></li>
                            <li><a href="<?php echo base_url('');?>">Admin proveedores</a></li>
                        </ul>
                    </li>
                    <!-- End Productos -->

                    <!-- Ingresos -->
                    <li>
                        <a href="<?php echo base_url('');?>" class="dropdown-toggle">
                            Ingresos
                        </a>
                    </li>
                    <!-- End Ingresos -->

                    <!-- Salidas -->
                    <li class="dropdown">
                        <a href="<?php echo base_url('');?>" class="dropdown-toggle" data-toggle="dropdown">
                            Salidas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url('');?>">Admin salidas</a></li>
                            <li><a href="<?php echo base_url('');?>">Admin centros de costos</a></li>
                        </ul>
                    </li>
                    <!-- End Salidas -->

                    <!-- Informes -->
                    <li>
                        <a href="<?php echo base_url('');?>" class="dropdown-toggle">
                            Informes
                        </a>
                    </li>
                    <!-- End Informes -->

                    <!-- Usuararios -->
                    <li>
                        <a href="javascript:void(0);" class="dropdown-toggle">
                            Usuarios
                        </a>
                    </li>
                    <!-- End Usuararios -->
                </ul>
            </div><!--/end container-->
        </div><!--/navbar-collapse-->
    </div>
    <!--=== End Header ===-->
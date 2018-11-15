    <!-- Header -->
    <header id="js-header" class="u-header u-header--static--lg u-header--show-hide--lg u-header--change-appearance--lg" data-header-fix-moment="500" data-header-fix-effect="slide">
    <!-- Top Bar -->
    <div class="u-header__section g-brd-bottom g-brd-gray-light-v4 g-bg-black g-transition-0_3">
      <div class="container">
        <div class="row justify-content-between align-items-center g-mx-0--lg">

          <div class="col-sm-auto g-pos-rel g-py-8">
            <?php if (!empty($this->session->userdata('username'))): ?>
              <div class="text-white">
                Usuario activo: <?php echo $this->session->userdata('username') ?>
              </div>
            <?php endif ?>
          </div>

          <div class="col-sm-auto g-pr-15 g-pr-0--sm">
            <a href="<?php echo base_url('Login/logout'); ?>" class="btn btn-sm btn-info">Cerrar sesion</a>
          </div>
        </div>
      </div>
    </div>
    <!-- End Top Bar -->
      <div class="u-header__section u-header__section--light g-bg-white g-transition-0_3 g-py-10" data-header-fix-moment-exclude="g-bg-white g-py-10" data-header-fix-moment-classes="g-bg-white-opacity-0_7 u-shadow-v18 g-py-0">
        <nav class="navbar navbar-expand-lg">
          <div class="container">
            <!-- Responsive Toggle Button -->
            <button class="navbar-toggler navbar-toggler-right btn g-line-height-1 g-brd-none g-pa-0 g-pos-abs g-top-3 g-right-0" type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar" data-toggle="collapse" data-target="#navBar">
              <span class="hamburger hamburger--slider">
            <span class="hamburger-box">
              <span class="hamburger-inner"></span>
              </span>
              </span>
            </button>
            <!-- End Responsive Toggle Button -->
            <!-- Logo -->
            <a href="<?php echo base_url();?>" class="navbar-brand">
              <img src="<?php echo base_url('assets/img/logo.png');?>" alt="Image Description">
            </a>
            <!-- End Logo -->

            <!-- Navigation -->
            <div class="js-mega-menu collapse navbar-collapse align-items-center flex-sm-row g-pt-10 g-pt-5--lg" id="navBar">
              <ul class="navbar-nav text-uppercase g-font-weight-600 ml-auto">
                <li class="nav-item hs-has-sub-menu g-mx-20--lg">
                  <a href="<?php echo base_url('Products');?>" class="nav-link px-0" id="nav-link-productos" aria-haspopup="true"
                     aria-expanded="false" aria-controls="nav-submenu-productos">Productos
                  </a>
                  <!-- Submenu -->
                  <ul class="hs-sub-menu list-unstyled g-text-transform-none g-brd-top g-brd-primary g-brd-top-2 g-min-width-200 g-mt-20 g-mt-10--lg--scrolling" id="nav-submenu-productos" aria-labelledby="nav-link-productos">
                    <li class="dropdown-item">
                      <a class="nav-link g-px-0" href="<?php echo base_url('Products');?>">Admin productos</a>
                    </li>
                    <li class="dropdown-item">
                      <a class="nav-link g-px-0" href="<?php echo base_url('Rubros');?>">Admin rubros</a>
                    </li>
                    <li class="dropdown-item">
                      <a class="nav-link g-px-0" href="<?php echo base_url('Providers');?>">Admin proveedores</a>
                    </li>
<!--                     <li class="dropdown-item">
                      <a class="nav-link g-px-0" href="<?php echo base_url('Cost_center');?>">Admin centro de costos</a>
                    </li> -->
                  </ul>
                  <!-- End Submenu -->
                </li>
                <!-- end products -->
                <li class="nav-item g-mx-20--lg g-mb-5 g-mb-0--lg">
                  <a href="<?php echo base_url('Entries');?>" class="nav-link">Ingresos</a>
                </li>
                <li class="nav-item hs-has-sub-menu g-mx-20--lg">
                  <a href="<?php echo base_url('Outputs');?>" class="nav-link px-0" id="nav-link-outputs" aria-haspopup="true"
                     aria-expanded="false" aria-controls="nav-submenu-outputs">Salidas
                  </a>
                  <!-- Submenu -->
                  <ul class="hs-sub-menu list-unstyled g-text-transform-none g-brd-top g-brd-primary g-brd-top-2 g-min-width-200 g-mt-20 g-mt-10--lg--scrolling" id="nav-submenu-outputs" aria-labelledby="nav-link-outputs">
                    <li class="dropdown-item">
                      <a class="nav-link g-px-0" href="<?php echo base_url('Outputs');?>">Admin salidas</a>
                    </li>
                    <li class="dropdown-item">
                      <a class="nav-link g-px-0" href="<?php echo base_url('Cost_center');?>">Admin centro de costos</a>
                    </li>
                  </ul>
                  <!-- End Submenu -->
                </li>
                  <li class="nav-item g-mx-20--lg g-mb-5 g-mb-0--lg">
                    <a href="<?php echo base_url('Informes');?>" class="nav-link">Informes</a>
                  </li>
                <?php if ($this->session->userdata('rol') == 1): ?>
                  <li class="nav-item g-mx-20--lg g-mb-5 g-mb-0--lg">
                    <a href="<?php echo base_url('Users');?>" class="nav-link">Usuarios</a>
                  </li>
                <?php endif ?>
              </ul>
            </div>
            <!-- End Navigation -->
          </div>
        </nav>
      </div>
    </header>
    <!-- End Header -->
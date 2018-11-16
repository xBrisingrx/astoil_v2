<!--=== Footer Version 1 ===-->
<div class="footer-v1">
    <div class="footer">
        <div class="container">
            ...
            ...
        </div>
    </div><!--/footer-->

    <div class="copyright">
        <div class="container">
            ...
            ...
        </div>
    </div><!--/copyright-->
</div><!--/footer-v1-->
<!--=== End Footer Version 1 ===-->
</div><!--/wrapper-->

<!-- JS Global Compulsory -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>

<!-- JS Implementing Plugins -->
<script src="<?php echo base_url('assets/plugins/back-to-top.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/smoothScroll.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/sky-forms-pro/skyforms/js/jquery.maskedinput.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/sky-forms-pro/skyforms/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/sky-forms-pro/skyforms/js/messages_es_AR.js');?>"></script>

<!-- JS Customization -->
<script type="text/javascript" src="<?php echo base_url('assets/js/custom.js');?>"></script>

<!-- JS Page Level -->
<script src="<?php echo base_url('assets/js/app.js');?>"></script>

<!-- Datatables -->
<script src="<?php echo base_url('assets/js/datatables.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/datatables.bootstrap.min.js');?>"></script>

<script>
jQuery(document).ready(function() {
    App.init();
});
</script>

<!--[if lt IE 9]>
    <script src="assets/plugins/respond.js"></script>
    <script src="assets/plugins/html5shiv.js"></script>
    <script src="assets/plugins/placeholder-IE-fixes.js"></script>
<![endif]-->
<!--
    $(document).on('ready', function () {
      // initialization of go to
      $.HSCore.components.HSGoTo.init('.js-go-to');
    });

    $(window).on('load', function () {
      // initialization of header
      $.HSCore.components.HSHeader.init($('#js-header'));
      $.HSCore.helpers.HSHamburgers.init('.hamburger');

      // initialization of HSMegaMenu component
      $('.js-mega-menu').HSMegaMenu({
        event: 'hover',
        pageContainer: $('.container'),
        breakpoint: 991
      });
    });
  </script> -->
  </body>
</html>
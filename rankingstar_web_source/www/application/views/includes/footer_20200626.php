<!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="#"><?php echo lang('site_name_long') ?></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
         </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->


<script type="text/javascript">
    function toastMsg() {
        var toastmsg = "<?php echo $this->session->flashdata('login_success'); ?>";
        if(toastmsg != "" && toastmsg != undefined && toastmsg != null) {
            toastr.success(toastmsg);
        }
    }
    function actionSuccessToast() {
        var toastmsg = "<?php echo $this->session->flashdata('success_msg'); ?>";
        if(toastmsg != "" && toastmsg != undefined && toastmsg != null) {
            toastr.success(toastmsg);
        }
    }
    function setActiveMenu() {
        var active_menu = localStorage.getItem("active_menu");
        console.log(active_menu);
        if(active_menu == null) {
            active_menu = "dashboard";
            localStorage.setItem("active_menu", active_menu);
        }
        $('#'+active_menu).addClass('active');
    }
    $(document).ready(function() {
        toastMsg();
        setActiveMenu();
        actionSuccessToast();
        $('.menu').click(function() {
            $('.nav-link.active').removeClass('active');
            $(this).addClass('active');
            var id = $(this).attr('id');
            localStorage.setItem("active_menu", id);
        });
        $.loading.end();
    });

    function activeSideMenu(menuName) {
        localStorage.setItem("active_menu", menuName);
    }
    
    function startLoader() {
        $.loading.start('Loading...');
    }

    function stopLoader() {
        $.loading.end();
    }
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
</script>
</body>
</html>
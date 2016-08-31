 <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Simple Sidebar</h1>
                        <h1>About us</h1>
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                        <a href="<?php echo site_url("") ?>" class="btn btn-default" id="menu-toggle">Back Main</a>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->



    <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo base_url(); ?>js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>



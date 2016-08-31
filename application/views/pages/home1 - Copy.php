<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<?php $sitename= "Addige.NET Website"?>

    <title>Addige.NET Website</title>
    <link rel="icon" href="<?php echo base_url(); ?>/images/favicon.ico" type="image/x-icon">

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>css/simple-sidebar.css" rel="stylesheet">
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	<div class="page-header">
    
    <img src="<?php echo base_url(); ?>/images/Logo.jpg" width="155" height="77">
    
   
	</div>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                       <h2> Addige.NET</h2>
                  </a>
                </li>
                <li>
                    <a href="#">Home</a>
                </li>
                <li>
                 <a href="javascript:;" data-toggle="collapse" data-target="#demo" > Administration <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="<?php echo site_url("pages/mylink") ?>">Management</a>
                            </li>
                          	                            
                            <li>
                                <a href="<?php echo site_url("pages/aboutus") ?>">Site Management</a>
                            </li>
                        
                             <li>
                                <a href="#">Networks</a>
                            </li>
                            
                            </ul>
                   </li>         
                    <li>
                 <a href="javascript:;" data-toggle="collapse" data-target="#demo1" > Traffic <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo1" class="collapse">
                            
                          <li>
                                <a href="#">Manage Orders</a>
                            </li>
                          	                            
                            <li>
                                <a href="#">Manage files</a>
                            </li>
                        
                             <li>
                                <a href="#">Reports</a>
                            </li>
                            </ul>
                    </li>
                             
                            <li>
                 <a href="javascript:;" data-toggle="collapse" data-target="#demo3" > Billing <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo3" class="collapse">
                            <li>
                                <a href="#">Set info Month</a>
                            </li>
                          	                            
                            <li>
                                <a href="#">Invoicing</a>
                            </li>
                        
                             <li>
                                <a href="#">Legacy</a>
                            </li>
                            </ul>
                    </li>              
               
                   <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo4"><i class="fa fa-fw fa-arrows-v"></i> Utilities <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo4" class="collapse">
                            <li>
                                <a href="#">Insertion Stats</a>
                            </li>
                            <li>
                                <a href="#">Monitoring</a>
                            </li>
                            <li>
                                <a href="#">Others</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                    <a href="#">Logout</a>
                </li>
               
               
               
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Simple Sidebar</h1>
                        <p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
                        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

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

</body>

</html>

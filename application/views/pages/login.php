



<body>
    <div id="wrapper">
        <div id="sidebar-wrapper">
       	 	<div id="cssmenu">
        			<ul>
           				<div id="login_form">
            	 			<p>You're not login.</p>
                    			<p>LOGIN</p>
                			<?php 
								$data = array(
								'name'        => 'rememberme',
								'id'          => 'rememberme',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								echo form_open('pages/login/submit');
							?>
                            
                            	<span class="add-on"><i class="fa fa-user icon-large" style="color:#000"></i></span>
                            
                            	
								<?php
                                echo form_input('username','');
								
								?>
                                       	<span class="add-on"><i class="fa fa-key icon-large" style="color:#000"></i></span>
                            
                                
								<?php
								echo form_password('password','');
								
								?>
								<?php
                                echo "<br />";echo "<br />";
								echo "<br />";echo "<br />";
								echo form_checkbox($data);
								echo form_label('Remember Me', 'rememberme');
								
								
								echo "<br />";echo "<br />";
								echo form_submit('submit','Login');?>
                                
                                
                                
                	     		<?php echo "<br />";echo "<br />"; ?>
				   				<?php echo validation_errors(); ?>
                   				<?php echo form_open('pages/login'); ?>
                		</div>
            	</ul>          
        </div>       
    </div>

   
	<script src="<?php echo base_url(); ?>js/jquery-1.11.0.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
 	<script src="<?php echo base_url(); ?>js/script.js"></script>
</body>







</html>

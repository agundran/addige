<script>
function closepopup()
   {
	 	window.onunload = function(){
  				window.opener.location.reload();
		};
         window.close ();
        
		}

</script>
 <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                  
                       
                        <div id="container">
                        
							<div class="content">
                                <h3><?php echo $title; ?></h3>
                                <?php echo $message; ?>
                                <?php echo validation_errors(); ?>
                                <?php echo form_open($action); ?>
                                <div class="data">
                                	<table>
                                        <td>
                                        Update Priviledge Group<span style="color:red;">*</span>
                                        </td>
                                        <td>
                                       
                                          <?php
                                    $role_name = $this->manageusermodel->get_role();
                                    ?>
                                    <?php
                                   
								     $myexistingrole =  $Users['Rolename'];
								    echo form_dropdown('Priviledge_group', $role_name, $myexistingrole);
                                    ?>
                                       
                                       
                                       </td>
                                        </tr>
                                        
                                        <td>
                                        Update Operator Community<span style="color:red;">*</span>
                                        </td>
                                        <td>
                                        <?php
                                        $operator_name = $this->manageusermodel->get_operator();
                                        ?>
                                         
                                       
                                        <?php
                                        
                                        
                                         echo form_dropdown('Operator', $operator_name);
                                        ?>
                                        
                                        </td>
                                        
                                        </tr>
                                                   
                                      
                                        
                                        <tr>
                                            <td valign="top">Update Password<span style="color:red;">*</span></td>
                                            <td><input type="text" name="Password" class="text" value="<?php echo set_value($this->manageusermodel->decryptIt('Password'))?set_value($this->manageusermodel->decryptIt('Password')):$Users['Password']; ?>"/>
                                            <?php echo form_error('Password'); ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Update Email<span style="color:red;">*</span></td>
                                            <td><input type="text" name="Email" class="text" value="<?php echo set_value('Email')?set_value('Email'):$Users['Email']; ?>"/>
                                            <?php echo form_error('Email'); ?></td>
                                        </tr>
                                        
                                        
                                        
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" onclick="javascript: closepopup()"/></td>
                                        </tr>
                           	 	</table>
						</div>

	</form>


				<br />
					
						</div>
						
						
                       		 	<?php echo form_close(); ?>
								<?php echo validation_errors('<p class="error">'); ?>  
                        	<br  />
                        </div>
                         
                    </div>
                </div>
            </div>
        </div>
    <!-- /#page-content-wrapper -->



    



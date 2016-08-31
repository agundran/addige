<script>
function closepopup()
   {
	 	window.onunload = function(){
  				window.opener.location.reload();
		};
         window.close ();
        
		}

</script>


<div id="page-content-wrapper">
  <div class="container-fluid">
  	<div class="row">


<div class="col-lg-12">
  	
        <div id="container">
			<div class="content">
			<h4><?php echo $title; ?></h4>
			<?php echo $message; ?>
			<?php echo validation_errors(); ?>
			<?php echo form_open($action); ?>
			<div class="data">
			<table>
            <tr>
            <td>Priviledge Group</td>
            <td><?php $role_name = $this->manageusermodel->get_role();?>
                <?php echo form_dropdown('Priviledge_group', $role_name);?>
            </td>
            </tr><tr>
            <td>Operator Community</td>
            <td><?php $operator_name = $this->manageusermodel->get_operator();?>
                <?php echo form_dropdown('Operator', $operator_name);?>
            </td>
            </tr><tr>
            <td valign="top">Username<span style="color:red;">*</span></td>
            <td><input type="text" name="Username"  required class="text" value="<?php //echo (isset($Users['Username']))?$Users['Username']:''; 
			echo ""; ?>"/>
            </td>
            </tr><tr>
            <td valign="top">Password<span style="color:red;">*</span></td>
           <td><input type="password" name="Password" class="text" required value="<?php echo "";
		   //echo set_value($this->manageusermodel->decryptIt('Password'))?set_value($this->manageusermodel->decryptIt('Password')):$Users['Password']; ?>"/>
            <?php echo form_error('Password'); ?>
            </td>
            </tr><tr>
            <td valign="top">Email<span style="color:red;">*</span></td>
            <td><input type="text" name="Email" class="text" required value="<?php //echo set_value('Email')?set_value('Email'):$Users['Email']; ?>"/>
             <?php echo form_error('Email'); ?>
             </td>
             </tr><tr>
             <td>&nbsp;</td>
             <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" onclick="javascript: closepopup()"/></td>
             </tr><tr>
             
             <span style="color:red;">*</span> Required Fields
             </tr>
             </table>
						</div>

                           
                            <br />
                          
                            </div>
                            <?php echo form_close(); ?>
                            <?php echo validation_errors('<p class="error">'); ?>  
                            <br  />
     				</div>
               </div>
            </div>
        </div>
    <!-- /#page-content-wrapper -->


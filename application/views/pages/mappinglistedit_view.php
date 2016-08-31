
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
            <td>Network</td>
            <td>
			<input type="text" name="Network"  disabled="disabled" class="text" value="<?php echo (isset($Users['Network']))?$Users['Network']:''; ?>"/>
            
            
            
			  </td>
            </tr><tr>
			
            <td>HENumber</td>
            <td>
			<input type="text" name="HENumber"  class="text" value="<?php echo (isset($Users['HENumber']))?$Users['HENumber']:''; 
			echo ""; ?>"/>
			</td>
            </tr>
			<tr>
            <td>Network Number </td>
            <td><input type="text" name="NetworkNum"  disabled="disabled" class="text" value="<?php echo (isset($Users['NetworkNum']))?$Users['NetworkNum']:''; 
			echo ""; ?>"/>
            </td>
            </tr>
			<tr>
             <td>&nbsp;</td>
             <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" "/></td>
             </tr>
             
             
             <tr>
             
             
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


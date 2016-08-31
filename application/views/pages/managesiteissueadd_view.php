<div id="page-content-wrapper">
   <div class="container-fluid">
        <div class="row">
             <div class="col-lg-9">
                     <?php include("application/views/pages/template/ToggleBut.php"); ?>
                 <div id="container">    
						<div class="content">
                            <h4><?php echo $title; ?></h4>
                            <?php echo $message; ?>
                            <?php echo validation_errors(); ?>
							<?php echo form_open($action); ?>
					<div class="data">
					<table>
                     <tr><th>Date</th><th>Originator</th><th>Status</th></tr>
                     <tr>
                     <td><input type="text" name="Date"  required class="text" value="<?php echo (isset($Users['Date']))?$Users['Date']:''; ?>"/>
                     </td>
                     <td><input type="text" name="Originator"  required class="text" value="<?php echo (isset($Users['Originator']))?$Users['Originator']:''; ?>"/>
                     </td>
                     <td>
					 <?php
                     $options = array('1' => 'Close','0'  => 'Open', );  
					 echo form_dropdown('Status', $options, $Users['Status'] );
               		 ?>
					 </td>
                     </tr>
                     <tr>
                     <td>Description</td><td> </td><td> </td><td> </td>
                     </tr>
                     <tr>
                     <td width="100%">
                     <TEXTAREA NAME="Description"  COLS="100" ROWS="10"   >
					  <?php echo (isset($Users['Description']))?$Users['Description']:''; ?>
					  </TEXTAREA>
                      </td> <td> </td><td> </td><td> </td>                      
                      
                      </tr>
                      <tr>        
                      <td>              
                      <input type="submit" class="btn btn-primary btn-lg active" value="Save"/>
                      </td> <td> </td><td> </td><td> </td>
                     </tr>
                     </table>
                                                     
					</div>
                                        
                                        
                                       
									 <?php echo form_close(); ?>
							<br />
                            <?php echo $link_back; ?>
                            
                            
                            
						</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
		<?php include("application/views/pages/template/ToggleButScript.php"); ?>

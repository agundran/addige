<div id="page-content-wrapper">
   <div class="container-fluid">
        <div class="row">
             <div class="col-lg-12">
                     <?php include("application/views/pages/template/ToggleBut.php"); ?>
                 <div id="container">    
						<div class="content">
                            <h4><?php echo $title; ?></h4>
                            <?php echo $message; ?>
                            <?php echo validation_errors(); ?>
							<?php echo form_open($action); ?>
									<div class="data">
										<table>
                                                <tr>
                                                    <th>
                                                    Number
                                                    </th>
                                                    <th>
                                                    Date
                                                    </th>
                                                     <th>
                                                    Originator
                                                    </th>
                                                    <th>
                                                    Status
                                                    </th>
                                                   
                                                   </tr>
                                                   <tr>
                                                   
                                                    <td>
                                                    <input type="text" name="Seq" required class="text" readonly="readonly"  value="<?php echo (isset($Users['Seq']))?$Users['Seq']:''; ?>"/>
                                                   </td>
                                                    
                                                    <td>
                                                    <input type="text" name="Date"  required class="text" readonly="readonly" value="<?php echo (isset($Users['Date']))?$Users['Date']:''; ?>"/>
                                                   </td>
                                                    
                                                    <td>
                                                    <input type="text" name="Originator"  required class="text" readonly="readonly" value="<?php echo (isset($Users['Originator']))?$Users['Originator']:''; ?>"/>
                                                   </td>
                                                   <td>
                                                   <!-- <input type="text" name="Status"  class="text" value="<?php echo (isset($Users['Status']))?$Users['Status']:''; ?>"/>-->
                                    
                                    
                                                                                                 
               						<?php
                                     $options = array(
                  									'1'  => 'Close',
                  									'0'    => 'Open',
                  											  );   
                					echo form_dropdown('Status', $options, $Users['Status'] );
               						?>            
                                                    
                                                   </td>
                                                     </tr>
                                                     
                                                      <tr>
                                                    <td>
                                                    Description
                                                   </td>
                                                   
                                                    <td>
                                                  
                                                   </td>
                                                    <td>
                                                    
                                                   </td>
                                                    <td>
                                                    
                                                   </td>
                                                   </tr>
                                                   
                                                   </table>
                                                    
                                                    <TEXTAREA NAME="Description"  COLS="100" ROWS="10"  >
<?php echo (isset($Users['Description']))?$Users['Description']:''; ?>
													</TEXTAREA>
                                                    <br />
                                                    
                                                     <input type="submit" class="btn btn-primary btn-lg active" value="Save"/>									
                                                     
                                                     <br />
                                                     <?php echo $close_case_button; ?>
                                                     
                                                     </div>
                                        
                                        
                                       
									</form>
							<br />
                            <?php echo $link_back; ?>
                            
                            
                            
						</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
		<?php include("application/views/pages/template/ToggleButScript.php"); ?>

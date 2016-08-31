     

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
                                                <tr>
                                                    <td width="30%">
                                                    
                                                    </td>
                                                    
                                                    <td>
                                                      <input type="text" name="UserName" id="UserName" class="text" hidden="true" value="<?php echo (isset($Users['UserName']))?$Users['UserName']:''; ?>"/>
                                                    
                                              </td>
                                                    
                                                     </tr>
                                                        <tr>                                    
                                                    <td width="30%">
                                                    
                                                    Start Date
                                                    </td>
                                                    <td>
                                                   
                                                     <input type="text" name="Start_Date" disabled="disabled" id="Start_Date" class="text" value="<?php echo (isset($Users['Start_Date']))?$Users['Start_Date']:''; ?>"/>
                                                     </td>
                                                    </tr>
                                                    
                                                     <tr>                                    
                                                    <td width="30%">
                                                    
                                                    End Date
                                                    </td>
                                                    <td>
                                                   
                                                     <input type="text" name="End_Date" disabled="disabled" id="End_Date" class="text" value="<?php echo (isset($Users['End_Date']))?$Users['End_Date']:''; ?>"/>
                                                     </td>
                                                    </tr>
                                                    
                                                    
                                                 
                                                    
                                                  <input type="text" name="Month"  id="Month" class="text" hidden="true" value="<?php echo (isset($Users['Month']))?$Users['Month']:''; ?>"/>   
             
                                                    <br />
                                                                                             
                                                     <input type="text" name="Year" id="Year"    class="text"hidden="true" value="<?php echo (isset($Users['Year']))?$Users['Year']:''; ?>"/>
                                         
                                                  <tr>
                                                   <td>
                                                   </td>
                                                   
                                                    <td><input type="submit" class="btn btn-primary btn-lg active" value="Submit"  /></td>
                                                  </tr>
                                                  
                                                  
                                               </table>
										</div>
									</form>
							<br />
						</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
		

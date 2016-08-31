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
                                                  
                                                    </tr>
                                                    <tr>
                                                    <td width="30%">
                                                   
                                                    </td>
                                                    <td>
                                                    <input type="hidden" name="Seq"  required class="text" value="<?php echo (isset($Users['Seq']))?$Users['Seq']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                    <tr>
                                                    <td width="30%">
                                                    Salesman
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Name"  required class="text" style="font-weight:bolder" value="<?php echo (isset($Users['Name']))?$Users['Name']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Rate
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Rate"  required class="text" style="font-weight:bolder" value="<?php echo (isset($Users['Rate']))?$Users['Rate']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                     <tr>
                                                    <td>
                                                    Address 1
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Address1"  required class="text" style="font-weight:bolder" value="<?php echo (isset($Users['Address1']))?$Users['Address1']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                       <tr>
                                                    <td>
                                                    Address 2
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Address2"  class="text" style="font-weight:bolder" value="<?php echo (isset($Users['Address2']))?$Users['Address2']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    City
                                                    </td>
                                                    <td>
                                                    <input type="text" name="City"  required class="text" style="font-weight:bolder" value="<?php echo (isset($Users['City']))?$Users['City']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    State
                                                    </td>
                                                    <td>
                                                    <input type="text" name="State"  required class="text" style="font-weight:bolder" value="<?php echo (isset($Users['State']))?$Users['State']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                   	Zip
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Zip"  required class="text" style="font-weight:bolder" value="<?php echo (isset($Users['Zip']))?$Users['Zip']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Telephone
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Telephone"  required class="text" style="font-weight:bolder" value="<?php echo (isset($Users['Telephone']))?$Users['Telephone']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                   
                                                    
                                                                   
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><input type="submit" class="btn btn-primary btn-lg active" value="Save"/></td>
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
	

<div id="page-content-wrapper">
   <div class="container-fluid">
        <div class="row">
             <div class="col-lg-12">
                     <?php include("application/views/pages/template/ToggleBut.php"); ?>
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
                                                    Seq
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Seq" required class="text"  value="<?php echo (isset($Users['Seq']))?$Users['Seq']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td width="30%">
                                                    Operator
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Operator"  required class="text" value="<?php echo (isset($Users['Operator']))?$Users['Operator']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Customer Name
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Name"  required class="text" value="<?php echo (isset($Users['Name']))?$Users['Name']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                     <tr>
                                                    <td>
                                                    Address 1
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Address1"  class="text" value="<?php echo (isset($Users['Address1']))?$Users['Address1']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                       <tr>
                                                    <td>
                                                    Address 2
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Address2"  class="text" value="<?php echo (isset($Users['Address2']))?$Users['Address2']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    City
                                                    </td>
                                                    <td>
                                                    <input type="text" name="City"   class="text" value="<?php echo (isset($Users['City']))?$Users['City']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    State
                                                    </td>
                                                    <td>
                                                    <input type="text" name="State"  class="text" value="<?php echo (isset($Users['State']))?$Users['State']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    Zip
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Zip"  class="text" value="<?php echo (isset($Users['Zip']))?$Users['Zip']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Telephone
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Telephone"  class="text" value="<?php echo (isset($Users['Telephone']))?$Users['Telephone']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                   
                                                     <tr>
                                                    <td>
                                                    EBill
                                                    </td>
                                                    <td>
                                                    <input type="text" name="EBill"  class="text" value="<?php echo (isset($Users['EBill']))?$Users['EBill']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                      <tr>
                                                    <td>
                                                    Bonus
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Bonus"  class="text" value="<?php echo (isset($Users['Bonus']))?$Users['Bonus']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                     <tr>
                                                    <td>
                                                    Discount
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Discount"  class="text" value="<?php echo (isset($Users['Discount']))?$Users['Discount']:''; ?>"/>
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
                            <?php echo $link_back; ?>
						</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
		<?php include("application/views/pages/template/ToggleButScript.php"); ?>

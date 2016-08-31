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
                                                    ID
                                                    </td>
                                                    <td>
                                                    <input type="text" name="ID" required class="text" value="<?php echo (isset($Users['ID']))?$Users['ID']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td width="30%">
                                                    FTP Address
                                                    </td>
                                                    <td>
                                                    <input type="text" name="FTPAddress"  required class="text" value="<?php echo (isset($Users['FTPAddress']))?$Users['FTPAddress']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Operator
                                                    </td>
                                                    <td>
                                                    <input type="text" name="ShortName"  required class="text" value="<?php echo (isset($Users['ShortName']))?$Users['ShortName']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                     <tr>
                                                    <td>
                                                    Address 1
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Address1"  required class="text" value="<?php echo (isset($Users['Address1']))?$Users['Address1']:''; ?>"/>
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
                                                    <input type="text" name="City"  required class="text" value="<?php echo (isset($Users['City']))?$Users['City']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    State
                                                    </td>
                                                    <td>
                                                    <input type="text" name="State"  required class="text" value="<?php echo (isset($Users['State']))?$Users['State']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    Zip
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Zip"  required class="text" value="<?php echo (isset($Users['Zip']))?$Users['Zip']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Country
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Country"  required class="text" value="<?php echo (isset($Users['Country']))?$Users['Country']:''; ?>"/>
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
		<?php include("application/views/pages/template/ToggleButScript.php"); ?>

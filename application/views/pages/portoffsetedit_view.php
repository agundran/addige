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
                                                    Offset
                                                    </td>
                                                    <td>
                                                    <input type="text" name="PortOffset" required class="text" value="<?php echo (isset($Users['PortOffset']))?$Users['PortOffset']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td width="30%">
                                                    Site Name
                                                    </td>
                                                    <td>
                                                    <input type="text" name="ShortName"  required class="text" value="<?php echo (isset($Users['ShortName']))?$Users['ShortName']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    SSID
                                                    </td>
                                                    <td>
                                                    <input type="text" name="SSID"  required class="text" value="<?php echo (isset($Users['SSID']))?$Users['SSID']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                    
                                                                   
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><input type="submit"  class="btn btn-primary btn-lg active" value="Save"/></td>
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
		

 <style type="text/css">
	
		
		#Bonus, #EBill
		{
			font-weight:bolder;
		}
	
		.State {
    				text-transform: uppercase;
				}

   
    </style>  



<script>

window.onunload = function(){
  window.opener.location.reload();
};

window.onload = function(){
	window.opener.blur();
}

</script>


<div id="page-content-wrapper">
   <div class="container-fluid">
        <div class="row">
             <div class="col-lg-12">
                    
                 <div id="container">    
						<div class="content"> 
                          	<h3>UPDATE CUSTOMER</h3>
                            <p style="font-size:16px">Customer Name: <a style="color: #00F" style="font-weight:bold"> <?php echo $title; ?></a></p>
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
                                                    Customer
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Name" style="font-weight:bolder"  required class="text" value="<?php echo (isset($Users['Name']))?$Users['Name']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Address 1
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Address1"  style="font-weight:bolder" value="<?php echo (isset($Users['Address1']))?$Users['Address1']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                     <tr>
                                                    <td>
                                                    Address 2
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Address2" style="font-weight:bolder"  value="<?php echo (isset($Users['Address2']))?$Users['Address2']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                       <tr>
                                                    <td>
                                                    City
                                                    </td>
                                                    <td>
                                                    <input type="text" name="City" style="font-weight:bolder" class="text" value="<?php echo (isset($Users['City']))?$Users['City']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    State
                                                    </td>
                                                    <td>
                                                    <input type="text" name="State" style="font-weight:bolder"  value="<?php echo (isset($Users['State']))?$Users['State']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    Zip
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Zip" style="font-weight:bolder" value="<?php echo (isset($Users['Zip']))?$Users['Zip']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    Telephone
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Telephone"  style="font-weight:bolder" value="<?php echo (isset($Users['Telephone']))?$Users['Telephone']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Discount
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Discount" style="font-weight:bolder"  value="<?php echo (isset($Users['Discount']))?$Users['Discount']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                   
                                                     <tr>
                                                    <td>
                                                    EBill
                                                    </td>
                                                   	<td>
                                                     <?php
         $optionebill = array(
                  'True'  => 'Yes',
				  'False'  => 'No',
                  
				  
				  
				  
                );

	
		 // $js = 'id="Ebill"'; 
		  $ebillfetch =  $Users['EBill'];
		echo form_dropdown('EBill', $optionebill, $ebillfetch, 'class="EBill" id="EBill"');
                      
					  
					                                
                                                    ?>
                                                    
                                                    </td> 
                                                    </tr>
                                                    
                                                    
                                                       <tr>
                                                    <td>
                                                    Bonus Only
                                                    </td>
                                                    <td>
                                                                                              <?php
         $optionebonus = array(
                  'True'  => 'Yes',
				  'False'  => 'No',
                  
				  
				  
				  
                );

	
		//  $js = 'id="Bonus"'; 
		 $ebillbonus =  $Users['Bonus'];
		echo form_dropdown('Bonus', $optionebonus,  $ebillbonus, 'class="Bonus" id="Bonus"');
                                                    
                                                    ?>
                                                    
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

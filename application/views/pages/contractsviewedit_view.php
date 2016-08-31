<script>

window.onunload = function(){
  window.opener.location.reload();
};
</script>

 <?php
 
 $ag = array(
								'name'        => 'ag',
								'id'          => 'ag',
								'value'       => '1',
								'checked'     => FALSE,
								 
								'style'       => 'margin:0px',
								'onclick'     => "OnChangeCheckbox(this)"
								);

$pi = array(
			'name'        => 'pi',
			'id'          => 'pi',
			'value'       => '1',
			'checked'     => FALSE,
			'style'       => 'margin:0px',
			);
								
								
$pending = array(
			'name'        => 'pending',
			'id'          => 'pending',
			'value'       => '1',
			'checked'     => FALSE,
			'style'       => 'margin:0px',
			);
								
$prepaid = array(
			'name'        => 'prepaid',
			'id'          => 'prepaid',
			'value'       => '1',
			'checked'     => FALSE,
			'style'       => 'margin:0px',
			);
								
$filler = array(
			'name'        => 'filler',
			'id'          => 'filler',
			'value'       => '1',
			'checked'     => FALSE,
			'style'       => 'margin:0px',
			);
								
$coop = array(
			'name'        => 'coop',
			'id'          => 'coop',
			'value'       => '1',
			'checked'     => FALSE,
			'style'       => 'margin:0px',
			);
								
$eof = array(
			'name'        => 'eof',
			'id'          => 'eof',
			'value'       => '1',
			'checked'     => FALSE,
			'style'       => 'margin:0px',
			);
								
$amg = array(
			'name'        => 'amg',
			'id'          => 'amg',
			'value'       => '1',
			'checked'     => FALSE,
			'style'       => 'margin:0px',
								); 
							
	

$attrib = $Users['Attributes'];

	if(($attrib & 256) > 0) ///Agency Checkbox
		
 							 $ag = array(
								'name'        => 'ag',
								'id'          => 'ag',
								'value'       => '1',
								'checked'     => TRUE,
								 
								'style'       => 'margin:0px',
								'onclick'     => "OnChangeCheckbox(this)"
								);
					
		
				
							
							
								
	else	
								 $ag = array(
								'name'        => 'ag',
								'id'          => 'ag',
								'value'       => '1',
								'checked'     => FALSE,
								 
								'style'       => 'margin:0px',
								//'onclick'     => "OnChangeCheckbox(this)"
								);
								//$attrib >>= 1;
	if(($attrib & 64) > 0) //Prepaid Checkbox
								$prepaid = array(
								'name'        => 'prepaid',
								'id'          => 'prepaid',
								'value'       => '1',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
	else	
								$prepaid = array(
								'name'        => 'prepaid',
								'id'          => 'prepaid',
								'value'       => '1',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								//$attrib >>= 1;
	if(($attrib & 32) > 0)  //AMG Checkbox
								$amg = array(
								'name'        => 'amg',
								'id'          => 'amg',
								'value'       => '1',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								); 

	else	
								$amg = array(
								'name'        => 'amg',
								'id'          => 'amg',
								'value'       => '1',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								); 
								//$attrib >>= 1;
	if(($attrib & 16) > 0) //COOP Checkbox
								$coop = array(
								'name'        => 'coop',
								'id'          => 'coop',
								'value'       => '1',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
	else	
								$coop = array(
								'name'        => 'coop',
								'id'          => 'coop',
								'value'       => '1',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								//$attrib >>= 1;
	if(($attrib & 8) > 0) //EOF Checkbox
								$eof = array(
								'name'        => 'eof',
								'id'          => 'eof',
								'value'       => '1',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
	else
								$eof = array(
								'name'        => 'eof',
								'id'          => 'eof',
								'value'       => '1',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
	if(($attrib & 4) > 0) //PENDING Checkbox
								$pending = array(
								'name'        => 'pending',
								'id'          => 'pending',
								'value'       => '1',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
	else
								$pending = array(
								'name'        => 'pending',
								'id'          => 'pending',
								'value'       => '1',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
	if(($attrib & 2) > 0) //FILLER Checkbox
								$filler = array(
								'name'        => 'filler',
								'id'          => 'filler',
								'value'       => '1',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
	else
								$filler = array(
								'name'        => 'filler',
								'id'          => 'filler',
								'value'       => '1',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
	

		if(($attrib & 1) > 0) //PI Checkbox
								$pi = array(
			'name'        => 'pi',
			'id'          => 'pi',
			'value'       => '1',
			'checked'     => TRUE,
			'style'       => 'margin:0px',
			);
	else
								$pi = array(
			'name'        => 'pi',
			'id'          => 'pi',
			'value'       => '1',
			'checked'     => FALSE,
			'style'       => 'margin:0px',
			);
?>
                                

<style type="text/css">
	

	#CalendarType, #ClientType, #AIndex, #SIndex, #CIndex
		{
			font-weight:bolder;
		}
	
   
    </style>                                 
                                
	   
 <!-- Page Content -->
 

    <script type="text/javascript">
        function OnChangeCheckbox (checkbox) {
            if (checkbox.checked) {
               // alert ("The check box is checked.");
			   
			   
			   
			   document.getElementById("AIndex").style.visibility= "visible";
			   document.getElementById("AgencyComm").style.visibility= "visible";
			   
            }
            else {
               document.getElementById("AIndex").style.visibility= "hidden";
			   document.getElementById("AgencyComm").style.visibility= "hidden";
			   
            }
        }
		
	document.getElementById("CIndex").selectedIndex = -1;	
    </script>
    

   <script type="text/javascript"  
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.  
            min.js"></script>  
          
          
          
            <script type="text/javascript"  
               src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquer  
               y-ui.min.js"></script>  
               <script type="text/javascript">   
        
        
            $(document).ready(function() { 
		        $("#CIndex").change(function(){
            		var mydata = $(this).val();
					var post_url = "<?php echo base_url(); ?>index.php/orderentry/get_discount/"+ mydata;
                   
					
					$.ajax({
                   		url:post_url,
						type: "POST",
						dataType:'json',
                		data: mydata,
					  	success: function(result){
                  			$("#Discount").val(result);},
        				error: function(result ) {
						     alert(result);	}
                    
                    });
                });
	     }).change();
		 
		 
		 $(document).ready(function() { 
		        $("#AIndex").change(function(){
            		var agencydata = $(this).val();
					var post_url = "<?php echo base_url(); ?>index.php/orderentry/get_agencyrate/"+ agencydata;
                   
					
					$.ajax({
                   		url:post_url,
						type: "POST",
						dataType:'json',
                		data: agencydata ,
					  	success: function(result1){
                  			$("#AgencyComm").val(result1);},
        				error: function(result1 ) {
						     alert(result1);	}
                    
                    });
                });
	     }).change();
		 
		 
		  $(document).ready(function() { 
		        $("#SIndex").change(function(){
            		var salesdata = $(this).val();
					var post_url = "<?php echo base_url(); ?>index.php/orderentry/get_salesmanrate/"+ salesdata;
                   
					
					$.ajax({
                   		url:post_url,
						type: "POST",
						dataType:'json',
                		data: salesdata ,
					  	success: function(result2){
                  			$("#SalesComm").val(result2);},
        				error: function(result2 ) {
						     alert(result2);	}
                    
                    });
                });
	     }).change();
		 
            
  </script>
  
  
  
      
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                      <div id="container">
   						<div class="content">
                            <div class="container">

							<div class="main">
		<center>
        <h3><?php echo $title; ?></h3>
 
		</center>
	
		<?php echo validation_errors(); ?>
		<?php echo form_open($action); ?>
		<div class="data">
		<table>
		  <tr>
          <th>Contract Header Record</th> 
          <th></th>
          </tr>
          <tr>
          <td> Customer </td>
          <td>    
       
            <?php $seq_customer_name = $this->contractsviewmodel->get_customer();
			    $selectmycustomer = array(
							'blank'=> '',
							$seq_customer_name);?> 
			
			<?php $seq_customer = $Users['CIndex'];?> 
			<?php echo form_dropdown('CIndex', $selectmycustomer,$seq_customer,' class="CIndex" id="CIndex" ' ); ?>  
            
            
            
            
            
           
            
            
             
           
            
          </td>
          </tr><tr>  
          <td>Contract Name </td> 
          <td>
            <input type="text" name="ContractName" style=" font-weight:bolder"      class="text" value="<?php echo (isset($Users['ContractName']))?$Users['ContractName']:''; ?>"/>  &nbsp;  
          </td> 
          </tr>
          
          
          
          <tr>  
          	<td>
            Calendar Type
		  	<td>
        <?php
         
		 $options = array(
                  1   => 'Broadcast',
                  0   => 'Monthly',
                  
				  
                );
				
		$spotl =  $Users['billing_type'];		
		echo form_dropdown('billing_type', $options, $spotl, 'class="CalendarType" id="CalendarType"');
        ?> 
          </td> 
          </tr>

          
          
          
          
          
          
          
          
          <tr> 
          <td> Start Date </td>
		  <td>
           <input type="text" id="StartDate" name="StartDate" style=" font-weight:bolder" placeholder="Choose Date"value="<?php echo (isset($Users['StartDate']))?$Users['StartDate']:''; ?>"/>
             
          <script src="<?php echo base_url();?>js/jquery-ui.js"></script>
		    </td> 
            </tr><tr> 
            <td> End Date</td>
			<td>
           <input type="text" id="EndDate" name="EndDate" style=" font-weight:bolder" placeholder="Choose Date" value="<?php echo (isset($Users['EndDate']))?$Users['EndDate']:''; ?>"/>
        
               
  <script>
  $(function() {
    $( "#StartDate" ).datepicker({
      dateFormat: "yy-mm-dd",
	  defaultDate: null,
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#EndDate" ).datepicker({
	  dateFormat: "yy-mm-dd",	
      defaultDate: "+1m",
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  </script>
               
            </td> 
            </tr>
            
             <tr><td>
            Client Type
            </td>
             <td>
         	<?php
         
		 $options = array(
                  'Null'   => 'National',
                  'Regional'   => 'Regional',
				  'Local'   => 'Local',
				  'Promo'   => 'Promo',
                  
				  
                );
				
		$spotl =  $Users['client_type'];		
		echo form_dropdown('client_type', $options, $spotl, 'class="ClientType" id="ClientType"');
        ?>
         
         
         
         
              </td>
        </tr>
            
            
            
            <tr>
            <td>Customer Order </td>
			<td><input type="text" name="CustOrder" style=" font-weight:bolder"    class="text" value="<?php echo (isset($Users['CustOrder']))?$Users['CustOrder']:''; ?>"/>
            </td> 
            </tr>
            <tr>
            <td>Estimate Code</td>
			<td><input type="text" name="EstCode" style=" font-weight:bolder"    class="text" value="<?php echo (isset($Users['est']))?$Users['est']:''; ?>"/>
            </td> 
            </tr>
            <tr> 
            <td> Discount </td>       
        	<td>
           <input type="text" name="Discount" id="Discount" style=" font-weight:bolder" value="<?php echo (isset($Users['Discount']))?$Users['Discount']:'';?>" />
           
            </td> 
            </tr><tr>
               </td> </tr>
			<tr><td> Agency
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo form_checkbox($ag); 
                               echo form_label('', 'ag');
								?>
                                
                             
            </td>
         	<td>
			
            <?php $agency = $this->contractsviewmodel->get_agency(); ?>
                <?php $valueagency =  $Users['AIndex'];                     
               echo form_dropdown('AIndex', $agency ,$valueagency,'class="AIndex" id="AIndex"');?> 
               
           
			
	         
            
            </td>
            </tr><tr>
            <td>Rate</td>
            <td>
            
            
            <input type="text" name="AgencyComm"  id="AgencyComm" style=" font-weight:bolder" style="visibility:hidden" class="AgencyComm" value="<?php echo (isset($Users['AgencyComm']))?$Users['AgencyComm']:''; ?>"/>
            </td> 
            </tr><tr>
 			<td> Salesman</td>
			<td> 
			
            <?php $salesman = $this->contractsviewmodel->get_salesman();
			  
			?>
                
                 <?php  
				$valueasi =  $Users['SIndex'];
				echo form_dropdown('SIndex', $salesman,$valueasi,'class="SIndex" id="SIndex"'); 
				?> 
           
			
			</td>
            </tr><tr>
            <td>Rate </td>
			<td><input type="text" name="SalesComm" style=" font-weight:bolder" class="SalesComm"  id="SalesComm"  value="<?php 
					echo (isset($Users['SalesComm']))?$Users['SalesComm']:''; 
			?>"/>
            </td> 
            </tr><tr> 
            <td>Min Separation</td>
            <td><input type="text" name="Minseparation" style=" font-weight:bolder"  class="text" value="<?php echo (isset($Users['MinSeparation']))?$Users['MinSeparation']:''; ?>"/>
            </td>
            </tr><tr>
           <td>Revision</td>
            <td><input type="text" name="Revision"  style=" font-weight:bolder" class="text" value="<?php echo (isset($Users['Revision']))?$Users['Revision']:''; ?>"/>
            </td>
            </tr>
           
            <tr>
            <td><input type="text" name="Attributes" hidden   class="text" value="<?php echo (isset($Users['Attributes']))?$Users['Attributes']:''; ?>"/>
             </td >
            <td></td>
             </tr>
             <tr>
            <td>Attributes</td>
            <td>				<?php 
			
								echo form_checkbox($pi); 
                               echo form_label('PI', 'pi');
								?>
                                <?php echo form_checkbox($pending); 
                                echo form_label('Pending', 'pending');
								?>
                                
								<?php echo form_checkbox($prepaid); 
                                echo form_label('Prepaid', 'prepaid');
								?>
                                <?php echo form_checkbox($filler); 
                                echo form_label('Filler', 'filler');
								?>
                                <br />
                                
                              	<?php echo form_checkbox($coop); 
                                echo form_label('COOP', 'coop');
								?>
                                <?php echo form_checkbox($eof); 
                                echo form_label('EOF', 'eof');
								?>
                                
                                <?php echo form_checkbox($amg); 
                                echo form_label('AMG', 'amg');
								?>
                                
          		</td>
            </tr>  
            
           <tr><td>&nbsp;</td>
				<!--<td><input type="submit" class="btn btn-primary btn-lg active" value="Save" onclick="javascript: closepopup()"/></td>-->
                <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" /></td>
			</tr>
           
            
		</table>
		</div>

	
   
		<br />
       
        <br />
        
        
			</div>
						
                        
                        
                        
                        
                        <?php echo form_close(); ?>
						<?php echo validation_errors('<p class="error">'); ?>  
                        <br  />
                        </div>
                    </div>
                </div>
            </div>
        </div>
           </div>
        </div>
    <!-- /#page-content-wrapper -->
	



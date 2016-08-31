<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();

</script>
<style type="text/css" >

#checklabel { font-family:Verdana, Geneva, sans-serif;  
 
	 
	} 
</style>


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
								'style'       => 'display: none',
								
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
								'style'       => 'display: none',
								); 
								
								?>
                                
                                
                                <style type="text/css">
	

	#CalendarType, #ClientType, #AIndex, #SIndex, #CIndex, #siteops
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
			   document.getElementById("agencyrate").style.visibility= "visible";
			   
            }
            else {
               document.getElementById("AIndex").style.visibility= "hidden";
			   document.getElementById("agencyrate").style.visibility= "hidden";
			   
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
                  			$("#discount").val(result);},
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
                  			$("#agencyrate").val(result1);},
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
                  			$("#salesmanrate").val(result2);},
        				error: function(result2 ) {
						     alert(result2);	}
                    
                    });
                });
	     }).change();
		 
            
  </script>
  
  
  
      
        
        <div id="container">
   					
		<center>
        <h3><?php echo $title; ?></h3>
        <h4><?php echo $subtitle; ?></h4>
		</center>
		<?php echo $message; ?>
		<?php echo validation_errors(); ?>
		<?php echo form_open($action); ?>
		<div class="data">
		<table>
		  <tr><th>
          Contract Header Records
          </th><th>
          </th>
          </tr>
          <tr><td>
             Customer &nbsp;&nbsp;&nbsp; 
            
        	<?php echo $link_addcust;?>
		  </td><td>    
            <?php $seq_customer_name = $this->orderentrymodel->get_customer();
			    $selectmycustomer = array(
							'blank'=> '',
							$seq_customer_name
						
							);
			 
			?> 
			
			<?php $seq_customer = $Users['CIndex'];?> 
			  
              
			<?php echo form_dropdown('CIndex', $selectmycustomer,'',' class="CIndex" id="CIndex" ' ); ?>  
            
             
           
                     
          </td> </tr>
          <tr>  
          	<td>
            Contract &nbsp;&nbsp;&nbsp; Name
		  	<td>
            <input type="text" name="ContractName"  style="font-weight:bolder" style="text-transform:uppercase"    class="text" value="<?php echo (isset($Users['ContractName']))?$Users['ContractName']:''; ?>"/>  &nbsp;  
          </td> 
          </tr>
		
    	<tr>  
          	<td>
            Calendar Type
		  	<td>
            <?php
         $optionCalendar = array(
				  '1'  => 'Broadcast',
                  '0'  => 'Monthly',
				  
				  
				  
                );

	
		  $js = 'id="CalendarType"'; 
		echo form_dropdown('CalendarType', $optionCalendar, '', $js);
        ?>  &nbsp;  
          </td> 
          </tr>

    
    
    
    
    
    
    
              
          <tr> 
          <td> Start Date </td>
		  <td>
           
           
           <input type="text" id="StartDate"  style="font-weight:bolder" name="StartDate" placeholder="Choose Date">
            <!-- This is an original dropdown Start Date -->
             <?php //$startdate = $this->orderentrymodel->get_startdate();?>
             <?php //echo form_dropdown('StartDate', $startdate,'','class="StartDate" id="StartDate"'); ?> 
          
		  
		  
		  <script src="<?php echo base_url();?>js/jquery-ui.js"></script>
		
            </td> </tr>
			<tr> <td> End Date</td>
			<td>
           
           <input type="text" id="EndDate"  style="font-weight:bolder" name="EndDate" placeholder="Choose Date" >
           
           <!-- This is an original dropdown End Date -->
           
		  <?php //$enddate = $this->orderentrymodel->get_enddate();?>
             <?php //echo form_dropdown('EndDate', $enddate ,'','class="EndDate" id="EndDate"'); ?> 
          
               
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
               
            </td> </tr>
            
            
             <tr><td>
            Client Type
            </td>
             <td>
         <?php
         $optionclient = array(
                  'Null'  => 'National',
				  'Regional'  => 'Regional',
                  'Local'  => 'Local',
				  'Promo'  => 'Promo',
				  
				  
				  
				  
                );

	
		  $js = 'id="ClientType"'; 
		echo form_dropdown('ClientType', $optionclient, '', $js);
        ?>     </td>
        </tr>
            
            <tr><td>Customer Order </td>
			<td><input type="text" name="CustOrder"  style="font-weight:bolder" required="required"     class="text" value="<?php echo (isset($Users['CustOrder']))?$Users['CustOrder']:''; ?>"/>
            </td> </tr>
            
               <tr><td>Estimate Code </td>
			<td><input type="text" name="EstCode"  style="font-weight:bolder" required="required"     class="text" value="<?php echo (isset($Users['EstCode']))?$Users['EstCode']:''; ?>"/>
            </td> </tr>
            
		  	<tr> <td>  Discount &nbsp;&nbsp;&nbsp; 
			
            </td>
        
        	<td>
           
            <div id="discounttext"> 
            <input type="text" name="discount"  style="font-weight:bolder"   id="discount"  class="discount" value="
			
			<?php //echo (isset($Users['Discount']))?$Users['Discount']:''; ?>"/>
            
            
            
            
            
            </div>
            </td> </tr>
			<tr><td> Agency
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo form_checkbox($ag); 
                               echo form_label('', 'ag');
								?>
                                
                             
            </td>
         	<td><?php $agency = $this->orderentrymodel->get_agency(); 
			 $selectmyagency = array(
							'blank'=> '',
							$agency
						
							);
			
			?>
                <?php //$valueagency =  $Users['agencies'];                     
               echo form_dropdown('AIndex', $selectmyagency,'','class="AIndex" id="AIndex" style="visibility:hidden"');?> 
            </td></tr>
            <td>
            Rate
            
            
            </select>
            &nbsp;&nbsp;&nbsp; 
            <?php echo $link_addagency;?>
            </td>
            <td><input type="text" name="agencyrate"   style="font-weight:bolder" id="agencyrate" style="visibility:hidden"    class="agencyrate" value="<?php echo (isset($Users['Rate']))?$Users['Rate']:''; ?>"/></td> 
            </tr><tr>
 			<td> Salesman</td>
			<td> <?php $salesman = $this->orderentrymodel->get_salesman();
			  
			   $selectmysalesman = array(
							'blank'=> '',
							$salesman
						
							);
			?>
                
                 <?php  
				
				echo form_dropdown('SIndex', $selectmysalesman,'','class="SIndex" id="SIndex"'); 
				?> 
            </td>  </tr> 
            <tr><td>
            Salesman Rate &nbsp;&nbsp;&nbsp;<?php echo $link_addsalesman;?>  </td>
			<td><input type="text" name="salesmanrate"   style="font-weight:bolder"   class="salesmanrate"  id="salesmanrate"  value="<?php echo (isset($Users['SalesComm']))?$Users['SalesComm']:''; ?>"/>
            
            </td> </tr> 
            <tr> <td>
            Min Separation
            </td><td><input type="text" name="Minseparation"    style="font-weight:bolder"  class="text" value="<?php echo (isset($Users['MinSeparation']))?$Users['MinSeparation']:''; ?>"/>
            </td> </tr> 
           <tr><td>
             Revision
            </td><td><input type="text" name="Revision"   style="font-weight:bolder"   class="text" value="<?php echo (isset($Users['Revision']))?$Users['Revision']:''; ?>"/>
           
           
			</tr>
            <div id="checklabel">
             <tr>
            <td>Attributes</td>
            <td>				<?php echo form_checkbox($pi); 
                               echo form_label('', 'pi');
								?>
                                <?php echo form_checkbox($pending); 
                                echo form_label('', 'pending');
								?>&nbsp; Pending&nbsp;
                                
								<?php echo form_checkbox($prepaid); 
                                echo form_label('', 'prepaid');
								?>&nbsp;Prepaid&nbsp;
                                <?php echo form_checkbox($filler); 
                                echo form_label('', 'filler');
								?>&nbsp;Filler&nbsp;
                                
                                
                              	<?php echo form_checkbox($coop); 
                                echo form_label('', 'coop');
								?>&nbsp;COOP&nbsp;
                                <?php echo form_checkbox($eof); 
                                echo form_label('', 'eof');
								?>&nbsp;EOF&nbsp;
                                
                                <?php echo form_checkbox($amg); 
                                echo form_label('', 'amg');
								?>
                                
          		</td>
            </tr>  
            </div>
            <tr>
            <td>
            SysCode<br />
            (Use CTRL + mouse left <br />
            click for multiple selection)
            </td>
			
            <td>
            <?php $site_operator= $this->orderentrymodel->get_site();
			
			
			
			?>           				
           
		    
        
		   <?php
		    
		    echo form_multiselect('siteoperator[ ]',$site_operator,'','class="siteops" id="siteops"'); 
			
			
			?>
            
            
           
            
            
            
            
            
          
          </td> 
            
          </tr>
           <tr>
           <td>
          
           </td>
           
           <td> Choose Network
           
           </td>
           </tr>
           
           
           
           <tr><td>&nbsp;</td>
				<td><input type="submit" class="btn btn-primary btn-lg active" value="Save"/></td>
			</tr>
           
            
		</table>
		</div>

	
   
		<br />
       
        <br />
        
        
			</div>
						
                        
                        
                        
                        
                        <?php echo form_close(); ?>
						<?php echo validation_errors('<p class="error">'); ?>  
                        <br  />
            
    <!-- /#page-content-wrapper -->
	



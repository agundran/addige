<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #legacy').addClass('open');
$('#Billing, #legacy').children('ul').slideDown();

</script>

  <div id="container">
		<center>
        <h4>Create Invoices / Logs </h4>
         <h5>Generate by Customer & SiteCode </h5>
		</center>
		
	   
         <table>	
	 	   <tr><td><td> </tr>
           <tr>
           <td>(1) Set Billing Month   <?php echo $setbm; ?>  </td>     
            <td></td>
           
           </table>
      
       
        <center>
        <H4><?php echo $title1; ?>
        </H4>
        </center>
        
           <table>	
	 	   <tr><td><td> </tr>
           <tr>
           <td>(2) Choose Customer  : <b><?php echo $custcode,' - ', $custname; ?></b> </td>     
           
		   <?php $cust= $this->legacysetcustomer1model->get_customer();
			$so= array(		'blank'=> '',
						     
							'' => $cust
						);  ?>           				
 		  <td> 
		  <?php echo form_open($action); ?>
		  
		  <?php
		  $jc = 'id="custcode"  required="required"';?>
		  
		  
		  (Change) <?php echo form_dropdown('custcode',$so,'',$jc); ?>
          <?php //echo form_dropdown('syscode',$so); ?>
          
          </td>
          
          <tr>
           <td>(3) Set SysCode / SiteName  : <b><?php echo $syscode,' - ',$sysname;  ?></b> </td>     
           
		   <?php $site_operator= $this->legacysetcustomer1model->get_site();
			$so= array(		'blank'=> '',
							"All Sites"=> 'All Sites',
							'' => $site_operator
						);  ?>           				
 		  
          <td> 
          
           
		  
		  <?php
		  $js = 'id="syscode" onChange="this.form.submit();" required="required"';?>
		  
		  
		  (Change) <?php echo form_dropdown('syscode',$so,'',$js); ?>
           <?php echo form_close(); ?>
          </td>
          
          </tr>
           </tr>
           
          </table>
          
          <br />
          <br />
          
          <center>
          <font  face="glyphicon" size="+2">
           <?php echo $createinvoice; ?>
          </font>
           </center>
  
       
      	</div>
    
   	
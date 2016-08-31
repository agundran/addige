<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #legacy').addClass('open');
$('#Billing, #legacy').children('ul').slideDown();

</script>

  <div id="container">
		<center>
        <h4>Create Invoices / Logs </h4>
         <h5>Generate by Customer </h5>
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
           
		   <?php $cust= $this->legacysetcustomermodel->get_customer();
			$so= array(		'blank'=> '',
							
							'' => $cust
						);  ?>           				
 		  <td> 
		  <?php echo form_open($action); ?>
		  
		  <?php
		  $js = 'id="custcode" onChange="this.form.submit();" required="required"';?>
		  
		  
		  (Change) <?php echo form_dropdown('custcode',$so,'',$js); ?>
          <?php //echo form_dropdown('syscode',$so); ?>
          
          
           <?php echo form_close(); ?>
          </td>
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
    
   	
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #legacy').addClass('open');
$('#Billing, #legacy').children('ul').slideDown();

</script>

  <div id="container">
		<center>
        <h4>Choose Option for Billing Type</h4>
		</center>
		
	   
         <table>	
	 	   <tr><td><td> </tr>
           <tr>
           <td>(1) Set Billing <?php echo $setbm; ?>  </td>     
            <td></td>
           
           </table>
      
       
        <center>
        <H4><?php echo $title1; ?>
        </H4>
        </center>
        
           <table>	
	 	   <tr><td><td> </tr>
           <tr>
           <td>(2) Choose Customer  : <b><?php echo $syscode; ?></b> </td>     
           
		   <?php $cust= $this->generatebillingbycustmodel->get_customer();
			$so= array(		'blank'=> '',
							"'[0-9_]%'"=> 'Customers',
							'' => $cust
						);  ?>           				
 		  <td> 
		  <?php echo form_open($action); ?>
		  
		  <?php
		  $js = 'id="syscode" onChange="this.form.submit();" required="required"';?>
		  
		  
		  (Change) <?php echo form_dropdown('syscode',$so,'',$js); ?>
          <?php //echo form_dropdown('syscode',$so); ?>
          
          
           <?php echo form_close(); ?>
          </td>
           </tr>
           
          </table>
          
          <br />
          <br />
          
          <center>
          <font  face="glyphicon" size="+2">
           <?php echo $generatebill; ?>
          </font>
           </center>
  
       
      	</div>
    
   	
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #legacy').addClass('open');
$('#Billing, #legacy').children('ul').slideDown();
</script>

  <div id="container">
		<center>
        <h3><?php echo $title; ?></h3>
		<h4><?php echo $title2; ?></h4>
     
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
           <td>(2) Generate Billing Summary   </td>     
           
		         				
 		  <td> 
		  
          <font  face="glyphicon" size="+2">
           <?php echo $createinvoice; ?>
          </font>
           
          </td>
           </tr>
           
          </table>
          
          <br />
          <br />
          
          
  
       
      	</div>
    
   	
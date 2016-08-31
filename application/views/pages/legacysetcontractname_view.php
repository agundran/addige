<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #legacy').addClass('open');
$('#Billing, #legacy').children('ul').slideDown();

</script>


<body>
  <div id="container">
		<center>
        <h4>Create Invoices  / Logs</h4>
        <h5>Generate by Contract Name</h5>
		</center>
		
	<div class="row">
   
   		<div class="col-md-7">
        <div class="search">   
         <table>	
	 	   <tr><td><td> </tr>
           <tr>
           <td>(1) Set Billing Month   <?php echo $setbm; ?>  </td>     
            <td></td>
           
           </table>
      
       <fieldset>
		
		<form name='search' action=<?=site_url('legacysetcontractname/search');?> method='post'>
        <center>
        <H4><?php echo $title1; ?>
        </H4>
        </center>
        
           <table>	
	 	   <tr><td><td> </tr>
           <tr>
           <td>(2) <input name="cn" type='text' id="cn" placeholder="Enter Contract Name"  /> </td>     
           
		  		
 		  <td> 
		  <input type='submit' class="btn btn-primary btn-lg active" id='filter' name='' value='Search'>
          </td>
           </tr>
           
          </table>
     </form>
   
	</fieldset>     
          <br />
          <br />
          
          <center>
          
          
          
           </center>
  
       
        </div>
		
		<div class="paging"><?php echo $pagination; ?></div>

		<div class="data"><?php echo $table; ?></div>
        
		<div class="paging"><?php echo $pagination; ?></div>

		<br />
	
   		 </div>
    
      	</div>
    	</div>   	
</div>
   
</body>
</html>
   	
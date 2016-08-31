<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();




function myFunction() {
    var x = document.getElementById("chkclear").value;
    document.getElementById("demo").innerHTML = "You selected: " + x;
}


</script>





<body>
      
   
        
<div id="container">
    <center>
    
		<h4><?php echo $countpending; ?></h4>
     
		
        </center>
   <div class="row">
   
   		<div class="col-md-7">
        <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('pending/index');?> method='post'>
		<table>
			<tr>
           
				<th>Search Client</th>
				<th></th>	
                <th></th>	
                 				
			</tr>
			<tr>
			<td><input name="SiteName" type='text' id="SiteName" placeholder="Enter Contract Name"  /></td>					
				    
            <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                <input type='submit' class="btn btn-primary btn-lg active" id='filter' name='' value='Filter'>
                
                  <input type='submit' class="btn btn-primary btn-lg active" id='clearf' name='clearf' value='Clear Flag'>
                </td>
                
                <td>                 
                </td>
				<td>
				</td>
			</tr>
		</table>
        
        <br />
        <br />
       
		</form>
   
	</fieldset>
    
    </div>
		
       


		<p id="demo"></p>





        
		<div class="paging"><?php echo $pagination; ?></div>


		
	<div class="dataPending"><?php echo $table; ?></div>



		
        
        
        
        
		<div class="paging"><?php echo $pagination; ?></div>

		
      
		<br />
	
    </div>
   	</div>   	
</div>
   
</body>
</html>
		

    

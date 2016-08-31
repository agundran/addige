<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #Invoicing').addClass('open');
$('#Billing, #Invoicing').children('ul').slideDown();

</script>

    <div id="container">
		<center>
        <h4><?php echo $title; ?></h4>
		</center>
        
        <div class="search">
		<fieldset>
		
		<form name='search' action=<?=site_url('booking/index');?> method='post'>
		<table>
			<tr>
                     
				<th>Search Year</th>
				<th></th>	
                <th></th>	
                                				
						</tr>
			<tr>
				<td><input name="Year" type='text' id="Year" placeholder="Enter Year" /></td>					
				    
                               <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                <input type='submit' class="btn btn-primary btn-lg active"  id='filter' name='' value='Filter' style="">
                </td>
                
                <td></td>
			</tr>
		</table>
        
        
		</form>
	</fieldset>
        
        
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
       
        
       
        
        
      
		
         <br />
    	
    	</div>
    
   	
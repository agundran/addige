
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Admin, #SiteManagement').addClass('open');
$('#Admin, #SiteManagement').children('ul').slideDown();

</script>


<?php //echo $this->table->generate($records); ?>  

        <div id="container">
		
        <center>
		<h4><?php echo $title; ?></h4>
        </center>
        
        
         <fieldset>
		<form name='search' action=<?=site_url('portoffset/index');?> method='post'>
		<table>
			<tr>
      		<th>Search Site Name</th>
				<th></th>	
                <th></th>	
      		</tr>
			
            <tr>
			<td><input name="ShortName" type='text' id="ShortName" placeholder="Enter Site Name" /></td>					
				    
            <td>
            <input type='submit' class="btn btn-primary btn-lg active"  id='filter' name='' value='Filter' style="">
            </td>
			</tr>
		</table>
        
        
		</form>
	</fieldset>
        
        
		
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
		<br />
        
     
	
    	
   </div>
    
   	
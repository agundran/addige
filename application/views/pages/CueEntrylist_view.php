<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Admin, #Network').addClass('open');
$('#Admin, #Network').children('ul').slideDown();

</script>



    <?php //echo $this->table->generate($records); ?>
	
       
   		 <div id="container">
			 <h4><?php echo $message; ?></h4>
             <center>
            <h4>Network Table</h4>
    		</center>
            
            
            
              <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('CueEntrylist/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th>Search Network</th>
				<th></th>	
                <th></th>	
                
                				
						</tr>
			<tr>
				<td><input name="Description" type='text' id="Description"  placeholder="Enter Description"/></td>					
				    
                
               <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                <input type='submit' class="btn btn-primary btn-lg active"  id='filter' name='' value='Filter' style="">
                </td>
			</tr>
		</table>
        
        
		</form>
	</fieldset>
</div>
            
    
            
            <div class="paging"><?php echo $pagination; ?></div>
    			
            <div class="data"><?php echo $table; ?></div>
    
            <div class="paging"><?php echo $pagination; ?></div>
            
            
            
          
            <br />
            <?php echo $add_networklink; ?>
            
            
           
            
        	</div> 
    
           
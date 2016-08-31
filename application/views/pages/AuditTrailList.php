




<?php //echo $this->table->generate($records); ?>  

    <div id="container">
		<center>
        <h4>Audit Trail</h4>
		</center>
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
        <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('ControllerAuditTrail/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th>Search User</th>
				<th></th>	
                <th></th>	
                
                				
						</tr>
			<tr>
				<td><input name="Name" type='text' id="Name"  /></td>					
				    
                
               <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                <input type='submit' class="btn btn-primary btn-lg active" id='filter' name='' value='Filter'>
                </td>
			</tr>
		</table>
        
        
		</form>
	</fieldset>
</div>
        
        
        
        
        
        
         
            <?php echo $print_me; ?>
        	<br /><br /><br />
		 <br />
         <br />
    	<?php include("application/views/pages/template/ToggleBut.php"); ?>
    	</div>
    
   		<?php include("application/views/pages/template/ToggleButScript.php"); ?>
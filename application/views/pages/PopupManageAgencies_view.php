


<script>

window.onunload = function(){
  window.opener.location.reload();
};

window.onload = function(){
	window.opener.blur();
}

</script>

<?php //echo $this->table->generate($records); ?>  

    <div id="container">
		
        <h4>AdSystems Agencies</h4>
		
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
        <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('PopupManageAgencies/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th>Search Agency</th>
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
        
        
        
        
		<br />
		<?php echo anchor('TrafficManageAgencies/validate_add/','Add New Agency',array('class'=>'validate_add')); ?>
		 <br />
         <br />
   
    	</div>
    

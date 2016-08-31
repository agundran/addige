


<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageFiles').addClass('open');
$('#Traffic, #ManageFiles').children('ul').slideDown();

</script>

<?php //echo $this->table->generate($records); ?>  

    <div id="container">
		<center>
        <h3>AGENCIES</h3>
		</center>
        
        
         <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('TrafficManageAgencies/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th><label for="Search" class="fa fa-search">Search Agency</label></th>
				<th></th>	
                <th></th>	
                
                				
						</tr>
			<tr>
				<td><input name="Name" type='text' id="Name" placeholder="Enter Agency"  /></td>					
				    
                
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
        
        
        
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
       
        
        
        
        
		<br />
        
        
        
		<?php 
		  $attrib = array(
				
              'width'      => '0',
              'height'     => '0',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'   =>  '0',
    		  'screeny'   =>  '0',
            );
		 echo anchor_popup('TrafficManageAgencies/validate_add/', 'Add new Agency',array('class'=>'validate_add'), $attrib);
		
		?>
		 <br />
         <br />
    	
    	</div>
    
   
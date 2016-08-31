
    <?php //echo $this->table->generate($records); ?>
	
       
   		 <div id="container">

            <center>
			<h4><?php echo $title; ?></h4>
		
        		</center>
    
            <div class="paging"><?php echo $pagination; ?></div>
    
            <div class="data"><?php echo $table; ?></div>
    
            <div class="paging"><?php echo $pagination; ?></div>
    
    
    	<div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('manageuserlist/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th>Search Username</th>
				<th></th>	
                <th></th>	
                
                				
						</tr>
			<tr>
				<td><input name="ShortName" type='text' id="ShortName"  /></td>					
				    
                
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
    
            <?php echo anchor('manageuserlist/validate_add/','Add new user',array('class'=>'validate_add')); ?>
            
            <br />
            
            
            
            
            <br />
            
       		 
        	</div> 
    
          
<script>

//Nav Bar Collapse Open when click ManageUser & Operators
$('#Admin, #AdminManagement').addClass('open');
$('#Admin, #AdminManagement').children('ul').slideDown();


</script>

    <div id="container">
		<center>
        <h4>Operator Profiles</h4>
		</center>
        <fieldset>
		
		<form name='search' action=<?=site_url('manageoperatorlist/index');?> method='post'>
		<table>
			<tr>
                     
				<th>Search Operator</th>
				<th></th>	
                <th></th>	
                                				
						</tr>
			<tr>
				<td><input name="ShortName" type='text' id="ShortName" placeholder="Enter Operator Name"  /></td>					
				    
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
			  
			  
			 
        
    
		 
			  echo anchor_popup('manageoperatorlist/validate_add/', 'Add New Operator',array('class'=>'validate_add'), $attrib) ?>
		 <br />
         <br />
    	
    	</div>
    
   	
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #Reports').addClass('open');
$('#Traffic, #Reports').children('ul').slideDown();

</script>


 <div id="container">
		<center>
        <h4><?php echo $title; ?></h4>
		</center>
         <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('missingspots/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th></th>
				
                <th></th>	
                <th></th>	<th></th><th></th>
                
                				
						</tr>
			<tr>
					<td>
            <?php
         $optionCalendar = array(
				  ''  => ' - Please Select - ',
                  
				  '-1'  => 'Yesterday',
                  '-2'  => '2 Days Ago',
		    	  '-3'  => '3 Days Ago',
                  '-4'  => '4 Days Ago',
		          '-5'  => '5 Days Ago',
				 
				);

	
		  $js = 'id="CalendarType"'; 
		echo form_dropdown('CalendarType', $optionCalendar, '', $js);
        ?>  &nbsp;  
          
                <td> <input type='submit' class="btn btn-primary btn-lg active" id='filter' name='' value='go'></td>
               <td></td><td></td><td></td>
			</tr>
		</table>
        
        
		</form>
	</fieldset>
        
        
        
        <div class="paging"><?php //echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php //echo $pagination; ?></div>
       
        
       
        
        
      
		
         <br />
    	
    	</div>
    
   	
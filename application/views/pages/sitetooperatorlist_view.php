<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Admin, #SiteManagement').addClass('open');
$('#Admin, #SiteManagement').children('ul').slideDown();

</script>



  <script type="text/javascript"> 
  
   $(document).ready(function() { 
		        $("#mylimit").change(function(){
			
					var limitdata = $(this).val();
					var post_url = "<?php echo base_url(); ?>index.php/sitetooperator/index/"+ $this->sitetioperator->limit;
			  
			  $.ajax({
                   		url:post_url,
						type: "POST",
						dataType:'json',
                		data: limitdata ,
					  	success: function(result2){
                  			$("#mylimit").val(result2);},
        				error: function(result2 ) {
						     alert(result2);	}
                    
                    });
			  });
          
		  }).change();
						
					
		</script>			
<body>

     
    <?php //echo $this->table->generate($records); ?>
        
	
  
    <div id="container">
		<center>
		<h4>Operator Profiles</h4>
		</center>
        
        
        <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('sitetooperator/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th>Search Operator</th>
				<th></th>	
                <th></th>	
                
                				
						</tr>
			<tr>
				<td><input name="ShortName" type='text' id="ShortName" placeholder="Enter Site Name" /></td>					
				    
                
               <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                <input type='submit'class="btn btn-primary btn-lg active"  id='filter' name='' value='Filter'>
                </td>
                <td>
                </td>
			</tr>
            
            
		</table>
        
        
        <br />
        
      
        
		</form>
	</fieldset>
</div>
        
         <?php
         $options = array(
                  '10'   => '10 items per page',
                  '20'   => '20 items per page',
                  '50'   => '50 items per page',
                  'All'   => 'Show All Data'
				  
             );
			 
		//$startday =  $Users['StartDay'];	 
		echo form_dropdown('mylimit', $options, 10);
        ?>     
          <br />
        
		<div class="paging"><?php echo $pagination; ?></div>

		<div class="data"><?php echo $table; ?></div>

		<div class="paging"><?php echo $pagination; ?></div>

		<br />
	
    
		<?php echo $link_add ?>
         <br /><br /><br />
     
		</div>
    
    <div>
    <div>
    	
      
    </div>
    
  	
    
    
</body>
</html>
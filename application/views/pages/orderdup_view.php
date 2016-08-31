<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();

 $(document).ready(function() { 
		        $("#Range").change(function(){
            		var mydata = $(this).val();
					var post_url = "<?php echo base_url(); ?>index.php/manageuserlist/get_discount/"+ mydata;
                   
					
					$.ajax({
                   		url:post_url,
						type: "POST",
						dataType:'json',
                		data: mydata,
					  	success: function(result){
                  			$("#datas").val(result);},
        				error: function(result ) {
						     alert(result);	}
                    
                    });
                });
	     }).change();

   


</script>




   		 <div id="container">
        
	        <center>
			<h4><?php echo $title; ?></h4>
            <h6>Note: Select sitename to duplicate a contract</h6>
	   		</center>
            
            <div class="search">
			<fieldset>
			<form name='search' action=<?=site_url('orderdup');?> method='post'>
			<table>
			<tr>
        		<th>Search Sitename</th>
				<th></th>	
                <th></th>	
            </tr>
			<tr>
				<td><input name="ShortName" type='text' id="ShortName" class="ShortName" placeholder="Enter Username"  /></td>					
			   <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                <input type='submit' class="btn btn-primary btn-lg active"  id='filter' name='' value='Filter' style="">
                </td>
                
                <td>
                </td>
			</tr>
		</table>
        
		</form>
	</fieldset>
</div>
    		
           
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
      
    	
        
        
			
            
            
         
            
        
 
         
            
            
        	
           
    		
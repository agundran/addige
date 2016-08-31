<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Admin, #AdminManagement').addClass('open');
$('#Admin, #AdminManagement').children('ul').slideDown();

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
	   		</center>
            
            <div class="search">
			<fieldset>
			<form name='search' action=<?=site_url('manageuserlist');?> method='post'>
			<table>
			<tr>
        		<th>Search Username</th>
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
    	<!--	Show Entries:
                <form method="post" accept-charset="utf-8" action="<?php echo site_url("manageuserlist"); ?>">
    				<select name="hours" onchange="this.form.submit()">
        		<option value="5" selected="selected">Select</option>
                        <option value="5">5</option>
        				<option value="10">10</option>
        				<option value="15">15</option>
                        <option value="23">Show All</option>
    				</select>
			</form>-->
            <div class="paging"><?php echo $pagination; ?></div>
            <div class="data" id="datas"><?php echo $table; ?></div>
      
    
    	
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
			  
			  
			  
			  echo anchor('manageuserlist/validate_add/', 'Add new user',array('class'=>'validate_add')) ?>

            &nbsp;&nbsp;&nbsp;&nbsp;
            
            
            
            <?php echo $print_me; ?>
            
        
 
         
            
            
        	<br /><br /><br />
           
    		
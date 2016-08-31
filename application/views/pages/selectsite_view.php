<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
      
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();

</script>
        

       
<div id="container">
    <center>
		<h4><?php echo $title; ?></h4>
        <h5><?php echo 'Broadcast Calendar: '.$StartDate . ' to ' . $EndDate; ?></h5>
    </center>
    
    
    <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('selectsite/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th>Search Client</th>
				<th></th>	
                <th></th>	
                
                				
						</tr>
			<tr>
				<td><input name="SysCode" type='text' id="SysCode"   placeholder="Enter System Code" /></td>					
				    
                
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
    
        
    
   <div class="row">
   
   		<div class="col-md-7">
        
		<div class="paging"><?php echo $pagination; ?></div>

		<div class="data"><?php echo $table; ?></div>

		<div class="paging"><?php echo $pagination; ?></div>

		<br />
	
    </div>
    
    
 
  
 </div>   
	
</div>
    
    
    
    

    
   
    
</body>
</html>
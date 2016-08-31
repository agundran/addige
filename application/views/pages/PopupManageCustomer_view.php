<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<style>



</style>

<script>

window.onunload = function(){
  window.opener.location.reload();
};

window.onload = function(){
	window.opener.blur();
}

</script>
<body>


<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title><?php //echo $this->table->generate($records); ?>  

    <div id="container">
		
        <h4>AdSystems Customers</h4>
		
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
        
        <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('PopupManageCustomers/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th>Search Customer</th>
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
		<?php echo anchor('TrafficManageCustomers/validate_add/','Add New Customer',array('class'=>'validate_add')); ?>
		 <br />
         <br />
    
    	</div>
    
   		
</head>


</body>
</html>
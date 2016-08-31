<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">




<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title><?php //echo $this->table->generate($records); ?>  

    <div id="container">
		
        <h4>AdSystems Salesman</h4>
		
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
        
        
         <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('TrafficManageSalesman/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th><label for="Search" class="fa fa-search">Search Salesman</label></th>
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
		<?php echo anchor('TrafficManageSalesman/validate_add/','Add New Salesman',array('class'=>'validate_add')); ?>
		 <br />
         <br />

    	</div>
    
 
</head>

<body>
</body>
</html>
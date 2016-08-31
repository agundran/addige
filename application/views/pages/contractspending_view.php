<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
      
    <?php //echo $this->table->generate($records); ?>
        

       
    <div id="container">
    
 
		<center>
		<h4><?php echo $title; ?></h4>
		
        </center>
		
		<div class="paging"><?php echo $pagination; ?></div>

		<div class="data"><?php echo $table; ?></div>

		<div class="paging"><?php echo $pagination; ?></div>

		<br />
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
				<td><input name="ShortName" type='text' id="ShortName"  /></td>					
				    
                
               <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                <input type='submit' class="btn btn-primary btn-lg active" id='filter' name='' value='Filter'>
                </td>
			</tr>
		</table>
        
        <br />
        <br />
        
       <a href="#menu-toggle"  id="menu-toggle"><i class="fa fa-minus-circle"></i>Toggle Menu</a>
       
       
       
       
		</form>
	</fieldset>
</div>
    
	
       	
    
		</div>
    
    
    
    
    <div>
    
    </div>
    
       <!-- jQuery Version 1.11.0 -->
    <script src="<?php echo base_url(); ?>js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
    
    
</body>
</html>
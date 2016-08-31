<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
      
    <?php //echo $this->table->generate($records); ?>
        
	<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();

</script>
       
    <div id="container">
    
 
		<center>
    
 
        <p style="font-size:16px">Selected Sitename : <a style="color: #00F" style="font-weight:bold"> <?php echo $title; ?></a></p>
       	 <h5><?php echo 'Number of filtered rows:'.$no_row; ?></h5>
        </center>
        
        <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('contracttobecopied/index/0/'.$title.'/asc');?> method='post'>
		
        <!--<form name='search' action=<?=site_url('constractsview/index');?> method='post'>
		-->	
        <table>
			<tr>
           
            
            
				<th>Search Contract</th>
				<th></th>	
                <th></th>	
                <th></th>	
                
                	  			
				</tr>
			<tr>
				
                <td>Search by
                
               <select name="myselect" id="myselect">
  					<option value="ContractName">Name</option>
  					<option selected value="Seq">Seq</option>
  					<option value="CustOrder">Order</option>
  					</select> 
                </td>					
				
                
                
                <td>value<input name="myvalue" type='text' id="myvalue"  /></td>					
				    
                
               <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                <input type='submit' class="btn btn-primary btn-lg active" id='filter' name='' value='Filter'>
                </td>
                <td>
                </td>
            
			</tr>
		</table>
		
        </form>
        
     
      
	</fieldset>
    	<center>
    	<h4>Contracts to be copied</h4>
		</center>
        <div class="paging"><?php echo $pagination; ?></div>

		<div class="data"><?php echo $table; ?></div>

		<div class="paging"><?php echo $pagination; ?></div>

		<br />
	
         <br /><br />
        
        
        <?php echo $link_back; ?>
        
       
        
        <br />
        <br />
      
		
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
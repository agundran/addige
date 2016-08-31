



<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageFiles').addClass('open');
$('#Traffic, #ManageFiles').children('ul').slideDown();

</script>

<?php //echo $this->table->generate($records); ?>  

    <div id="container">
		<center>
        <h4>AdSystems Salesman</h4>
		</center>
        
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
				<td><input name="Name" type='text' id="Name" placeholder="Enter Salesman"  /></td>					
				    
                
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
        
        
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
        
        
        
        
        
		<br />
		<?php
		
		 $attrib = array(
				
              'width'      => '0',
              'height'     => '0',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'no',
          'screenx'   =>  '\'+((parseInt(screen.width) - 800)/2)+\'',
    'screeny'   =>  '\'+((parseInt(screen.height) - 600)/2)+\'',
            );
		
		
		 
		
		 	echo anchor_popup('TrafficManageSalesman/validate_add/', 'Add new Salesman',array('class'=>'validate_add'), $attrib);
		 
		 ?>
		 <br />
         <br />
    	
    	</div>
    
   		
</head>

<body>
</body>
</html>








<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageFiles').addClass('open');
$('#Traffic, #ManageFiles').children('ul').slideDown();



var myWindow;

    function openWin() {
        myWindow = window.open('http://192.168.1.253:81/index.php/TrafficManageCustomers/validate_add/', 'XML Importer', 'width=800,height=600,scrollbars=0');
    }

    function checkWin() {
        if (!myWindow) {
            openWin();
        } else {
            if (myWindow.closed) {
                openWin();
            } else {
                alert('ADD CUSTOMER window is already opened.');
                myWindow.focus();
            }
        }
    }

</script>

<body>


<head>


<?php //echo $this->table->generate($records); ?>  

    <div id="container">
		<center>
        <h3>CUSTOMERS</h3>
		</center>
        
        
        <div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('TrafficManageCustomers/index');?> method='post'>
		<table>
			<tr>
           
            
            
				<th><label for="Search" class="fa fa-search">Search Customer</label></th>
				<th></th>	
                <th></th>	
                
                				
						</tr>
			<tr>
				<td><input name="Name" type='text' id="Name" placeholder="Enter Customer"/></td>					
				    
                
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
		<a class="initChat" onClick="checkWin()"> <span>Add New Customer</span></a>
		
         <br />
         <br />
    
    	</div>
    
   	
</head>


</body>
</html>
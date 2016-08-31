<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #Reports').addClass('open');
$('#Traffic, #Reports').children('ul').slideDown();

</script>



    	<div id="container">



		
        <center>
		<h3><?php echo $title; ?></h3>
		<h4><?php echo $title1; ?></h4>
        </center>
		<table>
        <div class="search">
		<fieldset>
		
		<form name='search' action=<?=site_url('missinglogsSetMonth/index');?> method='post'>
		<table>
			<tr>
                     
				<th>Search Sequence</th>
				<th></th>	
                <th></th>	
                                				
						</tr>
			<tr>
				<td><input name="Year" type='text' id="Year" placeholder="Enter Year" /></td>					
				    
                               <!-- <td><input name="SysCode"  type='text' id="SysCode"  value="<?php echo $selectedSysCode; ?>" /></td>					
				-->
				<td>
                <input type='submit' class="btn btn-primary btn-lg active"  id='filter' name='' value='Filter' style="">
                </td>
                
                <td></td>
			</tr>
		</table>
        
        
		</form>
	</fieldset>
        
        </table>  

		
        
        
      
		
   		
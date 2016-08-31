
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #Invoicing').addClass('open');
$('#Billing, #Invoicing').children('ul').slideDown();

</script>

<?php //echo $this->table->generate($records); ?>  

    <div id="container">
		
        <center>
		<h3><?php echo $title; ?></h3>
		<h4><?php echo $title1; ?></h4>
        </center>
		<!-- <fieldset>
		
		<form name='search' action=<?=site_url('invoicingbysite/index');?> method='post'>
		<table>
			<tr>
                     
				<th>Search Site</th>
				<th></th>	
                <th></th>	
                                				
						</tr>
			<tr>
				<td><input name="Seq" type='text' id="Seq" placeholder="" /></td>					
				    
             	<td>
                <input type='submit' class="btn btn-primary btn-lg active"  id='filter' name='' value='Filter' style="">
                </td>
                
                <td></td>
			</tr>
		</table>
        
        
		</form>
	</fieldset>
    -->
        <div class="paging"><?php //echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php //echo $pagination; ?></div>
        
        
        
        
        
        <br />
        
      
		
   		
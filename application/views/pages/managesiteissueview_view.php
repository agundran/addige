

<?php //echo $this->table->generate($records); ?>  

    <div id="container">
        <center>
			<h4><?php echo 'Cases for '.$title ; ?></h4>
        </center>
		
        <div class="paging"><?php echo $pagination; ?></div>
        <div class="data"><?php echo $table; ?></div>
        <div class="paging"><?php echo $pagination; ?></div>
        
			<br />
        	<br />
         	<br />
	<div class="search">
	<fieldset>
		<form name='search' action=<?=site_url('managesiteissueview/index');?> method='post'>
		<table>
			<tr>
    			<th>Search Client</th>
				<th></th>	
                <th></th>	
    					</tr>
			<tr>
				<td><input name="ShortName" type='text' id="ShortName"  /></td>					
				<td><input type='submit' class="btn btn-primary btn-lg active" id='filter' name='' value='Filter'></td>
			</tr>
		</table>
        
        <br />
        <?php echo $create_case; ?> 
        <br />
        <?php echo $link_back; ?>
		</form>
	</fieldset>
	</div>
         <br />
    	
    	</div>
    	
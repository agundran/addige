

   	<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();

</script>   
    <?php //echo $this->table->generate($records); ?>
        

       
    <div id="container">
    
 
		<center>
		<h4>Contract for site: <b><?php echo  $title; ?></b></h4>
        <h5>Sequence: <b><?php echo  $subtitle; ?></b></h5>
		  <br />
        <table>
        <tr>
        <th>Seq</th><th>Contract Name</th><th>Order</th><th>Start Date</th><th>End Date</th>
        </tr>
        <tr>
        <td><?php echo  $Seq1;  ?></td>
        <td><?php echo  $Contractname1;  ?></td>
        <td><?php echo  $CustOrder1;  ?></td>
        <td><?php echo  $StartDate1;  ?></td>
        <td><?php echo  $EndDate1;  ?></td>
        </tr>
        </table>
		
		
        <br />
        <br />
        </center>
		
		<div class="paging"><?php echo $pagination; ?></div>
		<p>Copy of contract name: <b> <?php echo  $Contractname1; ?></b></p>
        	
		
        <div class="data"><?php echo $table; ?></div>

		<div class="paging"><?php echo $pagination; ?></div>

		<br />
	<div class="search">
	<fieldset>
		
		<form name='search' action=<?=site_url('selectsite/index');?> method='post'>
		<table>
			
            
            
            <tr>
           
            
            
				<th></th>
				<th></th>	
                <th></th>	
                
                				
						</tr>
			<tr>
				<td>
                 <?php
                 
				  echo $add_sched; ?>
                  
                    <?php
                 
				  echo $dup_copy; ?>
                  <br />
                  <br />
                  <br />
                  
                    
                 
                 <br />
                  <br />
                  <br />
                  
                 
                   <?php
                 
				  echo $link_back; ?>
                 
                 
				</td>
                <td>
                
                </td>
                <td>
                
                </td>
			</tr>
		</table>
        
        <br />
        <br />
        
       
       
       
       
       
		</form>
	</fieldset>
</div>
    
	
       	
    
		</div>
    
    
    
    
    <div>
    
    </div>
    
  
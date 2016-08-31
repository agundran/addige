<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Admin, #Network').addClass('open');
$('#Admin, #Network').children('ul').slideDown();

</script>



            <?php //echo $this->table->generate($records); ?>
	
       
   		    <div id="container">
			<center>
            <h4>All Machines</h4>
    		</center>
            <div class="paging"><?php echo $pagination; ?></div>
    
            <div class="data"><?php echo $table; ?></div>
    
            <div class="paging"><?php echo $pagination; ?></div>
    
            
    
           
        	</div> 
    
         

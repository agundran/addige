
    <?php //echo $this->table->generate($records); ?>
	
       
   		 <div id="container">

            <h4>All Machines</h4>
    
            <div class="paging"><?php echo $pagination; ?></div>
    
            <div class="data"><?php echo $table; ?></div>
    
            <div class="paging"><?php echo $pagination; ?></div>
    
            <br />
    
            <?php echo anchor('Cuesources/validate_add/','Add new user',array('class'=>'validate_add')); ?>
            
          
       		
            
        	</div> 
    
            <!-- Menu Toggle Script -->
           
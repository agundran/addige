<?php //echo $this->table->generate($records); ?>  

    <div id="container">
		
        <center>
		<h4><?php echo $title; ?></h4>
		
        </center>
		
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        <h4>Search</h4>
        <form name='search' action=<?=site_url('parent/index/');?> method='post'>
		<br />
        
        
        
        <br />
        
        
		<?php echo anchor('customerlist/validate_add/','Add New Operator',array('class'=>'validate_add')); ?>
		 <br />
         <br />
    	<?php include("application/views/pages/template/ToggleBut.php"); ?>
    	</div>
    
   		<?php include("application/views/pages/template/ToggleButScript.php"); ?>
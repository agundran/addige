<script>

window.onunload = function(){
  window.opener.location.reload();
};

//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();


</script>

      
    <?php //echo $this->table->generate($records); ?>
        

       
    <div id="container">
      
		<center>
       
		  <p style="font-size:16px">Selected Sequence : <a style="color: #00F" style="font-weight:bold"> <?php echo $title; ?></a></p>
         <p style="font-size:16px">Selected Sitename : <a style="color: #00F" style="font-weight:bold"> <?php echo $subtitle; ?></a></p
        >
      
		

        </center>
    
		 <h4>Selected Contract to Copy</h4>
         
		<div class="paging"><?php echo $pagination; ?></div>

		<div class="data"><?php echo $table; ?></div>

		<div class="paging"><?php echo $pagination; ?></div>

		<br />
		  <h4>Schedule of selected Contract</h4>       
	
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
    
    

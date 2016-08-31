<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #legacy').addClass('open');
$('#Billing, #legacy').children('ul').slideDown();


</script>

<?php

    ini_set('memory_limit', '2048M');
    ini_set('max_execution_time', '5000');
	set_time_limit(5000);
	ini_set("display_errors", "on");
	 ?>

    	<div id="container">


         
		
        <center>
        <?php //echo $output; ?>
        
        
		<h3><?php echo $title; ?></h3>
		<h4><?php echo $title1; ?></h4>
        </center>
		<!--
        <table>
        <tr>
        
        <td align="right" >
        -->
       	<button type="button" class="btn btn-default" onclick="tableToExcel('table2excel', 'Billeddetail')" value="Export to Excel">
      	<span class="glyphicon glyphicon-export"></span> Export to Excel
        
    	</button>
        
        <script src="js/tableToExcel.js"></script>
       <!--
        </td>
        </tr>
        </table>  
        -->
        <div class="data"><?php echo $table; ?></div>
		
        
        
      
		
   		
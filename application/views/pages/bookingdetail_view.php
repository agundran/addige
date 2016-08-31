<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #Reports').addClass('open');
$('#Traffic, #Reports').children('ul').slideDown();

</script>



    	<div id="container">



		
        <center>
         <?php echo $output; ?>
		<h3><?php echo $title; ?></h3>
		<h4><?php echo $title1; ?></h4>
        </center>
		<table>
        <tr>
        
        <td align="right" >
       	<button type="button" class="btn btn-default" onclick="tableToExcel('table2excel', 'BookedOrders')" value="Export to Excel">
      	<span class="glyphicon glyphicon-export"></span> Export to Excel
        
    	</button>
        <script src="js/tableToExcel.js"></script>
        </td>
              
		
        </tr>
        </table>  
        
        <div class="data"><?php echo $table; ?></div>
		
        
        
      
		
   		
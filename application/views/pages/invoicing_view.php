<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #Invoicing').addClass('open');
$('#Billing, #Invoicing').children('ul').slideDown();

</script>


<?php //echo $this->table->generate($records); ?>  

    <div id="container">
		
        <center>
		<h4><?php echo $title; ?></h4>
		
        </center>
		<table>
        <tr>
        
        <td align="right" >
       	<button type="button" class="btn btn-default" onclick="tableToExcel('table2excel', 'Invoicing')" value="Export to Excel">
      	<span class="glyphicon glyphicon-export"></span> Export to Excel
        
    	</button>
        <script src="js/tableToExcel.js"></script>
        </td>
              
		
        </tr>
        </table>  
        
        <div class="paging"><?php //echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php //echo $pagination; ?></div>
        
       
        
        
        <br />
        
      
		
   		
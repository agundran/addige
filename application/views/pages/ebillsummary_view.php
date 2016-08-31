<?php //echo $this->table->generate($records); ?> 

    <div id="container">
		
        <center>
		<h4><?php echo $title; ?></h4>
        <h5><?php echo $title2; ?></h5>
        
        <table>
        <tr>
        
        <td align="right" >
       	<button type="button" class="btn btn-default" onclick="tableToExcel('table2excel', 'ebill')" value="Export to Excel">
      	<span class="glyphicon glyphicon-export"></span> Export to Excel
        
    	</button>
        <script src="js/tableToExcel.js"></script>
        </td></tr>
       
        </table>  
        
        </center>
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
        
		<br />
        
        
        
        <br />
        
      
		
   		
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #Invoicing').addClass('open');
$('#Billing, #Invoicing').children('ul').slideDown();

</script>

<?php //echo $this->table->generate($records); ?> 

    <div id="container">
		
        <center>
		<h4><?php echo $title; ?></h4>
        <h5><?php echo 'from '.$sd.' to '.$ed?> </h5>
		
        <table>
        <tr>
        
        <td align="right" >
    	<button type="button" class="btn btn-default" onclick="tableToExcel('table2excel', 'generate_invoice')" value="Export to Excel">
      	<span class="glyphicon glyphicon-export"></span> Export to Excel
        
    	</button>
        <script src="js/tableToExcel.js"></script>
        </td>
              
		
        </tr>
        </table>  
        
        <!--
        <fieldset>
		-->
        <!--
		<form name='search' action=<?=site_url('invoicingbycustomer/index/0/');?> method='post'>
		
        <form name='search' action=<?=site_url('invoicingbycustomer/index');?> method='post'>
		-->	
       
      
       <!--
        </form>
        

      
	</fieldset>
    
    -->
        </center>
		
    
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
        
		<br />
        
        
        
        <br />
        
      
		
   		
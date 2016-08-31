<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #legacy').addClass('open');
$('#Billing, #legacy').children('ul').slideDown();

</script>

    <div id="container">
		
        <center>
		<h3><?php echo $title; ?></h3>
		<h4><?php echo $title1; ?></h4>
        </center>
        
        
        <table>

  
        <tr>
        
        <td>
       	<button type="button" class="btn btn-default" onclick="tableToExcel('table2excel', 'generate_invoice')" value="Export to Excel">
      	<span class="glyphicon glyphicon-export"></span> Export to Excel
        
    	</button>
        <script src="js/tableToExcel.js"></script>
        </td>
          
        </tr>
        </table>  
          
       
        <div class="paging"><?php //echo $pagination; ?></div>
		
        <div class="data">
		
		<?php echo $table; ?>
        
        </div>
		
        <div class="paging"><?php //echo $pagination; ?></div>
        
      
  
        
        
        <br />
        
         <font size="2" face="verdana">
		    <br />
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    
        <!--    <asp:Button ID="lnkOperatorView"
			OnClick="OnbtnLinkOperatorView_Clicked"
			text="Export"
			runat="server" >
		    </asp:Button>
		<?php echo $this->benchmark->memory_usage();?>
                   
         <?php //echo "Click ".$filewrite; ?>   to generate electronic data and to download.
		
        -->
        </font>
                
                         
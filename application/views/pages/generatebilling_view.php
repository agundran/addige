<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #legacy').addClass('open');
$('#Billing, #legacy').children('ul').slideDown();

</script>

    <div id="container">
		
        <center>
		<h3><?php echo $title; ?></h3>
		<h4><?php echo $title1; ?></h4>
        
          <table>	
	 	   <tr><td><td> </tr>
           <tr>
           <td>(1) Change Billing Month   <?php echo $setbm; ?>  </td>     
            <td></td>
           
           
           
           
           
           </table>
        
        <center>
          <font  face="glyphicon" size="+2">
           <?php echo $generatebill; ?>
          </font>
           </center>
       
		
        <div class="data">
		
		 
        </div>
		
        
      
  
        
        
        <br />
        
         <font size="2" face="verdana">
		    <br />
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    
        <!--    <asp:Button ID="lnkOperatorView"
			OnClick="OnbtnLinkOperatorView_Clicked"
			text="Export"
			runat="server" >
		    </asp:Button>
		-->
                   
        
		
        </font>
        
        
                
                         </center>
                         
                         
                         <?php  //phpinfo(); ?>
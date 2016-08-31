<?php //echo $this->table->generate($records); ?>  

    <div >
		
          
         
     <table width=800px border=0 cellpadding=0 cellspacing=0>
	<tr>
	    <td width=50% valign="top">
		<span style='font-size:12.0pt;font-family:Arial'>
		    <br />
		    <b>
		    <span id="CustName"><?php echo $name; ?></span>
		    </b>
		    <br />
		    <span id="Address1"><?php echo $add1;  if ($add2 != null) echo "<br/>".$add2;   ?>  </span>
		    <!--<br />
		    <span id="Address2"><?php //echo $add2; ?></span> -->
		    <br />
		    <span id="Address3"><?php echo $city; ?>, <?php echo $state; ?></span>
		    <br />
            
		    <span id="Address4"><?php echo $zip; ?></span>
		    <br />
		    <br />
		</span>
	    </td>
	    <td valign="top" >
	    </td>
	</tr>
    </table>

    <table width=800px border=0 cellpadding=0 cellspacing=0>
	<tr>
		<span style='font-size:14.0pt;font-family:Arial'>
		    <i>Ad Insertion at&nbsp;
		    <span id="SiteName"><?php echo $city; ?>, <?php echo $state; ?></span>
		    (SysCode
		    <span id="SysCode"><?php echo $syscode; ?></span>
		    )
		</i></span>
	</tr>
	<tr>
	    <td width=50% valign="top">
		<font face="arial" size="3">
		    <b>From
			&nbsp;
			&nbsp;
			</b>
			<span id="StartDate"><?php $sd = strtotime($StartDate); echo date("l, F  d ,Y",$sd);?></span></asp:label>
		    <br><b>To &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </b>
			<span id="EndDate"><?php $sd = strtotime($EndDate); echo date("l, F  d ,Y",$sd);?></span></asp:label>
		    <br />
		    <b>Printed&nbsp;</b>
			<span id="PrintDate"><?php $sd = strtotime($EndDate) +(24*3600*1); echo date("l, F  d ,Y",$sd+1);?></span></asp:label>
		    <br />
		    <b>Customer Order&nbsp;</b>
			<span id="CustOrder"><?php echo $co; ?></span>
		</font>
	    </td>
	    <td width=50% valign="top">
		<font face="arial" size="3">
		    <b>Number&nbsp;</b>
		    <span id="InvoiceNumber"><?php echo $cy.$cm; ?>-<?php echo $contractno; ?></span>
		    <br />
		    <b>Contract&nbsp;</b>
		    <span id="Seq"><?php echo $contractno; ?></span>
		    <br />
		    <b>Terms</b>&nbsp;&nbsp;Net 30 days
		    <br />
		</font>
	    </td>
	</tr>
    </table>

    <br />

    <table width=800px border=0 cellpadding=0 cellspacing=0>
	<tr>
	    <td width=50% valign="top">
		<span style='font-size:12.0pt;font-family:Arial'>
		    <b>Contract Name</b>
		    <br />
		    <span id="ContractName"><?php echo $cn; ?></span>
		</span>
	    </td>
	    <td valign="top" >
		<span style='font-size:12.0pt;font-family:Arial'>
		    <b>Spot Name(s)</b>
		    <br />
		    <span id="SpotName"><?php echo $spotname; ?></span>
		</i></span>
	    </td>
	</tr>
    </table>
    
        <br />    <br />
        
       <i>Order Details</i> 
       
        <div class="tbdata"><?php echo $table; ?></div>
		
        
       
    <table width=800px border=0 cellpadding=0 cellspacing=0>
	<tr>
	    <td width=40% valign="top">
		<p align=left style='text-align:left'>
		    <span style='font-size:12.0pt;font-family:Arial'>
			Subtotal this page:
		    </span>
		
		</p>
	    </td>
	    <td width=60% valign="top">
		<p align=left style='text-align:left'>
		    <span style='font-size:12.0pt;font-family:Arial'>
			<span id="SubTotalText"><?php echo $totalprice; ?></span>
		    </span>
		
		</p>
	    </td>
	</tr>
	<tr>
	    <td width=40% valign="top">
		<p align=left style='text-align:left'>
		    <span style='font-size:12.0pt;font-family:Arial'>
			Less discount/commission
		    </span>
		
		
		</p>
	    </td>
	    <td width=60% valign="top">
		<p align=left style='text-align:left'>
		    <span style='font-size:12.0pt;font-family:Arial'>
			<span id="DiscountText"><?php echo $discount; ?></span>
		    </span>
		
		</p>
	    </td>
	</tr>
	<tr>
	    <td width=40% valign="top">
		<p align=left style='text-align:left'>
		    <span style='font-size:12.0pt;font-family:Arial'>
			<b>Amount due this page</b>
		    </span>
	
		</p>
	    </td>
	    <td width=60% valign="top">
		<p align=left style='text-align:left'>
		    <span style='font-size:12.0pt;font-family:Arial'>
			<b><span id="AmountDueText">$<?php echo $due; ?>
            </span></b>
		    </span>
		<br />
		</p>
	    </td>
	</tr>
    </table>
   
        
        
        
        <br />
        
      
		</div>
   		
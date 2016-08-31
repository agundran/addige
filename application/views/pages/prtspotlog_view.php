<?php //echo $this->table->generate($records); ?>  


    <table width=800px border=0 cellpadding=0 cellspacing=0>
	<tr>
	    <td width=50% valign="top">
		<span style='font-size:12.0pt;font-family:Arial'>
		    <b>Contract Name</b>
		    <br />
		    <span id="ContractName"><?php echo $cn; ?></span>
		    <br />
		    <br />
		    <b>Customer Order&nbsp;</b>
		    <span id="CustOrder"><?php echo $co; ?></span>
		    <br />
		    <b>Contract Number&nbsp;</b>
		    <span id="Seq"><?php echo $cc; ?></span>
		    <br />
		    <br />
		</span>
	    </td>
	    <td valign="top" >
		<span style='font-size:12.0pt;font-family:Arial'>
		    <b>Spot Name(s)</b>
		    <br />
		    <span id="SpotName"><?php echo $spotname; ?></span>
		    <br />
		    <br />
		    <b>From&nbsp;</b>
		    <span id="StartDate"><?php echo date("l, F  d ,Y",strtotime($sd)); ?></span>
		    <b>To&nbsp;</b>
		    <span id="EndDate"><?php echo date("l, F  d ,Y",strtotime($ed)); ?></span>
		</i></span>
	    </td>
	</tr>
    </table>

    

 <div class="tbdata"><?php echo $table; ?></div>






	
    
    </td></tr>
	   
	<tr>
	    <td>
		<font face="arial" size="2">
		<br />
		    Printed&nbsp;
		    <?php $sd = strtotime($EndDate) +(24*3600*1); echo date("l, F  d ,Y",$sd+1);?>
		</font>
	    </td>
	</tr>

    </table>

  
   		
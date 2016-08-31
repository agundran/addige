<script type="text/javascript">

//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();



<!--
function un_check(){
for (var i = 0; i < document.frmactive.elements.length; i++) {
var e = document.frmactive.elements[i];
if ((e.name != 'allbox') && (e.type == 'checkbox')) {
e.checked = document.frmactive.allbox.checked;
}
}
}
//-->
</script>

<body>

    <div class="row-fluid">
        <div class="span12">


         	<h4><center>Pending Contracts</center></h4>
            <h5><center>All Sites</center></h5>
            <div class="container">
							<form form name="frmactive" method="post" action="<?=site_url('pendingtesting2/update');?>" >
                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
                            <div class="alert alert-info">
                              
                                <strong><i class="icon-user icon-large"></i>&nbsp;Clear Multiple Contract</strong>
								&nbsp;&nbsp;Check the checkbox and click the Clear flag button below to clear contracts. 
                            </div>
                            <thead>
						
                                <tr>
                                    <th><input type="checkbox" name="allbox" onClick="un_check(this);" title="Select or Deselct ALL" style="background-color:#ccc;"/></th>
                                    <th>Seq</th>
                                    <th>SysCode</th>
                                    <th>SiteName</th>
                                    <th>ContractName</th>
                                    <th>StartDate</th>
                                    <th>EndDate</th>
                                    <th>Schedule</th>
                                    <th>Copy Entry</th>
                                    <th>Update Contract</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php 
							$query=mysql_query("SELECT DISTINCT ch.Seq,so.SysCode, ch.SiteName,ch.ContractName,ch.StartDate,
ch.EndDate 
FROM contract_header ch 
JOIN site_operators so ON ch.SiteName = so.SiteName
JOIN registration reg ON so.SiteName = reg.SiteName
WHERE ch.`Attributes` > 256 AND
reg.Active = 1
")or die(mysql_error());
							while($row=mysql_fetch_array($query)){
							$id=$row['Seq'];
							?>
                              
										<tr>
										<td>
										<input name="selector[]" type="checkbox" value="<?php echo $id; ?>">
										</td>
                                         <td><?php echo $row['Seq'] ?></td>
                                         <td><?php echo $row['SysCode'] ?></td>
                                         <td><?php echo $row['SiteName'] ?></td>
                                         <td><?php echo $row['ContractName'] ?></td>
                                         <td><?php echo $row['StartDate'] ?></td>
                                		<td><?php echo $row['EndDate'] ?></td>
                                        <td><a href="<?php echo site_url('detailentry/index/0/'.$row['SiteName'].'/asc/'.$row['Seq'].'') ?>">Schedule Entry</a></td>
                                         <td><a href="<?php echo site_url('copyentry/index/0/'.$row['SiteName'].'/asc/'.$row['Seq'].'') ?>">Copy Entry</a></td>
                                         <td><a href="<?php echo site_url('contractsview/update/'.$row['Seq'].'') ?>">Update Contract</a></td>
                                 
                                   
                                        
                                       
                                            
                                </tr>
                                
                         
						          <?php } ?>
                            </tbody>
                        </table>
						<input type="submit" class="btn btn-primary btn-lg active" value="Clear Flag" name="delete">
                        
                        	
          
</form>

        </div>
        </div>
        </div>
    </div>



</body>
</html>



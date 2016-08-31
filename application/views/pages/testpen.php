'<input name="checkbox[]" type="checkbox" id="checkbox[]" value="'. $Users->Seq.'">',




<div class="dataPending"><?php echo $table; ?></div>











<?php
//$host="localhost"; // Host name 
//$username="username"; // Mysql username 
//$password="password"; // Mysql password 
//$db_name="test"; // Database name 
//$tbl_name="test_mysql"; // Table name 
 
// Connect to server and select databse.
//mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
//mysql_select_db("$db_name")or die("cannot select DB");
 
if(isset($_POST['checkbox']))
{
	$checkbox = $_POST['checkbox'];
if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
 
$id = "('" . implode( "','", $checkbox ) . "');" ;
$sql="UPDATE contract_header SET Attributes = '256' WHERE Seq IN $id" ;
$result = mysql_query($sql) or die(mysql_error());
}
 
$sql="SELECT ch.Seq,so.SysCode, ch.SiteName,ch.ContractName,ch.StartDate,
ch.EndDate FROM contract_header ch JOIN site_operators so ON ch.SiteName = so.SiteName
WHERE ch.`Attributes` > 256 LIMIT 10";
$result=mysql_query($sql);
 
$count=mysql_num_rows($result);
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update multiple rows in mysql with checkbox</title>
 
<script type="text/javascript">
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
 
</head>
<body>
 <div id="container">
<table width="400" border="0" cellspacing="1" cellpadding="0">
<tr>
<td><form name="frmactive" method="post" action="">
<table width="400" border="0" cellpadding="3" cellspacing="1">
<tr>
  <td colspan="5"><input name="activate" class="btn btn-primary btn-lg active" type="submit" id="activate" value="Clear Flag" />
  <input name="deactivate" class="btn btn-primary btn-lg active" type="submit" id="deactivate" value="Deactivate" /></td>
  </tr>
<tr>
<td>&nbsp;</td>
<td colspan="4"><strong>Update multiple rows in mysql with checkbox</strong> </td>
</tr>
<tr>
<td align="center"><input type="checkbox" name="allbox" onclick="un_check(this);" title="Select or Deselct ALL" style="background-color:#ccc;"/></td>
<td align="center"><strong>Seq</strong></td>
<td align="center"><strong>SysCode</strong></td>
<td align="center"><strong>SiteName</strong></td>
<td align="center"><strong>ContractName</strong></td>
<td align="center"><strong>StartDate</strong></td>
<td align="center"><strong>EndDate</strong></td>
</tr>
<?php
while($rows=mysql_fetch_array($result)){
?>
<tr>
<td align="center"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="<?php echo $rows['Seq']; ?>"></td>
<td><?php echo $rows['Seq']; ?></td>
<td><?php echo $rows['SysCode']; ?></td>
<td><?php echo $rows['SiteName']; ?></td>
<td><?php echo $rows['ContractName']; ?></td>
<td><?php echo $rows['StartDate']; ?></td>
<td><?php echo $rows['EndDate']; ?></td>
</tr>
<?php
}
?>
<tr>
<td colspan="5" align="center">&nbsp;</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
 </div>
</body>
</html>
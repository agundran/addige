<html>
<head>
	<title>Users Management</title>
	<script src="<?php echo base_url(); ?>js/jquery-1.6.3.min.js"></script>
	<script src="<?php echo base_url(); ?>js/datagrid.js"></script>
</head>
<body>
<style>
	.dg_form table{
		border:1px solid silver;
	}
	
	.dg_form th{
		background-color:gray;
		font-family:"Courier New", Courier, mono;
		font-size:12px;
	}
	
	.dg_form td{
		background-color:gainsboro;
		font-size:12px;
	}
	
	.dg_form input[type=submit]{
		margin-top:2px;
	}
</style>
<?php
		$this->Datagrid->hidePkCol(true);
		$this->Datagrid->setHeadings(array('Username'=>'User','Email'=>'EMAIL'));
		$this->Datagrid->ignoreFields(array('ApplicationName'));
		if($error = $this->session->flashdata('form_error')){
			echo "<font color=red>$error</font>";
		}
		echo form_open('test/proc',array('class'=>'dg_form'));
		echo $this->Datagrid->generate();
		echo Datagrid::createButton('delete','Delete');
		echo form_close();
?>

</body>
</html>
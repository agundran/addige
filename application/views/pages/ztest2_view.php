

<style type="text/css" media="print">
	.dontprint{ 
	display: none; 
	}
	@media print {
 	a[href]:after {
    content: none !important;
  }
}
@page  
{ 
    size: auto;   /* auto is the initial value */ 

    /* this affects the margin in the printer settings */ 
    margin: 25mm 25mm 25mm 25mm;  
} 
@media print {
thead { display: table-header-group; }
tfoot { display: table-footer-group; }
}
@media screen {
thead { display: block; }
tfoot { display: block; }
}
</style>

<body>

       <?php 
	   
	   $servername = '192.168.1.254';
		$username = 'arnold';
	   $password = 'Ved12345';
//$db['default']['database'] = 'dev_reporting';
	   
	   
       //     $servername = "localhost";
		//	$username = "username";
		//	$password = "password";

// Create connection
$con = new mysqli($servername, $username, $password);	   
	   
	   
	   
			$procedures = mysqli_query($con, "SELECT * FROM quality_procedures WHERE status = 'Approved' ORDER BY doc_no ASC"); 
			$c1 = mysqli_num_rows($procedures);
			
			$wi = mysqli_query($con, "SELECT * FROM work_instruction WHERE status_w = 'Approved' ORDER BY wi_no ASC");
			$c2 = mysqli_num_rows($wi);	
			
			$fo = mysqli_query($con, "SELECT * FROM forms WHERE status_f = 'Approved'");
			$c3 = mysqli_num_rows($fo);	
			
			$count = $c1 + $c2 + $c3;
			
			$q = mysqli_query($con, "SELECT * FROM forms WHERE form_name = 'Document Master List'");
			$get_f = mysqli_fetch_array($q);					
		?>
	<!-- top navbar -->
      <div class="row row-offcanvas row-offcanvas-left" style="margin-top:-50px;">
		<div class="col-md-12" align="center" style=" background-color:#FFFFFF;">
			<span align="center"><a href="home.php"><img src="../css/logo.png"></a></span>
			<table class="table-hover"  style="margin-top:-40px;">
				<thead>
					<tr style="background:#FFFFFF;">
						<th colspan="5" align="center"><h1><span style="font-size:22px; font-family:calibri;">Documentation Master List</span></h1></th>
						<th align="right" colspan="13"><div class="dontprint"><a href="" onClick="window.print()"><img src="../css/print.jpg" height="40"></a></div></th>
					</tr>				
					<tr style="font-weight:bold; background:#0066CC; color:#FFFFFF; font-size:12px">
						<th id="border1">Document no.</th>
						<th id="border1">Document Title</th>
						<th id="border1">Document Type</th>
						<th id="border1">Rev./Issue</th>
						<th id="border1">Doc. Date</th>	
					</tr>
				</thead>
				<?php while($get = mysqli_fetch_array($procedures)){ 
							$forms = mysqli_query($con, "SELECT * FROM forms WHERE status_f = 'Approved' and doc_category = '".$get['document_title']."'"); 
				?>
				<tbody>
				<tr align="center">
					<td id="border1"><strong><?=$get['doc_no'];?></strong></td>
					<td id="border1"><strong><?=$get['document_title']?></strong></td>
					<td id="border1"><strong><?php if($get['document_title'] == 'Quality Manual'){ echo "Quality Manual"; } else{ echo "Quality Procedures";}?></strong></td>
					<td id="border1"><strong><?=$get['issue_rev']?></strong></td>
					<td id="border1"><strong><?=$get['date_issue']?></strong></td>
				</tr>
				<?php while($get_form = mysqli_fetch_array($forms)){ ?>
				<tr align="center">
					<td id="border1"><?=$get_form['form_no'];?></td>
					<td id="border1"><?=$get_form['form_name'];?></td>
					<td id="border1">Form</td>
					<td id="border1"><?=$get_form['form_issue'];?></td>
					<td id="border1"><?=$get_form['form_date'];?></td>
				</tr>
				<?php }
				 } 
				 while($get_wi = mysqli_fetch_array($wi)){ ?>
				<tr align="center">
					<td id="border1"><?=$get_wi['wi_no'];?></td>
					<td id="border1" width="300"><?=$get_wi['wi_name'];?></td>
					<td id="border1">Work Instruction</td>
					<td id="border1"><?=$get_wi['wi_rev'];?></td>
					<td id="border1"><?=$get_wi['wi_date'];?></td>
				</tr>
				<?php }?>
				</tbody>
				<tr>
					<td colspan="5">Approved by Management Representative: ________________________</td>	
				</tr>
				<tr>
					<td colspan="5">Date: ________________________</td>	
				</tr>
				<tr style="font-size:10px">
					<td colspan="5" align="right"><?=$get_f['form_no']?> rev. <?=$get_f['form_issue']?></td>	
				</tr>
			</table><br>
		</div>							
    </div>

</body>

<?php
?>
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Billing, #Invoicing').addClass('open');
$('#Billing, #Invoicing').children('ul').slideDown();
</script>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title><?php //echo $this->table->generate($records); ?>  

    <div id="container">
		
        <center>
        <h4><?php echo $title; ?></h4>
        
		 <h4><?php echo $title1; ?></h4>
         </center>
        <div class="paging"><?php echo $pagination; ?></div>
		
        <div class="data"><?php echo $table; ?></div>
		
        <div class="paging"><?php echo $pagination; ?></div>
        
		<br />
		
		 <br />
         <br />
    	
    	</div>
    
</head>

<body>
</body>
</html>
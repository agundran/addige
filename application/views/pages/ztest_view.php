
        
		
     

    <div id="container">
		
        <center>
        
        <?php
		 
		
		
	$newdate = strtotime('2016-6-30' .  "+2 days" );
	
	
	echo $newdate;
	echo "<br />";
	echo date("Y-m-d", $newdate);
	// this is a test date	
	$eday = 2;
	$newdate1 = strtotime('2016-6-30' .  "+3 days" );
	$newdate2 = strtotime('2016-6-30' .   "-".(1 * (6 - $eday))." days");
	echo "<br />";
	//$boolean = true;
	
	//$boolean = $newdate1 > $newdate2;
	if ($newdate1 > $newdate2)
	echo "true";
	else echo "false";
	 
	 	echo "<br />";
	echo date("Y-m-d", $newdate2);
		
		?>
        </center>
        
       
     
        
      
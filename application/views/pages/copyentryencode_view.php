					
 <script type="text/javascript">
        function OnChangeCheckbox (checkbox) {
            if (checkbox.checked) {
               // alert ("The check box is checked.");
		   document.getElementById("NetworkName").style.visibility= "visible";
			   
            }
            else {
               document.getElementById("NetworkName").style.visibility= "hidden";
			   
            }
        }
		
	


window.onunload = function(){
  window.opener.location.reload();
};



	</script>
    
    
    
</script>

        
   <style type="text/css">
	
	#smalltxt input[type="text"] {
    width: 25px;
	height: 12x;
    }
	
	#smalltxt2 input[type="text"] {
    width: 25px;
	height: 12x;
	}
   
    #checkme2 input[type="checkbox"] {
		
			
     
	}
	
.Spotname {
    text-transform: uppercase;
}

	#NetworkName, #SpotLength
		{
			font-weight:bolder;
		}
	
   
    </style> 
    
 <?php

$netcheck = array(
'name'        => 'netcheck',
'id'          => 'netcheck',
'value'       => '1',
'checked'     => FALSE,
'class' 	  => 'checkbox-inline',
'onclick'     => "OnChangeCheckbox(this)"

);
?>	
								  
   <script>
  $(function() {
    $( "#StartWeek" ).datepicker({
      dateFormat: "yy-mm-dd",
	  defaultDate: null,
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#EndWeek" ).datepicker({
	  dateFormat: "yy-mm-dd",	
      defaultDate: "+1m",
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  
  </script>                              
	   
 <!-- Page Content -->
 

      
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                      <div id="container">
   						<div class="content">
                            <div class="container">

							<div class="main">
		<center>
        <h3><?php echo $title; ?></h3>
        <h4><?php //echo $subtitle; ?></h4>
		</center>
		<?php echo $message; ?>
        <?php echo form_open($action); ?>
		
		<div class="data">
		<table width="350px">
		 <tr><th>
         
         </th>
         <th></th> 
         </tr>
        
         <tr><td>
         Start Week
         </td><td>
         
          <input type="text" name="StartWeek" style=" font-weight:bolder" id="StartWeek" placeholder="Choose Date"    class="text" value="<?php echo (isset($Users['StartDate']))?$Users['StartDate']:''; ?>"/>
			   <script src="<?php echo base_url();?>js/jquery-ui.js"></script>
         </td></tr>
         <tr><td>
         End Week
         </td><td>
         
          <input type="text" name="EndWeek" style=" font-weight:bolder" id="EndWeek"  placeholder="Choose Date"   class="text" value="<?php echo (isset($Users['EndDate']))?$Users['EndDate']:''; ?>"/>
			  
         </td></tr>
         <!--<tr><td>
         Start Day
         </td><td>
         <?php
         $options = array(
                  0   => 'Monday',
                  1   => 'Tuesday',
                  2   => 'Wednesday',
                  3   => 'Thursday',
				  4   => 'Friday',
                  5   => 'Saturday',
				  6   => 'Sunday',
             );
			 
		$startday =  $Users['StartDay'];	 
		echo form_dropdown('StartDay', $options, $startday);
        ?>     
        </td></tr>
		<tr><td>
         End Day
         </td><td>
         <?php
         $options = array(
                  0   => 'Monday',
                  1   => 'Tuesday',
                  2   => 'Wednesday',
                  3   => 'Thursday',
				  4   => 'Friday',
                  5   => 'Saturday',
				  6   => 'Sunday',
                  
                );
		 $endday =  $Users['EndDay'];		
		echo form_dropdown('EndDay', $options, $endday);
        ?>     
        </td></tr>
         -->
         <tr><td>
         Spot Name(s)
         </td><td>
         
          <input  type="text" name="SpotName" id="Spotname"  style=" font-weight:bolder"  class="Spotname"  value="<?php echo (isset($Users['SpotName']))?$Users['SpotName']:''; ?>"/>
			  
         </td></tr>
         
         <tr><td>
         Spot Length
         </td><td>
         
            <?php
         
		 $options = array(
                  30   => '30 Seconds',
                  60   => '60 Seconds',
                  90   => '90 Seconds',
                  120   => '120 Seconds',
				  
                );
				
		$spotl =  $Users['SpotLength'];		
		echo form_dropdown('SpotLength', $options, $spotl, 'class="SpotLength" id="SpotLength"');
        ?> 
         		  
         </td></tr>
         
           <tr><td>
         Network
    &nbsp;&nbsp;&nbsp;
           
           <div id="checkme2">
            <?php echo form_checkbox($netcheck); 
                              	?>
              </div>
         </td><td>
         
         <?php $site_network_name = $this->copyentryencodemodel->get_site_network($mysiteoperator);?> 
			
			<?php //$value_network_name = $Users['Network'];?> 
			  
              
			<?php echo form_dropdown('NetworkName', $site_network_name,'','class="NetworkName" id="NetworkName" style="visibility:hidden" '); ?>  
            
          <!--<input type="text" name="net" id="net" style="visibility:hidden"   class="text" value="<?php// echo (isset($Users['net']))?$Users['net']:''; ?>"/>-->
   
         		  
         </td></tr>
         
          <tr><td>
         Weighting
         </td><td>
    
          <input type="text" name="Weighting"  style=" font-weight:bolder"   class="text" value="<?php echo (isset($Users['Weighting']))?$Users['Weighting']:''; ?>"/>
			  
         </td></tr>
         
         <tr>
         <td>
         
          </td>
          <td>
           <input type="submit" class="btn btn-primary btn-lg active" value="Save" />
          </td>
         
        </table>
        
		 <?php echo form_close(); ?>

	
   
		<br />
       
        <br />
        
        
			</div>
						
                        
                        
                        
                        
               
						<?php echo validation_errors('<p class="error">'); ?>  
                        <br  />
                        </div>
                    </div>
                </div>
            </div>
        </div>
           </div>
        </div>
    <!-- /#page-content-wrapper -->
	



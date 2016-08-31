


   	<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();

</script>  
					
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
  
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/css/bootstrap.min.css"
    rel="stylesheet" type="text/css" />

<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
    rel="stylesheet" type="text/css" />
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
    type="text/javascript"></script>
  </script>                              
	  
      
	  <script type="text/javascript">
    $(function () {
        $('#siteoperator').multiselect({
            includeSelectAllOption: true
			
        });
    });
		</script>
 <!-- Page Content -->
 		<div id="container">
   		<div class="main">
		<center>
        <h3><?php echo $title; ?></h3>
        <h5>Note: all textbox are not editable.</h5>
        <h4><?php //echo $subtitle; ?></h4>
		</center>
		<?php echo $message; ?>
        <?php echo form_open($action2); ?>
		
		<div class="data">
		<table width="350px">
		 <tr>
         	<th>
           <div class="data"><?php echo $table; ?></div>
         	</th>
         	
         </tr>
        
         
         <tr>
          <td>
           <?php $countseq= $this->copyentryencodemodel->count_all_results($contractnamecount);
			?>        
             <p style="font-size:16px">No. of contracts to duplicate a copy : <a style="color: #00F" style="font-weight:bolder"> <?php echo $countseq; ?></a></p> <br />
          List of contracts with the same contract name
          </td>
           <td>
           <?php $site_operator= $this->copyentryencodemodel->get_site($contractname, $seq1);
			?>           				
           
		      <div id="siteop">
           
		   <?php echo form_multiselect('siteoperator[]',$site_operator,'','required id="siteoperator"' ); ?>
              <div>
          </td>
         </tr>
         <tr>
         <td>
         
              				
          </td>
          <td>
           <input type="submit" class="btn btn-primary btn-lg active" value="Duplicate" />
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
	



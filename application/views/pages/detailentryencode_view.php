<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>
				 <?php
				 $attributes = array(
    'class' => 'mycustomclass',
    'style' => 'color: #000;',
);
				 
				 

								$gdmo = array(
								'name'        => 'gdmo',
								'id'          => 'gdmo',
								'value'       => '1',
								'checked'     => FALSE,
								'class' 	  => 'checkbox-inline',
								
								
								);
								
															
								$gdtu = array(
								'name'        => 'gdtu',
								'id'          => 'gdtu',
								'value'       => '1',
								'checked'     => FALSE,
								'class' 	  => 'checkbox-inline'
								
								);
								
								$gdwe = array(
								'name'        => 'gdwe',
								'id'          => 'gdwe',
								'value'       => '1',
								'checked'     => FALSE,
								'class' 	  => 'checkbox-inline'
								
								
								);
								
								
								$gdth = array(
								'name'        => 'gdth',
								'id'          => 'gdth',
								'value'       => '1',
								'checked'     => FALSE,
								'class' 	  => 'checkbox-inline'
								);
								
								$gdfr = array(
								'name'        => 'gdfr',
								'id'          => 'gdfr',
								'value'       => '1',
								'checked'     => FALSE,
								'class' 	  => 'checkbox-inline'
								);
								
								$gdsa = array(
								'name'        => 'gdsa',
								'id'          => 'gdsa',
								'value'       => '1',
								'checked'     => FALSE,
								'class' 	  => 'checkbox-inline'
								);
								
								$gdsu = array(
								'name'        => 'gdsu',
								'id'          => 'gdsu',
								'value'       => '1',
								'checked'     => FALSE,
								'class' 	  => 'checkbox-inline'
								);
								
								?>
                                
                                
                                
	   
 <!-- Page Content -->
 

        
   <style type="text/css">
	
	#smalltxt input[type="text"] {
    width: 25px;
	height: 12x;
    }
	
	#smalltxt2 input[type="text"] {
    width: 25px;
	height: 12x;
	}
   
    select#StartTime { 
	 	overflow: hidden;
   		padding: 5px 10px;
		
   		white-space: nowrap;
		}
	
	select#EndTime {
   		overflow: hidden;
   		padding: 5px 10px;
   		
   		white-space: nowrap;
		}
		
		#NetworkName, #StartTime, #EndTime, #Priority
		{
			font-weight:bolder;
		}
	
		.ProgramName {
    text-transform: uppercase;
}

   
    </style>     
   
 <script>
  
    
  $(function() {
    $( "#StartDate" ).datepicker({
      dateFormat: "yy-mm-dd",
	  defaultDate: "-1m",
      changeMonth: true,
    
	  numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#EndDate" ).datepicker({
	  dateFormat: "yy-mm-dd",	
      defaultDate: "-1m",
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
  
  </script>
  
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                      <div id="container">
   						<div class="content">
                            <div class="container">

							<div class="main">
		<center>
        <h3><?php echo "ADD SCHEDULE"; ?></h3>
         <p style="font-size:16px">Add schedule under Contract Number : <a style="color: #00F" style="font-weight:bold"> <?php echo $subtitle; ?></a></p>
        
		</center>
        
       
        
        
		<?php echo $message; ?>
        <?php echo form_open($action); ?>
		
		<div class="data">
		<table>
		 <tr>
         <th>
         <h4>Schedule Line Item</h4>
         </th>
         <th>
         </th><th>
         </th>
         </tr>
         <tr>
         <th>
         <h5>Contract Detail Record</h5>
         </th>
         <th>
         </th>
         
         <th>
         </th>
         </tr>
         <tr>
         
         <td>
         Network
         </td>
         <td>
         
         
                  
          <?php $site_network_name = $this->detailentryencodemodel->get_site_network($mysiteoperator);?> 
			
			<?php //$site_network_name = $Users['SiteName'];?> 
			  
              
			<?php echo form_dropdown('NetworkName', $site_network_name,'','class="NetworkName" id="NetworkName"'); ?>  
         
         </td>
         
         <td>
         </td>
         
         
		 </tr>
           
         <tr><td>
         Start / End Date
         </td>
         <td>
         
         <input type="text" style="font-weight:bolder" required id="StartDate" name="StartDate" placeholder="Choose Date" value="<?php echo (isset($Users['StartDate']))?$Users['StartDate']:''; 
			echo ""; ?>" >
             
          <?php //$detailstartdate = $this->detailentryencodemodel->get_detail_startdate($mycontract);?>
             <?php //echo form_dropdown('StartDate', $detailstartdate,'','class="StartDate" id="StartDate"'); ?> 
                 
         <script src="<?php echo base_url();?>js/jquery-ui.js"></script>
         
         
         
         <input type="text"  style="font-weight:bolder" id="EndDate" name="EndDate" placeholder="Choose Date">
             
         </td>
         </tr>   
		
      
          
         </td>
         </tr> <?php ?>
         
           
		<tr><td>
         Start / End Time
         </td>
         <td>
         <?php
         $optionst = array(
                  '00:00'  => '00:00',
                  '00:30'  => '00:30',
				  '01:00'  => '01:00',
				  '01:30'  => '01:30',
				  '02:00'  => '02:00',
				  '02:30'  => '02:30',
				  '03:00'  => '03:00',
				  '03:30'  => '03:30',
				  '04:00'  => '04:00',
				  '04:30'  => '04:30',
				  '05:00'  => '05:00',
				  '05:30'  => '05:30',
				  '06:00'  => '06:00',
				  '06:30'  => '06:30',
				  '07:00'  => '07:00',
                  '07:30'  => '07:30',
				  '08:00'  => '08:00',
				  '08:30'  => '08:30',
				  '09:00'  => '09:00',
				  '09:30'  => '09:30',
				  '10:00'  => '10:00',
				  '10:30'  => '10:30',
				  '11:00'  => '11:00',
				  '11:30'  => '11:30',
				  '12:00'  => '12:00',
				  '12:30'  => '12:30',
				  '13:00'  => '13:00',
				  '13:30'  => '13:30',
				  '14:00'  => '14:00',
				  '14:30'  => '14:30',
				  '15:00'  => '15:00',
				  '15:30'  => '15:30',
				  '16:00'  => '16:00',
				  '16:30'  => '16:30',
				  '17:00'  => '17:00',
				  '17:30'  => '17:30',
				  '18:00'  => '18:00',
				  '18:30'  => '18:30',
				  '19:00'  => '19:00',
				  '19:30'  => '19:30',
				  '20:00'  => '20:00',
				  '21:00'  => '21:00',
				  '21:30'  => '21:30',
				  '20:30'  => '20:30',
				  '22:00'  => '22:00',
				  '22:30'  => '22:30',
				  '23:00'  => '23:00',
				  '23:30'  => '23:30',
				  
                );

	
		  $js = 'id="StartTime"'; 
		echo form_dropdown('StartTime', $optionst, '00:00', $js);
        ?>     
         
         <?php
          $optionet = array(
                  '00:29'  => '00:29',
				  '00:59'  => '00:59',
                  '01:29'  => '01:29',
				  '01:59'  => '01:59',
				  '02:29'  => '02:29',
				  '02:59'  => '02:59',
				  '03:29'  => '03:29',
				  '03:59'  => '03:59',
				  '04:29'  => '04:29',
				  '04:59'  => '04:59',
				  '05:29'  => '05:29',
				  '05:59'  => '05:59',
				  '06:29'  => '06:29',
				  '06:59'  => '06:59',
				  '07:29'  => '07:29',
                  '07:59'  => '07:59',
				  '08:29'  => '08:29',
				  '08:59'  => '08:59',
				  '09:29'  => '09:29',
				  '09:59'  => '09:59',
				  '10:29'  => '10:29',
				  '10:59'  => '10:59',
				  '11:29'  => '11:29',
				  '11:59'  => '11:59',
				  '12:29'  => '12:29',
				  '12:59'  => '12:59',
				  '13:29'  => '13:29',
				  '13:59'  => '13:59',
				  '14:29'  => '14:29',
				  '14:59'  => '14:59',
				  '15:29'  => '15:29',
				  '15:59'  => '15:59',
				  '16:29'  => '16:29',
				  '16:59'  => '16:59',
				  '17:29'  => '17:29',
				  '17:59'  => '17:59',
				  '18:29'  => '18:29',
				  '18:59'  => '18:59',
				  '19:29'  => '19:29',
				  '19:59'  => '19:59',
				  '20:29'  => '20:29',
				  '21:29'  => '21:29',
				  '21:59'  => '21:59',
				  '20:59'  => '20:59',
				  '22:29'  => '22:29',
				  '22:59'  => '22:59',
				  '23:29'  => '23:29',
				  '23:59'  => '23:59',
				  
                );	
			
			
			
		$js1 = 'id="EndTime"'; 	
		echo form_dropdown('EndTime', $optionet, '6',$js1);
        ?>        
         </td>
         </tr>   
        
        <tr>
            <td>Distribution</td>
            <td>			
        <div id="smalltxt">    
          Mo <input type="text" style=" font-weight:bolder" name="dmo">
          Tu <input type="text" style=" font-weight:bolder" name="dtu">
          We <input type="text" style=" font-weight:bolder" name="dwe">
         Th <input type="text" style=" font-weight:bolder" name="dth">
        </div>
		
         <br />
         <div id="smalltxt2">   
		 
          Fr <input type="text" style=" font-weight:bolder" name="dfr">
          Sa <input type="text" style=" font-weight:bolder" name="dsa">
          Su <input type="text" style=" font-weight:bolder" name="dsu">
          
         </div> 
          
              
          </td>
                     
            </tr>  
        
         <tr>
            <td>Make Good Days</td>
            <td>			
            <div id="checkme">
         						<br />
                                <?php 
							//	echo "Mo";
                                echo form_label('Mo', 'gdmo', $attributes); 
								echo form_checkbox($gdmo);
								echo "&nbsp;";echo "&nbsp;";
								//echo "Tu";
								echo form_label('Tu', 'gdtu', $attributes);
								echo form_checkbox($gdtu);
								echo "&nbsp;";echo "&nbsp;";
								//echo "We";
								echo form_label('We', 'gdwe', $attributes);
                                echo form_checkbox($gdwe);
								echo "&nbsp;";echo "&nbsp;";
								//echo "Th";
                                echo form_label('Th', 'gdth', $attributes);
								echo form_checkbox($gdth);
								echo "&nbsp;";echo "&nbsp;";
								//echo "Fr";
                                echo form_label('Fr', 'gdfr', $attributes);
								echo form_checkbox($gdfr);
								echo "&nbsp;";echo "&nbsp;";
                                ?>
                                
                                
								<?php 
								
                               // echo "Sa";echo "&nbsp;";
								echo form_label('Sa', 'gdsa', $attributes);
								echo form_checkbox($gdsa);
								echo "&nbsp;";
								//echo "Su";
                                echo form_label('Su', 'gdsu', $attributes);
								echo form_checkbox($gdsu);
								echo "&nbsp;";
								?>
                                
                               
								
								</div>
                                
                                
          		</td>
            <td>
            </td>
           
            </tr>
            
         <!--<tr>
            <td>Bonus Spots</td>
            <td>			
            
           <input type="text" name="Bonus"  width="2" ><br>
                                
          		</td>
            <td>
            </td>
            
            </tr>-->
            
           <tr>
            <td>Unit Price</td>
            <td>			
            
           <input type="text" name="UnitPrice" style=" font-weight:bolder" width="2" required="required" ><br>
                                
          		</td>
            <td>
            </td>
            
            </tr>
           
           <tr>
            <td>Priority</td>
            <td>			
            
          	 <?php
          $PriorityVal = array(
                  '1'  => '1',
				  '2'  => '2',
                  '3'  => '3',
				  '4'  => '4',
				  '5'  => '5',
				  
				  
                );	
			
			
			
		$js1 = 'id="Priority"'; 	
		echo form_dropdown('Priority', $PriorityVal, '6',$js1);
        ?>        
         </td>
          <br>
                                
          		</td>
            <td>
            </td>
            
            </tr>
            
            <tr>
            <td>Program Name</td>
            <td>			
            
           <input type="text" name="ProgramName" style=" font-weight:bolder" id="ProgramName" class="ProgramName" width="2" ><br>
                                
          		</td>
            <td>
            </td>
            
            </tr>
             
                <tr>
            <td>
            
            </td>
            <td>			
           <!-- <input type="submit" class="btn btn-primary btn-lg active" value="Add" onclick="javascript: closepopup()"/>-->
             <input type="submit" class="btn btn-primary btn-lg active" value="Add" onclick=""/>
                                
          		</td>
            <td>
           
            </td>
            
            </tr>
        
        </table>
        
		 <?php echo form_close(); ?>

	
   
		<br />
       
        <br />
        
        
			</div>
						
                        
                        
                        
                        
                        <?php echo form_close(); ?>
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
	



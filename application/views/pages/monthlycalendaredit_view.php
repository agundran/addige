     

<div id="page-content-wrapper">
   <div class="container-fluid">
        <div class="row">
             <div class="col-lg-12">
                  
                 <div id="container">    
						<div class="content">
                            <h3><?php echo $title; ?></h3>
                            <?php echo $message; ?>
                            <?php echo validation_errors(); ?>
							<?php echo form_open($action); ?>
									<div class="data">
										<table>
                                                <tr>
                                                    <td width="30%">
                                                    Year
                                                    </td>
                                                    <td>
                                                    
                      <?php
         $options = array(
                  2008   => '2008',
                  2009   => '2009',
                  2010   => '2010',
				  2011   => '2011',
				  2012   => '2012',
                  2013   => '2013', 
				  2014   => '2014',
                  2015   => '2015',
                  2016   => '2016',
				  2017   => '2017',
                  2018   => '2018', 
                  2019   => '2019',
                  2020   => '2020'
				 				  
             );
			 
		$year =  $Users['Year'];	 
		echo form_dropdown('Year', $options, $year);
        ?>                                    
                                                  
                                                  
                                                  
                                                  
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td width="30%">
                                                    Month
                                                    </td>
                                                    <td>
                                                    
        <?php
         $options = array(
                  1   => '1',
                  2   => '2',
                  3   => '3',
				  4   => '4',
                  5   => '5', 
				  6   => '6',
                  7   => '7',
                  8   => '8',
				  9   => '9',
                  10   => '10', 
                  11   => '11',
                  12   => '12',
				 				  
             );
			 
		$month =  $Users['Month'];	 
		echo form_dropdown('Month', $options, $month);
        ?>     
           
                                                  
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Start Week
                                                    </td>
                                                    <td>
                                         
                                                    <input type="text" name="Start_Week"  required class="text" value="<?php echo (isset($Users['Start_Week']))?$Users['Start_Week']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                     <tr>
                                                    <td>
                                                    End Week
                                                    </td>
                                                    <td>
                                                    <input type="text" name="End_Week"  required class="text" value="<?php echo (isset($Users['End_Week']))?$Users['End_Week']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                       <tr>
                                                    <td>
                                                    Start Date
                                                    </td>
                                                    <td>
 <script src="<?php echo base_url();?>js/jquery-ui.js"></script>
                                                     
 <script>
  $(function() {
    $( "#Start_Date" ).datepicker({
      dateFormat: "yy-mm-dd",
	  defaultDate: null,
      changeMonth: true,
      numberOfMonths: 2,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#End_Date" ).datepicker({
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
                                                      <input type="text" name="Start_Date"  id="Start_Date" class="text" value="<?php echo (isset($Users['Start_Date']))?$Users['Start_Date']:''; ?>"/>
                                                    
                                                   </td>
                                                    </tr>
                                                       <tr>
                                                    <td>
                                                    End Date
                                                    
                                                    
                                                    </td>
                                                    
                                                    
                                                    
                                                    <td>
                                                    <input type="text" name="End_Date" id="End_Date" class="text" value="<?php echo (isset($Users['End_Date']))?$Users['End_Date']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    <tr>
                                                   <td>
                                                   </td>
                                                   
                                                    <td><input type="submit" class="btn btn-primary btn-lg active" value="Save" /></td>
                                                  </tr>
                                               </table>
										</div>
									</form>
							<br />
						</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
		

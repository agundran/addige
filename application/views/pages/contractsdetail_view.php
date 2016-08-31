





<?php

$atts = array(
				
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'no',
              'status'     => 'no',
              'resizable'  => 'no',
              'screenx'   =>  '\'+((parseInt(screen.width) - 800)/2)+\'',
    		  'screeny'   =>  '\'+((parseInt(screen.height) - 600)/2)+\'',
            );




$pi = array(
								'name'        => 'pi',
								'id'          => 'pi',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								
							
								$pending = array(
								'name'        => 'pending',
								'id'          => 'pending',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$prepaid = array(
								'name'        => 'prepaid',
								'id'          => 'prepaid',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$filler = array(
								'name'        => 'filler',
								'id'          => 'filler',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$coop = array(
								'name'        => 'coop',
								'id'          => 'coop',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$eof = array(
								'name'        => 'eof',
								'id'          => 'eof',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$amg = array(
								'name'        => 'amg',
								'id'          => 'amg',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								



$attrib = $Users['Attributes'];
if ($attrib=="256") 
{
 // echo "All checkbox are FALSE";
 								$pi = array(
								'name'        => 'pi',
								'id'          => 'pi',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$pending = array(
								'name'        => 'pending',
								'id'          => 'pending',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$prepaid = array(
								'name'        => 'prepaid',
								'id'          => 'prepaid',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$filler = array(
								'name'        => 'filler',
								'id'          => 'filler',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$coop = array(
								'name'        => 'coop',
								'id'          => 'coop',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$eof = array(
								'name'        => 'eof',
								'id'          => 'eof',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
								$amg = array(
								'name'        => 'amg',
								'id'          => 'amg',
								'value'       => 'accept',
								'checked'     => FALSE,
								'style'       => 'margin:0px',
								);
								
 
}
elseif ($attrib=="257") 
{
 // echo "PI is TRUE";
  $pi = array(
								'name'        => 'pi',
								'id'          => 'pi',
								'value'       => 'accept',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
} 
elseif ($attrib=="260") 
{
 // echo "Pending is TRUE";
  $pending = array(
								'name'        => 'pending',
								'id'          => 'pending',
								'value'       => 'accept',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
  
} 
elseif ($attrib=="320") 
{
 // echo "Prepaid is TRUE";
  
  	$prepaid = array(
								'name'        => 'prepaid',
								'id'          => 'prepaid',
								'value'       => 'accept',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
} 
elseif ($attrib=="258") 
{
 // echo "Filler is TRUE";
  $filler = array(
								'name'        => 'filler',
								'id'          => 'filler',
								'value'       => 'accept',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
} 
elseif ($attrib=="272") 
{
 // echo "Coop is TRUE";
  
  $coop = array(
								'name'        => 'coop',
								'id'          => 'coop',
								'value'       => 'accept',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
} 
elseif ($attrib=="264") 
{
  //echo "EOF is TRUE";
  $eof = array(
								'name'        => 'eof',
								'id'          => 'eof',
								'value'       => 'accept',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
} 
elseif ($attrib=="288") 
{
  //echo "AMG is TRUE";
  $amg = array(
								'name'        => 'amg',
								'id'          => 'amg',
								'value'       => 'accept',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
} 
elseif ($attrib=="276") 
{
  //echo "Pending and Cooop are TRUE";
  
 								 $pending = array(
								'name'        => 'pending',
								'id'          => 'pending',
								'value'       => 'accept',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
								
								$coop = array(
								'name'        => 'coop',
								'id'          => 'coop',
								'value'       => 'accept',
								'checked'     => TRUE,
								'style'       => 'margin:0px',
								);
} 


else 
{
  echo "";
}


 
								
								
								
							?>
 <!-- Page Content -->
 
 
 
 <script type="text/javascript">
function myFunction(str) {
	

	
	//var osval = $('[name="SM"] option:selected')
   
   	var salesman = str;
	 
	<?php 
	
	 echo $_GET['salesman'];
	?>;
	
	
	
	
   		//alert (salesman);	
   	
	//var SMRate = 0;
	
	 // if (str == "Tony Lenzi") 
	 // {
        	//SMRate = 30;
      ///} 
	 // else if (str == "Big Seller") 
	 // {
      // SMRate = 20;
  	 // } 
  ///	
	
	
	
	
	
	
	//document.getElementById("Salesmanrate").value = htmlString;
	
	
	
	
	
}





</script>
 
 
 
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        
                       
                        <div id="container">
                        
							<div class="content">
		<center>
        <h3><?php echo $title; ?></h3>
		</center>
		<?php echo $message; ?>
		<?php echo validation_errors(); ?>
<?php echo form_open($action); ?>
		<div class="data">
		<table>
		  <tr>
          <th>
          Contract Header Record
          </th>
          <th>
          
          </th>
          </tr>
          <tr>
			<td>
              Customer &nbsp;&nbsp;&nbsp; 
           <?php echo anchor_popup('TrafficManageCustomers', 'Entry', $atts) ?>
			<td>
            
            <?php
              $customer_name = $this->contractsviewmodel->get_customer();
              ?>
                                         
                                       
               <?php
                                        
                $value =  $Users['Name'];                     
               echo form_dropdown('CustomerName', $customer_name, $value );
               ?>            
            
            </td> 
             
            </tr>
          <tr>
			<td>
            Contract &nbsp;&nbsp;&nbsp; Name
			<td>
            
            <input type="text" name="ContractName"     class="text" value="<?php echo (isset($Users['ContractName']))?$Users['ContractName']:''; ?>"/>  &nbsp;  
            </td> 
            
            </tr>
            
            
            <tr>
			<td>
            Start Date
            </td>
			        	
			<td>
             <?php
              $Start_Date = $this->contractsviewmodel->get_startdate();
              ?>
                                         
                                       
               <?php
                                        
                $valueDate =  $Users['StartDate'];                     
               echo form_dropdown('StartDate', $Start_Date, $valueDate );
               ?> 
            
            
            </td> 
            
            </tr>
			
             <tr>
			<td>
            End Date
            </td>
			        	
			<td>
             <?php
              $End_Date = $this->contractsviewmodel->get_enddate();
              ?>
                                         
                                       
               <?php
                                        
                $valueEndDate =  $Users['EndDate'];                     
               echo form_dropdown('EndDate', $End_Date, $valueEndDate );
               ?> 
            </td>  
            
            </tr>
            
             <tr>
			<td>
            Customer Order
            </td>
			        	
			<td><input type="text" name="CustOrder"     class="text" value="<?php echo (isset($Users['CustOrder']))?$Users['CustOrder']:''; ?>"/></td> 
            
            </tr>
			
            <tr>
			
			      
            <td>
            Discount &nbsp;&nbsp;&nbsp; Get Rate
            
            
            </td>
			  
                             	
			<td><input type="text" name="Discount"     class="text" value="<?php echo (isset($Users['Discount']))?$Users['Discount']:''; ?>"/></td> 
            
            </tr>
			
            <tr>
			<td>
            Agency 
               
            </td>
            
              	
			<td>
            
            	 <?php
              $agency = $this->contractsviewmodel->get_agency();
              ?>
                                         
                                       
               <?php
                                        
                $valuesagency =  $Users['Name'];                     
               echo form_dropdown('SMName', $agency, $valuesagency);
               ?> 
            
            
            </td> 
            
            </tr>
            
            <td>
            Get Rate
            &nbsp;&nbsp; <?php echo anchor_popup('TrafficManageAgencies', 'Entry', $atts) ?>
            </td>
			        	
			<td><input type="text" name="Rate"     class="text" value="<?php echo (isset($Users['Rate']))?$Users['Rate']:''; ?>"/></td> 
            
            </tr>
            
            <tr>
 			<td>
           Salesman 
              
            </td>
			        	
			<td>
             <?php
              $salesman = $this->contractsviewmodel->get_salesman();
              ?>
                                         
              <?php 
       
				//$valuesalesman = 'id = "valuesalesman"';
                //$valuesalesman =  $Users['Name'];                     
               //echo form_dropdown('SM', $salesman, $valuesalesman, 'onchange="myFunction(this.value)"');
			   	 // echo form_dropdown('SM', $salesman, $valuesalesman, 'onchange="myFunction()"');
			  $js = 'id="sid" onChange="myFunction(this.value);"';

echo form_dropdown('shirts', $salesman, 'large', $js);
               ?> 
            </td> 
            
            </tr> 
            
              <tr>
             <td>
            Get Rate &nbsp;&nbsp;
            		<?php echo anchor_popup('TrafficManageSalesman', 'Entry', $atts) ?>
            </td>
			        	
			<td><input type="text" name="Salesmanrate" class="text" id="Salesmanrate"></td> 
            
            </tr> 
            
             <tr>
               <td>
            Min Separation
            </td>
			        	
			<td><input type="text" name="Minseparation"     class="text" value="<?php echo (isset($Users['City']))?$Users['City']:''; ?>"/></td> 
            
            </tr> 
            
            <tr>
            <td>
             Revision
            </td>
			        	
			<td><input type="text" name="Revision"     class="text" value="<?php echo (isset($Users['State']))?$Users['State']:''; ?>"/></td> 
            
            </tr>
                    
               <tr>
           <td>
             
            </td>
			        	
			<td><input type="text" name="Attributes" hidden   class="text" value="<?php echo (isset($Users['Attributes']))?$Users['Attributes']:''; ?>"/></td> 
            
            </tr>
                    
               <tr>
             	<td>
         Attributes
          </td><td>
          						<?php echo form_checkbox($pi); 
                                echo form_label('PI', 'pi');
								
								
								
								?>
                                
                                <?php echo form_checkbox($pending); 
                                echo form_label('Pending', 'pending');
								?>
                                
                                
								<?php echo form_checkbox($prepaid); 
                                echo form_label('Prepaid', 'prepaid');
								?>
                                
                                <?php echo form_checkbox($filler); 
                                echo form_label('Filler', 'filler');
								?>
                                
                                <br />
                                
                                	<?php echo form_checkbox($coop); 
                                echo form_label('COOP', 'coop');
								?>
                                
                                <?php echo form_checkbox($eof); 
                                echo form_label('EOF', 'eof');
								?>
                                <?php echo form_checkbox($amg); 
                                echo form_label('AMG', 'amg');
								?>
                                
          		</td>
            
            </tr>  
            
               
              
                     
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="btn btn-primary btn-lg active" value="Save"/></td>
			</tr>
           
            
		</table>
		</div>

	</form>
    <?php include("application/views/pages/template/ToggleBut.php"); ?>
<?php include("application/views/pages/template/ToggleButScript.php"); ?>

		<br />
        <?php echo $link_back; ?>
			</div>
						
                        
                        <?php echo form_close(); ?>
						<?php echo validation_errors('<p class="error">'); ?>  
                        <br  />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /#page-content-wrapper -->
	



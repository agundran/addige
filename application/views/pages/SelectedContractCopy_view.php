<script>

window.onunload = function(){
  window.opener.location.reload();
};

//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();


</script>									
					 <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        
                       
                        <div id="container">
                        
							<div class="content">
		<center>
        <h4>Selected contract to duplicate</h4>
        <h4> From Sequence : <?php echo $title; ?></h4>
		From Sitename : <?php echo $message; ?>
        </center>
		
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
             Seq:
 
			<td>
            
            <input type="text" name="Seq"     class="text" value="<?php echo (isset($Users['Seq']))?$Users['Seq']:''; ?>"/>
   
            </td> 
             
            </tr>
          <tr>
			<td>
            CIndex:
  
			<td>
            
            <input type="text" name="CIndex"     class="text" value="<?php echo (isset($Users['CIndex']))?$Users['CIndex']:''; ?>"/>  &nbsp;  
            </td> 
            
            </tr>
            
            
            <tr>
			<td>
            ContractName:
            </td>
			        	
			<td>
            <input type="text" name="ContractName"     class="text" value="<?php echo (isset($Users['ContractName']))?$Users['ContractName']:''; ?>"/>
            
            
            </td> 
            
            </tr>
			
             <tr>
			<td>
            SiteName:
      	    (Use CTRL + mouse left 
            click for multiple selection) 
            </td>
			        	
			<td>
             <?php $site_operator= $this->detailcontracttocopy_model->get_site();
			?>           				
            
            
            <div id="siteop">
           
		   <?php echo form_multiselect('siteoperator[ ]',$site_operator,'','required'); ?>
              <div>
            
            &nbsp;</td>  
            
            </tr>
            
             <tr>
			<td>
           StartDate:
            </td>
			        	
			<td><input type="text" name="StartDate"     class="text" value="<?php echo (isset($Users['StartDate']))?$Users['StartDate']:''; ?>"/>   &nbsp; </td> 
            
            </tr>
			
            <tr>
			
			      
            <td>
           EndDate:
            
            
            </td>
			  
                             	
			<td><input type="text" name="EndDate"     class="text" value="<?php echo (isset($Users['EndDate']))?$Users['EndDate']:''; ?>"/>  &nbsp; </td> 
            
            </tr>
			
            <tr>
			<td>
            AgencyComm:
            </td>
            
              	
			<td><input type="text" name="AgencyComm"     class="text" value="<?php echo (isset($Users['AgencyComm']))?$Users['AgencyComm']:''; ?>"/></td> 
            
            </tr>
            
            <td>
           Discount:
            </td>
			        	
			<td><input type="text" name="Discount"     class="text" value="<?php echo (isset($Users['Discount']))?$Users['Discount']:''; ?>"/></td> 
            
            </tr>
            
            <tr>
 			<td>
           AIndex:
            </td>
			        	
			<td>
             <input type="text" name="AIndex"     class="text" value="<?php echo (isset($Users['AIndex']))?$Users['AIndex']:''; ?>"/>
            </td> 
            
            </tr> 
            
              <tr>
             <td>
          	TotalValue:
            </td>
			        	
			<td><input type="text" name="TotalValue"     class="text" value="<?php echo (isset($Users['TotalValue']))?$Users['TotalValue']:''; ?>"/> 
  </td> 
            
            </tr> 
            
             <tr>
               <td>
            Attributes:
            </td>
			        	
			<td><input type="text" name="Attributes"     class="text" value="<?php echo (isset($Users['Attributes']))?$Users['Attributes']:''; ?>"/></td> 
            
            </tr> 
            
            <tr>
            <td>
             CustOrder:
            </td>
			        	
			<td><input type="text" name="CustOrder"     class="text" value="<?php echo (isset($Users['CustOrder']))?$Users['CustOrder']:''; ?>"/></td> 
            
            </tr>
                    
               <tr>
           <td>
             SIndex:
            </td>
			        	
			<td><input type="text" name="SalesComm"     class="text" value="<?php echo (isset($Users['SalesComm']))?$Users['SalesComm']:''; ?>"/>
  </td> 
            
            </tr>
                    
               <tr>
             	<td>
       MinSeparation:
          </td><td><input type="text" name="MinSeparation"     class="text" value="<?php echo (isset($Users['MinSeparation']))?$Users['MinSeparation']:''; ?>"/>
  
  </td>
            
            </tr> 
            
                   
               <tr>
             	<td>
      Revision:
          </td><td><input type="text" name="Revision"     class="text" value="<?php echo (isset($Users['Revision']))?$Users['Revision']:''; ?>"/></td>
            
            </tr>  
            
            
               
              
                     
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="btn btn-primary btn-lg active" value="Copy"/></td>
			</tr>
           
            
		</table>
		
		</div>

	</form>
    <?php include("application/views/pages/template/ToggleBut.php"); ?>
<?php include("application/views/pages/template/ToggleButScript.php"); ?>

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
    <!-- /#page-content-wrapper -->
	
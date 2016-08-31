
 <!-- Page Content -->
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
			<td>
            Site Name
			<td><input type="text" name="SiteName"  required class="text" value="<?php echo (isset($Users['SiteName']))?$Users['SiteName']:''; ?>"/></td> 
            
            </tr>
            
            
            <tr>
            <td>
            Operator Name
            </td>
            <td>
            <?php
            $operator_name = $this->sitetooperatormodel->get_operator();
            ?>
           	 
           
            <?php
            echo form_dropdown('Operator', $operator_name);
            ?>
            
            </td>
            
            </tr>
                       
            <tr>
			<td>
            Record Format
            </td>
			        	
			<td><input type="text" name="Format"  required class="text" value="<?php echo (isset($Users['Format']))?$Users['Format']:''; ?>"/></td> 
            
            </tr>
			
             <tr>
			<td>
            Remote File
            </td>
			        	
			<td><input type="checkbox" name="UseFTP"  class="text" value="<?php echo (isset($Users['UseFTP']))?$Users['UseFTP']:''; ?>"/></td> 
            
            </tr>
            
             <tr>
			<td>
            Site Key
            </td>
			        	
			<td><input type="text" name="SiteKey"  required class="text" value="<?php echo (isset($Users['SiteKey']))?$Users['SiteKey']:''; ?>"/></td> 
            
            </tr>
			
            <tr>
			
			      
                  	<td>
            Head End Number
            </td>
			        	
			<td><input type="text" name="HENumber"  required class="text" value="<?php echo (isset($Users['HENumber']))?$Users['HENumber']:''; ?>"/></td> 
            
            </tr>
			
            <tr>
			<td>
            SysCode
            </td>
            
              	
			<td><input type="text" name="SysCode"  required class="text" value="<?php echo (isset($Users['SysCode']))?$Users['SysCode']:''; ?>"/></td> 
            
            </tr>
            
            <td>
            Contact
            </td>
			        	
			<td><input type="text" name="Contact"   class="text" value="<?php echo (isset($Users['Contact']))?$Users['Contact']:''; ?>"/></td> 
            
            </tr>
            
            <tr>
 			<td>
            Address 1
            </td>
			        	
			<td><input type="text" name="Address1"  required class="text" value="<?php echo (isset($Users['Address1']))?$Users['Address1']:''; ?>"/></td> 
            
            </tr> 
            
              <tr>
             <td>
            Address 2
            </td>
			        	
			<td><input type="text" name="Address2"   class="text" value="<?php echo (isset($Users['Address2']))?$Users['Address2']:''; ?>"/></td> 
            
            </tr> 
            
             <tr>
               <td>
            City
            </td>
			        	
			<td><input type="text" name="City"  required class="text" value="<?php echo (isset($Users['City']))?$Users['City']:''; ?>"/></td> 
            
            </tr> 
            
            <tr>
            <td>
              State
            </td>
			        	
			<td><input type="text" name="State"  required class="text" value="<?php echo (isset($Users['State']))?$Users['State']:''; ?>"/></td> 
            
            </tr>
                    
               <tr>
             <td>
             Zip
            </td>
			        	
			<td><input type="text" name="Zip"   class="text" value="<?php echo (isset($Users['Zip']))?$Users['Zip']:''; ?>"/></td> 
            
            </tr>     
              <tr>
             <td>
             Rev Split  (XX.X)
            </td>
			        	
			<td><input type="text" name="RevSplit"   class="text" value="<?php echo (isset($Users['RevSplit']))?$Users['RevSplit']:''; ?>"/></td> 
            
            </tr>      
                     
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="btn btn-primary btn-lg active" value="Save"/></td>
			</tr>
           
            
		</table>
		</div>

	</form>


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
	


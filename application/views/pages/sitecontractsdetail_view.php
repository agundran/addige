
 <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?php include("application/views/pages/template/ToggleBut.php"); ?>
                       
                        <div id="container">
                        
							<div class="content">
		<h3><?php echo $title; ?></h3>
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
            Customer Entry
			<td><input type="text" name="SiteName"  required class="text" value="<?php echo (isset($Users['SiteName']))?$Users['SiteName']:''; ?>"/></td> 
            
            </tr>
            
            
            <tr>
            <td>
            Contract Name
            </td>
            <td>
            
            </td>
            
            </tr>
                       
            <tr>
			<td>
            Start Date
            </td>
			        	
			<td><input type="text" name="Format"  required class="text" value="<?php echo (isset($Users['Format']))?$Users['Format']:''; ?>"/></td> 
            
            </tr>
			
             <tr>
			<td>
            End Date
            </td>
			        	
			<td><input type="checkbox" name="UseFTP"  class="text" value="<?php echo (isset($Users['UseFTP']))?$Users['UseFTP']:''; ?>"/></td> 
            
            </tr>
            
             <tr>
			<td>
            Customer Order
            </td>
			        	
			<td><input type="text" name="SiteKey"  required class="text" value="<?php echo (isset($Users['SiteKey']))?$Users['SiteKey']:''; ?>"/></td> 
            
            </tr>
			
            <tr>
			
			      
            <td>
            Discount 
            </td>
			        	
			<td><input type="text" name="HENumber"  required class="text" value="<?php echo (isset($Users['HENumber']))?$Users['HENumber']:''; ?>"/></td> 
            
            </tr>
			
            <tr>
			<td>
            Agency
            </td>
            
              	
			<td><input type="text" name="SysCode"  required class="text" value="<?php echo (isset($Users['SysCode']))?$Users['SysCode']:''; ?>"/></td> 
            
            </tr>
            
            <td>
            Get Rate
            </td>
			        	
			<td><input type="text" name="Contact"  required class="text" value="<?php echo (isset($Users['Contact']))?$Users['Contact']:''; ?>"/></td> 
            
            </tr>
            
            <tr>
 			<td>
           Salesman
            </td>
			        	
			<td><input type="text" name="Address1"  required class="text" value="<?php echo (isset($Users['Address1']))?$Users['Address1']:''; ?>"/></td> 
            
            </tr> 
            
              <tr>
             <td>
            Get Rate
            </td>
			        	
			<td><input type="text" name="Address2"  required class="text" value="<?php echo (isset($Users['Address2']))?$Users['Address2']:''; ?>"/></td> 
            
            </tr> 
            
             <tr>
               <td>
            Min Separation
            </td>
			        	
			<td><input type="text" name="City"  required class="text" value="<?php echo (isset($Users['City']))?$Users['City']:''; ?>"/></td> 
            
            </tr> 
            
            <tr>
            <td>
             Revision
            </td>
			        	
			<td><input type="text" name="State"  required class="text" value="<?php echo (isset($Users['State']))?$Users['State']:''; ?>"/></td> 
            
            </tr>
                    
               <tr>
             <td>
             Attributes
            </td>
			        	
			<td><input type="text" name="Zip"  required class="text" value="<?php echo (isset($Users['Zip']))?$Users['Zip']:''; ?>"/></td> 
            
            </tr>     
              <tr>
             <td>
             Rev Split  (XX.X)
            </td>
			        	
			<td><input type="text" name="RevSplit"  required class="text" value="<?php echo (isset($Users['RevSplit']))?$Users['RevSplit']:''; ?>"/></td> 
            
            </tr>      
                     
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" class="btn btn-primary btn-lg active" value="Save"/></td>
			</tr>
           
            
		</table>
		</div>

	</form>


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
	<?php include("application/views/pages/template/ToggleButScript.php"); ?>



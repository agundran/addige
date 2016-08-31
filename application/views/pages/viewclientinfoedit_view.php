
 <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                       
                       
                        <div id="container">
                        
							<div class="content">
		<h4><?php echo $title; ?></h4>
		<?php echo $message; ?>
		<?php echo validation_errors(); ?>
<?php echo form_open($action); ?>
		<div class="data">
		<table>
		
            <tr>
				<td valign="top">Email</td>
			
   	         <td><input type="text" name="EmailAddress"  required class="text" value="<?php echo (isset($Users['EmailAddress']))?$Users['EmailAddress']:''; ?>"/></td> 
            
            </tr>
			
              <tr>
				<td valign="top">Address 1</td>
			
   	         <td><input type="text" name="Address1"   class="text" value="<?php echo (isset($Users['Address1']))?$Users['Address1']:''; ?>"/></td> 
            
            </tr>
            
                 <tr>
				<td valign="top">Address 2</td>
			
   	         <td><input type="text" name="Address2"   class="text" value="<?php echo (isset($Users['Address2']))?$Users['Address2']:''; ?>"/></td> 
            
            </tr>
            
                    
             <tr>
				<td valign="top">City</td>
			
   	         <td><input type="text" name="City"  class="text" value="<?php echo (isset($Users['City']))?$Users['City']:''; ?>"/></td> 
            
            </tr>
             <tr>
				<td valign="top">State</td>
			
   	         <td><input type="text" name="State"   class="text" value="<?php echo (isset($Users['State']))?$Users['State']:''; ?>"/></td> 
            
            </tr>
      
                   
             <tr>
				<td valign="top">Zip</td>
			
   	         <td><input type="text" name="Zip"   class="text" value="<?php echo (isset($Users['Zip']))?$Users['Zip']:''; ?>"/></td> 
            
            </tr>
            
               <tr>
				<td valign="top">Country</td>
			
   	         <td><input type="text" name="Country"   class="text" value="<?php echo (isset($Users['Country']))?$Users['Country']:''; ?>"/></td> 
            
            </tr>
            
               <tr>
				<td valign="top">Region</td>
			
   	         <td><input type="text" name="Region"   class="text" value="<?php echo (isset($Users['Region']))?$Users['Region']:''; ?>"/></td> 
            
            </tr>
            
               <tr>
				<td valign="top">Telephone</td>
			
   	         <td><input type="text" name="Telephone"   class="text" value="<?php echo (isset($Users['Telephone']))?$Users['Telephone']:''; ?>"/></td> 
            
            </tr>
                      <tr>
				<td valign="top">IP Address</td>
			
   	         <td><input type="text" name="IPAddress"   class="text" value="<?php echo (isset($Users['IPAddress']))?$Users['IPAddress']:''; ?>"/></td> 
            
            </tr>
            
            		<td valign="top">Sub Count (000's):</td>
			
   	         <td><input type="text" name="SubCount"   class="text" value="<?php echo (isset($Users['SubCount']))?$Users['SubCount']:''; ?>"/></td> 
            
            </tr>
            		<td valign="top">Resources</td>
			
   	         <td><input type="text" name="Resources"   class="text" value="<?php echo (isset($Users['Resources']))?$Users['Resources']:''; ?>"/></td> 
            
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



  
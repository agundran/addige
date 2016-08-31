
<script>

window.onunload = function(){
  window.opener.location.reload();
};


</script>


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
                                                    Description
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Description" required class="text" value="<?php echo (isset($Users['Description']))?$Users['Description']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td width="30%">
                                                    Number
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Number"  required class="text" value="<?php echo (isset($Users['Number']))?$Users['Number']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Seconds Per Hour
                                                    </td>
                                                    <td>
                                                    <input type="text" name="TimeAvail"  required class="text" value="<?php echo (isset($Users['TimeAvail']))?$Users['TimeAvail']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                     <tr>
                                                    <td>
                                                    Preroll (ms)
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Preroll"  required class="text" value="<?php echo (isset($Users['Preroll']))?$Users['Preroll']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                       <tr>
                                                    <td>
                                                    Contact (Yes; 1/No;0)
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Contact"  class="text" value="<?php echo (isset($Users['Contact']))?$Users['Contact']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    Number of Cue Tones
                                                    </td>
                                                    <td>
                                                    <input type="text" name="nCues"  required class="text" value="<?php echo (isset($Users['nCues']))?$Users['nCues']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    Cue Tones 1 Start Time
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Min1"  required class="text" value="<?php echo (isset($Users['Min1']))?$Users['Min1']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                    <td>
                                                    Cue Tones 1 End Time
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Max1"  required class="text" value="<?php echo (isset($Users['Max1']))?$Users['Max1']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                   <tr>
                                                    <td>
                                                    Break Length
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Length1"  required class="text" value="<?php echo (isset($Users['Length1']))?$Users['Length1']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                   
                                                     <tr>
                                                    <td>
                                                    DTMF Code
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Code1"  class="text" value="<?php echo (isset($Users['Code1']))?$Users['Code1']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                                   
                                                    <tr>
                                                    <td>
                                                    Cue Tone 2 Start Time
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Min2"  class="text" value="<?php echo (isset($Users['Min2']))?$Users['Min2']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                                   
                                                    <tr>
                                                    <td>
                                                    Cue Tone 2 End Time
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Max2"  class="text" value="<?php echo (isset($Users['Max2']))?$Users['Max2']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                                   
                                                    <tr>
                                                    <td>
                                                    Break Length
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Length2"  class="text" value="<?php echo (isset($Users['Length2']))?$Users['Length2']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                                   
                                                    <tr>
                                                    <td>
                                                    DTMF Code
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Code2"  class="text" value="<?php echo (isset($Users['Code2']))?$Users['Code2']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                                   
                                                    <tr>
                                                   	<td>
                                                    NCC Alias
                                                    </td>
                                                    <td>
                                                    <input type="text" name="NCCAlias"  class="text" value="<?php echo (isset($Users['NCCAlias']))?$Users['NCCAlias']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                                   
                                                    <tr>
                                                    <td>
                                                    Exclusion (Yes;1/No;0)
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Exclusion"  class="text" value="<?php echo (isset($Users['Exclusion']))?$Users['Exclusion']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                        
                                                                   
                                                    <tr>
                                                    <td>
                                                    Start Exclusion (HH:MM)
                                                    </td>
                                                    <td>
                                                    <input type="text" name="StartExclusion"  class="text" value="<?php echo (isset($Users['StartExclusion']))?$Users['StartExclusion']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                        
                                                                   
                                                    <tr>
                                                    <td>
                                                    End Exclusion (HH:MM)
                                                    </td>
                                                    <td>
                                                    <input type="text" name="EndExclusion"  class="text" value="<?php echo (isset($Users['EndExclusion']))?$Users['EndExclusion']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                        
                                                                   
                                                    <tr>
                                                    <td>
                                                    Name
                                                    </td>
                                                    <td>
                                                    <input type="text" name="Name"  class="text" value="<?php echo (isset($Users['Name']))?$Users['Name']:''; ?>"/>
                                                   </td>
                                                    </tr>
                                                    
                                                    
                                                                   
                                                    <tr>
                                                    
                                                        <td>&nbsp;</td>
                                                        <td><input type="submit"  class="btn btn-primary btn-lg active" value="Save"/></td>
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
		

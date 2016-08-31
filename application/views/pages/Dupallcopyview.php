
<script>
//Nav Bar Collapse Open when click ManageUser & Operators
$('#Traffic, #ManageOrders').addClass('open');
$('#Traffic, #ManageOrders').children('ul').slideDown();

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
        
	
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" type="text/css" />
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>

<script type="text/javascript" src="http://davidstutz.github.io/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="http://davidstutz.github.io/bootstrap-multiselect/dist/css/bootstrap-multiselect.css" type="text/css"/>                         
	  
      
	 
       
       
       
    <div id="container">
    
 
		<center>
        <h3>Master Copy</h3>
		<div class="data"><?php echo $table; ?></div>
        </center>
        <?php echo form_open($action); ?>
		

		<fieldset>
		
		
		<table>
			
            
         
         <td>
        <?php $site_operator= $this->copyentryencodemodel->get_site($contractname, $seq);?>           				
      
         <?php echo form_multiselect('siteoperator[]',$site_operator,'','required id="siteoperator"' ); ?>
     
     
     
     	 <script type="text/javascript">
     $(document).ready(function() {
        $('#siteoperator').multiselect({
            includeSelectAllOption: true,
			enableFiltering: true
			
        });
    });
		</script>
       
     
         </td>
         
         <tr>
          <td>
           <input type="submit" class="btn btn-primary btn-lg active" value="Duplicate" />
          </td>
          
         </tr>
                
		</table>
        
     
       
       
       
       
       
		</form>
	</fieldset>
</div>
    
	
       	
    
	
    	
    
    
    
   
    
    

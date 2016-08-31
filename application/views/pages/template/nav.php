
	
	
<body>
	<?php
	
	$atts = array(
				
              'width'      => '800',
              'height'     => '600',
              'scrollbars' => 'yes',
              'status'     => 'yes',
              'resizable'  => 'no',
              'screenx'   =>  '\'+((parseInt(screen.width) - 800)/2)+\'',
    		  'screeny'   =>  '\'+((parseInt(screen.height) - 600)/2)+\'',
            );

	
	
	
	?>
	
    
	<script src="<?php echo base_url(); ?>js/jquery-1.11.0.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
 	<script src="<?php echo base_url(); ?>js/script.js"></script>
    <script src="<?php echo base_url(); ?>js/mypopup.js"></script>
    
    
   	 <script src="<?php echo base_url(); ?>js/jquery.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.dataTables.js"></script>
        <script src="<?php echo base_url(); ?>js/DT_bootstrap.js"></script>
              
              
	
	<script type="text/javascript">
			 
		
		
	var Rolename = "<?php echo $Role; ?>";
	
	if(Rolename == "Administrators")					
	$(document).ready(function() 
	{
   			 $('#InsertionDetail,#ChangePassword,#Sitemap').hide();
	});
		
	else if(Rolename == "Operators")
		
	$(document).ready(function() 
	{
   			$('#Admin,#InsertionDetail,#ChangePassword,#Sitemap').hide();
	}
	);
	else if(Rolename == "Cablesystems")
		
	$(document).ready(function() 
	{
   			 $('#Admin,#Traffic,#Utilities').hide();
	}
	);
	
	
	else
		document.write("Access Denied!"); 
			
			
		
	
	var myWindow;

    function openWin() {
        myWindow = window.open('http://192.168.1.253:81/xml_import3/xml_import.php', 'XML Importer', 'width=612,height=380,scrollbars=0');
    }

    function checkWin() {
        if (!myWindow) {
            openWin();
        } else {
            if (myWindow.closed) {
                openWin();
            } else {
                alert('XML Importer window is already opened.');
                myWindow.focus();
            }
        }
    }
	
	
	
	
    </script> 
    
    
    <div id="wrapper">
        <div id="sidebar-wrapper">
        		<div id="cssmenu">
            		<ul>	
           		 <li>
                        <a href='#'><font size="2" face="verdana" color= "black">Welcome:
                        	<font size="2" face="verdana" color="yellow">
                        	<span><?php echo $this->session->userdata('username'); ?></span>
                        	</font>
                            <br>
                            Privileges:  <font size="2" face="verdana" color="yellow">
                        	<span><?php echo $this->session->userdata('role'); ?></span>
                        	</a>
                            
                            </font>
                     	</font>         
                 </li>
                 <?php $data['Role']=$this->session->userdata('role') ?>
                 <li><a href="<?php echo site_url("site/".$data['Role']) ?>"><span><i class="fa fa-home" style="color:#000"></i> Home</span></a></li>
                 <li class='active has-sub' id="Admin"><a href='#'><span><i class="fa fa-users" style="color:#000"></i> Administration</span></a>
                    		<ul>
                       			<li class='has-sub' id="AdminManagement"><a href='#'><span>MANAGEMENT</span></a>
                                    	<ul>
                                        	<li><a href="<?php echo site_url("manageuserlist") ?>">Manage Users</a></li>
                                        	<li class='last'><a href="<?php echo site_url("manageoperatorlist") ?>"><span>Manage Operators</span></a></li>
                                         
                                    	</ul>
                       			</li>
                       			<li class='has-sub' id="SiteManagement"><a href='#'><span>SITE MANAGEMENT</span></a>
                                    	<ul>
                                        	<li><a href="<?php echo site_url("broadcastcalendar") ?>"><span>Broadcast Calendar</span></a></li>
                                            <li><a href="<?php echo site_url("monthlycalendar") ?>"><span>Monthly Calendar</span></a></li>
                                            <li><a href="<?php echo site_url("sitetooperator") ?>"><span>Assign Sites to Operators</span></a></li>
     
                                            <li class='last'><a href="<?php echo site_url("viewclientinfo") ?>"><span>View Client Info</span></a></li>
                                        	<li class='last'><a href="<?php echo site_url("portoffset") ?>"><span>Cue Port Offsets</span></a></li>
                                        	<li class='last'><a href="<?php echo site_url("managesiteissue") ?>"><span>Manage Site Issues</span></a></li>
                                    	</ul>
                       			</li>
                            	<li class='has-sub' id="Network"><a href="#"><span>NETWORKS</span></a>
                            			<ul>
                                   			<li><a href="<?php echo site_url("CueEntrylist") ?>"><span>Cue Entry</span></a></li>
                                        	<li class='last'><a href="<?php echo site_url("mappinglist") ?>"><span>Mapping</span></a></li>
                                        	<li class='last'><a href="<?php echo site_url("Cuesources") ?>"><span>Cue Sources</span></a></li>
                          				</ul>
                       			</li>
                     		</ul>
                  </li>
                  <li class='active has-sub' id="Traffic"><a href='#'><span><i class="fa fa-cab" style="color:#000"></i> Traffic</span></a>
                  	    	<ul>
                       				<li class='has-sub' id="ManageOrders"><a href='#'><span>MANAGE ORDERS</span></a>
                                    	<ul>
                                        <li><a class="initChat" onClick="checkWin()"> <span>XML Importer </span></a></li>
                                        	<li><a href="<?php echo site_url("orderentry") ?>"><span>Order Entry</span></a></li>
                                            <li class='last'><a href='<?php echo site_url("selectsite") ?>'><span>Per Site Contracts</span></a></li>
                                                         <li class='last'><a href='<?php echo site_url("pendingtesting2") ?>'><span>Pending Contracts</span></a></li>
                                          
                                        	
                                        	<li class='last'><a href='<?php echo site_url("orderdup") ?>'><span>Order Duplication</span></a></li>
                                            
                               


                                    	</ul>
                       				</li>


		                                    
                       				<li class='has-sub' id="ManageFiles"><a href='#'><span>MANAGE FILES</span></a>
                                    	<ul>
                                        	<li class='last'><a href="<?php echo site_url("TrafficManageAgencies") ?>"><span>Manage Agency</span></a></li>
                                        	
                                        	<li class='last'><a href="<?php echo site_url("TrafficManageCustomers") ?>"><span>Manage Customers</span></a></li>
                                        	<li class='last'><a href="<?php echo site_url("TrafficManageSalesman") ?>"><span>Manage Salesman</span></a></li>
                                           
                                            
                                   		</ul>
                       				</li>
                            		<li class='has-sub' id="Reports"><a href="#"><span>REPORTS</span></a>
                            			<ul>
                                            <!--<li><a href='#'><span>Completion Rates</span></a></li>-->
                                           
                                          <!--  <li class='last'><a href='#'><span>Missing Spots</span></a></li>
                                            <li class='last'><a href='<?php echo site_url("missinglogsSetMonth") ?>'><span>Missing Logs</span></a></li> -->
                                           
                                            <!--<li class='last'><a href='#'><span>Late Contracts</span></a></li>
                                            <li class='last'><a href='#'><span>Lost Revenue</span></a></li>
                                            <li class='last'><a href='#'><span>Inventory Status</span></a></li>-->
                                            
                                              <li class='last'><a href='<?php echo site_url("missingspots") ?>'><span>Missing Spots</span></a></li>
                                            <li class='last'><a href='<?php echo site_url("booking") ?>'><span>Booked Revenue (broadcast)</span></a></li>
                                             <li class='last'><a href='<?php echo site_url("booking_monthly") ?>'><span>Booked Revenue(monthly)</span></a></li>
                                            <!--<li class='last'><a href='<?php echo site_url("ztest") ?>'><span>Test</span></a></li>
                                            <li class='last'><a href='#'><span>Schedule Generator Log</span></a></li>
                                            <li class='last'><a href='#'><span>Event File Generator Log</span></a></li>-->
                          				</ul>
                       				</li>
                     		</ul>
                            		
                  </li>
                  <li class='active has-sub' id="Billing"><a href='#'><span><i class="fa fa-dollar" style="color:#000"></i> Billing</span></a>
                  	    	<ul>
                       			<li class=''><a href="<?php echo site_url("BillingSetInvoicingMonth") ?>"><span>SET INVOICING MONTH (Broadcast Calendar)</span></a></li>
                                <li class=''><a href="<?php echo site_url("BillingSetInvoicingMonthMonthly") ?>"><span>SET INVOICING MONTH (Monthly Calendar)</span></a></li>
                                
                               
                                
                                
                       			<li class='has-sub' id="Invoicing"><a href='#'><span>INVOICING</span></a>
                                    <ul>
                                    <!-- <li class=''><a href="<?php echo site_url("billedset") ?>"><span>Billing Summary</span></a></li>-->
                                        <li><a href="<?php echo site_url("invoicingbycustomer") ?>"><span>Hardcopy Billing (Broadcast)</span></a></li>
                                        <li><a href="<?php echo site_url("invoicingbycustomermonthly") ?>"><span>Hardcopy Billing (Monthly)</span></a></li>
                                        
                                        <!--
                                        <li><a href="<?php echo site_url("invoicing") ?>"><span>Hardcopy Billing Summary</span></a></li>
                                        -->
                                        
                                        <li class='last'><a href="<?php echo site_url("ebillsummary") ?>"><span>Electronic Billing</span></a></li>
                                    </ul>
                       			</li>
                            	<li class='has-sub' id="legacy"><a href="#"><span>LEGACY</span></a>
                            		<ul>
                                    <li class='last' ><a href="<?php echo site_url("billedset") ?>"><span>Create Invoices / Logs Summary</span></a></li>
                                   		 <li class='last' ><a href="<?php echo site_url("legacysetcustomer") ?>"><span>Create Invoices / Logs by Customer</span></a></li>
                                        <li class='last' ><a href="<?php echo site_url("legacyset") ?>"><span>Create Invoices / Logs by Site Name</span></a></li>			
                                       	<li class='last' ><a href="<?php echo site_url("legacysetcontractname") ?>"><span>Create Invoices / Logs by Contract Name</span></a></li>
                                        <li class='last' ><a href="<?php echo site_url("legacysetcontractno") ?>"><span>Create Invoices / Logs by Contract No.</span></a></li>
                                        
                                        
                                         <li class='last' ><a href="<?php echo site_url("generatebillingbycust") ?>"><span>Generate Billing by Cust</span></a></li>				
                                         <li class='last' ><a href="<?php echo site_url("generatebilling") ?>"><span>Generate Billing</span></a></li>				
                                        <!--<li class='last'><a href='#'><span>End of Flight Invoicing</span></a></li>
                                        <li class='last'><a href='#'><span>File Download</span></a></li>-->
                          			</ul>
                       			</li>
                     		</ul>
                            		
                  	</li>
                    <li class='active has-sub' id="Utilities"><a href='#'><span><i class="fa fa-gear" style="color:#000"></i> Utilities</span></a>
                  	    	<ul>
                       			<li class='has-sub'><a href='#'><span>INSERTION STATS</span></a>
                                    <ul>
                                        <li><a href="<?php echo site_url("insertionsummarylist") ?>"><span>Insertion Summary</span></a></li>
                                        <li class='last'><a href='#'><span>Insertion Detail</span></a></li>
                                        <li class='last'><a href='#'><span>Active Cues</span></a></li>
                                    </ul>
                       			</li>
                       			<li class='has-sub'><a href='#'><span>MONITORING</span></a>
                                    <ul>
                                        <li><a href='#'><span>Alarm Conditions</span></a></li>
                                        <li class='last'><a href='#'><span>Detailed Report</span></a></li>
                                    </ul>
                       			</li>
                               
                             <!--   <li class='has-sub'><a href="#"><span>CLEAR CACHE</span></a>
                            		<ul>
                                    	<li><a href="<?php echo site_url("clearcachegb") ?>"><span>Clear Billing Cache </span></a></li>
                                   		<li><a href="<?php echo site_url("clearcache") ?>"><span>Clear All Cache </span></a></li>
                                   </ul>-->
                                    
                            	<li class='has-sub'><a href="#"><span>OTHERS</span></a>
                            		<ul>
                                   		<!--<li><a href="<?php echo site_url("clearcache") ?>"><span>Clear Cache</span></a></li>-->
                                        <li><a href='#'><span>Client Map</span></a></li>
                                        
                                        <li class='last'><a href='#'><span>Change Password</span></a></li>
                                        
                                        <li class='last'><a href="<?php echo site_url("sitemap/".$data['Role']) ?>"><span>Site Map</span></a></li>
                                      <li><a href="<?php echo site_url("ControllerAudittrail") ?>"><span>Audit Trail</span></a></li>
                                      
                                      
                                  
                                    
                                    
                                    </ul>
                                    
                                    
                                    
                       			</li>
                     		</ul>
                            		
                  </li>
                 
                  	<li class='' id="InsertionDetail"><a href='#'><span><i class="fa fa-long-arrow-up" style="color:#000"></i> Insertion Detail</span></a></li>
                    <li class='' id="ChangePassword"><a href='#'><span><i class="fa fa-cogs" style="color:#000"></i> Change Password</span></a></li>
                    <li class='' id="Sitemap"><a href="<?php echo site_url("sitemap/".$data['Role']) ?>"><span><i class="fa fa-sitemap" style="color:#000"></i> Site Map</span></a></li>
                   <li><a  href="<?php echo site_url("site/logout")?> "><i class="fa fa-sign-out" style="color:#000"></i> Logout</a></li>
                   
                  
                  
                  <li class='last'><a href="<?php echo site_url("ztest") ?>"><span><i class="fa fa-wrench" style="color:#000"></i> Test  </span></a></li>
                  
                  <!--
                   <li class='last'><a href="<?php echo site_url("legacysetcustomer1") ?>"><span><i class="fa fa-wrench" style="color:#000"></i> Legacy Billing Test  </span></a></li>
                  --> 
                   
            			</ul>
                </div>         
        </div>   
        
        

</body>
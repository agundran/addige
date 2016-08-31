

	<title>Techlister.com - jQuery Tree view without plugin</title>
	 <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
	<script src="http://code.jquery.com/jquery-1.7.2.min.js" type="text/javascript" > </script>
	
	<script type="text/javascript">

		$( document ).ready( function( ) {
				$( '.tree li' ).each( function() {
						if( $( this ).children( 'ul' ).length > 0 ) {
								$( this ).addClass( 'parent' );     
						}
				});
				
				$( '.tree li.parent > a' ).click( function( ) {
						$( this ).parent().toggleClass( 'active' );
						$( this ).parent().children( 'ul' ).slideToggle( 'fast' );
				});
				
				$( '#all' ).click( function() {
					
					$( '.tree li' ).each( function() {
						$( this ).toggleClass( 'active' );
						$( this ).children( 'ul' ).slideToggle( 'fast' );
					});
				});
				
		});
        
	</script>


	

<div class="tree">
		
		
<ul>
		<button id="all">Collapse All</button>
		<li><a>Home</a>
        		<ul>
                
                
				<li><a>Traffic</a>
					<ul>
						<li><a>Manage Orders</a>
                            <ul>
                                <li><a href="<?php echo site_url("contractsview") ?>"><span>Order Entry / Edit</span></a></li>
                                <li class='last'><a href='<?php echo site_url("selectsite") ?>'><span>Per Site Contracts</span></a></li>
                                        	<li class='last'><a href='<?php echo site_url("selectsite2") ?>'><span>Pending Contracts</span></a></li>
                                        	<li class='last'><a href='#'><span>Order Duplication</span></a></li>
                            </ul>	
                        </li>
                        <li><a>Manage Files</a>
                        	<ul>
                                <li class='last'><a href="<?php echo site_url("TrafficManageAgencies") ?>"><span>Manage Agency</span></a></li>
                                        	
                                        	<li class='last'><a href="<?php echo site_url("TrafficManageCustomers") ?>"><span>Manage Customers</span></a></li>
                                        	<li class='last'><a href="<?php echo site_url("TrafficManageSalesman") ?>"><span>Manage Salesman</span></a></li>
                            </ul>
                        
                        </li>
                        <li><a>Reports</a>
                       		<ul>
                                <li><a>Completion Rates</a></li>
                                <li><a>Missing Spots</a></li>
                                <li><a>Missing Logs</a></li>
                                <li><a>Late Contracts</a></li>
                                <li><a>Lost Revenue</a></li>
                                <li><a>Inventory Status</a></li>
                                <li><a>Booked Revenue</a></li>
                                <li><a>Schedule Generator Log</a></li>
                                <li><a>Event File Generator Log</a></li>
                            </ul>
                        </li>
					</ul>
				</li>
		<li><a>Billing</a>
			<ul>
				<li class=''><a href="<?php echo site_url("BillingSetInvoicingMonth") ?>"><span>SET INVOICING MONTH</span></a></li>
					<li><a>Invoicing</a>
                		<ul>
                        	<li><a>Hardcopy Billing</a></li>
                            <li><a>Electronic Billing</a></li>
                        </ul>
                	</li>
                    <li><a>Legacy</a>
                		<ul>
                        	<li><a>Create Invoices/Logs</a></li>
                            <li><a>End of Flight Invoicing</a></li>
                            <li><a>File download</a></li>
                        </ul>
                	</li>    
			</ul>
		</li>
        <li><a>Utilities</a>
			<ul>
					<li><a>Insertion Stats</a>
                		<ul>
                        	<li><a href="<?php echo site_url("insertionsummarylist") ?>"><span>Insertion Summary</span></a></li>
                            <li><a>Insertion Detail</a></li>
                            <li><a>Active Cues</a></li>
                        </ul>
                	</li>
                    <li><a>Monitoring</a>
                		<ul>
                        	<li><a>Alarm Conditions</a></li>
                            <li><a>Detailed Report</a></li>
                        </ul>
                	</li>
                       <li><a>Others</a>
                		<ul>
                        	<li><a>Client Map</a></li>
                            <li><a>Change Password</a></li>
                            <li><a>Site Map</a></li>
                        </ul>
                	</li>     
			</ul>
		</li>
                
                
                </ul>
        </li>
</ul>
</div>



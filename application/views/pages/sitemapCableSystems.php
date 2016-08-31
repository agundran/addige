

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
                
                
				
		<li><a>Billing</a>
			<ul>
				<li><a>Set Invoicing Months</a></li>
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
      <li><a>Insertion Detail</a></li>
      <li><a>Change Password</a></li>
      <li><a>Site Map</a></li>
                
                
                </ul>
        </li>
</ul>
</div>



function toggle_visibility(id) {
			       var e = document.getElementById(id);
			       if(e.style.display == 'block')
			          e.style.display = 'none';
					  
					  
					  
					  
					  
			       else
			          e.style.display = 'block';
					  
					  
					  
			    }
				
				$("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
				 
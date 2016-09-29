jQuery( function( $ ) {	 
	
  	$(".bg").css( "background-size", "cover" );
	
  	$("a[href='#go-to-top']").click(function() {
		$("html, body").animate({ scrollTop: 0 }, "slow");
		return false;
	});

});


var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeft = document.getElementById( 'showLeft' ),
				body = document.body;

			showLeft.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeft' );
			};

			function disableOther( button ) {
				if( button !== 'showLeft' ) {
					classie.toggle( showLeft, 'disabled' );
				}
			}
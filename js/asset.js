(function($) {

	var SlideSpeed = 'fast';

	// listen to any anchor clicks within the podcon_* (wildcard) container
	$( "[id^=podcon_] a" ).click( function( event ){
	    
	    var GrandParentContainer = $( this ).parent().parent().attr( "id" ),
//	        ParentContainer = $( this ).parent().attr( "id" ),
//	        ParentContainerSplit = ParentContainer.split( "_" ),
	    	ThisElementID = $( this ).attr( "id" ),
	    	ThisElementIDSplit = ThisElementID.split( "_" ),
	    	RestAPI_URL = setup_play_podcast_vars.rest_url_acf,
	    	RestAPIField = setup_play_podcast_vars.display_fields,
	    	AjaxFileURL = setup_play_podcast_vars.ajaxurl,
	    	ThisElementPostType = 'acf', PassVariables;
	    
	    // ################################################
	    // # play podcast (Listen now)
	    // ################################################
	    if( ThisElementIDSplit[ 0 ] == 'cta-podcast' ) {

	    	// explode (split) to get the post id
			GPCTrimmed = GrandParentContainer.split( "_" );

            // create container
        	var ContainerID = 'ss_ajax_responses_' + GPCTrimmed[ 1 ];

        	// hide this anchor tag
        	$( this ).hide();
        	// show dummy text
        	$( '#cta-podcast-2_' + GPCTrimmed[ 1 ] ).show();
        	// show close anchor tag
        	$( '#cta-podcast-close_' + GPCTrimmed[ 1 ] ).show();


        	// check if element exists
        	if( $( "#" + ContainerID ).length === 0 ) {
				
				// Add container
        		$( '#' + GrandParentContainer ).append( '<div id="' + ContainerID + '"></div>' );

        	} else {

        		// clear contents for next relationship
//		            		$( "#" + ContainerID ).html( '' );
				$( '#' + ContainerID ).slideDown( SlideSpeed );

        	}

	    	//alert( JSON.stringify( RestAPIField ) );
	    	$.each( jQuery.parseJSON( JSON.stringify( RestAPIField ) ), function( index, element ){

				PassVariables = 'restapi_url=' + RestAPI_URL +
//								'&post_type=' + ThisElementPostType +
								'&post_id=' + ThisElementIDSplit[ 1 ] +
								'&post_fields=' + element +
								'&api_end_point=' + ThisElementPostType;
//								'&site_url=' + MainSiteURL;
				
//				alert( AjaxFileURL + '/trv-podcast-ajax-loader.php?' + PassVariables );
				// RUN AJAX
		        $.ajax({
		            type: 'POST',
		            url: AjaxFileURL + '/trv-podcast-ajax-loader.php',
	                data: PassVariables,
		            success: function( data ) {
		            	
						var TestScriptVar = $( data ).load( '#ss_container' ).html(); // get rest api contents
//						alert( TestScriptVar );

						// validate first if <script is found in the contents
						var index = TestScriptVar.indexOf( "<script" );    
						if(index !== -1){
						    //alert("Substring found!");

			            	// insert iFrame
			            	var iFrame = $( '<iframe id="thepage_' + GPCTrimmed[ 1 ] + '" ></iframe>');
			            	$( "#" + ContainerID ).slideDown( SlideSpeed ).append( iFrame );

			                var iFrameDoc = iFrame[0].contentDocument || iFrame[0].contentWindow.document;
							iFrameDoc.write( TestScriptVar );
							iFrameDoc.close();

						} else{
						    //alert("Substring not found!");
			                $( '#' + ContainerID ).append( TestScriptVar ); // works
						}
		                
		            }

		        }); // end of $.ajax({

			}); // end of $.each( jQuery.parseJSON( JSON.stringify( RestAPIField ) ), function( index, element ){

	    }

	    // ################################################
	    // # close podcast
	    // ################################################
	    if( ThisElementIDSplit[ 0 ] == 'cta-podcast-close' ) {
	    	
	    	// show Listen Now link
	    	$( '#cta-podcast_' + ThisElementIDSplit[ 1 ] ).removeAttr( 'style' );
	    	``
	    	// hide Listen Now text
	    	$( '#cta-podcast-2_' + ThisElementIDSplit[ 1 ] ).hide();

	    	// hide this close link
	    	$( this ).hide();

	    	// slide up and hide iframe container
	    	$( '#ss_ajax_responses_' + ThisElementIDSplit[ 1 ] ).slideUp( SlideSpeed, function(){
	    		$( '#ss_ajax_responses_' + ThisElementIDSplit[ 1 ] ).empty();
	    	});

	    }
		
	});


	/*
	// BLINKING TEXT
	function blink_text() {
	    // '#blink'
	    $('[id^=blink]').fadeOut(500);
	    $('[id^=blink]').fadeIn(500);
	}
	setInterval( blink_text, 1000 );
	*/

})( jQuery );
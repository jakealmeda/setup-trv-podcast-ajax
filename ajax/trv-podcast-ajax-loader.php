<?php

$ajax_rest_api = $_REQUEST[ 'restapi_url' ];
//$ajax_post_type = $_REQUEST[ 'post_type' ];
$ajax_post_entry = $_REQUEST[ 'post_id' ];
$ajax_post_field = $_REQUEST[ 'post_fields' ];
$ajax_post_make = $_REQUEST[ 'api_end_point' ];

// decode contents to determine what to do
//$post_fields = json_decode( $ajax_post_field, TRUE );

/*
echo 'REST API: '.$ajax_rest_api.'<hr />';
//echo 'POST TYPE: '.$ajax_post_type.'<hr />';
echo 'POST ENTRY: '.$ajax_post_entry.'<hr />';
echo 'POST FIELD: '.$ajax_post_field.'<hr />';
echo 'POST MAKE: '.$ajax_post_make.'<hr />';
*/

/* ###########################################
 * # NO WP FUNCTIONS WILL WORK - NOT CONNECTED
 * ######################################## */
// CONTAINER - OPEN
?><div id="ss_container"><?php

echo setup_starter_json_decode( $ajax_rest_api, $ajax_post_entry, $ajax_post_make, $ajax_post_field );

// CONTAINER - CLOSE
?></div><?php

//if( !function_exists( 'setup_starter_json_decode' ) ) {

    function setup_starter_json_decode( $ajax_rest_api, $ajax_post_entry, $ajax_post_make = FALSE, $ajax_post_field = FALSE ) {
    	
        $contents = file_get_contents( $ajax_rest_api.'/'.$ajax_post_entry );
        $insides = json_decode($contents);
        
        /*if( is_array( $ajax_post_field ) ) {

        	$field = $ajax_post_field[ 'field' ];
        	$img_size = $ajax_post_field[ 'size' ];

        	return $insides->$ajax_post_make->$field;

        } else {*/
			//echo '<h1>here: '.$ajax_post_field.'</h1>'; var_dump( $insides->$ajax_post_field->rendered );

//        	$img_size = '';
			
        	// field is WP native
			if( $ajax_post_make == 'wp' ) {
				return $insides->$ajax_post_field->rendered;
			} else {
				//$field = $ajax_post_field;
				return $insides->$ajax_post_make->$ajax_post_field;
			}

        	
        	

        //}
//        echo '<p>break</p>';
//        var_dump($insides);
        
        //var_dump($insides->$ajax_post_make->$field);
        

    }

//}


// <script src="https://www.buzzsprout.com/150542/754819-112-jack-frederick-notes-from-my-mentor.js?player=small&style=minimal" type="text/javascript" charset="utf-8"></script>

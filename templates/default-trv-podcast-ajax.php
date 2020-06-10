<?php

if ( ! defined( "ABSPATH" ) ) {
    exit; // Exit if accessed directly
}

echo '<div id="podcon_'.get_the_ID().'">
		<div class="item link podcast-link podcast-embed-cta" id="cta-container_'.get_the_ID().'">
			<a id="cta-podcast_'.get_the_ID().'" tabindex="-1" aria-hidden="true">Listen Now</a>
			<span id="cta-podcast-2_'.get_the_ID().'" style="display: none;">Listen Now |</span> <a id="cta-podcast-close_'.get_the_ID().'" style="display: none;" tabindex="-1" aria-hidden="true">Close</a>
		</div>
	</div>';
//<div id="ss_ajax_responses_'.get_the_ID().'"></div>
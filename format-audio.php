

<div class="featured-image_">
	<div class="format-audio-container ">

	<?php

		$audio_link = get_post_meta( $post->ID, '_format_audio_embed', true );

		if(0 === strpos( $audio_link, 'http:/')) :
			$post_embed = do_shortcode('[audio src="'.$audio_link.'" width="60%"]');
		    echo $post_embed;
		else :
			echo $audio_link;
		endif;
    ?>  
    	<div class="clear"></div>
	</div>
</div>
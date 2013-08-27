

<div class="featured-image">
	<div class="format-video-container ">

	<?php

		$video_link = get_post_meta( $post->ID, '_format_video_embed', true );
		//echo 'Video Link: '.$video_link;
	    
	    //the_featured_video($video_link);

		if(0 === strpos( $video_link, 'http:/')) :
		    global $wp_embed;
			$post_embed = $wp_embed->run_shortcode('[embed]'.$video_link.'[/embed]');
		    echo $post_embed;
		else :
			echo '[video src="'.$video_link.'" width="100%"]';
		endif;
    ?>  
	</div>
</div>
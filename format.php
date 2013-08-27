
<div class="format-standard-container">

<?php if(is_singular() && !is_page()) {
	global $post;
	// Featured image
	$featured_img = (int)core_options_get('featured_img');
	if (has_post_thumbnail() && $featured_img) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'large');
		echo '<div class="featured-image" style="background:url('.$image[0].')">';
		echo '</div>';
	}
} else {
	if (has_post_thumbnail()) {
		echo '<div class="featured-image">';
			the_post_thumbnail('portfolio-thumb_medium');
		echo '</a></div>';
	}
	
}

?>

</div>

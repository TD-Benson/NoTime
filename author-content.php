<?php

// if there is "Biographical Info", then display the post author
if( get_the_author_meta('description') != '' ) :
	echo '<div class="theme-author">';
	echo '<div class="description">';
	
	echo '<div class="shortcode-header"><h6>' . sprintf(__('About %s', THEME_SLUG), get_the_author()) . '</h6></div>';
	echo '<div class="avatar">' . get_avatar(get_the_author_meta('ID'), 64) . '</div>';
	echo '<p>' . get_the_author_meta('description') . '</p>';
	
	echo '<p>' . __('View all posts by', THEME_SLUG) . ' ';
	the_author_posts_link();
	echo '</p>';
	
	echo '</div>';
	
	// List other posts by this author
	echo '<div class="posts">';
	echo '<div class="shortcode-header"><h6>' . sprintf(__('More post by %s', THEME_SLUG), get_the_author()) . '</h6></div>';
	
	$author_posts = get_posts(array(
	    'numberposts'     => 5,
	    'offset'          => 0,
	    'orderby'         => 'post_date',
	    'order'           => 'DESC',
	    'post_type'       => 'post',
	    'post_status'     => 'publish',
	    'author'          => get_the_author_meta('ID'),
	));
	
	echo '<ul>';
	foreach ($author_posts as $author_post) {
		echo '<li>&rsaquo;&rsaquo;  <a href="' . get_permalink($author_post->ID) . '">' . $author_post->post_title . '</a></li>';
	}
	echo '</ul>';
	echo '</div>';
	
	echo '<div class="floatclear"></div>';
	
	echo '</div>';

endif;

?>
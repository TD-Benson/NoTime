<?php

$meta = core_options_get('meta');

while (have_posts()) {
	the_post();

	// Article start
	$post_classes = get_post_class();
	$index = array_search('hentry', $post_classes);
	unset($post_classes[$index]);
	$post_classes = implode(' ', $post_classes);
		get_template_part( 'format', get_post_format() ); 

	echo '<article class="theme-article entry-content ', $post_classes, '">';
	

	// Output content
	// If the content is really empty, right sidebars will go left, so something is always put in it
	echo "<div class='theme-article-content'>";
	$content = apply_filters('the_content', get_the_content());
	if ($content == '') {
		$content = '&nbsp;';
		echo wpautop($content);
	} else {
		the_content();
	}
	echo "</div>";

	// Pagination
	wp_link_pages(array(
	    'before'           => '<ul class="theme-pagination">',
	    'after'            => '</ul>',
	));

	// Author info
	if (is_single())
		get_template_part('author', 'content');

	// Related posts
	if (is_single()) {
		$tags = wp_get_post_tags($post->ID);
		$cats = wp_get_post_categories($post->ID);

		if ($tags || $cats) {
			// Construct array of just tag slugs
			$new_tags = array();
			foreach ($tags as $tag)
				$new_tags[] = $tag->slug;

			// Query related posts
			$related_posts = get_posts(array(
				'tag_slug__in' => $new_tags,
				'category__in' => $cats,
				'post__not_in' => array($post->ID),
				'numberposts' => 6,
				'order' => 'ASC',
				'orderby' => 'rand',
			));

			if ($related_posts) {
				$items = '';
				foreach ($related_posts as $related_post) {
					if (!has_post_thumbnail($related_post->ID))
						continue;

					$thumb_id = get_post_thumbnail_id($related_post->ID);
					$post_image = wp_get_attachment_image_src($thumb_id, 'thumbnail');
					$alt_text = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);

					$items .= '
					<div class="post">
						<a href="' . get_permalink($related_post->ID) . '" rel="bookmark" title="' . $alt_text . '">
						<div class="title">' . $related_post->post_title . '</div>
						<img src="' . $post_image[0] . '" class="thumbnail">
						</a>
					</div>
					';
				}

			}
		}
	}

	echo '</article>';

	comments_template();
}

?>
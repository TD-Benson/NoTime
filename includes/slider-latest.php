<?php

// Slider definition
$slider = array(
	'name' => __('Latest posts Slider', THEME_SLUG),
	'scripts' => array(
		'jquery' => '',
		'latest-slider-script' => THEME_URI . '/js/latest-slider.js',
	),
	'styles' => array(),
	'supportsLayers' => false,
	'supportsSlides' => false,
	'output' => 'theme_slider_latest_output',

	// General settings
	'options' => array(
		'width' => array(
			'type' => 'string',
			'title' => __('Width', THEME_SLUG),
			'default' => '100%'
		),
		'height' => array(
			'type' => 'string',
			'title' => __('Height', THEME_SLUG),
			'default' => '300',
		),
		'transition_speed' => array(
			'type' => 'number',
			'title' => __('Transition speed', THEME_SLUG),
			'default' => '500',
		),
		'slide_delay' => array(
			'type' => 'number',
			'title' => __('Slide delay', THEME_SLUG),
			'default' => '2000',
		),
		'categories' => array(
			'type' => 'multiline',
			'title' => __('Categories', THEME_SLUG),
			'description' => __('Enter the slug names of categories you want the slider to display, separated by commas.', THEME_SLUG),
			'default' => '',
		),
		'post_count' => array(
			'type' => 'string',
			'title' => __('Post count', THEME_SLUG),
			'default' => '10',
		),
	),
);

// Register
core_slider_register($slider);

// Post thumbnail sizes
add_image_size('slider-latest', 1080, 500, false);


// Outputs the Layer Slider code
//
function theme_slider_latest_output($settings) {
	$slider_settings = $settings['settings'];

	$id = core_get_uuid('theme-slider-');
	echo '<div id="', $id, '" class="slider-latest" style="margin: 0 auto; width: ', core_css_unit($slider_settings['width']), '; height: ', core_css_unit($slider_settings['height']), '">';

	// Get recent posts
	$posts = wp_get_recent_posts(array(
		'numberposts' => intval($slider_settings['post_count']),
		'category_name' => $slider_settings['categories'],
		'post_type' => 'post',
		'order' => 'ASC',
		'orderby' => 'rand',
		'post_status' => 'publish',
	));

	// Output slides and layers
	foreach ($posts as $post) {
		echo '<div class="slider-latest-slide">';

		$post_id = $post['ID'];
		
		if (has_post_thumbnail($post_id)) {
			$thumb_id = get_post_thumbnail_id($post_id);
			$post_image = wp_get_attachment_image_src($thumb_id, 'slider-layer');

			echo '<a href="', get_permalink($post_id), '">';
			
			echo '<img class="slider-latest-image" src="', $post_image[0], '">';

			echo '<div class="slider-latest-content">';
			echo '<h2 class="slider-latest-title">', $post['post_title'], '</h2>';
			if ($post['post_excerpt'] != '')
				$post_content = $post['post_excerpt'];
			else
				$post_content = $post['post_content'];

			$post_content = strip_shortcodes(strip_tags($post_content));
			if (strlen($post_content) > 300)
				$post_content = substr($post_content, 0, 240) . '...';

			echo strip_tags($post_content);
			echo '<br><br><div class="theme-button small">Read more</div>';

			echo '</div>';

			echo '</a>';
		}

		echo '</div>';
	}	
	echo '</div>';
	
	// Output inline JavaScript
	?>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#<?php echo $id; ?>').latestSlider({
				slideDelay: <?php echo intval($slider_settings['slide_delay']); ?>,
				transitionSpeed: <?php echo intval($slider_settings['transition_speed']); ?>
			});
		});
	</script>
	<?php
}

?>
<?php 
/*
 * Layer Slider WP
 *
 * 
 */

// Supported jQuery UI easing effects
$flex_ease_effects = array(
	'linear' => 'Linear',
	'swing' => 'Swing',
	'easeInQuad' => 'In quadratic',
	'easeOutQuad' => 'Out quadratic',
	'easeInOutQuad' => 'In-out quadratic',
	'easeInCubic' => 'In cubic',
	'easeOutCubic' => 'Out cubic',
	'easeInOutCubic' => 'In-out cubic',
	'easeInQuart' => 'In quarter',
	'easeOutQuart' => 'Out quarter',
	'easeInOutQuart' => 'In-out quarter',
	'easeInQuint' => 'In quintuple',
	'easeOutQuint' => 'Out quintuple',
	'easeInOutQuint' => 'In-out quintuple',
	'easeInSine' => 'In sine',
	'easeOutSine' => 'Out sine',
	'easeInOutSine' => 'In-out sine',
	'easeInExpo' => 'In exponential',
	'easeOutExpo' => 'Out exponential',
	'easeInOutExpo' => 'In-out exponential',
	'easeInCirc' => 'In circular',
	'easeOutCirc' => 'Out circular',
	'easeInOutCirc' => 'In-out circular',
	'easeInElastic' => 'In elastic',
	'easeOutElastic' => 'Out elastic',
	'easeInOutElastic' => 'In-out elastic',
	'easeInBack' => 'In back',
	'easeOutBack' => 'Out back',
	'easeInOutBack' => 'In-out back',
	'easeInBounce' => 'Bounce in',
	'easeOutBounce' => 'Bounce out',
	'easeInOutBounce' => 'Bounce in-out',
);

// Slider definition
$slider = array(
	'name' => __('Flex Slider', THEME_SLUG),
	'scripts' => array(
		'jquery' => '',
		'jquery-ui' => '',
		'jquery-effects-core' => '',
		'layerslider-script' => THEME_URI . '/flexslider/jquery.flexslider.js',
	),
	'styles' => array(
		'layerslider-style' => THEME_URI . '/flexslider/flexslider.css',
	),
	'supportsLayers' => false,
	'supportsSlides' => true,
	'output' => 'theme_slider_flexslider_output',

	// General settings
	'options' => array(
		'width' => array(
			'type' => 'string',
			'title' => __('Width', THEME_SLUG),
			'description' => __("Width of the slider (for responsive layout you can use % as well).", THEME_SLUG),
			'default' => '100%'
		),
		'height' => array(
			'type' => 'string',
			'title' => __('Height', THEME_SLUG),
			'description' => __("Height of the slider, you can leave it blank if you want to have it full responsive.", THEME_SLUG),
			'default' => '300',
		),
		'animation' => array(
			'type' => 'select',
			'items' => array(
					'fade' => __('Fade', THEME_SLUG), 
					'slide'=> __('Slide', THEME_SLUG)
				),
			'title' => __('Animation', THEME_SLUG),
			'default' => 'fade',
		),
		'easing' => array(
			'type' => 'select',
			'items' => $flex_ease_effects,
			'title' => __('Easing', THEME_SLUG),
			'default' => 'swing',
		),
		'direction' => array(
			'type' => 'select',
			'items' => array(
					'horizontal' => __('Horizontal', THEME_SLUG), 
					'vertical'=> __('Vertical', THEME_SLUG)
				),
			'title' => __('Easing', THEME_SLUG),
			'default' => 'swing',
		),
		'slideshowSpeed' => array(
			'type' => 'number',
			'title' => __('Slideshow speed', THEME_SLUG),
			'default' => '7000',
		),
		'animationSpeed' => array(
			'type' => 'number',
			'title' => __('Animation speed', THEME_SLUG),
			'default' => '600',
		),
		'randomFlex' => array(
			'type' => 'boolean',
			'title' => __('Randomize', THEME_SLUG),
			'default' => false,
		),
		'thumbnailSlider' => array(
			'type' => 'boolean',
			'title' => __('Display Thumbnail Slider', THEME_SLUG),
			'default' => false,
		),
		'tsWidth' => array(
			'type' => 'string',
			'title' => __('Thumbnail Width', THEME_SLUG),
			'default' => '110'
		),
		'tsHeight' => array(
			'type' => 'string',
			'title' => __('Thumbnail Height', THEME_SLUG),
			'description' => __("Height of the slider", THEME_SLUG),
			'default' => '90',
		),
	),

	// Options for individual slides
	'slideOptions' => array(

		// Image
		'image' => array(
			'title' => __('Image', THEME_SLUG),
			'settings' => array(
				'image' => array(
					'type' => 'image',
					'delete' => false,
				),
			),
		),

		// Caption
		'caption' => array(
			'title' => __('Caption', THEME_SLUG),
			'settings' => array(
				'caption' => array(
					'type' => 'multiline',
				),
			),
		),
	),

);

// Register
core_slider_register($slider);

// Add FlexSlider Styles and Scripts
function theme_slider_flexslider_enqueue(){
	wp_enqueue_script(
			'flex-slider-js',
			THEME_URI . '/flexslider/jquery.flexslider.js',
			array('jquery')
		);
	
	wp_register_style( 'flex-slider', 
	    THEME_URI . '/flexslider/flexslider.css', 
	    array(), 
	    '20121022', 
	    'all' );
	wp_enqueue_style( 'flex-slider' );
}
add_action('wp_enqueue_scripts', 'theme_slider_flexslider_enqueue');

// Outputs the Layer Slider code
//
function theme_slider_flexslider_output($settings) {
	$slider_settings = $settings['settings'];

	$id = core_get_uuid('theme-slider-');
	echo "<div id='slider-", $id, "' class='flexslider' >\n";
	echo "<ul class='slides'>\n";

	// Output slides
	$index = 0;
	$captions = '';
	foreach ($settings['slides'] as $slide) {
		$slide_settings = $slide['settings'];
		$index++;
		
		echo "<li style='height: ", core_css_unit($slider_settings["height"]), "; width: ", core_css_unit($slider_settings["width"]), ";'>\n";

		if ($slide_settings['caption'] != '') {
			echo '<img src="', $slide_settings['image'], '" title="#slider-', $id, '-caption-', $index, '">';
			echo '<div class="flex-caption">' . wpautop(do_shortcode($slide_settings['caption'])) . '</div>';
		} else {
			echo '<img src="', $slide_settings['image'], '" alt="">';
		}

		echo "</li>";
	}

	echo '</ul>';
	echo '</div>';

	if ($slider_settings['thumbnailSlider'] == true ){


		echo "<div id='carousel-", $id, "' class='carousel flexslider' >\n";
		echo "<ul class='slides'>\n";

		// Output slides
		$index = 0;
		foreach ($settings['slides'] as $slide) {
			$slide_settings = $slide['settings'];
			$index++;
			
			echo "<li style='overflow: hidden; height: ", core_css_unit($slider_settings["tsHeight"]), "; width: ", core_css_unit($slider_settings["tsWidth"]), ";'>\n";
			echo '<img src="', $slide_settings['image'], '" alt="">';
			echo "</li>";
		}

		echo '</ul>';
		echo '</div>';

	}

	//echo $captions;

	// Output inline JavaScript
	?>
	<script type="text/javascript">
		jQuery(window).load(function() {

		<?php if($slider_settings['thumbnailSlider'] == 0 ) : ?>	
			jQuery('#slider-<?php echo $id; ?>').flexslider({
				animation: '<?php echo $slider_settings['animation'];?>',
				easing: '<?php echo $slider_settings['easing'];?>',
				direction: '<?php echo $slider_settings['direction'];?>',
				slideshowSpeed: <?php echo intval($slider_settings['slideshowSpeed']);?>,
				animationSpeed: <?php echo intval($slider_settings['animationSpeed']);?>,
				randomize: <?php $slider_settings['randomFlex'] = $slider_settings['randomFlex'] > 0 ? 'true' : 'false'; echo $slider_settings['randomFlex']; ?>,

			});

		<?php else : ?>

			jQuery('#carousel-<?php echo $id; ?>').flexslider({
			    animation: "slide",
			    controlNav: false,
			    directionNav: true,
			    slideshow: false,
			    itemWidth: <?php echo intval($slider_settings['tsWidth']);?>,
			    itemMargin: 10,
			    asNavFor: '#slider-<?php echo $id; ?>'
			  });
			   
			  jQuery('#slider-<?php echo $id; ?>').flexslider({
			    animation: '<?php echo $slider_settings['animation'];?>',
				easing: '<?php echo $slider_settings['easing'];?>',
				direction: '<?php echo $slider_settings['direction'];?>',
				slideshowSpeed: <?php echo intval($slider_settings['slideshowSpeed']);?>,
				animationSpeed: <?php echo intval($slider_settings['animationSpeed']);?>,
				randomize: <?php $slider_settings['randomFlex'] = $slider_settings['randomFlex'] > 0 ? 'true' : 'false'; echo $slider_settings['randomFlex']; ?>,
			    controlNav: false,
			    directionNav: true,
			    slideshow: true,
			    sync: "#carousel-<?php echo $id; ?>"
			  });

		<?php endif; ?>

		});
	</script>
	<?php
}

?>
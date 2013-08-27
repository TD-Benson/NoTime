<?php

// Slider definition
$slider = array(
	'name' => __('Slideshow Slider', THEME_SLUG),
	'scripts' => array(),
	'styles' => array(
		'slideshow-slider-style' => THEME_URI . '/slideshow/slideshow-slider.css',
	),
	'supportsLayers' => false,
	'supportsSlides' => true,
	'output' => 'theme_slider_slideshow_output',

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
		'animation' => array(
			'type' => 'select',
			'items' => array(
					'fade' => __('FadeIn/FadeOut', THEME_SLUG),
					'rotate' => __('Rotate/SlideRight', THEME_SLUG),
					'move' => __('MovesDown/MovesUp', THEME_SLUG),
					'mixed' => __('Combined', THEME_SLUG),
				),
			'title' => __('Animation', THEME_SLUG),
			'default' => 'fade',
		),
		'interval' => array(
			'type' => 'string',
			'title' => __('Slide Interval <br>(default: 6 seconds)', THEME_SLUG),
			'default' => '6',
		),
		'pattern' => array(
			'type' => 'image',
			'delete' => true,
			'title' => __('Pattern Overlay', THEME_SLUG),
			'default' => 'none',
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
					'delete' => true,
				),
			),
		),

		// Caption
		'html_block' => array(
			'title' => __('HTML Block', THEME_SLUG),
			'settings' => array(
				'html_block' => array(
					'type' => 'multiline',
				),
			),
		),
	),
);

// Register
core_slider_register($slider);

// Outputs the Slideshow Slider code
//
function theme_slider_slideshow_output($settings) {
	$slider_settings = $settings['settings'];

	$id = core_get_uuid('theme-slider-');
	$index = 1;
	$delay = 0;
	$interval = (int)$slider_settings['interval'];
	$duration = sizeof($settings['slides']) * $interval;
	
	echo "<link rel='stylesheet' href='", THEME_URI ,"/slideshow/", $slider_settings['animation'] ,".css'> \n";
	echo "<style>\n";
	echo ".slider-slideshow:after { background: transparent url('", $slider_settings['pattern'] ,"') repeat top left; } \n";
	echo ".slider-slideshow li span { -webkit-animation: imageAnimation ", $duration ,"s linear infinite ", $delay ,"s; -moz-animation: imageAnimation ", $duration ,"s linear infinite ", $delay ,"s; -o-animation: imageAnimation ", $duration ,"s linear infinite ", $delay ,"s; -ms-animation: imageAnimation ", $duration ,"s linear infinite ", $delay ,"s; animation: imageAnimation ", $duration ,"s linear infinite ", $delay ,"s; } \n";
	echo ".slider-slideshow li div  { -webkit-animation: titleAnimation ", $duration ,"s linear infinite ", $delay ,"s; -moz-animation: titleAnimation ", $duration ,"s linear infinite ", $delay ,"s; -o-animation: titleAnimation ", $duration ,"s linear infinite ", $delay ,"s; -ms-animation: titleAnimation ", $duration ,"s linear infinite ", $delay ,"s; animation: titleAnimation ", $duration ,"s linear infinite ", $delay ,"s; } \n";
	echo "</style>\n";
	
	echo '<ul id="', $id, '" class="slider-slideshow ', $slider_settings['animation'] ,' " style="margin: 0 auto; width: ', core_css_unit($slider_settings['width']), '; height: ', core_css_unit($slider_settings['height']), '; overflow: hidden; position:relative; ">';

	// Output slides
	foreach ($settings['slides'] as $slide) {
		$slide_settings = $slide['settings'];
		
		echo "<li>\n";
		echo "<span style=\"display: none; display:none\9; background-image: url('", $slide_settings['image'] ,"'); -webkit-animation-delay: ", $delay ,"s; -moz-animation-delay: ", $delay ,"s; -o-animation-delay: ", $delay ,"s; -ms-animation-delay: ", $delay ,"s; animation-delay: ", $delay ,"s; \">Image ", $index ,"</span>\n";
		
		if ($slide_settings['html_block'])
			echo "<!-- [if lte IE 8] --> \n";
			echo "<div style=\"display:none;visibility:hidden\9;  -webkit-animation-delay: ", $delay ,"s; -moz-animation-delay: ", $delay ,"s; -o-animation-delay: ", $delay ,"s; -ms-animation-delay: ", $delay ,"s; animation-delay: ", $delay ,"s; \">", do_shortcode($slide_settings['html_block']), "</div>\n";
			echo "<!-- [endif] --> \n";
		
		echo "</li>\n";
		$index++;
		$delay += $interval ;
	}	
		
	echo '</ul>';
	
	// Output inline JavaScript
	?>
	<script type="text/javascript">
		jQuery(window).ready(function() {
			jQuery('.slider-slideshow li span, .slider-slideshow li div').hide();
		});
		
		jQuery(window).load(function() {
			jQuery('.slider-slideshow li span, .slider-slideshow li div').show();
		});
	</script>
<?php		
}

?>
<?php

$slider_nivo_transitions = array(
	'fold' => __('Fold', THEME_SLUG),
	'fade' => __('Fade', THEME_SLUG),
	'random' => __('Random', THEME_SLUG),
	/*'sliceDown' => __('Slice down', THEME_SLUG),
	'sliceDownLeft' => __('Slice down left', THEME_SLUG),
	'sliceUp' => __('Slice up', THEME_SLUG),
	'sliceUpLeft' => __('Slice up left', THEME_SLUG),
	'sliceUpDown' => __('Slice up down', THEME_SLUG),
	'sliceUpDownLeft' => __('Slice up down left', THEME_SLUG),
	'slideInRight' => __('Slide in right', THEME_SLUG),
	'slideInLeft' => __('Slide in left', THEME_SLUG),
	'boxRandom' => 'Boxes random', THEME_SLUG),
	'boxRain' => __('Boxes rain', THEME_SLUG),
	'boxRainReverse' => __('Boxes rain reverse', THEME_SLUG),
	'boxRainGrow' => __('Boxes rain grow', THEME_SLUG),
	'boxRainGrowReverse' => __('Boxes rain grow reverse', THEME_SLUG)*/
);

// Slider definition
$slider = array(
	'name' => __('Nivo slider', THEME_SLUG),
	'scripts' => array(
		'jquery' => '',
		'nivo-slider-script' => THEME_URI . '/nivoslider/jquery.nivo.slider.js',
	),
	'styles' => array(
		'nivo-slider-style' => THEME_URI . '/nivoslider/nivo-slider.css',
		'nivo-slider-theme' => THEME_URI . '/nivoslider/default/default.css',
	),
	'supportsLayers' => false,
	'supportsSlides' => true,
	'output' => 'theme_slider_nivo_output',

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
		'delay' => array(
			'type' => 'number',
			'title' => __('Slide delay', THEME_SLUG),
			'default' => '3000',
		),
		'transition' => array(
			'type' => 'select',
			'items' => $slider_nivo_transitions,
			'title' => __('Transition effect', THEME_SLUG),
			'default' => 'fade',
		),
		'transition_speed' => array(
			'type' => 'number',
			'title' => __('Transition speed', THEME_SLUG),
			'default' => '1000',
		),
		'hoverpause' => array(
			'type' => 'boolean',
			'title' => __('Pause on hover', THEME_SLUG),
			'default' => false,
		),
		'navigate_leftright' => array(
			'type' => 'boolean',
			'title' => __('Next\previous buttons', THEME_SLUG),
			'default' => false,
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

		// Link
		'link' => array(
			'title' => __('Link', THEME_SLUG),
			'settings' => array(
				'link' => array(
					'type' => 'string',
					'default' => '',
				),
			),
		),
	),
);

// Register
core_slider_register($slider);


// Outputs the Nivo slider code
//
function theme_slider_nivo_output($settings) {
	$slider_settings = $settings['settings'];

	$id = core_get_uuid('theme-slider-');
	echo '<div class="slider-wrapper theme-default" style="margin: 0 auto; height: ', core_css_unit($slider_settings['height']), '; width: ', core_css_unit($slider_settings['width']), ';">';
	echo '<div class="nivoSlider" id="', $id, '">';

	// Output slides
	$index = 0;
	$captions = '';
	foreach ($settings['slides'] as $slide) {
		$slide_settings = $slide['settings'];
		$index++;
		
		if ($slide_settings['link'])
			echo '<a href="', $slide_settings['link'], '" target="_blank" class="nivo-imageLink">';

		if ($slide_settings['caption'] != '') {
			echo '<img src="', $slide_settings['image'], '" title="#slider-', $id, '-caption-', $index, '">';
			$captions .= '<div id="slider-' . $id . '-caption-' . $index . '" class="nivo-html-caption">' . wpautop(do_shortcode($slide_settings['caption'])) . '</div>';
		} else {
			echo '<img src="', $slide_settings['image'], '" alt="">';
		}

		if ($slide_settings['link'])
			echo '</a>';
	}

	echo '</div>';
	echo '</div>';

	echo $captions;

	// Output inline JavaScript
	?>
	<script type="text/javascript">
		jQuery(window).load(function() {
			jQuery('#<?php echo $id; ?>').nivoSlider({
				effect:           '<?php echo $slider_settings['transition'];?>',
				animSpeed:        <?php echo intval($slider_settings['transition_speed']);?>,
				pauseTime:        <?php echo intval($slider_settings['delay']) + intval($slider_settings['transition_speed']);?>,
				startSlide:       0,
				directionNav:     <?php echo intval($slider_settings['navigate_leftright']);?>,
				directionNavHide: true,
				controlNav:       false,
				controlNavThumbs: false,
				pauseOnHover:     <?php echo intval($slider_settings['hoverpause']);?>,
				manualAdvance:    false,
				prevText:         'Previous',
				nextText:         'Next',
				randomStart:      false
			});
		});
	</script>
	<?php
}

?>
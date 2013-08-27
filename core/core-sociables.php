<?php

if (!defined('CORE_VERSION'))
	die();


// Registered sociables
// key = array('title' => string,
//             'icon_uri' => string,
//             'uri' => string,
//             'custom' => boolean)
$core_sociables = array();


// Registers the options for all registered sociables
//
function core_sociables_options_register() {
	global $core_theme_options_handler;
	global $core_sociables;

	// Theme options
	$options = new CoreOptionGroup('sociables', 'Sociables', __('Use this page to enter your social media profile names, or to define custom social media links.', THEME_URI), CORE_URI. '/images/options-sociables.png');
	$core_theme_options_handler->group_add($options);

	/*$section = new CoreOptionSection('sociables', __('Predefined', THEME_SLUG));
	$options->section_add($section);*/

	// Predefined sociable profiles
	foreach ($core_sociables as $slug => $sociable) {
		if ($sociable['custom'] == false)
			$section->option_add(new CoreOption('sociable_'. $slug, $sociable['title'], 'text'));
	}

	// Custom sociables
	foreach ($core_sociables as $slug => $sociable) {
		if ($sociable['custom'] == true) {
			$section = new CoreOptionSection('sociable-custom-'. $slug, $sociable['title']);
			$options->section_add($section);

			$section->option_add(new CoreOption('sociable_' .$slug, __('URL', THEME_SLUG), 'text'));
			$section->option_add(new CoreOption('sociable_' .$slug. '_icon', __('Icon', THEME_SLUG), 'image'));
			$section->option_add(new CoreOption('sociable_' .$slug. '_hover_icon', __('Hover icon', THEME_SLUG), 'image'));
		}
	}
}
add_action('after_setup_theme', 'core_sociables_options_register');

// Registers a new sociable
//
function core_sociables_register($slug, $title, $uri, $icon_uri, $icon_hover_uri, $custom=false) {
	global $core_sociables;

	$core_sociables[$slug] = compact('title', 'uri', 'icon_uri', 'icon_hover_uri', 'custom');
}

// Outputs sociables
//
function core_sociables($class='theme-sociables', $custom_entries = array() ) {
	global $core_sociables;

	echo '<ul class="', $class, '">';
	foreach ($core_sociables as $slug => $sociable) {
		$profile = core_options_get('sociable_' .$slug);
		if (!$profile)
			continue;

		// Custom sociables are a link, not a profile name
		if ($sociable['custom'] == true) {
			$link = $profile;
			$icon = core_options_get('sociable_' .$slug. '_icon');
			$icon_hover = core_options_get('sociable_' .$slug. '_hover_icon');
		} else {
			$link = $sociable['uri'] . $profile;
			$icon = $sociable['icon_uri'];
			$icon_hover = $sociable['icon_hover_uri'];
		}

		// Icon or sociable name
		if ($icon)
			echo '<li><a href="', $link, '"><img class="icon" src="', $icon, '"><img class="icon-hover" src="', $icon_hover, '"></a></li>';
		else
			echo '<li><a href="', $link, '">', $sociable['title'], '</a></li>';
	}
	if( !empty( $custom_entries )  ){
		foreach($custom_entries as $i=>$sociable_print){
			
			echo $sociable_print;
		
		}
	
	}
	
	echo '</ul>';
}
// Sociable Widget
//
class Sociables extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'sociable_widget', 
			'ThemeDutch Sociables', 
			array( 'description' => __( 'Display Sociables in your sidebar.', THEME_SLUG ), ) 
		);
	}

 	public function form( $instance ) {
		$defaults = array( 'title' => __('Sociables', THEME_SLUG));
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
?>		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEME_SLUG); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
<?php
		
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		echo $before_widget;
		if ( $title ) 
			echo $before_title . $title . $after_title;
		core_sociables();
		echo $after_widget;
		
	}

}
register_widget( 'Sociables' );


//Sociable Shortcode
//
function core_sociables_shortcode($class='', $custom_entries = array() ) {
	global $core_sociables;

	$output .= '<ul class="theme-sociables '. $class. '">';
	foreach ($core_sociables as $slug => $sociable) {
		$profile = core_options_get('sociable_' .$slug);
		if (!$profile)
			continue;

		// Custom sociables are a link, not a profile name
		if ($sociable['custom'] == true) {
			$link = $profile;
			$icon = core_options_get('sociable_' .$slug. '_icon');
			$icon_hover = core_options_get('sociable_' .$slug. '_hover_icon');
		} else {
			$link = $sociable['uri'] . $profile;
			$icon = $sociable['icon_uri'];
			$icon_hover = $sociable['icon_hover_uri'];
		}

		// Icon or sociable name
		if ($icon)
			$output .= '<li><a href="'. $link. '"><img class="icon" src="'. $icon. '"><img class="icon-hover" src="'. $icon_hover. '"></a></li>';
		else
			$output .= '<li><a href="'. $link. '">'. $sociable['title']. '</a></li>';
	}
	if( !empty( $custom_entries )  ){
		foreach($custom_entries as $i=>$sociable_print){
			
			$output .= $sociable_print;
		
		}
	
	}
	
	$output .= '</ul>';
	
	return $output;
}
add_shortcode('sociables', 'core_sociables_shortcode');

?>
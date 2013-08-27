<?php

if (!defined('CORE_VERSION'))
	die();

require_once('layout-classes.php');
require_once('layout-options.php');
require_once('layout-registry.php');
require_once('layout-generate.php');


// Enqueue scripts
//
function core_layout_enqueue_scripts() {
	wp_enqueue_style('core-layout', CORE_URI. '/layout/layout.css');
	wp_enqueue_script('core-layout', CORE_URI. '/layout/layout.js', '', '', true);

	wp_enqueue_script('json2', '', '', '', '', true);
}
add_action('admin_enqueue_scripts', 'core_layout_enqueue_scripts');

// Register options
//
function core_layout_options_register() {
	global $core_layout_default_sidebars;
	global $core_layout_default;
	global $core_layout_footer_default;
	global $core_theme_options_handler;

	

	// Post layout options
	$layout_options = new CoreOptionHandler(THEME_SLUG . '-layout', THEME_NAME . ' layout', array('post', 'page'));
	
	// Custom Post Types support
	//$layout_options = new CoreOptionHandler(THEME_SLUG . '-layout', THEME_NAME . ' layout', array_merge( array('post', 'page'), get_core_get_post_types() ));
	core_options_handler_register($layout_options);

	$options = new CoreOptionGroup('layout', __('Layout', THEME_SLUG));
	$layout_options->group_add($options);

	$section = new CoreOptionSection('layout');
	$options->section_add($section);
	$section->option_add(new CoreOption('layout', '', 'layout', __('Use this option to change the layout of the current page. Sidebars are ordered from left to right.', THEME_SLUG), null));

	// Sidebar options
	$options = new CoreOptionGroup('sidebars', __('Sidebars', THEME_SLUG), __('By adding sidebars here, you can assign widgets to them and then use them in your page layouts.', THEME_SLUG), CORE_URI. '/layout/images/icon-sidebars.png');
	$core_theme_options_handler->group_add($options);

	$section = new CoreOptionSection('sidebars');
	$options->section_add($section);
	$section->option_add(new CoreOption('sidebars', '', 'sidebars', null, $core_layout_default_sidebars));

	// Theme layout options
	$options = new CoreOptionGroup('layouts', __('Layouts', THEME_SLUG), __('Use this page to define the layouts of special pages.', THEME_SLUG), CORE_URI. '/layout/images/icon-layouts.png');
	$core_theme_options_handler->group_add($options);


	$layouts = array(
		//'layout-single' => __('Single page', THEME_SLUG),
		'layout-search' => __('Search page', THEME_SLUG),
		'layout-archive' => __('Archive page', THEME_SLUG),
		'layout-404' => __('404 page', THEME_SLUG),
		'layout-author' => __('Author page', THEME_SLUG),
		'layout-tag' => __('Tag page', THEME_SLUG),
	);
	
	// Layouts
	foreach ($layouts as $key => $value) {
		$section = new CoreOptionSection($key, $value);
		$options->section_add($section);
		$section->option_add(new CoreOption($key, null, 'layout', null, $core_layout_default));
		
		// Slider
		$section->option_add(new CoreOption('slider_'.$key, __('Slider', THEME_SLUG), 'sliders', __('The slider will be displayed at the top of the '.$value.'.', THEME_SLUG)));
		
		$section->option_add(new CoreOption($key.'_background', __('Background', THEME_SLUG), 'image'));
	
		$section->option_add(new CoreOption($key.'_colorscheme', __('Color scheme', THEME_SLUG), 'colorschemes-list'));
		
		// Custom Category Content section
		if($key != 'layout-404'){
			$section->option_add(new CoreOption('custom_content_' .$key , __('Slogan block', THEME_SLUG), 'text-multiline', __('Any HTML put here will be included in it\'s own block above the content.', THEME_SLUG)));
			$section->option_add(new CoreOption('custom_content_' .$key.'_bg' , __('Slogan background', THEME_SLUG), 'image', __('A background for the '.$value.' slogan block above the content.', THEME_SLUG)));
		}
	}
	
}
add_action('after_setup_theme', 'core_layout_options_register');

// Register sidebars
//
function core_layout_sidebars_register() {
	global $core_sidebars;

	$core_sidebars = core_options_get('sidebars');

	foreach ($core_sidebars as $sidebar_slug => $sidebar_title) {
		register_sidebar(array(	'name' => THEME_NAME. ': ' .$sidebar_title,
								'id' => $sidebar_slug,
								'before_widget' => '<li class="widget">',
								'after_widget' => '</li>',
								'before_title' => '<h3 class="widget-title">',
								'after_title' => '</h3>'));
	}
	register_sidebar(array(	'name' => THEME_NAME. ':  SLIDE PANEL',
							'id' => THEME_SLUG."-slidepanel",
							'before_widget' => '<div class="row">',
							'after_widget' => '</div>',
							'before_title' => '<h3> ',
							'after_title' => '</h3>'));
}
add_action('after_setup_theme', 'core_layout_sidebars_register');

//function get all public custom post types
//
$core_post_types = array();
function get_core_get_post_types(){
	
	$args=array(
	  //'public'   => true,
	  '_builtin' => false
	); 
	
	$output = 'names'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'
	$post_types=get_post_types($args,$output,$operator); 
	foreach ($post_types as $post_type ) {
	  $core_post_types[$post_type] = $post_type;
	}
	
	//return $core_post_types;
	return $post_types;
}

?>
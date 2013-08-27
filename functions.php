<?php

define('THEME_ICON', get_template_directory(). 'images/icon-theme.png');

// WordPress plugin functions
require_once(ABSPATH . 'wp-admin/includes/plugin.php');

// Core startup
require_once('core/core-init.php');

// Load Language Text Domain
add_action('after_setup_theme', 'core_load_theme_textdomain');
function core_load_theme_textdomain(){
	load_theme_textdomain( THEME_SLUG, get_template_directory() . '/languages' );
 	// - CL Custom Portfolio Thumbs
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' ); 
			set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions   
	}

}
 
 
 
// Theme options
require_once('includes/theme-options.php');

// Register sliders
require_once('includes/slider-nivo.php');
require_once('includes/slider-latest.php');
require_once('includes/slider-slideshow.php');
require_once('includes/slider-flexslider.php');

// Register layouts
require_once('includes/layouts.php');

// Customizer settings
require_once('includes/customization.php');


// Theme widgets
//
require_once('core/widgets/categories.php');
require_once('core/widgets/postwidget.php');

function theme_register_widgets() {
	if (!is_blog_installed())
		return;

	register_widget('TD_Widget_Categories');
	register_widget('td_postWidget');

}
add_action('widgets_init', 'theme_register_widgets');


// Theme styles and scripts
//
//function my_admintheme_scripts() {
//		wp_enqueue_script('jquery-main', 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array());
//		wp_enqueue_script('jquery-sitebuilder', THEME_URI. '/core/slider/slider-builder.js', array());
//}
//add_action('admin_init', 'my_admintheme_scripts');
function theme_enqueue_scripts() {
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-effects-core');

	// Theme
	wp_enqueue_script('theme-script', THEME_URI. '/js/theme.js', array('jquery', 'jquery-ui-core'), '', true);

	// PrettyPhoto lightbox
	wp_enqueue_style('prettyphoto-style', CSS_URI. '/prettyPhoto.css');
	wp_enqueue_script('prettyphoto-script', THEME_URI. '/js/jquery.prettyPhoto.js', array('jquery'), '', true);
	
	// Mobile Menu
	wp_enqueue_script('mobileMenu', THEME_URI. '/js/jquery.mobilemenu.js', array('jquery'), '', true);
	
	// Thumbnail CA Slider
	wp_enqueue_script('tdcarousel', THEME_URI. '/js/jquery.carousel.min.js', array('jquery'), '', true);

	// Element resize events
	wp_enqueue_script('jquery-resize', THEME_URI. '/js/jquery.ba-resize.min.js', array('jquery'), '', true);	
	
	// FlexSlider
	wp_enqueue_script('flexslider', THEME_URI. '/flexslider/jquery.flexslider.js', array('jquery'), '', true);
	wp_enqueue_style('flexslider', THEME_URI. '/flexslider/flexslider.css');
	
	// Masonry
	wp_enqueue_script('isotope', THEME_URI. '/js/jquery.isotope.min.js', array('jquery'), '', true);
	
	// Widget CSS
	wp_enqueue_style('widgets', THEME_URI. '/core/widgets/widgets.css');

	// Comment replies
	if (is_singular() && get_option('thread_comments'))
		wp_enqueue_script('comment-reply');
	
	
	// CSS3 media query support for older IE versions
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
		wp_enqueue_script('css3-mediaqueries', THEME_URI. '/js/css3-mediaqueries.js', '', '', true);
		
		wp_enqueue_script('isotope-filter', THEME_URI. '/js/filter-isotope.js', '', '', true);	
		wp_enqueue_script('select-boxes', THEME_URI. '/js/select-boxes.js', '', '', true);	
		wp_enqueue_script('hoverdir', THEME_URI. '/js/jquery.hoverdir.js', '', '', true);	
		wp_enqueue_style('hoverdir', THEME_URI. '/css/jquery.hoverdir.css');
				
		
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


// Theme menus
//
register_nav_menus(array(
	'theme_main' => 'Main menu',
	'theme_footer' => 'Footer menu')
);

$theme_menus['main'] = array(
	'theme_location' => 'theme_main',
	'depth' => 3,
	'menu_class' => '',
	'menu_id' => 'theme-menu-main',
	'container' => false,
	'fallback_cb' => ''
);

$theme_menus['footer'] = array(
	'theme_location' => 'theme_footer',
	'depth' => 1,
	'menu_class' => '',
	'menu_id' => '',
	'container' => false,
	'fallback_cb' => ''
);

// Sociables
//
core_sociables_register('custom1', 'Custom 1', '', '', '', true);
core_sociables_register('custom2', 'Custom 2', '', '', '', true);
core_sociables_register('custom3', 'Custom 3', '', '', '', true);
core_sociables_register('custom4', 'Custom 4', '', '', '', true);
core_sociables_register('custom5', 'Custom 5', '', '', '', true);
core_sociables_register('custom6', 'Custom 6', '', '', '', true);
core_sociables_register('custom7', 'Custom 7', '', '', '', true);
core_sociables_register('custom8', 'Custom 8', '', '', '', true);

// Register post\page option sections
// Post\page option for themes
//
$theme_post_options2 = new CoreOptionHandler(THEME_SLUG . '-post-options2','Layout Width', array('post'));
core_options_handler_register($theme_post_options2);
require_once('includes/post-options2.php');

$theme_post_options = new CoreOptionHandler(THEME_SLUG . '-post-options', THEME_NAME . ' options', array('post', 'page'));
core_options_handler_register($theme_post_options);
require_once('includes/post-options.php');


// SEO Basic
//
core_seo_register_spot('meta', __('Meta Title, Description and Keywords', THEME_SLUG));

// Removes container from wp_nav_menu's menu output
// wp_nav_menu always outputs a div container otherwise, despite the arguments passed to it
//
function theme_fix_menus($args = '') {
	$args['container'] = false;
	return $args;
}
add_filter('wp_nav_menu_args', 'theme_fix_menus');

// Automatically adds prettyPhoto rel attributes to embedded images
//
function theme_content_lightbox($content) {
	$pattern = '/<a(.*?)href="(.*?).(bmp|gif|jpeg|jpg|png)"(.*?)>/i';
  	$replacement = '<a$1href="$2.$3" data-rel="prettyPhoto"$4>';

	return preg_replace($pattern, $replacement, $content);
}
add_filter('the_content', 'theme_content_lightbox');

// Replaces admin panel login logo with theme logo
//
function theme_login_logo() {
	echo '<style type="text/css">';
	echo 'h1 a { background-image: url(' .core_options_get('login_logo'). ') !important; }';
	echo '</style>';
}
add_action('login_head', 'theme_login_logo');

// Outputs the page title and breadcrumbs before a template page
//
function theme_page_title() {
	if (!is_front_page()) {
		global $post;
		echo '<div class="title-row">';
		if (core_options_get('titles') == true){
			if (is_category())
				echo '<h1 class="title entry-title">',single_cat_title( '', false ), '</h1>';
			elseif (is_archive() && is_day() )
				printf( __( '<h1 class="title entry-title">Daily Archives: %s', 'themedutch' ), get_the_date() . '</h1>' );
			elseif (is_archive() && is_month() )
				printf( __( '<h1 class="title entry-title">Monthly Archives: %s', 'themedutch' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'themedutch' ) ) . '</h1>' );
			elseif (is_archive() && is_year() )
				printf( __( '<h1 class="title entry-title">Yearly Archives: %s', 'themedutch' ), get_the_date( _x( 'Y', 'yearly archives date format', 'themedutch' ) ) . '</h1>' );
			elseif (is_tag() )
				printf( __( '<h1 class="title entry-title">Showing posts with tag: %s', 'themedutch' ), single_term_title("", false) . '</h1>' );		
			elseif (is_search() )
				printf( __( '<h1 class="title entry-title">Search Results: %s', 'themedutch' ) , '"<span>' . get_search_query() . '</span>"' . '</h1>' );				
			else {			
					echo '<h1 class="title entry-title">', get_the_title(), '</h1>';
			}
		}
			
		if (core_options_get('breadcrumbs') == true) {
			echo '<div class="theme-breadcrumbs">';
			
			if( ! core_is_buddypress_pages() )
				core_breadcrumbs(' \ ', __('You are here:', THEME_SLUG));
				
			echo '</div>';
		}
		echo '</div>';

	}
}
add_action('core_before_template', 'theme_page_title');

// Outputs the theme's slider area + widget if any
//
function theme_slider_area() {

	$post_type = get_post_type();
	$category = get_query_var('cat');
	$current_category = get_category ($category);
	$slug = '';
	
	if ( is_archive() ){
		$post_type = 'theme';
		
		if ( is_category() )
			$slug = '_'.$current_category->slug;
			
		elseif ( is_author() )
			$slug = '_layout-author';
		
		elseif ( is_tag() )
			$slug = '_layout-tag';
			
		else
			$slug = '_layout-archive';
	} 
	
	if ( is_404() ){
		$post_type = 'theme';
		$slug = '_layout-404';
	}
	 
	if ( is_search() ){
		$post_type = 'theme';
		$slug = '_layout-search';
	} 
	
	if (!$post_type)
		return;

	$slider = core_options_get('slider'.$slug, $post_type);
		
	if (!$slider || $slider == 'none')
		return;
	
	//if ( is_category() ){
		// Slider widget
		$widget_position = '';
		$widget_sidebar = '';			
	//} else {
		// Slider widget
		//$widget_position = core_options_get('widget_position', $post_type);
		//$widget_sidebar = core_options_get('widget_sidebar', $post_type);	
	//}

	
	echo '<div class="row" id="theme-slider-row">';

	// Left widget
	if ($widget_position == 'left' && $widget_sidebar) {
		?>
		<div class="border-box" style="width: 32.89%; float: left; padding-left: 10px; padding-right: 15px;">
			<ul class="border-box" id="theme-slider-widget">
				<?php dynamic_sidebar($widget_sidebar); ?>
			</ul>
		</div>
		<div class="border-box" style="width: 67.10%; float: left; padding-right: 10px;">
			<div class="border-box" id="theme-slider">
				<?php core_slider($slider); ?>
			</div>
		</div>
		<div class="floatfix"></div>
		<?php

	// Right widget
	} else if ($widget_position == 'right' && $widget_sidebar) {
		?>
		<div class="border-box" style="width: 72%; float: left; padding-left: 10px; padding-right: 15px;">
			<div class="border-box" id="theme-slider">
				<?php core_slider($slider); ?>
			</div>
		</div>
		<div class="border-box" style="width: 27.69%; float: left; padding-right: 10px;">
			<ul class="border-box" id="theme-slider-widget">
				<?php dynamic_sidebar($widget_sidebar); ?>
			</ul>
		</div>
		<div class="floatfix"></div>
		<?php

	// No widget
	} else {
		?>
		<div class="border-box" style="width: 100%; float: left; padding: 0;">
			<div id="theme-slider">
				<?php core_slider($slider); ?>
			</div>
		</div>
		<div class="floatfix"></div>
		<?php
	}
	
	echo '</div>';
	
}

// Check if Slider is set 
//
function theme_slider_check(){
	$post_type = get_post_type();
	$category = get_query_var('cat');
	$current_category = get_category ($category);
	$slug = '';
	
	if ( is_archive() ){
		$post_type = 'theme';
		
		if ( is_category() )
			$slug = '_'.$current_category->slug;
			
		elseif ( is_author() )
			$slug = '_layout-author';
		
		elseif ( is_tag() )
			$slug = '_layout-tag';
			
		else
			$slug = '_layout-archive';
	}  
	if ( is_404() ){
		$post_type = 'theme';
		$slug = '_layout-404';
	} 
	if ( is_search() ){
		$post_type = 'theme';
		$slug = '_layout-search';
	} 
	
	if (!$post_type)
		return false;

	$slider = core_options_get('slider'.$slug, $post_type);
		
	if (!$slider || $slider == 'none')
		return false;
		
	return true;
}

// Miscellaneous
//

// Post thumbnail support
if ( function_exists( 'add_image_size' ) ) { 
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(300, 275, false);
	add_image_size('post-featured', 1080, 200, false);
	add_image_size('post-excerpt', 1080, 275, true);
	add_image_size('tdac-thumb', 90, 90, true);
	add_image_size( 'portfolio-thumb', 9999 , 201, true ); //(cropped)
	add_image_size( 'portfolio-thumb_medium', 9999 , 201, true ); //(cropped)
	add_image_size( 'portfolio-thumb_large', 9999 , 409, true ); //(cropped)
}

// Feed links
add_theme_support('automatic-feed-links');

// Content width
if (!isset($content_width))
	$content_width = 1080;

// Editor styling
add_editor_style('css/editor-style.css');

// Load Page Styles
function load_page_styles(){
	get_template_part('styles');
}
add_action('wp_head', 'load_page_styles', 10);

// Google Analytics
function core_load_google_analytics(){
	$analytics = core_options_get('google_analytics');
	if ($analytics)
		echo $analytics;
}
add_action('wp_head', 'core_load_google_analytics', 99);

// add demo settings
function core_load_cutomize_settings(){
	$customize = core_options_get('customize');
	core_demo_settings_enable($customize);
}
add_action('wp_footer', 'core_load_cutomize_settings', 99);	
		
// add custom javascripts
function core_load_custom_js(){
	$custom_js = core_options_get('custom_js');
	if ($custom_js)
		echo $custom_js;	
}
add_action('wp_footer', 'core_load_custom_js', 99);	

// Post Formats
add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio') );

// Post Format Admin UI
//
add_action('after_setup_theme', 'core_load_post_format_plugin');
add_action('after_setup_theme', 'core_load_html5_audio_plugin');

// This function loads the post format plugin.
function core_load_post_format_plugin() {
	if (!defined('CFPF_VERSION')) {
		// load CF Post Format if not already loaded
		include_once( THEME_PATH . '/core/cf-post-formats/cf-post-formats.php');
	}
}

// This function loads the oEmbed audio player plugin.
function core_load_html5_audio_plugin() {
	if (!defined('MEDIAELEMENTJS_DIR')) {
		// load Audio player if not already loaded
		include_once( THEME_PATH . '/core/audio/mediaelement-js-wp.php');
	}
}


// Video Output
function the_featured_video( &$content ) {
    $url = trim( array_shift( explode( "\n", $content ) ) );
    $w = get_option( 'embed_size_w' );
    if ( !is_single() )
        $url = str_replace( '448', $w, $url );

    if ( 0 === strpos( $url, 'http://' ) ) {
        echo apply_filters( 'the_content', $url );
        $content = trim( str_replace( $url, '', $content ) );                
    } else if ( preg_match ( '#^<(script|iframe|embed|object)#i', $url ) ) {
        $h = get_option( 'embed_size_h' );
        if ( !empty( $h ) ) {
            //if ( $w === $h ) 
            $h = ceil( $w * 0.25 );

            $url = preg_replace( 
                array( '#height="[0-9]+?"#i', '#height=[0-9]+?#i' ), 
                array( sprintf( 'height="%d"', $h ), sprintf( 'height=%d', $h ) ), 
                $url 
            );
        }

        echo $url;
        $content = trim( str_replace( $url, '', $content ) ); 
    }
}

// Gallery Format PrettyPhoto
add_filter( 'wp_get_attachment_link', 'core_load_gallery_prettyphoto');

function core_load_gallery_prettyphoto ($content) {
	$content = preg_replace("/<a/","<a data-rel=\"prettyPhoto[gallery-format]\"",$content,1);
	return $content;
}

// Theme customize option
function theme_menus() {
	if (function_exists('_wp_customize_include'))
		add_theme_page(sprintf(__('Customize %s', THEME_SLUG), THEME_NAME), sprintf(__('Customize %s', THEME_SLUG), THEME_NAME), 'edit_theme_options', 'customize.php', '', '', 6);
}
add_action('admin_menu', 'theme_menus');

// Font preview text
core_fonts_preview_text(__('Amazingly few discotheques provide jukeboxes.', THEME_SLUG));


// ****************************************************************
// Plugin activation and style overrides
// ****************************************************************

// This function loads the google maps widget plugin.
add_action('after_setup_theme', 'core_load_google_maps_widget_plugin');
function core_load_google_maps_widget_plugin() {
 if (!defined('GMW_VER')) {
  // load CF Post Format if not already loaded
  include_once( THEME_PATH . '/core/google-maps-widget/google-maps-widget.php');
 }
}
add_action( 'wp_print_styles', 'plugin_override_styles', 11 );

function plugin_override_styles() {

	// check if Socialbox is active
	if ( is_plugin_active('socialbox/socialbox.php')) {
    	wp_dequeue_style('socialbox');
    }

}

remove_filter('widget_text', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');

?>
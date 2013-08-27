<?php

if (!defined('CORE_VERSION'))
	die();


// Available advertisement spots on a given page
//
$core_seo = array();


// Registers a new ad spot
//
function core_seo_register_spot($seo_slug, $seo_title) {
	global $core_seo;

	$core_seo[$seo_slug] = $seo_title;
}

// Adds ad post options
//
function core_seo_options() {
	global $core_seo;

	$seo_options = new CoreOptionHandler(THEME_SLUG . '-seo', THEME_NAME . ' SEO Basic', array('post', 'page'));
	core_options_handler_register($seo_options);

	$options = new CoreOptionGroup('seo', 'SEO');
	$seo_options->group_add($options);

	// Add settings for each ad spot
	foreach ($core_seo as $seo_slug => $seo_title) {
		$section = new CoreOptionSection($seo_slug, $seo_title);
		$options->section_add($section);
		$section->option_add(new CoreOption('seo_' . $seo_slug . '_show', __('Enable for this page.', THEME_SLUG), 'checkbox', null, false));

		$section->option_add(new CoreOption('seo_' . $seo_slug . '_title', __('Page Title', THEME_SLUG), 'text'));
		$section->option_add(new CoreOption('seo_' . $seo_slug . '_desc', __('Meta Description', THEME_SLUG), 'text-multiline', __('The description should optimally be between 150-160 characters.', THEME_SLUG)));
		$section->option_add(new CoreOption('seo_' . $seo_slug . '_keywords', __('Keywords', THEME_SLUG), 'text-multiline', __('Separate each keyword with a comma.', THEME_SLUG)));
	}
}
add_action('after_setup_theme', 'core_seo_options');

// Display SEO Basic Meta
//
function core_seo_basic($spot){

	$post_type = get_post_type();
	$category = get_query_var('cat');
	$current_category = get_category ($category);
	
	if (!$post_type)
		return null;
	
	// SEO Basic Title
	core_seo_basic_enable();	
		
	// display generic description from General Settings
	if (  is_home() || is_front_page() || is_singular()  ) {
		
		// Check if SEO Basic is enabled.
		$show = core_options_get('seo_' . $spot . '_show', $post_type);
		
		if ($show){
			
			$title = core_options_get('seo_' . $spot . '_title', $post_type);
			$desc = core_options_get('seo_' . $spot . '_desc', $post_type);
			$keywords = core_options_get('seo_' . $spot . '_keywords', $post_type);
			
			// display generic description from General Settings
			if (  (is_home()) || (is_front_page())  )
				echo "<meta name=\"description\" content=\"". get_bloginfo('description') ."\" />\n";
				
			if ( is_single() ){
				if ( $desc ) 
					echo "<meta name=\"description\" content=\"" . $desc . "\"/>\n\t";
			
				if ( $keywords ) 
					echo "<meta name=\"keywords\" content=\"" . $keywords . "\"/>\n\t";			
			}	
		} else {
			printf(__('<!-- SEO Basic is disabled -->', THEME_SLUG));
		}	
	
	} else {
		
		if ( is_category() ){
			
			$desc = core_options_get('seo_desc-'. $current_category->slug, 'theme');
			$keywords = core_options_get('seo_keywords-'. $current_category->slug, 'theme');
			
			if ( $desc ) 
				echo "<meta name=\"description\" content=\"" . $desc . "\"/>\n\t";		

			if ( $keywords ) 
				echo "<meta name=\"keywords\" content=\"" . $keywords . "\"/>\n\t";			
		
		} elseif ( is_archive() ){
			echo "<meta name=\"description\" content=\"Archives - " . get_bloginfo('description') . "\"/>\n\t";		
			
		} elseif ( is_search() ){
			echo "<meta name=\"description\" content=\"Search - " . get_bloginfo('description') . "\"/>\n\t";		
			
		} elseif ( is_author() ){
			echo "<meta name=\"description\" content=\"" . get_the_author() ." - ". get_bloginfo('description') . "\"/>\n\t";		
			
		} elseif ( is_tag() ){
			
			echo "<meta name=\"keywords\" content=\"" . single_tag_title("", false) . "\"/>\n\t";			
			
		} elseif ( is_404() ){
			echo "<meta name=\"description\" content=\"Page not found! \"/>\n\t";		
			
		} else {
			// default
			echo "<meta name=\"description\" content=\"". get_bloginfo('description') ."\" />\n";
		}
		
		
	}

}

// Apply WP Title Filter which works only on singular pages
function core_seo_basic_apply($spot){
	global $post;
	global $core_seo;
	
	// Check if SEO Basic is enabled.
	 if (is_object($post)) {
	if(!is_404()){
		$show = core_options_get('seo_' . $spot . '_show', $post->post_type);
		$title = core_options_get('seo_' . $spot . '_title', $post->post_type);	
	} else {
		return NULL;
	}
	
	if (is_null($spot) || is_null($show) || is_null($title) )
		return NULL;
	
	if ($show && $title)
		return $title;
	else
		return NULL;
	 }
}

// Enable SEO Basic from Freeze options
function core_seo_basic_enable(){
		add_filter( 'wp_title', 'core_seo_filter_wp_title', 10, 3 );	
}
add_action('after_setup_theme', 'core_seo_basic_enable');

// WP Title filter function
//
function core_seo_filter_wp_title( $old_title, $sep, $sep_location ){ 
	
	$ssep = ' ' . $sep . ' ';
	 
	// find the type of index page this is
	if( is_category() ) $insert = $ssep . 'Category';
	elseif( is_tag() ) $insert = $ssep . 'Tag';
	elseif( is_404() ) $insert = $ssep . 'Error 404';
	elseif( is_author() ) $insert = $ssep . 'Author';
	elseif( is_year() || is_month() || is_day() ) $insert = $ssep . 'Archives';
	else $insert = null;
	 
	// get the page number we're on (index)
	if( get_query_var( 'paged' ) )
		$num = $ssep . 'page ' . get_query_var( 'paged' );
	 
	// get the page number we're on (multipage post)
	elseif( get_query_var( 'page' ) )
		$num = $ssep . 'page ' . get_query_var( 'page' );
	 
	// else
	else $num = NULL;
	 
	if( ! is_null(core_seo_basic_apply('meta')) )
		 $old_title = $ssep . core_seo_basic_apply('meta');

	 
	// concoct and return new title
	return  $insert . $old_title . $num;
}

?>
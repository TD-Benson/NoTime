<?php

if (!defined('CORE_VERSION'))
	die();


// The sidebar currently being generated
$core_current_sidebar = null;

// The template being displayed.
// index.php is always called, but the layout generator will include the appropriate template file where the content should be
$core_template = array(
	'slug' => '',
	'name' => '',
	'external' => false,
	'path' => '',
);


// Filters the current page's template filename
// Stores the requested template name and slug, then always returns index.php
//
function core_layout_template($path) {
	global $core_template;

	$filename = pathinfo($path, PATHINFO_FILENAME);
	$filename = explode('-', $filename);
	$filepath = pathinfo($path, PATHINFO_DIRNAME);

	// Handle external files from plugins
	if ($filepath !== THEME_PATH) {
		$core_template['external'] = true;
		$core_template['path'] = $path;
	}

	// Get name and slug from path filename
	$core_template['slug'] = $filename[0];
	if (isset($filename[1]))
		$core_template['name'] = $filename[1];
	else
		$core_template['name'] = '';

	if ($core_template['slug'] == 'index')
		$core_template['slug'] = 'loop';

	return THEME_PATH . '/index.php';
}
add_filter('template_include', 'core_layout_template', 100);

// Returns the layout of the current WordPress page being displayed
//
function core_layout_current() {
	global $core_layout_default;
	global $core_layout_types;
	global $core_layout_footer_types;
	global $post;

	// Single post\page
	if (is_singular()) {
		$value = core_options_get('layout', $post->post_type);

	// Category
	} else if (is_category()) {
		$obj = get_queried_object();
		$value = core_options_get('layout-category-' .$obj->slug);

	// Tags
	} else if (is_tag()) {
		$value = core_options_get('layout-tag');

	// Author
	} else if (is_author()) {
		$value = core_options_get('layout-author');

	// Archive
	} else if (is_archive() || is_day() || is_month()) {
		$value = core_options_get('layout-archive');

	// Search results
	} else if (is_search()) {
		$value = core_options_get('layout-search');

	// 404
	} else if (is_404()) {
		$value = core_options_get('layout-404');
		
	// Default layout
	} else {
		$value = $core_layout_default;
	}

	$value = apply_filters('core_layout', $value);

	// Assign default layout for broken values
	if (!isset($value['layout']) || !isset($value['footer']))
		$value = $core_layout_default;

	// Create layout data
	$layout = array();
	$layout['layout'] = $core_layout_types[$value['layout']];
	$layout['layout-sidebars'] = $value['layout-sidebars'];
	$layout['footer'] = $core_layout_footer_types[$value['footer']];
	$layout['footer-sidebars'] = $value['footer-sidebars'];

	return $layout;
}
// Footer Tabs Output
//

function core_layout_footer_tabs_output(){
	global $wp_registered_sidebars;
	$options_ft_layout = core_options_get('layout_footertabs');
	$footer = $options_ft_layout['footer-sidebars'];
	switch($options_ft_layout['footer']){
		case 'one' :
		$limit = 1;
		break;
		case 'two' :
		$limit = 2;
		break;
		case 'three' :
		$limit = 3;
		break;
		case 'four' :
		$limit = 4;
		break;
		case 'five' :
		$limit = 5;
		break;
		case 'six' :
		$limit = 6;
		break;
	}

	if(!is_array($footer))
		return false;

	foreach($footer as $index => $key){
		$title[] = $wp_registered_sidebars[$key]['name'];
		$widgets[] = $key;
		if($index  == $limit - 1 ) break;

	}

	return array('tabtitles'=> $title, 'tabcontents' => $widgets);	
	
}




// Content layout
//
function core_layout_content_generate() {
	do_action('core_before_content');

	$layout = core_layout_current();
	core_layout_generate_type($layout['layout'], $layout['layout-sidebars']);

	do_action('core_after_content');
}
add_action('core_content', 'core_layout_content_generate');

// Generates output for a layout type
//
function core_layout_generate_type($layout, $sidebars) {
	global $core_current_sidebar;
	global $core_template;

	$sidebar_index = 0;
	foreach ($layout->elements as $element) {

		echo $element->before;

		// Set current sidebar slug
		if ($element->type == 'sidebar') {
			
			if (isset($sidebars[$sidebar_index])) {
				$core_current_sidebar = $sidebars[$sidebar_index];
				$sidebar_index++;
			//echo " <strong>FLAG HERE</strong>";
			} else {
				core_warning(__('No sidebar defined for this widget location.', THEME_SLUG));
				$core_current_sidebar = null;
			}
		}

		// Template elements use the current WordPress template
		if ($element->type == 'template') {
			do_action('core_before_template');

			if ($core_template['external'])
				require_once($core_template['path']);
			else
				get_template_part($core_template['slug'], $core_template['name']);
			
			do_action('core_after_template');
		}

		// Other elements use the template type's name
		else
			get_template_part($element->type);

		echo $element->after;
	}

	$core_current_sidebar = null;
}

// Returns the sidebar currently being generated, if any
//
function core_layout_current_sidebar() {
	global $core_current_sidebar;

	return $core_current_sidebar;
}

// Footer layout
//
function core_layout_footer_generate() {
	do_action('core_before_footer');

	$layout = core_layout_current();
	core_layout_generate_type($layout['footer'], $layout['footer-sidebars']);

	do_action('core_after_footer');
}
add_action('core_footer', 'core_layout_footer_generate');

// Outputs pagination links
//
function core_layout_pagination()
{
	global $wp_query;
	global $paged;

	
	$page_count = $wp_query->max_num_pages;
	$page_current = $paged;
	if ($page_current == 0)
		$page_current = 1;

	if ($page_count <= 1)
		return;

	echo '<ul class="theme-pagination">';


	// Pagination
	$links = paginate_links(array(
		'base' => str_replace(9999, '%#%', esc_url(get_pagenum_link(9999))),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $wp_query->max_num_pages,
		'type' => 'array'
	));
	
	foreach ($links as $link) {
		if (strpos($link, 'current')) {
			$active = ' class="active"';
			$link = str_replace('<span class="pagenumbers current">', '', $link);
		} else {
			$active = '';
			$link = str_replace('<span class="pagenumbers">', '', $link);
		}

		echo '<li' . $active . '>' . $link . '</li>';
	}

	echo '</ul>';
}

// Outputs a menu
//
function core_layout_menu($menu_name) {
	global $theme_menus;

	$location = $theme_menus[$menu_name]['theme_location'];

	if (has_nav_menu($location))
		wp_nav_menu($theme_menus[$menu_name]);
}

?>
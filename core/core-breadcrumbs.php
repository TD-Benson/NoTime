<?php

if (!defined('CORE_VERSION'))
	die();


// Returns a trail of categories as an array
//
function core_breadcrumbs_category_trail($category) {
	$trail = array();

	$link = get_category_link($category->cat_ID);
	$trail[$link] = $category->name;

	// Recurse into parents
	while ($category->parent) {
		$category = get_category($category->parent);
		$link = get_category_link($category->cat_ID);
		$trail[$link] = $category->name;
	}

	return array_reverse($trail);
}

// Returns a trail of posts as an array
//
function core_breadcrumbs_post_trail($post) {
	$trail = array();

	$link = get_permalink($post->ID);
	$trail[$link] = get_the_title($post->ID);

	// Recurse into parents
	while ($post->post_parent) {
		$post = get_page($post->post_parent);
		$link = get_permalink($post->ID);
		$trail[$link] = get_the_title($post->ID);
	}

	return array_reverse($trail);
}

// Returns a trail of archive dates as array
//
function core_breadcrumbs_date_trail($year=false, $month=false, $day=false) {
	$trail = array();

	if ($year) {
		$year = get_the_time('Y');
		$link = get_year_link($year);
		$trail[$link] = get_the_time('Y');
	}

	if ($month) {
		$month = get_the_time('m');
		$link = get_month_link($year, $month);
		$trail[$link] = get_the_time('F');
	}

	if ($day) {
		$day = get_the_time('d');
		$link = get_day_link($year, $month, $day);
		$trail[$link] = get_the_time('l');
	}

	return $trail;
}

// Outputs breadcrumb links for the current page
//
function core_breadcrumbs($separator='&raquo;', $prefix='You are here: ', $home_title='Home') {
	global $post;
	global $wp_query;
	global $author;
	global $paged;

	$trail = array();
	$request_uri = core_request_uri();

	// Generate trail array
	// Categories
	if (is_category()) {
		$obj = $wp_query->get_queried_object();
		$slug = $obj->term_id;

		$category = get_category($slug);
		$trail = core_breadcrumbs_category_trail($category);

	// Single post
	} else if (is_single()) {
		$category = get_the_category();
		if (count($category)) {
			$category = $category[0];
			$trail = core_breadcrumbs_category_trail($category);
		}
			
		$link = get_permalink();
		$trail[$link] = get_the_title();
	
	// Pages
	} else if (is_page()) {
		if ( core_is_buddypress_pages() ) {
			$page_title	= bp_get_page_title();
			$trail[$request_uri] = sprintf(__('%s', THEME_SLUG), ucwords(strtolower($page_title)));
		} else
			$trail = core_breadcrumbs_post_trail($post);
	
	// 404 page
	} else if (is_404()) {
		$trail[$_SERVER['REQUEST_URI']] = '404';

	// Archive by date
	} else if (is_day()) {
		$trail = core_breadcrumbs_date_trail(true, true, true);
	} else if (is_month()) {
		$trail = core_breadcrumbs_date_trail(true, true);
	} else if (is_year()) {
		$trail = core_breadcrumbs_date_trail(true);

	// Search page
	} else if (is_search()) {
		$trail[$request_uri] = sprintf(__('Search results for "%s"', THEME_SLUG), get_search_query());

	// Tags page
	} else if (is_tag()) {
		$trail[$request_uri] = sprintf(__('tag \ %s', THEME_SLUG), strtolower(single_term_title("", false)));

	// Author page
	} else if (is_author()) {
		$userdata = get_userdata($author);
		$trail[$request_uri] = __('Author', THEME_SLUG) . ' ' . $userdata->display_name;
	
	} else if(is_post_type_archive('product')){
		$trail[$link] = 'Shop';
	}
 
	// Output trail array
	echo $prefix, ' <a href="', get_site_url(), '">', $home_title, '</a> ';
	foreach ($trail as $link => $title)
		echo $separator, '<a href="', $link, '">', $title, '</a> ';
}

?>
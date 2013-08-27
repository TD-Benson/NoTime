<?php

if (!defined('CORE_VERSION'))
	die();


require_once('colorschemes-options.php');


// Enqueue scripts
//
function core_colorschemes_enqueue_scripts() {
	wp_enqueue_style('core-colorschemes-sctyle', CORE_URI. '/colorschemes/colorschemes.css');
	wp_enqueue_script('core-colorschemes-script', CORE_URI. '/colorschemes/colorschemes.js', '', '', true);
}
add_action('admin_enqueue_scripts', 'core_colorschemes_enqueue_scripts');


// Custom CSS for content color schemes
// TODO: Move CSS rules into customizable array, or something similar
//
function core_colorschemes_css() {
	$scheme = null;

	// Get scheme from post\page or category
	if (is_singular())
		$scheme = core_options_get('colorscheme', get_post_type());
		
	if (is_archive()){
		
		if (!$scheme && is_category()) {
			$obj = get_queried_object();
			$scheme = core_options_get('category_colorscheme_' .$obj->slug);
		} elseif (is_author())
			$scheme = core_options_get('layout-author_colorscheme', 'theme');
			
		elseif (is_tag())
			$scheme = core_options_get('layout-tag_colorscheme', 'theme');
		else
			$scheme = core_options_get('layout-archive_colorscheme', 'theme');
	}
		
	if (is_404())
		$scheme = core_options_get('layout-404_colorscheme', 'theme');
		
	if (is_search())
		$scheme = core_options_get('layout-search_colorscheme', 'theme');

	if (!$scheme)
		return;

	$schemes = core_options_get('colorschemes');
	if (!isset($schemes[$scheme]))
		return;

	$scheme = $schemes[$scheme];

	// Calculate rgba() strings
	$backgroundcolor = core_hex2rgb($scheme['color-background']);
	$backgroundcolor['alpha'] = intval($scheme['opacity-background']) / 100;

	// Outline is 60% alpha of original
	$outline = core_hex2rgb($scheme['color-background']);
	$outline['alpha'] = intval($scheme['opacity-background']) / 100 * 0.6;
	
	// Background Color
	echo '.theme-content-row, #theme-footer-tabs {';
	echo 'background-color: ', core_color2rgba($backgroundcolor), ';';
	echo '}';
	
	// Content block CSS
	echo '.theme-content-row .theme-content p {';
	echo 'outline-color: ', core_color2rgba($outline), ';';
	echo 'color: #', $scheme['color-paragraph'], ';';
	echo '}';

	// Heading shortcodes
	echo 'div.shortcode-header h1,';
	echo 'div.shortcode-header h2,';
	echo 'div.shortcode-header h3,';
	echo 'div.shortcode-header h4,';
	echo 'div.shortcode-header h5,';
	echo 'div.shortcode-header h6 {';
	// echo 'background-color: ', core_color2rgba($backgroundcolor), ';';  //
	echo '}';

	// Anchor CSS
	//echo '.theme-content-container a {';
	//echo 'color: #', $scheme['color-paragraph'], ';';
	//echo '}';

	// Comment form
	echo '#commentform p,';
	echo '#commentform a {';
	echo 'color: #', $scheme['color-paragraph'], ';';
	echo '}';	

	// Headings CSS
	echo '.theme-content-container h1,';
	echo '.theme-content-container h2,';
	echo '.theme-content-container h3,';
	echo '.theme-content-container h4,';
	echo '.theme-content-container h5,';
	echo '.theme-content-container h6,';
	echo '.theme-content-container h1 a,';
	echo '.theme-content-container h2 a,';
	echo '.theme-content-container h3 a,';
	echo '.theme-content-container h4 a,';
	echo '.theme-content-container h5 a,';
	echo '.theme-content-container h6 a {';
	echo 'color: #', $scheme['color-headings'], ';';
	echo '}';
}
add_action('core_custom_css', 'core_colorschemes_css');

?>
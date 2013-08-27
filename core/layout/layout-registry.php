<?php

if (!defined('CORE_VERSION'))
	die();


// Default sidebar configuration
// Key = slug, value = title
$core_layout_default_sidebars = null;
$core_block_default_sidebars = null;

// Default layout configuration
// layout = layout type slug
// layout-sidebars = indexed array of sidebar slugs
// footer = footer type slug
// footer-sidebars = indexed array of sidebar slugs
$core_layout_default = null;
$core_block_default = null;

// Registered sidebars
// Key = slug, value = title
$core_sidebars = null;

// Layout types
$core_layout_types = array();
$core_layout_footer_types = array();
$core_block_types = array();
$core_block_footer_types = array();


// Registers a new layout type
//
function core_layout_type_register($layout) {
	global $core_layout_types;

	$core_layout_types[$layout->slug] = $layout;
}
function core_block_type_register($layout) {
	global $core_block_types;

	$core_block_types[$layout->slug] = $layout;
}

// Registers a new footer type
//
function core_layout_footer_type_register($footer) {
	global $core_layout_footer_types;

	$core_layout_footer_types[$footer->slug] = $footer;
}
function core_block_footer_type_register($footer) {
	global $core_block_footer_types;

	$core_block_footer_types[$footer->slug] = $footer;
}

// Sets the default sidebar configuration
//
function core_layout_set_default_sidebars($default) {
	global $core_layout_default_sidebars;

	$core_layout_default_sidebars = $default;
}
function core_block_set_default_sidebars($default) {
	global $core_block_default_sidebars;

	$core_block_default_sidebars = $default;
}

// Sets the default layout configuration
//
function core_layout_set_default($default) {
	global $core_layout_default;

	$core_layout_default = $default;
}
function core_block_set_default($default) {
	global $core_block_default;

	$core_block_default = $default;
}

// Sets the default footer configuration
//
function core_layout_set_footer_default($default) {
	global $core_layout_footer_default;

	$core_layout_footer_default = $default;
}
function core_block_set_footer_default($default) {
	global $core_block_footer_default;

	$core_block_footer_default = $default;
}

// Sets the default slide panel configuration
//
function core_layout_set_slidepanel_default($default) {
	global $core_layout_slidepanel_default;

	$core_layout_slidepanel_default = $default;
}

?>
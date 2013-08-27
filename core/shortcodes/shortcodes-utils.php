<?php

if (!defined('CORE_VERSION'))
	die();


// Cleans and splits contents separated by newlines into an array
//
function core_shortcode_get_array($content) {
	$items = strip_tags($content);
	$items = str_replace(array("\r\n", "\n", "\r"), ',', $items);
	$items = explode(',', $items);
	$items = array_splice($items, 1, -1);

	$new_items = array();
	foreach ($items as $item) {
		if ($item)
			array_push($new_items, $item);
	}

	return $new_items;
}

// Returns the first attribute set in an attribute list
// [column third] returns third if it is in the types array
//
function core_shortcode_validate_type($atts, $types, $default) {
	if ($atts == '')
		return $default;

	foreach($types as $type) {
		if (in_array($type, $atts))
			return $type;
	}

	return $default;
}

?>
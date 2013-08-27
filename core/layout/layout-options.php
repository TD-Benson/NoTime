<?php

if (!defined('CORE_VERSION'))
	die();


// Outputs a simple sidebar select input
//
function core_layout_option_sidebarlist_output($id, $value, $option) {
	global $core_sidebars;

	echo '<select id="', $id, '" name="', $id, '">';

	// Output sidebar selection boxes
	foreach ($core_sidebars as $sidebar_slug => $sidebar_title) {
		if ($sidebar_slug == $value)
			$selected = ' selected';
		else
			$selected = '';

		echo '<option', $selected, ' value="', $sidebar_slug, '">', $sidebar_title, '</option>';
	}
	
	echo '</select>';
}
core_options_type_register('sidebar-list', 'core_layout_option_sidebarlist');

// Outputs layout picker list for a layout option
//
function core_layout_option_output_picker($type, $value, $option, $layout_types,$get = false ) {
	$sidebar_count = array();
	$output = "";
	// Output the layout picker
	$output .= '<ul class="core-layout-choice" data-type="'.$type. '">';
	foreach ($layout_types as $layout_name => $layout) {
		// Count number of sidebars in this layout
		$sidebar_count[$layout_name] = 0;
		if(empty($layout->elements)) continue;
		
		foreach ($layout->elements as $element) {
			if ($element->type == 'sidebar')
				$sidebar_count[$layout_name]++;
		}

		if ($value[$type] == $layout_name)
			$selected = ' selected';
		else
			$selected = '';

		// Output icon
		$output .=  '<li class="'. $selected. '" data-layout-name="'. $layout_name. '" data-sidebar-count="'. $sidebar_count[$layout_name]. '">';
		$output .=  '<img src="'. $layout->icon_uri. '">';
		$output .=  '</li>';
	}
	$output .=  '</ul>';
	if($get == false) echo $output;
	else return $output;
	return $sidebar_count;
}

// Outputs sidebar select inputs for a layout option
//
function core_layout_option_output_sidebars($type, $value, $option, $layout_types, $sidebar_count, $sidebar_naming) {
	global $core_sidebars;

	echo '<div>';
	
	// Layout properties
	$layout_name = $value[$type];
	$layout_sidebars = $value[$type. '-sidebars'];

	// Layout references
	$layout = $layout_types[$layout_name];
	$layout_sidebar_count = $sidebar_count[$layout_name];
	$max_sidebar_count = max($sidebar_count);

	// Output sidebar selection boxes
	for ($index = 0; $index < $max_sidebar_count; $index++) {
		
		// Hide sidebar selections that aren't needed for the current layout
		if ($index >= $layout_sidebar_count)
			$visibility = ' style="display: none;"';
		else
			$visibility = '';

		echo '<div data-type="', $type, '" class="core-layout-sidebar"', $visibility, '>';
		echo '<p>', $sidebar_naming, ' ', $index + 1, '</p>';

		// Output registered sidebar name options
		echo '<select data-index="', $index, '" data-type="', $type, '">';
		foreach ($core_sidebars as $sidebar_slug => $sidebar_title) {
			if (isset($layout_sidebars[$index]) && $layout_sidebars[$index] == $sidebar_slug)
				$selected = ' selected';
			else
				$selected = '';

			echo '<option', $selected, ' data-name="', $sidebar_slug, '">', $sidebar_title, '</option>';
		}
		echo '</select>';

		echo '</div>';
	}

	echo '</div>';
}

// Outputs layout option type
//
function core_layout_option_output($id, $value, $option) {
	global $core_layout_types;
	global $core_layout_footer_types;
	global $core_layout_default;

	// Replace broken input with defaults
	if (!isset($value['layout']) || !isset($value['footer']) || $value == null)
		$value = $core_layout_default;

	// Output layout pickers
	$layout_sidebar_count = core_layout_option_output_picker('layout', $value, $option, $core_layout_types);
	//$footer_sidebar_count = core_layout_option_output_picker('footer', $value, $option, $core_layout_footer_types);

	// Output sidebar options
	core_layout_option_output_sidebars('layout', $value, $option, $core_layout_types, $layout_sidebar_count, __('Sidebar', THEME_SLUG));
	//core_layout_option_output_sidebars('footer', $value, $option, $core_layout_footer_types, $footer_sidebar_count, __('Footer column', THEME_SLUG));
	
	
	// Hidden input field to store selected values
	echo '<input type="hidden" id="', $id, '" name="', $option->key, '" value=\'', json_encode($value), '\'>';
}
function core_layout_option_import($value, $option) {
	return json_decode(stripslashes($value), true);
}
core_options_type_register('layout', 'core_layout_option');

// ------------------------------------------------------------------------------------------------------- //
// Outputs block option type currently used in tabbed panel in the footer and the slide panel on top

// Outputs a simple sidebar select input
//
function core_block_option_sidebarlist_output($id, $value, $option) {
	global $core_sidebars;

	echo '<select id="', $id, '" name="', $id, '">';

	// Output sidebar selection boxes
	foreach ($core_sidebars as $sidebar_slug => $sidebar_title) {
		if ($sidebar_slug == $value)
			$selected = ' selected';
		else
			$selected = '';

		echo '<option', $selected, ' value="', $sidebar_slug, '">', $sidebar_title, '</option>';
	}
	
	echo '</select>';
}
core_options_type_register('sidebar-list', 'core_block_option_sidebarlist');

// Outputs layout picker list for a block option
//
function core_block_option_output_picker($type, $value, $option, $layout_types,$get = false ) {
	$sidebar_count = array();
	$output = "";
	// Output the layout picker
	$output .= '<ul class="core-layout-choice" data-type="'.$type. '">';
	foreach ($layout_types as $layout_name => $layout) {
		// Count number of sidebars in this layout
		$sidebar_count[$layout_name] = 0;
		if(empty($layout->elements)) continue;
		
		foreach ($layout->elements as $element) {
			if ($element->type == 'sidebar')
				$sidebar_count[$layout_name]++;
		}

		if ($value[$type] == $layout_name)
			$selected = ' selected';
		else
			$selected = '';

		// Output icon
		$output .=  '<li class="'. $selected. '" data-layout-name="'. $layout_name. '" data-sidebar-count="'. $sidebar_count[$layout_name]. '">';
		$output .=  '<img src="'. $layout->icon_uri. '">';
		$output .=  '</li>';
	}
	$output .=  '</ul>';
	if($get == false) echo $output;
	else return $output;
	return $sidebar_count;
}

// Outputs sidebar select inputs for a layout option
//
function core_block_option_output_sidebars($type, $value, $option, $layout_types, $sidebar_count, $sidebar_naming) {
	global $core_sidebars;

	echo '<div>';
	
	// Layout properties
	$layout_name = $value[$type];
	$layout_sidebars = $value[$type. '-sidebars'];

	// Layout references
	$layout = $layout_types[$layout_name];
	$layout_sidebar_count = $sidebar_count[$layout_name];
	$max_sidebar_count = max($sidebar_count);

	// Output sidebar selection boxes
	for ($index = 0; $index < $max_sidebar_count; $index++) {
		
		// Hide sidebar selections that aren't needed for the current layout
		if ($index >= $layout_sidebar_count)
			$visibility = ' style="display: none;"';
		else
			$visibility = '';

		echo '<div data-type="', $type, '" class="core-layout-sidebar"', $visibility, '>';
		echo '<p>', $sidebar_naming, ' ', $index + 1, '</p>';

		// Output registered sidebar name options
		echo '<select data-index="', $index, '" data-type="', $type, '">';
		foreach ($core_sidebars as $sidebar_slug => $sidebar_title) {
			if (isset($layout_sidebars[$index]) && $layout_sidebars[$index] == $sidebar_slug)
				$selected = ' selected';
			else
				$selected = '';

			echo '<option', $selected, ' data-name="', $sidebar_slug, '">', $sidebar_title, '</option>';
		}
		echo '</select>';

		echo '</div>';
	}

	echo '</div>';
}

//
function core_block_option_output($id, $value, $option) {
	global $core_block_types;
	global $core_block_footer_types;
	global $core_block_default;

	// Replace broken input with defaults
	if (!isset($value['layout']) || !isset($value['footer']) || $value == null)
		$value = $core_block_default;

	// Output layout pickers
	//$layout_sidebar_count = core_layout_option_output_picker('layout', $value, $option, $core_block_types);
	$footer_sidebar_count = core_block_option_output_picker('footer', $value, $option, $core_block_footer_types);

	// Output sidebar options
	//core_layout_option_output_sidebars('layout', $value, $option, $core_block_types, $layout_sidebar_count, __('Sidebar', THEME_SLUG));
	core_block_option_output_sidebars('footer', $value, $option, $core_block_footer_types, $footer_sidebar_count, __('Footer column', THEME_SLUG));
	
	// Hidden input field to store selected values
	echo '<input type="hidden" id="', $id, '" name="', $option->key, '" value=\'', json_encode($value), '\'>';
}
function core_block_option_import($value, $option) {
	return json_decode(stripslashes($value), true);
}
core_options_type_register('block', 'core_block_option');

// Outputs sidebars option type
//
function core_layout_sidebars_output($id, $value, $option) {

	echo '<input type="text" class="core-option-sidebars-name">';
	echo '<input type="button" class="core-option-sidebars-add" value="' . __('Add', THEME_SLUG) . '">';

	echo '<h2>' . __('Available sidebars', THEME_SLUG) . '</h2>';
	echo '<input type="hidden" name="', $option->key, '" id="' ,$id, '" value=\'', json_encode($value), '\'>';

	// Invisible sidebar item for JavaScript cloning
	echo '<div class="core-option-sidebar-cloneable" data-options-name="', $id, '" data-sidebar-slug="">';
	echo '<p></p>';
	echo '<a href="#">' . __('Remove', THEME_SLUG) . '</a>';
	echo '</div>';

	echo '<div class="core-option-sidebar-list">';

	// Output sidebar rows
	foreach ($value as $sidebar_slug => $sidebar_title) {
		echo '<div class="core-option-sidebar" data-sidebar-slug="', $sidebar_slug, '">';
		echo '<p>', $sidebar_title, '</p>';
		echo '<a href="#">' . __('Remove', THEME_SLUG) . '</a>';
		echo '</div>';
	}
	echo '</div>';
}
function core_layout_sidebars_import($value, $option) {
	return json_decode(stripslashes($value), true);
}
core_options_type_register('sidebars', 'core_layout_sidebars');

?>
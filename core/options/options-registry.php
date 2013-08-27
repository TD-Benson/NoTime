<?php

if (!defined('CORE_VERSION'))
	die();


// Types of options and their related functions
$core_option_types = array();

// Stores option handlers
// Option handlers contain any number of option groups.
// A handler will output it's options depending on it's context.
$core_option_handlers = array();

// Options caches
// These are built when options are registered, and contain direct references to options
$core_theme_options = array();
$core_context_options = array();


// Registers a new options handler
//
function core_options_handler_register($handler) {
	global $core_option_handlers;

	$core_option_handlers[$handler->slug] = $handler;
}

// Registers a new option type
//
function core_options_type_register($name, $function_base) {
	global $core_option_types;

	$function_output = $function_base. '_output';
	$function_import = $function_base. '_import';

	$option = compact('name', 'function_output', 'function_import');
	$core_option_types[$name] = $option;
}

// Returns an option's value
//
function core_options_get($option_name, $context='theme') {
	// Theme option
	if ($context == 'theme') {
		global $core_theme_options;
		
		if (isset($core_theme_options[$option_name]))
			return $core_theme_options[$option_name]->value();
		else {
			core_warning(sprintf(__('Cannot find theme option %s', THEME_SLUG), $option_name));
			return null;
		}

	// Post meta option
	} else {
		global $core_context_options;

		if (isset($core_context_options[$context][$option_name]))
			return $core_context_options[$context][$option_name]->value();
		else {
			//core_warning(sprintf(__('Cannot find post option %s in context %s', THEME_SLUG), $option_name, $context));
			return null;
		}
	}
}

?>
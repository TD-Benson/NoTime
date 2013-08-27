<?php

if (!defined('CORE_VERSION'))
	die();


// Prefix for options stored in the WordPress database
define('CORE_OPTIONS_KEY_PREFIX', 'core_');


// An options handler
// Defines one or more option groups that will be displayed depending on the handler's context
//
class CoreOptionHandler {
	public $slug = null;
	public $title = null;
	public $context = array();
	public $default_group = null;

	public $groups = array();
	public $options = array();

	function __construct($slug, $title=null, $context=null) {
		$this->slug = $slug;
		$this->title = $title;
		$this->context = $context;
	}

	// Adds an option group to this handler
	//
	public function group_add($group) {
		$group->handler = $this;
		$this->groups[$group->slug] = $group;
	}

	// Return true if the passed context string is part of this handler's context
	//
	public function has_context($test_context) {
		return in_array($test_context, $this->context);
	}
}

// A group of options
//
class CoreOptionGroup {
	public $slug = null;
	public $title = null;
	public $description = null;
	public $icon_uri = null;

	public $handler = null;
	public $sections = array();

	function __construct($slug, $title, $description=null, $icon_uri=null) {
		$this->slug = $slug;
		$this->title = $title;
		$this->description = $description;
		$this->icon_uri = $icon_uri;
	}

	// Adds a section to this group
	//
	public function section_add($section) {
		$section->handler = $this->handler;
		$this->sections[$section->slug] = $section;
	}

	// Outputs the HTML link to this group
	//
	public function output_link() {
		echo '<li id="core-option-group-link-', $this->slug, '" class="core-option-group-link">';
		if ($this->icon_uri)
			echo '<img src="', $this->icon_uri, '">';
		echo $this->title;
		echo '<div class="core-option-group-link-edge"><div></div></div></li>';
	}

	// Outputs this group's HTML and all of it's sections
	//
	public function output($output_title=true, $visible=true, $tabs=false) {
		if ($visible)
			$visibility_attr = 'block';
		else
			$visibility_attr = 'none';

		echo '<div id="core-option-group-', $this->slug, '" class="core-option-group" style="display: ', $visibility_attr, ';"><div class="core-option-group-head">';

		if ($output_title) {
			echo '<h1>';
			if ($this->icon_uri)
				echo '<img src="', $this->icon_uri, '"> ';
			echo $this->title;
			echo '</h1>';
		}

		if ($this->description)
			echo '<p>', $this->description, '</p>';

		// Section tabs
		if ($tabs && count($this->sections) > 1) {
			echo '<ul class="core-options-tabs">';

			$first = true;
			foreach ($this->sections as $slug => $section) {
				if ($first) {
					$active = ' class="active"';
					$first = false;
				} else {
					$active = '';
				}

				echo '<li data-section="', $slug, '"', $active, '>';
				echo $section->title;
				echo '</li>';
			}
			echo '</ul>';
			
			echo '<div class="clear"></div></div>';
			
			$first = true;
			foreach ($this->sections as $slug => $section) {
				$section->output($first);

				if ($first)
					$first = false;
			}
			
		// No tabs
		} else {
			
			echo '<div class="clear"></div></div>';
			
			foreach ($this->sections as $slug => $section)
				$section->output(true);
			
		}

		echo '</div>';
	}
}

// A section of options, part of a group
// Sections segment the options into more manageable chunks, and allows a number of options to be hidden simultaneously
//
class CoreOptionSection {
	public $slug = null;
	public $title = null;
	
	public $options = array();
	public $handler = null;

	function __construct($slug, $title = null) {
		$this->slug = $slug;
		$this->title = $title;
	}

	// Adds an option to this section
	//
	public function option_add($option) {
		global $core_theme_options_handler;

		$option->handler = $this->handler;

		$this->handler->options[$option->slug] = $option;
		$this->options[$option->slug] = $option;

		// Add this option to the appropriate handler (theme or a context)
		if ($this->handler == $core_theme_options_handler) {
			global $core_theme_options;
			$core_theme_options[$option->slug] = $option;

		} else {
			global $core_context_options;
			foreach ($this->handler->context as $context)
				$core_context_options[$context][$option->slug] = $option;
		}
	}

	// Outputs this section's HTML and all options inside it
	//
	public function output($visible=true) {
		if (!$visible)
			$visibility = ' style="display: none;"';
		else
			$visibility = '';

		echo '<div id="core-option-section-', $this->slug, '" class="core-option-section"', $visibility, '>';

		if ($this->title != null)
			echo '<h2>', $this->title, '</h2>';

		foreach ($this->options as $slug => $option)
			$option->output();

		echo '</div>';
	}
}

// A single option, part of a section
// An option's context determines where the value will be read from
// A 'global' context reads the option from the global table
// A 'post' context reads the option from the current post in the loop
//
class CoreOption {
	public $slug = null;
	public $type = null;
	public $title = null;
	public $description = null;
	public $default = null;
	
	public $handler = null;
	public $key = null;

	function __construct($slug, $title, $type, $description=null, $default=null) {
		$this->slug = $slug;
		$this->title = $title;
		$this->type = $type;
		$this->description = $description;
		$this->default = $default;

		$this->key = CORE_OPTIONS_KEY_PREFIX .$slug;
	}

	// Returns the value of this option
	//
	public function value() {
		global $core_theme_options_handler;

		// From theme options
		if ($this->handler == $core_theme_options_handler) {
			$value = get_option($this->key, $this->default);

		// From post metadata
		} else {
			global $post;

			$value = get_post_meta($post->ID, $this->key, true);
			if ($value == '')
				$value = $this->default;
		}

		// Convert objects to associative arrays
		// Storing objects is not recommended anyway
		if (is_object($value))
			$value = get_object_vars($value);

		if (is_string($value))
			$value = stripslashes($value);

		return $value;
	}

	// Return the value as it should be stored into the WordPress database
	// This is used in option_update and meta_update functions.
	//
	public function import($value) {
		global $core_option_types;

		$function_name = $core_option_types[$this->type]['function_import'];
		if (function_exists($function_name))
			return $function_name($value, $this);
		else
			return $value;
	}

	// Outputs this option's HTML
	//
	public function output() {
		global $core_option_types;

		echo '<div id="core-option-', $this->slug, '" class="core-option">';

		if ($this->title)
			echo '<p class="core-option-name">', $this->title, '</p>';
			
		// Output option type HTML
		if (!isset($core_option_types[$this->type]))
			core_warning(sprintf(__('Unknown option type %s.', THEME_SLUG), $this->type));
		else
			$core_option_types[$this->type]['function_output']($this->key, $this->value(), $this);

		if ($this->description)
			echo '<p class="core-option-description">', $this->description, '</p>';
		
		echo '</div>';
	}
}

?>
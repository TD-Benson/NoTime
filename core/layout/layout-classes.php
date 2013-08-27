<?php

if (!defined('CORE_VERSION'))
	die();


// A layout description
//
class CoreLayout {
	public $slug = null;
	public $icon_uri = null;

	public $elements = array();

	function __construct($slug, $icon_uri=null) {
		$this->slug = $slug;
		$this->icon_uri = $icon_uri;
	}

	// Adds a new element to this layout
	//
	function element_add($element) {
		array_push($this->elements, $element);
	}
}

// An element inside a layout
//
class CoreLayoutElement {
	public $type = null;
	public $before = null;
	public $after = null;

	function __construct($type, $before=null, $after=null) {
		$this->type = $type;
		$this->before = $before;
		$this->after = $after;
	}
}

?>
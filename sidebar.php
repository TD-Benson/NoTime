<?php

global $core_sidebars;

$sidebar_slug = core_layout_current_sidebar();

if (!$sidebar_slug)
	return;

if (!dynamic_sidebar($sidebar_slug))
	//core_warning('Sidebar with name "' .$core_sidebars[$sidebar_slug]. '" not found, or has no widgets assigned to it.');
	//core_warning('Please add your widget content for "' .$core_sidebars[$sidebar_slug]. '" in the widget section of your wordpress dashboard!');
?>
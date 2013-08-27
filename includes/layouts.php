<?php

// Layout types
//
$layout = new CoreLayout('full', THEME_URI. '/images/layouts/layout-full.png');
$layout->element_add(new CoreLayoutElement('template', '<div class="ttwelvecol last"><div class="theme-content">', '</div></div>'));
core_layout_type_register($layout);
core_block_type_register($layout);

$layout = new CoreLayout('left-single', THEME_URI. '/images/layouts/layout-left-single.png');
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarnarrow"><ul class="theme-sidebar">', '</ul></div>'));
$layout->element_add(new CoreLayoutElement('template', '<div class="tcontent5 last"><div class="theme-content">', '</div></div>'));
core_layout_type_register($layout);
core_block_type_register($layout);

$layout = new CoreLayout('left-dual', THEME_URI. '/images/layouts/layout-left-dual.png');
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarnarrow"><ul class="theme-sidebar">', '</ul></div>'));
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarnarrow"><ul class="theme-sidebar">', '</ul></div>'));
$layout->element_add(new CoreLayoutElement('template', '<div class="tcontent3 last"><div class="theme-content">', '</div></div>'));
core_layout_type_register($layout);
core_block_type_register($layout);

$layout = new CoreLayout('right-single', THEME_URI. '/images/layouts/layout-right-single.png');
$layout->element_add(new CoreLayoutElement('template', '<div class="tcontent5"><div class="theme-content">', '</div></div>'));
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarnarrow last"><ul class="theme-sidebar">', '</ul></div>'));
core_layout_type_register($layout);
core_block_type_register($layout);

$layout = new CoreLayout('right-dual', THEME_URI. '/images/layouts/layout-right-dual.png');
$layout->element_add(new CoreLayoutElement('template', '<div class="tcontent3"><div class="theme-content">', '</div></div>'));
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarnarrow"><ul class="theme-sidebar">', '</ul></div>'));
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarnarrow last"><ul class="theme-sidebar">', '</ul></div>'));
core_layout_type_register($layout);
core_block_type_register($layout);

$layout = new CoreLayout('both', THEME_URI. '/images/layouts/layout-both.png');
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarnarrow"><ul class="theme-sidebar">', '</ul></div>'));
$layout->element_add(new CoreLayoutElement('template', '<div class="tcontent3"><div class="theme-content">', '</div></div>'));
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarnarrow last"><ul class="theme-sidebar">', '</ul></div>'));
core_layout_type_register($layout);
core_block_type_register($layout);

$layout = new CoreLayout('left-wide', THEME_URI. '/images/layouts/layout-left-wide.png');
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarwide"><ul class="theme-sidebar">', '</ul></div>'));
$layout->element_add(new CoreLayoutElement('template', '<div class="tcontent4 last"><div class="theme-content">', '</div></div>'));
core_layout_type_register($layout);
core_block_type_register($layout);

$layout = new CoreLayout('right-wide', THEME_URI. '/images/layouts/layout-right-wide.png');
$layout->element_add(new CoreLayoutElement('template', '<div class="tcontent4"><div class="theme-content">', '</div></div>'));
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarwide last"><ul class="theme-sidebar">', '</ul></div>'));
core_layout_type_register($layout);
core_block_type_register($layout);

$layout = new CoreLayout('wide-dual', THEME_URI. '/images/layouts/layout-wide-dual.png');
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarwide"><ul class="theme-sidebar">', '</ul></div>'));
$layout->element_add(new CoreLayoutElement('template', '<div class="tcontent1"><div class="theme-content">', '</div></div>'));
$layout->element_add(new CoreLayoutElement('sidebar', '<div class="tsidebarwide last"><ul class="theme-sidebar">', '</ul></div>'));
core_layout_type_register($layout);
core_block_type_register($layout);

// Footer types
//
$footer = new CoreLayout('none', THEME_URI. '/images/layouts/footer-none.png');
core_layout_footer_type_register($footer);
core_block_footer_type_register($footer);

$footer = new CoreLayout('one', THEME_URI. '/images/layouts/footer-one.png');
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="twelvecol last"><ul class="theme-footer-column">', '</ul></div>'));
core_layout_footer_type_register($footer);
core_block_footer_type_register($footer);

$footer = new CoreLayout('two', THEME_URI. '/images/layouts/footer-two.png');
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="sixcol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="sixcol last"><ul class="theme-footer-column">', '</ul></div>'));
core_layout_footer_type_register($footer);
core_block_footer_type_register($footer);

$footer = new CoreLayout('three', THEME_URI. '/images/layouts/footer-three.png');
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="fourcol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="fourcol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="fourcol last"><ul class="theme-footer-column">', '</ul></div>'));
core_layout_footer_type_register($footer);
core_block_footer_type_register($footer);

$footer = new CoreLayout('four', THEME_URI. '/images/layouts/footer-four.png');
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="threecol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="threecol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="threecol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="threecol last"><ul class="theme-footer-column">', '</ul></div>'));
core_layout_footer_type_register($footer);
core_block_footer_type_register($footer);

$footer = new CoreLayout('six', THEME_URI. '/images/layouts/footer-six.png');
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="twocol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="twocol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="twocol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="twocol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="twocol"><ul class="theme-footer-column">', '</ul></div>'));
$footer->element_add(new CoreLayoutElement('sidebar', '<div class="twocol last"><ul class="theme-footer-column">', '</ul></div>'));
core_layout_footer_type_register($footer);
core_block_footer_type_register($footer);

// Default sidebar configuration
//
core_layout_set_default_sidebars(array(
	'default-left' => __('Default Left', THEME_SLUG),
	'default-right' => __('Default Right', THEME_SLUG),
	'footer-1' => __('Footer 1', THEME_SLUG),
	'footer-2' => __('Footer 2', THEME_SLUG),
	'footer-3' => __('Footer 3', THEME_SLUG),
	'footer-4' => __('Footer 4', THEME_SLUG),
	'footer-5' => __('Footer 5', THEME_SLUG),
	'footer-6' => __('Footer 6', THEME_SLUG),
));
core_block_set_default_sidebars(array(
	'default-left' => __('Default Left', THEME_SLUG),
	'default-right' => __('Default Right', THEME_SLUG),
	'footer-1' => __('Footer 1', THEME_SLUG),
	'footer-2' => __('Footer 2', THEME_SLUG),
	'footer-3' => __('Footer 3', THEME_SLUG),
	'footer-4' => __('Footer 4', THEME_SLUG),
	'footer-5' => __('Footer 5', THEME_SLUG),
	'footer-6' => __('Footer 6', THEME_SLUG),
));

// Default layout configuration
//
core_layout_set_default(array(
	'layout' => 'full',
	'layout-sidebars' => array('default-left', 'default-right'),
	'footer' => 'four',
	'footer-sidebars' => array('footer-1', 'footer-2', 'footer-3', 'footer-4', 'footer-5', 'footer-6')
));
core_block_set_default(array(
	'layout' => 'full',
	'layout-sidebars' => array('default-left', 'default-right'),
	'footer' => 'four',
	'footer-sidebars' => array('footer-1', 'footer-2', 'footer-3', 'footer-4', 'footer-5', 'footer-6')
));
core_layout_set_slidepanel_default(array(
	'layout' => 'full',
	'layout-sidebars' => array('default-left', 'default-right'),
	'footer' => 'four',
	'footer-sidebars' => array('footer-1', 'footer-2', 'footer-3', 'footer-4', 'footer-5', 'footer-6')
));

?>
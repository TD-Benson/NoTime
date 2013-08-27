<?php

// Register settings and controls
//
function theme_customize_register($wp_customize) {
	define('SECTION_COLORS', THEME_SLUG . '_colors');

	// Sections
	$wp_customize->add_section(SECTION_COLORS, array(
		'title'          => __('Colors', THEME_SLUG),
		'priority'       => 35,
	));

	// Settings
	$wp_customize->add_setting('core_color_links', array(
	    'default'        => '#000000',
	    'type'           => 'option',
	    'transport'      => 'postMessage',
	));
	$wp_customize->add_setting('core_color_links_hover', array(
	    'default'        => '#ffb805',
	    'type'           => 'option',
	    'transport'      => 'postMessage',
	));
	$wp_customize->add_setting('core_color_footer_text', array(
	    'default'        => '#888888',
	    'type'           => 'option',
	    'transport'      => 'postMessage',
	));
	$wp_customize->add_setting('core_color_footer_background', array(
	    'default'        => '#eab410',
	    'type'           => 'option',
	    'transport'      => 'postMessage',
	));
	$wp_customize->add_setting('core_color_button', array(
	    'default'        => '#ffb805',
	    'type'           => 'option',
	    'transport'      => 'postMessage',
	));
	$wp_customize->add_setting('core_color_button_text', array(
	    'default'        => '#ffffff',
	    'type'           => 'option',
	    'transport'      => 'postMessage',
	));

	// Controls
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'core_color_links', array(
		'section'    => SECTION_COLORS,
		'label'      => __('Links', THEME_SLUG),
	)));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'core_color_links_hover', array(
		'section'    => SECTION_COLORS,
		'label'      => __('Links, hover', THEME_SLUG),
	)));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'core_color_footer_text', array(
		'section'    => SECTION_COLORS,
		'label'      => __('Footer text', THEME_SLUG),
	)));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'core_color_footer_background', array(
		'section'    => SECTION_COLORS,
		'label'      => __('Footer background', THEME_SLUG),
	)));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'core_color_button', array(
		'section'    => SECTION_COLORS,
		'label'      => __('Buttons', THEME_SLUG),
	)));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'core_color_button_text', array(
		'section'    => SECTION_COLORS,
		'label'      => __('Buttons text', THEME_SLUG),
	)));

	// Preview JavaScript hook
	if ($wp_customize->is_preview() && ! is_admin())
    	add_action('wp_footer', 'theme_customize_preview', 21);
}
add_action('customize_register', 'theme_customize_register');

// Register preview JavaScript
//
function theme_customize_preview() {
   ?>
    <script type="text/javascript">

    	wp.customize('core_color_links', function(value) {
	        value.bind(function(to) {
	            jQuery('a:not(.theme-button, .theme-footer-column a)').css('color', to ? to : '');
	        });
	    });

	    wp.customize('core_color_links_hover', function(value) {
	        value.bind(function(to) {
	            jQuery('a:hover, #theme-copyright a:hover, #theme-footer-a .theme-footer-column a:hover').css('color', to ? to : '');
	        });
	    });

	    wp.customize('core_color_footer_text', function(value) {
	        value.bind(function(to) {
	            jQuery('#theme-footer-a .theme-footer-column, #theme-footer-a .theme-footer-column h3, #theme-footer-a .theme-footer-column a').css('color', to ? to : '');
	        });
	    });

	    wp.customize('core_color_footer_background', function(value) {
	        value.bind(function(to) {
	            jQuery('#theme-footer-background').css('background-color', to ? to : '');
	        });
	    });

	    wp.customize('core_color_button', function(value) {
	        value.bind(function(to) {
	            jQuery('.theme-button').css('background-color', to ? to : '');
	        });
	    });

		wp.customize('core_color_button_text', function(value) {
	        value.bind(function(to) {
	            jQuery('.theme-button').css('color', to ? to : '');
	        });
	    });	    

    </script>
    <?php
}

?>
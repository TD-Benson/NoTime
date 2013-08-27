<?php

// Theme constants
$theme_data = wp_get_theme();
define('THEME_PATH', get_theme_root() . '/' . get_template());
define('THEME_URI', get_template_directory_uri());
define('THEME_NAME', $theme_data['Name']);
define('THEME_SLUG', strtolower(str_replace(' ', '-', THEME_NAME)));

// CSS constants
define('CSS_URI', get_stylesheet_directory_uri(). '/css');
define('CSS_PATH', get_stylesheet_directory(). '/css');

// Core constants
define('CORE_VERSION', '1.1.2');
define('CORE_PATH', THEME_PATH. '/core');
define('CORE_URI', THEME_URI. '/core');


// Print custom scripts
//
function core_print_scripts() {
	?>
	<script type="text/javascript">
		window.templateDir = "<?php echo get_template_directory_uri(); ?>";
		window.coreDir = "<?php echo CORE_URI; ?>";
	</script>
	<?php
}
add_action('wp_head', 'core_print_scripts');
add_action('admin_head', 'core_print_scripts');

// Register common styles and scripts
//
function core_enqueue_scripts() {
	wp_register_script('core-colorpicker', CORE_URI. '/includes/colorpicker/colorpicker.js', '', '', true);
	wp_register_style('core-colorpicker', CORE_URI. '/includes/colorpicker/colorpicker.css');
}
add_action('admin_enqueue_scripts', 'core_enqueue_scripts');


// Core functions
require_once('core-utils.php');

// Separate modules
require_once('options/options-init.php');
require_once('shortcodes/shortcodes-init.php');
require_once('layout/layout-init.php');
require_once('fonts/fonts-init.php');
require_once('slider/slider-init.php');
require_once('colorschemes/colorschemes-init.php');

// Single file modules
require_once('core-breadcrumbs.php');
require_once('core-sociables.php');
require_once('core-loader.php');
require_once('core-seo.php');
require_once('core-demo.php');

?>
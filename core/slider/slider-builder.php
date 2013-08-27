<?php

define('WP_PATH', '../../../../../');

require_once(WP_PATH . 'wp-load.php');

define('WP_URL', home_url());

if (!is_user_logged_in() || !current_user_can('edit_posts')) 
	die();

function load_script($handle) {
	global $wp_scripts;

	if (!$wp_scripts)
		die('No $wp_scripts!');

	$src = home_url() . $wp_scripts->registered[$handle]->src;
	echo '<script type="text/javascript" src="', $src, '?ver=', uniqid() , '"></script>';
} 

?>
<!doctype html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Title</title>

	<script type="text/javascript">
		var thickboxL10n = {
			next: "Next >",
			prev: "< Prev",
			image: "Image",
			of: "of",
			close: "Close",
			closeImage: "<?php echo WP_URL; ?>" + "/wp-includes/js/thickbox/tb-close.png",
			loadingAnimation: "<?php echo WP_URL; ?>" + "/wp-includes/js/thickbox/loadingAnimation.gif"
		};
		try {
			convertEntities(thickboxL10n);
		} catch(e) {};
	</script>

	<link rel="stylesheet" type="text/css" href="slider-builder.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo WP_URL; ?>/wp-includes/js/thickbox/thickbox.css" media="screen">
	
	<?php

		// Some plugins (BuddyPress!) unset $wp_scripts
		global $wp_scripts;
		if (!isset($wp_scripts)) {
			$wp_scripts = new WP_Scripts();
		}

		// Load local scripts manually
		
		load_script('jquery');
		load_script('json2');
		load_script('jquery-ui-core');
		load_script('jquery-ui-widget');
		load_script('jquery-ui-mouse');
		load_script('jquery-ui-sortable');
		load_script('thickbox');

		// Slider settings
		$slider_name = $_GET['name'];
		$slider_slug = $_GET['slug'];
		$slider_type = $_GET['slider'];
		$slider_settings = get_option('core_slider_' .$slider_slug, '{}');

		// Write script
		echo '<script type="text/javascript">';
			echo 'window.sliderSlug = "', $slider_slug, '";';
			echo 'window.sliderName = "', $slider_name, '";';
			echo 'window.sliderType = "', $slider_type, '";';
			echo 'window.sliderSettings = "', $slider_settings, '";';
			echo 'window.nonce = "' .wp_create_nonce('core-slider-save'). '";';
			echo 'window.ajaxurl = "' .admin_url('admin-ajax.php'). '";';
			echo 'window.blogurl = "' .get_bloginfo('url'). '";';
		echo '</script>';
	?>

	<?php /*?><script type="text/javascript" src="slider-builder.js"></script><?php */?>
</head>

<body>

<div id="header"><?php echo $slider_name; ?></div>

<!-- Slider settings -->
<ul id="core-slider-settings">
</ul>

<!-- Slides -->
<div id="core-slider-slides">
</div>

<!-- Add new slide -->
<a href="#" class="core-slide-add">Add slide</a>

<!-- Save slider -->
<br>
<p id="save-result"></p>

<!-- Slide template -->
<div class="core-slider-slide core-slide-template">

	<div class="draggable_wrapper">
		<div class="draggable" style="position: relative;"></div>
	</div>

</div>

<!-- Layer template -->
<table>
	<tr class="core-slidertable-row core-layer-template">
	</tr>
</table>

</body>
</html>
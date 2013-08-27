<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if ie]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
<?php
// SEO Basic Activation
if ( !core_options_get('seobasic') ){
	core_seo_basic('meta');
}

?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<?php
$favicon_uri = core_options_get('favicon');
if ($favicon_uri)
	echo '<link rel="shortcut icon" href="', $favicon_uri, '">';
?>
<link rel='stylesheet' href='<?php echo CSS_URI; ?>/reset.css?ver=3.4.1' type='text/css' media='all' />
<link rel='stylesheet' href='<?php echo CSS_URI; ?>/1140.css?ver=3.4.1' type='text/css' media='all' />
<link rel='stylesheet' href='<?php bloginfo( 'stylesheet_url' ); ?>?ver=3.4.1' type='text/css' media='all' />

<!--[if IE 7]>
<link rel="stylesheet" href="<?php echo CSS_URI; ?>/ie7.css">
<![endif]-->
<!--[if lt IE 9]>
<script>
// Fix to get older IE versions to recognize new HTML5 elements for CSS styling
var e = ['abbr', 'article', 'aside', 'audio', 'canvas',
	'datalist', 'details', 'figure', 'footer',
	'header', 'hgroup', 'mark', 'menu', 'meter',
	'nav', 'output', 'progress', 'section',
	'time', 'video'];
for (var i in e)
document.createElement(e[i]);
</script>
<![endif]-->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/IE9.js"></script>
<![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<!--[if lt IE 8]>
<div id="browserdetect">
	<div class="shortcode-notify warn">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> to experience this site.</div>
</div>
<![endif]-->

<?php

	// check if demo is enabled
	$customize = (core_options_get('customize') == true) ? 'id="boxed"' : '';

	// boxed layout, 100% fluid or full width container
	if(core_options_get('layout_style') == 'boxed')
		$boxed_layout = '<div '.$customize.' class="boxed">';
	elseif(core_options_get('layout_style') == 'fluid')
		$boxed_layout = '<div '.$customize.' class="fluid">';
	elseif(core_options_get('layout_style') == 'fullwidth')
		$boxed_layout = '<div '.$customize.' class="fullwidth">';
	else
		$boxed_layout = '<div '.$customize.'>';

	echo $boxed_layout;
?>


<!-- Header -->
<?php if(core_options_get('enable_slidepanel') == true  ) : ?>
<div id="top-slidepanel" class="container" >
    <div id="panel">
		<?php  if(dynamic_sidebar(THEME_SLUG.'-slidepanel'))  ;  ?>
    </div>
	<div class="tab row" >
			<div id="toggle" class="twocol last">
                <div class="slidepanel-arrow"><div>&nbsp;</div></div>
			</div>
	</div> <!-- / top -->

</div>
<?php endif;?>

<div class="container">

	<div id="theme-header">

		<div class="row">
			<div id="theme-logo" class="fixed" <?php //if(theme_slider_check()) echo "class=\"fixed\""; ?> style="text-align: <?php echo core_options_get('logo_align'); ?>;">

		<?php if(core_options_get('logo') == '' ) : ?>
			<?php if (core_options_get('skin') == 'custom') : ?>
				<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
				<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php else : ?>
				<a href="<?php echo home_url(); ?>"><img src="<?php echo THEME_URI."/css/skins/logos/" . core_options_get('skin') . ".png"; ?>" alt="<?php echo bloginfo('name'); ?>"></a>
			<?php endif; ?>
		<?php else : ?>
				<a href="<?php echo home_url(); ?>"><img src="<?php echo core_options_get('logo'); ?>" alt="<?php echo bloginfo('name'); ?>"></a>
		<?php endif; ?>
			</div>
			<div class="clear"></div>
		</div>


	<?php $category = get_the_category();  ?>
		<div id="slider-area">
			<!-- Slider -->
			<?php theme_slider_area(); ?>
		</div><!-- Slider Area -->
	<?php //endif; ?>


	</div><!-- Theme Header -->

	<!-- Main menu -->
	<div id="theme-navigation-row">
		<div class="row">
			<div id="theme-navigation" class="twelvecol last">
				<?php
				// Main menu
				core_layout_menu('main');

				?>
	            <div class="threecol last search" id="search-container">

	            	<!-- Search -->
					<div class="theme-search-box">
						<?php get_template_part('searchform'); ?>
					</div>

	            </div>
			</div>
			<div class="clear"></div>
        </div>

	</div>

</div><!-- End of container -->


<div class="container bg-custom-color w-content">
<div id="menu-shadow" class="bg-custom-color" ></div>
<!-- Custom content row -->
<?php
	$content = theme_custom_content();
	if ($content) {
	?>
		<div id="theme-custom-row">
			<div class="row">
				<div class="twelvecol last">
					<div class="theme-custom">
						<?php echo do_shortcode($content); ?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
?>

<div class="hentry">

<!-- Content -->
<div class="theme-content-row">
	<div class="row">
		<div class="theme-content-container">
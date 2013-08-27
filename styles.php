<?php
	define('BASE_FONT_SIZE', 12);

$skin = core_options_get('skin');
	
	echo '<!-- Page '.$skin.' CSS -->' ;		

	// Fonts that need to be loaded through the Google Fonts API
	global $theme_load_fonts;
	global $core_fonts;
	$theme_load_fonts = array();

	// Path to all theme images
	$imagepath = THEME_URI . '/images/';

	// Get background image
	// Post type > category > theme
	$backgroundimage = null;
	if (is_singular())
		$backgroundimage = core_options_get('background_image', get_post_type());
	
	
	if (is_archive()){
		if (is_category() && !$backgroundimage) {
			$obj = get_queried_object();
			$backgroundimage = core_options_get('category_background_' .$obj->slug);
		} elseif (is_author())
			$backgroundimage = core_options_get('layout-author_background', 'theme');
		elseif (is_tag())
			$backgroundimage = core_options_get('layout-tag_background', 'theme');
		else 
			$backgroundimage = core_options_get('layout-archive_background', 'theme');
	}	
		
	if (is_404())
		$backgroundimage = core_options_get('layout-404_background', 'theme');
		
	if (is_search())
		$backgroundimage = core_options_get('layout-search_background', 'theme');	
	
	if (is_home() || is_front_page())
		$backgroundimage = core_options_get('background_image', get_post_type());
	
	if (!$backgroundimage)
		$backgroundimage = core_options_get('background_image');

	// Fonts
	$fonts = array(
		'font_menu' => array('#theme-menu-main','#wp-calendar th',"#wp-calendar caption", '#wp-calendar td','#theme-footer-menu','#theme-footer-tabs'),
		'font_heading' => array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
		'font_paragraph' => array('body'),
	);

	// Font sizes
	$fontsizes = array(
		'font_size_heading1' => array('h1'),
		'font_size_heading2' => array('h2'),
		'font_size_heading3' => array('h3', '#theme-footer-a h2'),
		'font_size_heading4' => array('h4'),
		'font_size_heading5' => array('h5'),
		'font_size_heading6' => array('h6'),

		'font_size_mainmenu' => array('#theme-navigation-row ul li a'),
		'font_size_mainmenu_span' => array('#theme-navigation-row ul li .desc'),
		'font_size_mainmenu_sub' => array('#theme-navigation-row  ul  li ul li a'),
		'font_size_footermenu' => array( '#theme-footer-tabs ul li a'),
		
		'font_size_other_paragraph' => array('p', '.entry-content', '.theme-sidebar > li section'),
		'font_size_sidebar_header' => array('.theme-sidebar h3',"#wp-calendar caption"),
		'font_size_other_copyright' => array('#theme-copyright'),
		'font_size_other_footer' => array('#menu-footer-menu'),
	);

	// Text colors
	$colors = array(
		// Headings
		'color_heading1' => array('h1'),
		'color_heading2' => array('h2'),
		'color_heading3' => array('h3'),
		'color_heading4' => array('h4'),
		'color_heading5' => array('h5'),
		'color_heading6' => array('h6'),

		// Menu
		'color_menu_text' => array(
			'#theme-menu-main > li > a',
			'#theme-footer-tabs  li > a',
			'#theme-menu-main > li .desc',
		),
		'color_menu_text_hover' => array(
			'#theme-menu-main  li:hover a',
			'#theme-menu-main > li.current-menu-item:hover > a',
		),
		'color_submenu_text' => array(
			'#theme-menu-main > li.current-menu-item > li > a',
			'#theme-menu-main > li ul > li > a',
		),
		'color_submenu_text_hover' => array(
			'#theme-menu-main > li ul > li:hover > a',
		),

		//Slide Panel
		'header_color_slidepanel' => array(
			'#top-slidepanel .textwidget h3  ',
		),
		'content_color_slidepanel' => array(
			'#top-slidepanel .textwidget  text ',
			'#top-slidepanel .textwidget  p ',
			'#top-slidepanel .textwidget  span ',
		),
		
		//Breadcrumb
		'color_breadcrumb_text' => array(
			'.theme-breadcrumbs',
			'.theme-breadcrumbs a',
		),
		'color_breadcrumb_text_hover' => array(
			'.theme-breadcrumbs a:hover',
		),		
		
		//Sidebar
		'color_sidebar_text' => array(
			'.theme-sidebar'
		),
		'color_sidebar_title' => array(
			'.theme-sidebar .widget-title'
		),
		'color_sidebar_widget_text' => array(
			'.theme-sidebar .widget-content',
			'.theme-sidebar a'
		),
		
		//Footer
		'color_footer_text' => array(
			'#theme-footer .tabcontent ',
			'#theme-footer .tabcontent h3',
			'#theme-footer .tabcontent > a',
		),
		'color_footer_menu_text' => array(
			'#theme-footer-menu > ul > li > a',
		),
		'color_footer_menu_text_hover' => array(
			'#theme-footer-menu > ul > li > a:hover',
		),
		'color_footertabs_tabtitle' => array(
			'#theme-footer-tabs > ul > li > a',
		),
		'color_footertabs_tabtitle_hover' => array(
			'#theme-footer-tabs > ul > li > a:hover',
			'#theme-footer-tabs > ul > li.active  a ',
		),
				

		//Content
		'color_paragraphs' => array('.theme-content p', '#theme-footer .tabcontent .theme-sidebar'),
		'color_links' => array('a', '#theme-footer .tabcontent .theme-sidebar a' ),
		'color_links_hover' => array(
			'a:hover',
			'#theme-copyright a:hover',
			'#theme-footer-a .theme-footer-column a:hover',
			'ul.shortcode-toggle > li:hover > div.header > span.title',
			'#theme-footer .tabcontent .theme-sidebar a:hover',
			'#theme-footer .tabcontent a:hover',
		),
		'color_button_text' => array(
			'.theme-button',
		),
		'color_button_text_hover' => array(
			'.theme-button:hover',
		),
		
		'color_copyright' => array(
			'#theme-copyright a',
		),
		
		'color_search_field' => array(
			'.theme-search-box input[type="text"]',
		),
		
		//Portfolio
		'color_portfolio_overlaybox_item_title' => array(
			'#types',
			'#types a',
			'.da-thumbs li a div span',
		),
		'color_portfolio_overlaybox' => array(
			'#types a:hover',
		),

	);
	
	
	// Background colors
	$colors_background = array(
		//Menu
		'color_menu_bg' => array(
			'#theme-navigation-row',
		),
		'color_submenu_background' => array(
			'#theme-menu-main > li:hover ul > li',
		),
		'color_submenu_background_hover' => array(
			'#theme-menu-main > li:hover ul > li:hover',
			'#theme-menu-main li.current-menu-item li.current-menu-item',
		),

		//Portfolio Overlay 
		'color_portfolio_overlaybox' => array(
			'.portfolio-container li a div',
			'ul.shortcode-gallery li.view .mask'
		),
		'color_portfolio_overlaybox_item_hline' => array(
			'.theme-content #categories',
		),

		//Sidebar
		'color_sidebar_bg' => array('.theme-sidebar','.theme-excerpts .item', '#post-display-option' ),
		'color_sidebar_title_bg' => array('.theme-content-container .theme-sidebar .widget-title'),
		'color_sidebar_widget_bg' => array('.theme-content-container .theme-sidebar .widget'),
		
		//Slide Panel Top
		'color_slidepanel' => array('#top-slidepanel #panel'),
		
		//Footer
		'color_footer_menu_background' => array(
			'#top-widget',
			'#theme-footer',
		),
		
		//Footer Tabs
		'color_footertabs_bgcolor' => array(
			'#theme-footer-tabs ul.row li',
		),
		
		//Content
		'color_content_background' => array(
			'#theme-content-row',
		),
		'color_button' => array(
			'.theme-button',
			'input[type="submit"].theme-button',
			'.widget_price_filter .ui-slider .ui-slider-handle', 
			'.theme-sidebar .ui-slider .ui-slider-handle',
		),
		'color_button_hover' => array(
			'.theme-button:hover',
			'input[type="submit"].theme-button:hover',
			'.widget_price_filter .ui-slider .ui-slider-handle', 
			'.theme-sidebar .ui-slider .ui-slider-handle',
		),
		'color_sidebar_title_bg' => array(
			'.theme-content-container .theme-sidebar h3',
			'ul.theme-pagination > li.active',
			'.theme-search-form input[type="submit"]',
			'#searchform input[type="submit"]',
			'#wp-calendar caption',
		),
		'color_custom_content' => array(
			'#theme-custom-row',
		),
		
		//Portfolio
		'color_portfolio_overlaybox_item_hline' => array(
			'.theme-content #categories',
		),
	);
	
	// Menu Background color : Hover
	$color_menu_background =array(
			'color_menu_background' => array(
			'#theme-menu-main  li:hover',
			'.theme-search-box:hover .theme-search-icon',
		),
	);
	
	// Opacity 	
	$opacity =array(
			'opacity_slidepanel' => array(
				'#top-slidepanel #panel',
				'.slidepanel-arrow',
		),
			'color_portfolio_overlaybox_opacity' => array(
				'.portfolio-container li a div.item-title',
				'ul.shortcode-gallery li.view:hover .mask',
				'ul.shortcode-gallery li.view.hover .mask',
			)
	);
	// Arrow Bg Color 
	$border_top =array(
			'color_slidepanel' => array(
				40 => '.slidepanel-arrow',
			),
			'color_portfolio_item_border' => array(
				10 => '#portfolio-container li a div span',
			),
			'color_menu_text_hover' => array( 
				2 => '#theme-menu-main > li:hover'
			),
	);
	$border_bottom =array(
		'color_footer_backtotop_arrow' => array(
		25 => 	'#theme-totop',
		),
		'color_portfolio_item_border' => array(
		3 => '#portfolio-container li a div span',
		'ul.shortcode-gallery > li.view h2'
		)
	);
	

	// Border colors
	$colors_border = array(
		'color_menu_text_hover' => array(

		),
		'color_links_hover' => array(
			'a > img:hover',
			'img.avatar:hover',
			'ul.products li:hover > a > img',
			'ul.products li:hover img.wp-post-image',
			'ul.product_list_widget li:hover img',
			'.td_postWidget_posts .thumbs:hover',
			'.shortcode-tdacs .overview li img:hover',
			'.related-posts .post:hover',
			'.td_adwidget_thumb img:hover',
			'#commentform input:hover',
			'#commentform textarea:hover',
		),
		'color_sidebar_bg' => array('ul.theme-pagination'),
		
		//Portfolio
		'color_portfolio_item_border' => array(
			'.da-thumbs li a div span',
			'.portfolio_block',	
		),

	);

	// Outline colors
	$colors_outline = array(
		'color_links_hover' => array(
			'ul.shortcode-gallery > li:hover',
		),
	);
	
	
	// Text Alignments colors
	$text_alignments = array(
		'content_align_slidepanel' => array(
			'#top-slidepanel .textwidget  p  ',
			'#top-slidepanel .textwidget  span ',
			'#top-slidepanel .textwidget  div ',
		),
		'header_align_slidepanel' => array(
			'#top-slidepanel .textwidget  h3  ',
		),
	);

	
	// Outputs font size CSS
	function apply_font_sizes($sizes) {
	
	
		foreach($sizes as $option => $tags) {
			$size = intval(core_options_get($option));
			echo implode(', ', $tags);
			echo ' { font-size: ', ($size / BASE_FONT_SIZE), 'em; }';			
			echo "\n";
		}
	}

	// Outputs text align CSS
	function apply_textalign($alignments) {
	
	
		foreach($alignments as $option => $tags) {
			$alignment = core_options_get($option);
			echo implode(', ', $tags);
			echo ' { text-align: ', $alignment , '}';			
			echo "\n";
		}
	}

	// Outputs font family CSS
	function apply_fonts($fonts) {
		global $theme_load_fonts;

		foreach($fonts as $option => $tags) {
			$font = core_options_get($option);
			echo implode(', ', $tags);
			echo ' { font-family: "', $font, '"; }';
			echo "\n";

			array_push($theme_load_fonts, $font);
		}
	}

	// Outputs color CSS
	function apply_colors($style, $colors) {
		foreach($colors as $option => $tags) {
			$color = core_options_get($option);
			echo implode(', ', $tags);
			echo ' { ', $style, ': ', $color, '; }';
			echo "\n";
		}
	}
	
	function apply_opacity($opacities){
		foreach($opacities as $option => $tags) {
			$opacity = number_format(core_options_get($option) / 100 , 2);
			echo implode(', ', $tags);
			echo ' { -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=', $opacity*100, ')";';
			echo ' filter: alpha(opacity= ', $opacity*100, ');';
			echo ' -moz-opacity:', $opacity, ';';
			echo ' -khtml-opacity: ', $opacity, ';';
			echo ' opacity: ', $opacity, '; ';
			echo "}\n";
		}
	}
	function apply_bordertop($border_top ){
		foreach($border_top as $option => $tags) {
			$color = core_options_get($option);
			foreach($tags as $size=>$tag){
				echo $tag;
				echo ' { border-top : '.$size.'px solid ', $color, '; }';
				echo "\n";
			}
		}
	}
	function apply_borderbottom($border_top){
		foreach($border_top as $option => $tags) {
			
			$color = core_options_get($option);
			foreach($tags as $size=>$tag){
				echo $tag;
				echo ' { border-bottom : '.$size.'px solid ', $color, '; }';
				echo "\n";
			}
		}
	}
	
	
	
	
	
?>

<style type="text/css">
<?php
?>
<?php
// Content colors
if(!core_options_get('color_content_background')) :
	$color = core_hex2rgb(core_options_get('color_content_background'));
	$color['alpha'] = 1.0;
	echo '.theme-content-row,';
	echo '#theme-slider-row,';
	echo 'div.shortcode-header h1,';
	echo 'div.shortcode-header h2,';
	echo 'div.shortcode-header h3,';
	echo 'div.shortcode-header h4,';
	echo 'div.shortcode-header h5,';
	echo 'div.shortcode-header h6';
	echo '{ background-color:'.core_options_get('color_content_background').'; background-color: ', core_color2rgba($color), ';';
	$color['alpha'] = 0.7;
	echo " outline-color: ', core_color2rgba($color), ';}\n";
endif;

// Typography
apply_fonts($fonts);
apply_font_sizes($fontsizes);
// Load default content bgcolor
// Other color settings
if($skin == 'custom'){
	apply_colors('color', $colors);
	apply_colors('background-color', $color_menu_background);
	apply_colors('background-color', $colors_background);
	apply_colors('background-color', $color_menu_background);
	
	apply_colors('border-color', $colors_border);
	apply_colors('outline-color', $colors_outline);
	
	apply_opacity($opacity);
	apply_bordertop($border_top);
	apply_borderbottom($border_bottom);
} else {
	include_once("css/skins/style-".$skin.".css");
}

apply_textalign($text_alignments);

?> 

body  {
/*font-size: <?php echo ( 16 / BASE_FONT_SIZE); ?> em;*/
/*font-size: <?php echo ( intval(core_options_get('font_size_other_paragraph')) / BASE_FONT_SIZE ); ?>em;*/
background-color: <?php echo core_options_get('main_background_color'); ?>;
background-image: url(<?php echo $backgroundimage; ?>);
background-position: top center;
<?php $bg_repeat = (core_options_get('background_repeat') == true) ? 'background-repeat: repeat;' : 'background-repeat: no-repeat;'; ?>
<?php echo $bg_repeat . "\n"; ?>
<?php $bg_size = (core_options_get('background_size') == false) ? 'background-size: cover;' : 'background-size: auto;'; ?>
<?php echo $bg_size . "\n"; ?>
}<?php  
 
 if (core_options_get('layout_style') == 'boxed')
  	$boxed_layout = 'max-width: 1140px;';
 elseif (core_options_get('layout_style') == 'fluid')
  	$boxed_layout = 'max-width: 100%; }';
 else
  	$boxed_layout = 'max-width: 100%;} .row { max-width: 1140px;';
?>
.container, .boxed{ position: relative; margin: 0 auto; <?php echo $boxed_layout; ?> }
<?php 
if(core_options_get('layout_style')) {
echo ".boxed { -moz-box-shadow: 0px 0px 10px rgba(0,0,0,0.35); -webkit-box-shadow: 0px 0px 10px rgba(0,0,0,0.35); box-shadow: 0px 0px 10px rgba(0,0,0,0.35); }\n";
}
?>

<?php $new_base_font = intval(core_options_get('font_size_other_paragraph')) / BASE_FONT_SIZE; ?>
h1 { <?php echo ( intval(core_options_get('font_size_heading1')) / BASE_FONT_SIZE ) + $new_base_font; ?>em; }
h2 { <?php echo ( intval(core_options_get('font_size_heading2')) / BASE_FONT_SIZE ) + $new_base_font; ?>em; }
h3 { <?php echo ( intval(core_options_get('font_size_heading3')) / BASE_FONT_SIZE ) + $new_base_font; ?>em; }
h4 { <?php echo ( intval(core_options_get('font_size_heading4')) / BASE_FONT_SIZE ) + $new_base_font; ?>em; }
h5 { <?php echo ( intval(core_options_get('font_size_heading5')) / BASE_FONT_SIZE ) + $new_base_font; ?>em; }
h6 { <?php echo ( intval(core_options_get('font_size_heading6')) / BASE_FONT_SIZE ) + $new_base_font; ?>em; }

a > img,
img.avatar, 
.td_postWidget_posts .thumbs,
.shortcode-tdacs .overview li img,
.related-posts .post,
.td_adwidget_thumb img,
#commentform input,
#commentform textarea{ border-color: #FFF; }

.slidepanel-arrow {
	border-left: 29px solid transparent;
    border-right: 29px solid transparent;
    bottom: 0; 
    position: relative;
    width: 0;
    z-index: 9998;
	margin: 3px auto auto;
}
.slidepanel-arrow div{
	width: 30px;
	height: 30px;
	position: absolute;
	top: -41px;
	left: -14px;
	background: url('<?php echo THEME_URI; ?>/images/arrow-down-slide-panel.png') no-repeat;
}
.slidepanel-arrow.collapse div {
	background: url('<?php echo THEME_URI; ?>/images/arrow-up-slide-panel.png') no-repeat;
}

#theme-totop {
	width: 0; 
	height: 0; 
	border-left: 25px solid transparent;
	border-right: 25px solid transparent;
	background:none;
}
<?php
// Menu color
$color = core_hex2rgb(core_options_get('color_submenu_background'));
$color['alpha'] = 1;
// Other color settings
if($skin == 'custom') 
	if(!core_options_get('color_submenu_background')) 
		echo '#theme-menu-main > li ul { background-color: '.core_options_get('color_submenu_background').'; background-color: ', 	core_color2rgba($color), '; }';

//Menu Border
$color = core_hex2rgb(core_options_get('color_menu_border'));
if($color){
	$color['alpha'] = number_format(core_options_get('color_menu_border_opacity') / 100 , 2);
	echo '#theme-navigation-row, .theme-search-icon { border-color: '.core_options_get('color_menu_border').'; border-color: ', 	core_color2rgba($color), '; }';
	$color = '';
}
//Portfolio Overlay 
$color = core_hex2rgb(core_options_get('color_portfolio_overlaybox'));
if($color){
	$color['alpha'] = number_format(core_options_get('color_portfolio_overlaybox_opacity') / 100 , 2);
	echo '.portfolio-container li a div.item-title, ul.shortcode-gallery li.view:hover .mask, ul.shortcode-gallery li.view.hover .mask, .portfolio-container li a div, ul.shortcode-gallery li.view .mask { background-color: '.core_options_get('color_portfolio_overlaybox').'; background-color: ', 	core_color2rgba($color), '; }';
}



?>
<?php
function slogan_block_background(){
$post_type = get_post_type();
$category = get_query_var('cat');
$current_category = get_category ($category);
$slogan_bg = '';

	// check if it's a page or post with a custom content block background
	if ( is_singular() )
		$slogan_bg = core_options_get('custom_content_image', $post_type);
	
	if (is_archive()){
		
		// check if it's a category and display the custom content if there are any
		if ( is_category() ){
			$obj = get_queried_object();
			$slogan_bg = core_options_get('custom_content_' .$obj->slug.'_bg');
		
		} elseif (is_author())
			$slogan_bg = core_options_get('custom_content_layout-author_bg', 'theme');
			
		elseif (is_tag())
			$slogan_bg = core_options_get('custom_content_layout-tag_bg', 'theme');
		
		else
			$slogan_bg = core_options_get('custom_content_layout-archive_bg', 'theme');	
	}
		
	if (is_search())
		$slogan_bg = core_options_get('custom_content_layout-search_bg', 'theme');
		
	
	$slogan_bg = "#theme-custom-row { background-image: url(".$slogan_bg."); background-position: top center; background-repeat: no-repeat; }\n";
	
	if ( $slogan_bg != '' )	
		return $slogan_bg;
	else
		return null;
}

$slogan_block_background = slogan_block_background();

if( !is_null($slogan_block_background) )
	echo $slogan_block_background;

?>
#theme-footer-menu > ul > li > a { letter-spacing: 1px; }
#top-slidepanel  .slidepanel-arrow:hover{cursor:pointer}
<?php 

// Core custom CSS (Colorschemes)
do_action('core_custom_css');

// add custom css
if(core_options_get('custom_css')) :	
echo core_options_get('custom_css'); 
endif; 
?>
</style>
<?php if (!is_null($theme_load_fonts)) : ?>
<script type="text/javascript">
window.WebFont.load({
google: {
families: [<?php
$text = '';
$prev_font = array();
foreach ($theme_load_fonts as $font) {
	if (!in_array($font,$prev_font) && in_array($font, $core_fonts["Google fonts"])) {
		array_push($prev_font, $font);
		$text .= '"' . $font . '",';
	}
}
echo substr($text, 0, -1);
?>]
}
});

</script>
<?php endif; ?>


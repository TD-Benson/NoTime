<?php

require_once('../../../../../wp-load.php');

if (!is_user_logged_in() || !current_user_can('edit_posts')) 
	die();

$shortcode_categories = array(
	__('Buttons', THEME_SLUG) => array(
		__('Small button', THEME_SLUG) => array(
			'description' => __('Inserts a small button. If you add the <i>window</i> attribute, the link will be opened in a new window.', THEME_SLUG),
			'shortcode' => '[button small link="link"]button text[/button]',
		),
		__('Medium button', THEME_SLUG) => array(
			'description' => __('Inserts a medium sized button. If you add the <i>window</i> attribute, the link will be opened in a new window.', THEME_SLUG),
			'shortcode' => '[button medium link="link"]button text[/button]',
		),
		__('Large button', THEME_SLUG) => array(
			'description' => __('Inserts a large button. If you add the <i>window</i> attribute, the link will be opened in a new window.', THEME_SLUG),
			'shortcode' => '[button large link="link"]button text[/button]',
		),
	),

	__('Columns', THEME_SLUG) => array(
		__('2 columns', THEME_SLUG) => array(
			'description' => __('Inserts two columns in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns]\n[column half]Content here[/column]\n[column half]Content here[/column]\n[/columns]",
		),
		__('1/3 - 2/3', THEME_SLUG) => array(
			'description' => __('Inserts two columns, one a third and the other two thirds, in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns]\n[column third]Content here[/column]\n[column twothird]Content here[/column]\n[/columns]",
		),
		__('2/3 - 1/3', THEME_SLUG) => array(
			'description' => __('Inserts two columns, one two thirds and the other a third, in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns]\n[column twothird]Content here[/column]\n[column third]Content here[/column]\n[/columns]",
		),
		__('1/4 - 3/4', THEME_SLUG) => array(
			'description' => __('Inserts two columns, one a fourth and the other three fourths, in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns]\n[column fourth]Content here[/column]\n[column threefourth]Content here[/column]\n[/columns]",
		),
		__('3/4 - 1/4', THEME_SLUG) => array(
			'description' => __('Inserts two columns, one three fourths and the other a fourth, in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns]\n[column threefourth]Content here[/column]\n[column fourth]Content here[/column]\n[/columns]",
		),
		__('3 columns', THEME_SLUG) => array(
			'description' => __('Inserts three columns in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns]\n[column third]Content here[/column]\n[column third]Content here[/column]\n[column third]Content here[/column]\n[/columns]",
		),
		__('4 columns', THEME_SLUG) => array(
			'description' => __('Inserts four columns in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns]\n[column fourth]Content here[/column]\n[column fourth]Content here[/column]\n[column fourth]Content here[/column]\n[column fourth]Content here[/column]\n[/columns]",
		),
		__('5 columns', THEME_SLUG) => array(
			'description' => __('Inserts five columns in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns]\n[column fifth]Content here[/column]\n[column fifth]Content here[/column]\n[column fifth]Content here[/column]\n[column fifth]Content here[/column]\n[column fifth]Content here[/column]\n[/columns]",
		),
		__('Custom 2 columns', THEME_SLUG) => array(
			'description' => __("1. Insert the default column shortcode, which also can be changed into 3/4/5 columns  \n2. Then insert only the URL of your favourite background image. \n3. Choose your own personal text color  \n4. Set your own image size (default settings are: 100 % and 150 px), which can be made larger or smaller", THEME_SLUG),
			'shortcode' => "[custom_columns image=\"image url\" textcolor=\"#FFFFFF\" width=\"100\" height=\"150\"]\n[column half]Content here[/column]\n[column half]Content here[/column]\n[/custom_columns]",
		)
	),

	__('Columns (divider)', THEME_SLUG) => array(
		__('2 columns + divider', THEME_SLUG) => array(
			'description' => __('Inserts two columns separated by a divider line in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns divider]\n[column half]Content here[/column]\n[column half]Content here[/column]\n[/columns]",
		),
		__('1/3 - 2/3 + divider', THEME_SLUG) => array(
			'description' => __('Inserts two columns, one a third and the other two thirds, separated by a divider line in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns divider]\n[column third]Content here[/column]\n[column twothird]Content here[/column]\n[/columns]",
		),
		__('2/3 - 1/3 + divider', THEME_SLUG) => array(
			'description' => __('Inserts two columns, one two thirds and the other a third, separated by a divider line in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns divider]\n[column twothird]Content here[/column]\n[column third]Content here[/column]\n[/columns]",
		),
		__('1/4 - 3/4 + divider', THEME_SLUG) => array(
			'description' => __('Inserts two columns, one a fourth and the other three fourths, separated by a divider line in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns divider]\n[column fourth]Content here[/column]\n[column threefourth]Content here[/column]\n[/columns]",
		),
		__('3/4 - 1/4 + divider', THEME_SLUG) => array(
			'description' => __('Inserts two columns, one three fourths and the other a fourth, separated by a divider line in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns divider]\n[column threefourth]Content here[/column]\n[column fourth]Content here[/column]\n[/columns]",
		),
		__('3 columns + divider', THEME_SLUG) => array(
			'description' => __('Inserts three columns separated by a divider line in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns divider]\n[column third]Content here[/column]\n[column third]Content here[/column]\n[column third]Content here[/column]\n[/columns]",
		),
		__('4 columns + divider', THEME_SLUG) => array(
			'description' => __('Inserts four columns separated by a divider line in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns divider]\n[column fourth]Content here[/column]\n[column fourth]Content here[/column]\n[column fourth]Content here[/column]\n[column fourth]Content here[/column]\n[/columns]",
		),
		__('5 columns + divider', THEME_SLUG) => array(
			'description' => __('Inserts five columns separated by a divider line in which you can place further content.', THEME_SLUG),
			'shortcode' => "[columns divider]\n[column fifth]Content here[/column]\n[column fifth]Content here[/column]\n[column fifth]Content here[/column]\n[column fifth]Content here[/column]\n[column fifth]Content here[/column]\n[/columns]",
		),

	),

	__('Dividers', THEME_SLUG) => array(
		__('Dotted', THEME_SLUG) => array(
			'description' => __('Inserts a dotted divider line.', THEME_SLUG),
			'shortcode' => '[divider dotted]',
		),
		__('Invisible Spacer 20px', THEME_SLUG) => array(
			'description' => __('Inserts a spacer of 20 pixels high. Perfect to create space between columns.', THEME_SLUG),
			'shortcode' => '[divider invisible]',
		),
		__('Slashed', THEME_SLUG) => array(
			'description' => __('Inserts a slashed tall divider line.', THEME_SLUG),
			'shortcode' => '[divider slashed]',
		),
		__('Solid', THEME_SLUG) => array(
			'description' => __('Inserts a solid divider line.', THEME_SLUG),
			'shortcode' => '[divider solid]',
		),
		__('To top', THEME_SLUG) => array(
			'description' => __('Inserts a solid divider line with a button that scrolls the page to the top.', THEME_SLUG),
			'shortcode' => '[divider totop]',
		),
	),

	__('Dropcaps', THEME_SLUG) => array(
		__('Red dropcap', THEME_SLUG) => array(
			'description' => __('Inserts a red dropcap.', THEME_SLUG),
			'shortcode' => '[dropcap red]A[/dropcap]',
		),
		__('Green dropcap', THEME_SLUG) => array(
			'description' => __('Inserts a green dropcap.', THEME_SLUG),
			'shortcode' => '[dropcap green]A[/dropcap]',
		),
		__('Blue dropcap', THEME_SLUG) => array(
			'description' => __('Inserts a blue dropcap.', THEME_SLUG),
			'shortcode' => '[dropcap blue]A[/dropcap]',
		),
		__('White dropcap', THEME_SLUG) => array(
			'description' => __('Inserts a white dropcap.', THEME_SLUG),
			'shortcode' => '[dropcap white]A[/dropcap]',
		),
		__('Black dropcap', THEME_SLUG) => array(
			'description' => __('Inserts a black dropcap.', THEME_SLUG),
			'shortcode' => '[dropcap black]A[/dropcap]',
		),
		__('Grey dropcap', THEME_SLUG) => array(
			'description' => __('Inserts a grey dropcap.', THEME_SLUG),
			'shortcode' => '[dropcap grey]A[/dropcap]',
		),
	),

	/*__('Headings', THEME_SLUG) => array(
		__('Padded heading 1', THEME_SLUG) => array(
			'description' => __('Inserts a padded heading.', THEME_SLUG),
			'shortcode' => "[header 1]text[/header]",
		),
		__('Padded heading 2', THEME_SLUG) => array(
			'description' => __('Inserts a padded heading.', THEME_SLUG),
			'shortcode' => "[header 2]text[/header]",
		),
		__('Padded heading 3', THEME_SLUG) => array(
			'description' => __('Inserts a padded heading.', THEME_SLUG),
			'shortcode' => "[header 3]text[/header]",
		),
		__('Padded heading 4', THEME_SLUG) => array(
			'description' => __('Inserts a padded heading.', THEME_SLUG),
			'shortcode' => "[header 4]text[/header]",
		),
		__('Padded heading 5', THEME_SLUG) => array(
			'description' => __('Inserts a padded heading.', THEME_SLUG),
			'shortcode' => "[header 5]text[/header]",
		),
		__('Padded heading 6', THEME_SLUG) => array(
			'description' => __('Inserts a padded heading.', THEME_SLUG),
			'shortcode' => "[header 6]text[/header]",
		),
	),*/

	__('Image gallery', THEME_SLUG) => array(
		__('Image gallery, 2 columns', THEME_SLUG) => array(
			'description' => __('Inserts an image gallery with 2 columns.', THEME_SLUG),
			'shortcode' => "[tdgallery columns=\"2\"]\n Insert your images with links here \n[/tdgallery]",
		),
		__('Image gallery, 3 columns', THEME_SLUG) => array(
			'description' => __('Inserts an image gallery with 3 columns.', THEME_SLUG),
			'shortcode' => "[tdgallery columns=\"3\"]\n Insert your images with links here \n[/tdgallery]",
		),
		__('Image gallery, 4 columns', THEME_SLUG) => array(
			'description' => __('Inserts an image gallery with 4 columns.', THEME_SLUG),
			'shortcode' => "[tdgallery columns=\"4\"]\n Insert your images with links here \n[/tdgallery]",
		),
		__('Image gallery, 6 columns', THEME_SLUG) => array(
			'description' => __('Inserts an image gallery with 6 columns.', THEME_SLUG),
			'shortcode' => "[tdgallery columns=\"6\"]\n Insert your images with links here \n[/tdgallery]",
		),
	),

	__('Lists', THEME_SLUG) => array(
		__('Balloon', THEME_SLUG) => array(
			'description' => __('A list with balloon icon bullets.', THEME_SLUG),
			'shortcode' => "[list balloon]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Circle', THEME_SLUG) => array(
			'description' => __('A list with circular bullets.', THEME_SLUG),
			'shortcode' => "[list circle]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Creditcard', THEME_SLUG) => array(
			'description' => __('A list with creditcard icon bullets.', THEME_SLUG),
			'shortcode' => "[list creditcard]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Dot', THEME_SLUG) => array(
			'description' => __('A list with dotted bullets.', THEME_SLUG),
			'shortcode' => "[list dots]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('File', THEME_SLUG) => array(
			'description' => __('A list with file icon bullets.', THEME_SLUG),
			'shortcode' => "[list file]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Mail', THEME_SLUG) => array(
			'description' => __('A list with mail icon bullets.', THEME_SLUG),
			'shortcode' => "[list mail]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Info', THEME_SLUG) => array(
			'description' => __('A list with info icon bullets.', THEME_SLUG),
			'shortcode' => "[list info]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Minus', THEME_SLUG) => array(
			'description' => __('A list with minus sign bullets.', THEME_SLUG),
			'shortcode' => "[list minus]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Phone', THEME_SLUG) => array(
			'description' => __('A list with phone icon bullets.', THEME_SLUG),
			'shortcode' => "[list phone]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Plus', THEME_SLUG) => array(
			'description' => __('A list with plus sign bullets.', THEME_SLUG),
			'shortcode' => "[list plus]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Question', THEME_SLUG) => array(
			'description' => __('A list with question icon bullets.', THEME_SLUG),
			'shortcode' => "[list question]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Square', THEME_SLUG) => array(
			'description' => __('A list with square bullets.', THEME_SLUG),
			'shortcode' => "[list square]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Support', THEME_SLUG) => array(
			'description' => __('A list with "support" icon bullets.', THEME_SLUG),
			'shortcode' => "[list support]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('V', THEME_SLUG) => array(
			'description' => __('A list with tick bullets.', THEME_SLUG),
			'shortcode' => "[list v]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('Warning', THEME_SLUG) => array(
			'description' => __('A list with warning icon bullets.', THEME_SLUG),
			'shortcode' => "[list warning]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
		__('X', THEME_SLUG) => array(
			'description' => __('A list with cross bullets.', THEME_SLUG),
			'shortcode' => "[list x]\nitem 1\nitem 2\nitem 3\nitem 4\n[/list]",
		),
	),

	__('Notifications', THEME_SLUG) => array(
		__('Highlight', THEME_SLUG) => array(
			'description' => __('A highlighted text.', THEME_SLUG),
			'shortcode' => '[highlight bg="#FF6600" color="#FFFFFF"]Text here[/highlight]',
		),
		__('Warning', THEME_SLUG) => array(
			'description' => __('A warning notification.', THEME_SLUG),
			'shortcode' => '[notify warn]Text here[/notify]',
		),
		__('Info', THEME_SLUG) => array(
			'description' => __('An informative notification.', THEME_SLUG),
			'shortcode' => '[notify info]Text here[/notify]',
		),
		__('Textbox white', THEME_SLUG) => array(
			'description' => __('An informative White box notification.', THEME_SLUG),
			'shortcode' => '[notify textbox-white]Text here[/notify]',
		),
		__('Textbox blue', THEME_SLUG) => array(
			'description' => __('An informative Blue box notification.', THEME_SLUG),
			'shortcode' => '[notify textbox-blue]Text here[/notify]',
		),
		__('Textbox grey', THEME_SLUG) => array(
			'description' => __('An informative Grey box notification.', THEME_SLUG),
			'shortcode' => '[notify textbox-grey]Text here[/notify]',
		),
		__('Ok', THEME_SLUG) => array(
			'description' => __('A positive notification.', THEME_SLUG),
			'shortcode' => '[notify ok]Text here[/notify]',
		),
		__('Question', THEME_SLUG) => array(
			'description' => __('A question notification.', THEME_SLUG),
			'shortcode' => '[notify question]Text here[/notify]',
		),
		__('Error', THEME_SLUG) => array(
			'description' => __('An error notification.', THEME_SLUG),
			'shortcode' => '[notify error]Text here[/notify]',
		),
	),

	__('Quotes', THEME_SLUG) => array(
		__('Quote block', THEME_SLUG) => array(
			'description' => __('Inserts a block which is styled like a quote.', THEME_SLUG),
			'shortcode' => '[quote]content here[/quote]',
		),
		__('Pullquote left', THEME_SLUG) => array(
			'description' => __('Inserts a left-aligned pullquote block.', THEME_SLUG),
			'shortcode' => '[pullquote left]content here[/pullquote]',
		),
		__('Pullquote right', THEME_SLUG) => array(
			'description' => __('Inserts a right-aligned pullquote block.', THEME_SLUG),
			'shortcode' => '[pullquote right]content here[/pullquote]',
		),
		__('Quote symbol 1', THEME_SLUG) => array(
			'description' => __('Inserts a quote symbol image, which will be placed like a dropcap.', THEME_SLUG),
			'shortcode' => '[quote-symbol symbol1]',
		),
		__('Quote symbol 2', THEME_SLUG) => array(
			'description' => __('Inserts a quote symbol image, which will be placed like a dropcap.', THEME_SLUG),
			'shortcode' => '[quote-symbol symbol2]',
		),
		__('Quote symbol 3', THEME_SLUG) => array(
			'description' => __('Inserts a quote symbol image, which will be placed like a dropcap.', THEME_SLUG),
			'shortcode' => '[quote-symbol symbol3]',
		),
		__('Quote symbol 4', THEME_SLUG) => array(
			'description' => __('Inserts a quote symbol image, which will be placed like a dropcap.', THEME_SLUG),
			'shortcode' => '[quote-symbol symbol4]',
		),
		__('Quote symbol 5', THEME_SLUG) => array(
			'description' => __('Inserts a quote symbol image, which will be placed like a dropcap.', THEME_SLUG),
			'shortcode' => '[quote-symbol symbol5]',
		),
	),
	
	__('Tabs', THEME_SLUG) => array(
		__('Tab block', THEME_SLUG) => array(
			'description' => __('Inserts a tabbed content block. Use [tab] shortcodes to add more tabs.', THEME_SLUG),
			'shortcode' => "[tabs]\n[tab title=\"Title here\"]Content here[/tab]\n[/tabs]",
		),
		__('Tab left block', THEME_SLUG) => array(
			'description' => __('Inserts a tabbed content block and tabs on the left. Use [tab] shortcodes to add more tabs.', THEME_SLUG),
			'shortcode' => "[tabs left]\n[tab title=\"Title here\"]Content here[/tab]\n[/tabs]",
		),
		__('Tab right block', THEME_SLUG) => array(
			'description' => __('Inserts a tabbed content block and tabs on the right. Use [tab] shortcodes to add more tabs.', THEME_SLUG),
			'shortcode' => "[tabs right]\n[tab title=\"Title here\"]Content here[/tab]\n[/tabs]",
		),
		__('Single tab', THEME_SLUG) => array(
			'description' => __('A single tab. This needs to be placed inside a [tabs] shortcode (and not inside another [tab] shortcode) to work.', THEME_SLUG),
			'shortcode' => '[tab title="Title here"]Content here[/tab]',
		),
	),

	__('Toggle', THEME_SLUG) => array(
		__('Toggle block', THEME_SLUG) => array(
			'description' => __('Inserts a toggled content block. Use [toggle_content] shortcodes to add more content sections.', THEME_SLUG),
			'shortcode' => "[toggle]\n[toggle_content title=\"Title here\" subtitle=\"Optional subtitle here\"]Content here[/toggle_content]\n[/toggle]",
		),
		__('Single toggle section', THEME_SLUG) => array(
			'description' => __('A single toggle content section. This needs to be placed inside a [toggle] shortcode (and not inside another [toggle_content] shortcode) to work.', THEME_SLUG),
			'shortcode' => '[toggle_content title="Title here" subtitle="Optional subtitle here"]Content here[/toggle_content]',
		),
	),
	
	__('Special Shortcodes', THEME_SLUG) => array(
		__('Portfolio', THEME_SLUG) => array(
			'description' => __('Inserts the portfolio layout with category option.', THEME_SLUG),
			'shortcode' => '[portfolio category="portfolio,design,layout" number="15"]',
		),
		__('Sociables', THEME_SLUG) => array(
			'description' => __('Inserts the sociables which you already set at the admin panel.', THEME_SLUG),
			'shortcode' => '[sociables]',
		),
		__('Thumbnail Slider', THEME_SLUG) => array(
			'description' => __('Inserts an Accordion-Carousel Thumbnail slider.', THEME_SLUG),
			'shortcode' => '[thumbnailslider category="all" number="20" background="#CCC" textcolor="#000" count="10"]',
		),
		__('Latest Posts', THEME_SLUG) => array(
			'description' => __('Inserts a list of latest posts.', THEME_SLUG),
			'shortcode' => '[latestposts title="Latest Posts" category="_name" number="10" orderby="latest"]',
		),
		__('Popular Posts', THEME_SLUG) => array(
			'description' => __('Inserts a list of popular posts.', THEME_SLUG),
			'shortcode' => '[latestposts title="Popular Posts" category="_name" number="10" orderby="popular"]',
		),
		__('Random Posts', THEME_SLUG) => array(
			'description' => __('Inserts a list of random posts.', THEME_SLUG),
			'shortcode' => '[latestposts title="Random Posts" category="_name" number="10" orderby="random"]',
		),
		__('Custom Latest Posts', THEME_SLUG) => array(
			'description' => __('Inserts a list of latest posts in a blog style format. You put a custom title, select which category to display, limit the number of posts, limit the number of words and use thumbnail, medium or large as the size of the featured image.', THEME_SLUG),
			'shortcode' => '[blogposts title="Latest Blog Posts" category="all" number="10" words="55" orderby="latest" image="thumbnail"]')
	)
);


// Outputs a category list
//
function core_shortcodes_overlay_categories() {
	global $shortcode_categories;

	foreach ($shortcode_categories as $category => $shortcodes) {
		echo '<li data-category="', sanitize_title_with_dashes($category), '">', $category, '</li>';
	}
}

// Outputs categories and their shortcodes
//
function core_shortcodes_overlay_shortcodes() {
	global $shortcode_categories;

	foreach ($shortcode_categories as $category => $shortcodes) {
		echo '<ul class="shortcodes-', sanitize_title_with_dashes($category), '">';
		foreach ($shortcodes as $name => $shortcode) {
			echo '<li data-description=\'', $shortcode['description'], '\' data-shortcode=\'', $shortcode['shortcode'], '\'>', $name, '</li>';
		}
		echo '</ul>';
	}
}

?>
<!doctype html>
<html>
<head>
<title>Shortcodes</title>

<style type="text/css">
	#categories {
		vertical-align: top;
		width: 130px;
		display: inline-block;
		margin: 0;
		padding: 10px;
		height: 90%;
	}

	#categories > li {
		cursor: pointer;
		padding: 5px;
		margin: 0;
	}

	#categories > li:hover {
		background-color: #21759B;
		color: #fff;
	}

	#shortcodes {
		vertical-align: top;
		width: 150px;
		display: inline-block;
		margin: 0;
		padding: 10px;
		border-left: 1px solid #ddd;
		height: 90%;
	}

	#shortcodes > ul {
		display: none;
	}

	#shortcodes > ul > li {
		cursor: pointer;
		padding: 5px;
		margin: 0;
	}

	#shortcodes > ul > li:hover {
		background-color: #21759B;
		color: #fff;
	}

	#description {
		vertical-align: top;
		width: 290px;
		display: inline-block;
		margin: 0;
		padding: 10px;
		border-left: 1px solid #ddd;
		height: 90%;
	}

	#description > p {
		padding: 5px;
	}

	h1 {
		font-size: 1.1em;
		margin: 10px 0;
		padding: 5px;
	}
</style>

<script type="text/javascript">
	var ANIMATION_SPEED = 100;

	// Show a category's shortcodes
	jQuery('#categories > li').click(function() {
		var category = jQuery(this).attr('data-category');

		jQuery('#shortcodes > ul').slideUp(ANIMATION_SPEED);
		jQuery('#shortcodes > .shortcodes-' + category).stop(true, false).show(ANIMATION_SPEED);
	});

	// Show description when hovering over a shortcode
	jQuery('#shortcodes > ul > li').hover(function() {
		var description = jQuery(this).attr('data-description');
		
		jQuery('#description > p').fadeOut(ANIMATION_SPEED, function() {
			jQuery(this).html(description);
			jQuery(this).fadeIn(ANIMATION_SPEED);
		});
	});

	// Insert shortcode
	jQuery('#shortcodes > ul > li').click(function() {
		var shortcode = jQuery(this).attr('data-shortcode');
		window.send_shortcode(shortcode);
	});
</script>

</head>

<body>
	<ul id="categories">
		<h1><?php _e('Categories', THEME_SLUG); ?></h1>
		<?php core_shortcodes_overlay_categories(); ?>
	</ul>

	<div id="shortcodes">
		<h1><?php _e('Shortcodes', THEME_SLUG); ?></h1>
		<?php core_shortcodes_overlay_shortcodes(); ?>
	</div>

	<div id="description">
		<h1><?php _e('Description', THEME_SLUG); ?></h1>
		<p></p>
	</div>
</body>
</html>
<?php

if (!defined('CORE_VERSION'))
	die();

// Pre run the shorcodes first before wp_autop() and wp_textuarize()
function core_prerun_shortcode( $content ) {
    global $shortcode_tags;
 
    // Backup current registered shortcodes and clear them all out
    $orig_shortcode_tags = $shortcode_tags;
    $shortcode_tags = array();
    remove_all_shortcodes();
 
    add_shortcode('toggle', 'core_shortcode_toggle');
    add_shortcode('toggle_content', 'core_shortcode_toggle_content');
    add_shortcode('tabs', 'core_shortcode_tabs');
    add_shortcode('tab', 'core_shortcode_tab');
	add_shortcode('columns', 'core_shortcode_columns');
	add_shortcode('column', 'core_shortcode_column');
	add_shortcode('custom_columns', 'core_shortcode_custom_columns');
	add_shortcode('notify', 'core_shortcode_notify');
	add_shortcode('divider', 'core_shortcode_divider');
 
    // Do the shortcode (only the one above is registered)
    $content = do_shortcode( $content );
 
    // Put the original shortcodes back
    $shortcode_tags = $orig_shortcode_tags;
 
    return $content;
}
add_filter( 'the_content', 'core_prerun_shortcode', 7 );

// Toggle
// [toggle]
// [toggle_content title="title" subtitle="subtitle"]
// [/toggle_content]
// [/toggle]
//
function core_shortcode_toggle($atts, $content=null, $tag) {
	$output = '<ul class="shortcode-toggle">';
	$output .= do_shortcode($content);
	$output .= '</ul>';

	return $output;
}

function core_shortcode_toggle_content($atts, $content=null, $tag) {
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
	), $atts));

	$output = '<li>';
	$output .= '<div class="header"><span class="title">' . $title . '</span><span class="subtitle">' . $subtitle . '</span><span class="arrow">&rsaquo;&rsaquo;</span></div>';
	
	$output .= '<div class="content">';
	$output .= do_shortcode(wpautop($content));
	$output .= '</div>';

	$output .= '</li>';

	return $output;
}

// Padded headings
// [header 1|2|3|4|5|6]content[/header]
//
$core_shortcode_headings = array('1', '2', '3', '4', '5', '6');
function core_shortcode_heading($atts, $content=null, $tag) {
	global $core_shortcode_headings;

	$style = core_shortcode_validate_type($atts, $core_shortcode_headings, '1');

	return '<div class="shortcode-header"><h' .$style. '>' .$content. '</h' .$style. '></div>';
}

// Code
// [code]content with shortcodes[/code]
//
function core_shortcode_code($atts, $content=null, $tag) {
	return '<pre>'.htmlentities($content).'</pre>';
}

// Divider
// [divider solid|dotted|invisible|totop]
//
$core_shortcode_divider_styles = array('solid', 'dotted', 'invisible', 'slashed', 'totop');
function core_shortcode_divider($atts, $content=null, $tag) {
	global $core_shortcode_divider_styles;

	$style = core_shortcode_validate_type($atts, $core_shortcode_divider_styles, 'solid');
	$extra = '';
	if ($style == 'totop')
		$extra = '<a href="#" class="totop"></a>';

	return '<div class="shortcode-divider ' .$style. '">' . $extra. '</div>';
}

// Button
// [button small|medium|large link=""]
//
$core_shortcode_button_sizes = array('small', 'medium', 'large');
function core_shortcode_button($atts, $content=null, $tag) {
	global $core_shortcode_button_sizes;

	$size = core_shortcode_validate_type($atts, $core_shortcode_button_sizes, 'medium');

	if (isset($atts['link']))
		$link = $atts['link'];
	else
		$link = '/';

	if (in_array('window', $atts))
		$target = '_blank';
	else
		$target = '_self';

	return '<a href="' .$link. '" target="' .$target. '" class="theme-button ' .$size. '">' .do_shortcode($content). '</a>';
}

// Gallery
// [gallery columns="4"]<img src="">[/gallery]
//
function core_shortcode_gallery($atts, $content=null, $tag) {
	extract(shortcode_atts(array(
		'columns' => 4,
		'description' => '',
		'title' => ''
	), $atts));

	// SUpported column types
	$column = intval($columns);
	if ($columns == 2)
		$column_class = 'tsixcol';
	else if ($columns == 3)
		$column_class = 'tfourcol';
	else if ($columns == 4)
		$column_class = 'tthreecol';
	else if ($columns == 6)
		$column_class = 'ttwocol';
	else
		return '';

	// Extract image tags
	preg_match_all('/<img[^>]+>/i', $content, $image_list); 
	
	// Output gallery list
	$id = core_get_uuid('gallery');
	$index = 0;
	$output = '<ul class="shortcode-gallery">';
	foreach($image_list[0] as $image) {
		$index += 1;
		if ($index == $columns) {
			$column_last = ' last';
			$index = 0;
		} else {
			$column_last = '';
		}

		unset($width);
		unset($height);

		// Extract attributes
		preg_match_all('/(src|alt|title|width|height)=("[^"]*")/i', $image, $attribs);
		$attrs = array_combine($attribs[1], $attribs[2]);
		foreach($attrs as $key => $value) {
			$attrs[$key] = substr($value, 1, -1);
		}
		extract($attrs);

		// Default thumb size
		if (!isset($width))
			$width = '200';
		if (!isset($height))
			$height = '150';
		
		// Output list item
		$output .= '<li class="view ' . $column_class . $column_last .'">';
		$output .= '<img src="' .core_generate_thumbnail($src, $width, $height, true). '" alt="' .$alt. '" title="' .$title. '">';
		$output .= '<div class="mask">';
		if ($title)
			$output .= '<h2>' .$title. '</h2>';
		else if ($alt)
			$output .= '<h2>' .$alt. '</h2>';
		if ($description)
			$output .= '<p>' .$description. '</p>';
		$output .= '<a class="info" href="' .$src. '" data-rel="prettyPhoto[' .$id. ']">view image</a></div>';
		$output .= '</li>';
	}
	$output .= '</ul>';
	$output .= "<script type=\"text/javascript\"> 
		//ipad and iphone fix
		if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
		    jQuery(\"li.view\").each(function(index, element){
		    	var element = jQuery(this)
			    element.click(function(){
			    	jQuery(\"li.view\").removeClass('hover');
			    	jQuery(this).addClass('hover');	
			    });
		    });
		}
	</script>";
	return $output;
}
//remove_shortcode('gallery', 'gallery_shortcode');

// Tabs
// [tabs][tab title="title"]content[/tab][/tabs]
//
$core_shortcode_tabs_position = array('top', 'left', 'right');
function core_shortcode_tabs($atts, $content=null, $tag) {
	global $core_shortcode_tabs_position;

	$position = core_shortcode_validate_type($atts, $core_shortcode_tabs_position, null);

	$output = '<div class="shortcode-tabs '.$position.'">';
	$output .= '<div class="titles"></div>';
	$output .= '<div class="content"></div>';
	$output .= do_shortcode($content);
	$output .= '</div>';

	return $output;
}

function core_shortcode_tab($atts, $content=null, $tag) {
	extract(shortcode_atts(array(
		'title' => 'Tab',
	), $atts));

	$output = '<div class="shortcode-tab-title">' .$title. '</div>';
	$output .= '<div class="shortcode-tab">' .do_shortcode($content). '</div>';

	return $output;
}

// Notifications
// [notify textbox-white|textbox-black|textbox-grey|warn|info|ok|question|error]content[/notify]
//
$core_shortcode_notify_types = array('textbox-white','textbox-blue','textbox-grey','warn', 'info', 'ok', 'question', 'error');
function core_shortcode_notify($atts, $content=null, $tag) {
	global $core_shortcode_notify_types;

	$type = core_shortcode_validate_type($atts, $core_shortcode_notify_types, null);

	if (!$type)
		return core_get_warning(__('Invalid or no "notify" shortcode attribute.', THEME_SLUG));

	return '<div class="shortcode-notify ' .$type. '">' .do_shortcode($content). '</div>';
}

// Lists
//
$core_shortcode_list_types = array(	'circle', 'square', 'dots', 'phone', 'mail', 'file',
									'plus', 'minus', 'balloon', 'support', 'creditcard', 'info',
									'question', 'v', 'x', 'warning');
function core_shortcode_list($atts, $content=null, $tag) {
	global $core_shortcode_list_types;

	$list_items = core_shortcode_get_array($content);
	$type = core_shortcode_validate_type($atts, $core_shortcode_list_types, null);
	
	if (!$type)
		return core_get_warning(__('Invalid or no "list" shortcode attribute.', THEME_SLUG));

	$output = '';
	$output .= '<ul class="shortcode-list ' .$type. '">';
	foreach($list_items as $item)
		$output .= '<li>' .trim($item). '</li>';
	$output .= '</ul>';

	return $output;
}

// Columns
// [columns divider][column half|third|twothird|twofourth|threefourth|fifth|twofifth|threefifth|fourfifth]content[/column][/columns]
//
// Column container
function core_shortcode_columns($atts, $content=null, $tag) {
	if (is_array($atts) && in_array('divider', $atts))
		$class = ' divider';
	else
		$class = '';

	return '<div class="shortcode-columns' .$class. '">' .do_shortcode($content). '</div>';
}

// Single column
$core_shortcode_column_types = array('half', 'third', 'twothird', 'fourth', 'twofourth', 'threefourth', 'fifth', 'twofifth', 'threefifth', 'fourfifth');
function core_shortcode_column($atts, $content=null, $tag) {
	global $core_shortcode_column_types;

	$type = core_shortcode_validate_type($atts, $core_shortcode_column_types, null);

	if (!$type)
		return core_get_warning(__('Invalid or no "column" shortcode attribute.', THEME_SLUG));

	return '<div class="shortcode-column ' .$type. '">' .do_shortcode(wpautop($content)). '</div>';
}

// Column with a background
function core_shortcode_custom_columns($atts, $content=null){
	extract( shortcode_atts( array(
      'image' => '',
      'textcolor' => '#FFFFFF',
      'width' => 100,
      'height' => 200,
      ), $atts ) );
    
    $bg = '';
    $width = intval($width)-4;
    $height = intval($height);
    
    if($image || $image != '')
    	$bg = 'style="background: url('.$image.') top no-repeat; color: '.$textcolor.'; width: '.$width.'%; min-height: '.$height.'px;';
    
    return '<div class="shortcode-columns custom" '.$bg.'">' .do_shortcode($content). '</div>';  
      
}

// Pullquotes
// [pullquote left|right]content[/pullquote]
//
$core_shortcode_pullquote_types = array('left', 'right');
function core_shortcode_pullquote($atts, $content = null) {
	global $core_shortcode_pullquote_types;
   
	$type = core_shortcode_validate_type($atts, $core_shortcode_pullquote_types, 'left');

	return '<div class="shortcode-pullquote ' . $type . '">' . do_shortcode($content) . '</div>';
}

// Quote symbol
// [quote-symbol symbol1|symbol2|symbol3|symbol4|symbol5]content[/pullquote]
//
$core_shortcode_quote_symbol_types = array('symbol1', 'symbol2', 'symbol3', 'symbol4', 'symbol5');
function core_shortcode_quote_symbol($atts, $content = null) {
	global $core_shortcode_quote_symbol_types;

	$type = core_shortcode_validate_type($atts, $core_shortcode_quote_symbol_types, 'left');

	return '<span class="shortcode-quote-symbol ' . $type . '"></span>';
}

// Quote block shortcode
// [quote]content[/quote]
//
function core_shortcode_quote($atts, $content=null, $tag) {
	return '<div class="shortcode-quote">' .do_shortcode($content). '</div>';
}

// Drop caps
//
$core_shortcode_dropcap_types = array('red', 'green', 'blue', 'black', 'white', 'grey');
function core_shortcode_dropcap($atts, $content=null, $tag) {
	global $core_shortcode_dropcap_types;

	$type = core_shortcode_validate_type($atts, $core_shortcode_dropcap_types, 'left');

	return '<span class="shortcode-dropcap ' . $type . '">' . do_shortcode($content) . '</span>';
}

// Latest Post Shortcode 
// [latestposts title="Latest Posts" category="all" number="10" orderby="latest|popular|random" ]
//
function td_latestpost_shortcode($atts, $content=null) {
	
	extract(shortcode_atts(array(
		'title'		=> '',
		'category'	=> '',
		'number'	=> '10',
		'orderby'	=> 'date'
	), $atts));
		
	$output = '';
	if ( $title ) $output .= '<div class="shortcode-header"><h4>' . $title . '</h4></div>'; 
	
	if ( $category == '' || $category == 'all') :
		$args = array('category_name' => '');
	else :
		$args = array('category_name' => $category);
	endif;
	
	if ( $orderby == 'random') :
		$orderby = 'rand';
	elseif ( $orderby == 'popular') :
		$orderby = 'comment_count';
	else :
		$orderby = 'date';
	endif;
		
	$queryargs = array(			
			'posts_per_page' 		=> $number,
			'no_found_rows' 		=> true,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> true,
			'order'					=> 'desc',
			'orderby' 				=> $orderby
		 );
	$queryargs = array_merge($queryargs, $args );
	
	
	$r = new WP_Query( apply_filters( 'td_latestpost_shortcode_args', $queryargs, $atts ) ); //$queryargs); 
	
	if ($r->have_posts()) :
	
		$output .= '<ul class="td_postWidget_posts">';
		while ($r->have_posts()) : $r->the_post(); 

			$output .= '	<li>';
			if( has_post_thumbnail() ) :
				$output .= '<a href="'.get_permalink().'" title="'.get_the_title().'">';
				$output .= get_the_post_thumbnail(null, 'thumbnail', array('class' => 'thumbs alignleft'));
				//$output .= '<img src="http://placehold.it/150x150" class="td_postWidget_thumbs alignleft" alt="placeholder">';
				$output .= '</a>';
			else:
				$output .= ' <img src="http://placehold.it/150x150" class="thumbs alignleft" alt="placeholder">';
			endif;
				
			$output .= '<a  class="post-title" href="' .get_permalink(). '" title="'.get_the_title().'">'.get_the_title().'</a>';
			
			$category = get_the_category(); 
			if($category[0]){
				$output .= '<span class="td_postWidget_meta"><a class="cat" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a> ';
			}
			
			$output .= '<span>'.get_the_date(). '</span> | by <i>' .get_the_author(). '</i></span>';
			
			$output .= '	</li>';
		endwhile;
		$output .= '</ul>';
	
	else:
		
		$output .= '<p>' . __('No posts found.', THEME_SLUG) . '</p>';
			
	endif;
	
	// Reset the global $the_post as this query will have stomped on it
	wp_reset_postdata();
	
	
	return $output;
	
}

// Blog Post Shortcode 
// [blogposts title="Latest Blog Posts" category="all" number="10" orderby="latest|popular|random" image="thumbnail|medium|large" ]
//
function td_blogpost_shortcode($atts, $content=null) {
	
	extract(shortcode_atts(array(
		'title'		=> '',
		'category'	=> '',
		'number'	=> '10',
		'words'		=> '55',
		'orderby'	=> 'date',
		'image'		=> 'thumbnail',
	), $atts));
		
	$output = '';
	if ( $title ) $output .= '<div class="shortcode-header"><h4>' . $title . '</h4></div>'; 
	
	if ( $category == '' || $category == 'all') :
		$args = array('category_name' => '');
	else :
		$args = array('category_name' => $category);
	endif;
	
	if ( $orderby == 'random') :
		$orderby = 'rand';
	elseif ( $orderby == 'popular') :
		$orderby = 'comment_count';
	else :
		$orderby = 'date';
	endif;
	
	$words = (int)$words;
	
	if (!$image) $image = "thumbs";
		
	$queryargs = array(			
			'posts_per_page' 		=> $number,
			'no_found_rows' 		=> true,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> true,
			'order'					=> 'desc',
			'orderby' 				=> $orderby
		 );
	$queryargs = array_merge($queryargs, $args );
	
	
	$r = new WP_Query( apply_filters( 'td_latestpost_shortcode_args', $queryargs, $atts ) ); //$queryargs); 
	
	if ($r->have_posts()) :
	
		$output .= '<ul class="td_postWidget_posts">';
		while ($r->have_posts()) : $r->the_post(); 

			$output .= '	<li>';
			
			$output .= '<h4><a  class="post-title" href="' .get_permalink(). '" title="'.get_the_title().'">'.get_the_title().'</a></h4><div class="item">';						
			if( has_post_thumbnail() ) :
				$output .= '<a href="'.get_permalink().'" title="'.get_the_title().'">';
				$output .= get_the_post_thumbnail(null, $image, array('class' => $image . ' thumbs alignleft'));
				//$output .= '<img src="http://placehold.it/150x150" class="td_postWidget_thumbs alignleft" alt="placeholder">';
				$output .= '</a>';
			//else:
				//$output .= ' <img src="http://placehold.it/150x150" class="thumbs alignleft" alt="placeholder">';
			endif;
			
			$output .= '<p>' . excerpt($words).'... <a href="'.get_permalink().'"><br>'.__('read more', THEME_SLUG).' &rsaquo;&rsaquo;</a></p></div>';
			
			$num_comments = get_comments_number(); // get_comments_number returns only a numeric value

			//if ( comments_open() ) :
				if ( $num_comments == 0 )
					$comments = '<span class="num">0</span> ' . __(' Comments', THEME_SLUG);
				elseif ( $num_comments > 1 )
					$comments = '<span class="num">' . $num_comments . '</span>' . __(' Comments', THEME_SLUG);
				else 
					$comments = '<span class="num">1</span> ' . __('Comment', THEME_SLUG);
					
				$output .= '<div class="td_postWidget_meta"><a href="' . get_comments_link() .'"><span class="comment">'. $comments.'</span></a>  | ';
			//else :
				//$output .=  __('Comments are off for this post.');
			//endif;		
			
			$output .= '<span>'.get_the_date(). '</span> | by <span><i>' .get_the_author(). '</i></span></div>';
			
			$category = get_the_category(); 
			if($category[0]){
				$output .= '<div class="td_postWidget_meta">'. __('Category', THEME_SLUG). ': <a class="cat" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></div>';
			}			
			
			
			$tags = get_the_tag_list('<span class="cat">','</span> <span class="cat">','</span>');
			if ($tags){
				$output .= '<div class="td_postWidget_meta">'. __('Tags', THEME_SLUG). ': '.$tags.'</div>';	
			}
			
			$output .= '	</li>';
		endwhile;
		$output .= '</ul>';
	
	else:
		
		$output .= '<p>' . __('No posts found.', THEME_SLUG) . '</p>';
			
	endif;
	
	// Reset the global $the_post as this query will have stomped on it
	wp_reset_postdata();
	
	
	return $output;
	
}


// ThemeDutch Carousel - Accordion-like Thumbnail Slider
// Usage: [thumbnailslider category=all number=15]
//
function td_thumbnail_slider_shortcode($attr) {
	
	extract(shortcode_atts(array(
		'category'	 => '',
		'number'	 => '15',
		'words'      => '15',
		'background' => '#FFF',
		'textcolor'  => '#000',
		'orderby'	 => 'date'
	), $attr));
	
	$number = intval($number);
	$words = intval($words);
		
	$output = '';
	//if ( $title ) $output .= '<div class="shortcode-header"><h3>' . $title . '</h3></div>'; 
	
	if ( $category == '' || $category == 'all') :
		$args = array('category_name' => '');
	else :
		$args = array('category_name' => $category);
	endif;
	
	$queryargs = array(			
			'posts_per_page' 		=> $number,
			'no_found_rows' 		=> true,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> true,
			'order'					=> 'desc',
			'orderby' 				=> 'date'
		 );
	$queryargs = array_merge($queryargs, $args );
	
	
	$r = new WP_Query( apply_filters( 'td_thumbnail_slider_shortcode_args', $queryargs, $attr ) ); 
	$i = 1;
	if ($r->have_posts()) :
	
		$output .= '<div class="shortcode-tdacs"><div class="buttons prev">left</div><div class="viewport" style="background:'.$background.'; "><ul class="overview">';
		while ($r->have_posts()) : $r->the_post(); 
			
			if( has_post_thumbnail() ) :
				if($i<=1){
					$output .= '<li class="lastblock">';
					$i++;
				}else{
					$output .= '<li>';
				}
					
				
				$output .= '<a href="'.get_permalink().'" title="'.get_the_title().'" >';
				$output .= get_the_post_thumbnail(null, 'tdac-thumb', array('class' => 'thumbs alignnone'));
				$output .= '</a>';
				
					
				$output .= '<div class="item-wrap"><h4 style="color:'.$textcolor.';" class="item-title">'.get_the_title().'</h4>';
				
				
				$output .= '<p style="color:'.$textcolor.';">'.excerpt($words).'<a href="'.get_permalink().'"><br>'.__('read more', THEME_SLUG) . ' &rsaquo;&rsaquo;</a></p>';
				
				$output .= '</div></li>';
			endif;
		endwhile;
		$output .= '</ul></div><div style="color:'.$textcolor.';" class="buttons next">'.__('right', THEME_SLUG).'</div></div>';
	
	else:
		
		$output .= '<p>' . __('No posts found.', THEME_SLUG) . '</p>';
			
	endif;
	
	// Reset the global $the_post as this query will have stomped on it
	wp_reset_postdata();
	
	return $output;
	
}

// A highlighted text shortcode
//[highlight bg="#000000" color="#FFFFFF"]some content[/highlight]
//

function core_shortcode_highlight($atts, $content=null, $tag){
	extract(shortcode_atts(array(
		'bg' => '#FF6600',
		'color' => '#FFFFFF',
	), $atts));

	return '<span style="background-color: '.$bg.'; color: '.$color.';">&nbsp;'.$content.'&nbsp;</span>';
}

// A portfolio layout shortcode
//[portfolio display="all"]
//
function core_shortcode_portfolio_layout($atts, $content=null, $tag){
	extract(shortcode_atts(array(
		'category' => '',
		'number' => '15',
	), $atts));
	$number = intval($number);
	
	$output = '';
	$raw_category = trim($atts['category']);
	//if ( $title ) $output .= '<div class="shortcode-header"><h3>' . $title . '</h3></div>'; 
	
	if ( $category == '' || $category == 'all') :
		$args = array('category_name' => '');
	else :
		$args = array('category_name' => $category);
	endif;
	
	$queryargs = array(			
			'posts_per_page' 		=> $number,
			'no_found_rows' 		=> true,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> true,
			'order'					=> 'desc',
			'orderby' 				=> 'date'
		 );
	$queryargs = array_merge($queryargs, $args );
	
	$r = new WP_Query( apply_filters( 'core_shortcode_portfolio_layout_args', $queryargs, $atts ) ); 

	if ($r->have_posts()) :
	
		$index = 0;
		$html_thumbnails ="";
		$categories = array();
		if ( $r->have_posts() ) :
		
			while ($r->have_posts()) : 
				$r->the_post();
				global $post;
				$file_data = array();
				$permalink = get_permalink();
			
				 if ($index == 3) {
				 	$index = 0;
					$lastclass = 'last';
				} else {
					$lastclass = '';
				}
				$index++;
				$format = get_post_format();
				$lwidth = core_options_get('the_width','post');
				$test_padding = 0;
				switch($lwidth){
					case "column_four_sixth" :
					case "column_five_sixth" :
					case "column_six_sixth" :
						$thumb_size = "portfolio-thumb_large";
						break;
					case "column_two_sixth" :
						$thumb_size = "portfolio-thumb_medium";
						break; 
					default :
						$thumb_size = "portfolio-thumb"; 
				}
				$category = get_the_category();
				$attachment_id = get_post_thumbnail_id();
				$file_data = wp_get_attachment_image_src(get_post_thumbnail_id(),$thumb_size) ;
				$height =  $file_data[2];
				if( !get_the_post_thumbnail())  continue;
					//if(!in_array($cat->name,$categories)) $categories[$cat->slug] = $cat->name;
					$class_categories = array();
					foreach($category as $thecategory){
						$class_categories[] = $thecategory->slug;
					}
					
					$html_thumbnails .= '
					  <li class="item  '.$lwidth.' '.implode(" ",$class_categories).' "> 
		    			 <a href="'.$permalink.'" data-post-id="'.get_the_ID().'">
					';
						$html_thumbnails .='<div class="img" style="background:url('.$file_data[0].') no-repeat ; background-size: cover; height:'.$height.'px; width:100%; display:block ;"></div>';
						
					$html_thumbnails .='			
		                <div class="item-title"> 
		                   <span>'.get_the_title().'</span>
		                </div>
		                </a>
					</li>
					';
			endwhile;
			
		endif;
	
	
	endif;
	 
	// Reset the global $the_post as this query will have stomped on it
	wp_reset_postdata();
	$html_output ='<div class="portfolio_block">'; 
	$category_label =  ($raw_category == "all" || $raw_category == "") ? $categories : explode(",",$raw_category);
	$raw_category = "";
	if(count($category_label) > 1 || $raw_category == "all"){
	$html_output .= '

			<div id="categories"> 
			<ul id="types" data-option-key="filter">
		    	<li><a href="#" data-option-value="*">All</a></li>';
	foreach($category_label as $index=>$name):
		if(strtolower($name) == "all"  || $name == "" ) continue; 
		$html_output .= '<li><a href="#" data-option-value=".'.strtolower(str_replace(" ","-",$name)).'"> '.ucwords(str_replace("-"," ",$name)).'</a></li>';
	endforeach; 
	$html_output .= '</ul>
				<div class="navi">
					<div class="next hide-text">Next</div>
					<div class="close hide-text">Close</div>
					<div class="previous hide-text">Prev</div>
				</div>
				<div class="clear"></div>
		</div>';
	}
	$html_output .=	'	<div class="sc_portfolio-ajaxified"></div>
						<div class="sc_portfolio">

								<ul class="portfolio-container da-thumbs theme-excerpts">'. $html_thumbnails . '</ul>
								<div class="clear"></div>
							</div>
						</div>		';
	
	return $html_output;
}

function aldenta_get_images($postid) {
	global $post;
	
	$photos = get_children( array('post_parent' => $postid, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
	
	$results = array();

	if ($photos) {
		foreach ($photos as $photo) {
			// get the correct image html for the selected size
			$results[] = wp_get_attachment_image($photo->ID, $size);
		}
	}

	return $results;
}
// Register all shortcodes
add_shortcode('toggle', 'core_shortcode_toggle');
add_shortcode('toggle_content', 'core_shortcode_toggle_content');
add_shortcode('divider', 'core_shortcode_divider');
add_shortcode('button', 'core_shortcode_button');
add_shortcode('tdgallery', 'core_shortcode_gallery');
add_shortcode('tabs', 'core_shortcode_tabs');
add_shortcode('tab', 'core_shortcode_tab');
add_shortcode('notify', 'core_shortcode_notify');
add_shortcode('list', 'core_shortcode_list');
add_shortcode('columns', 'core_shortcode_columns');
add_shortcode('column', 'core_shortcode_column');
add_shortcode('custom_columns', 'core_shortcode_custom_columns');
add_shortcode('pullquote', 'core_shortcode_pullquote');
add_shortcode('quote-symbol', 'core_shortcode_quote_symbol');
add_shortcode('quote', 'core_shortcode_quote');
add_shortcode('dropcap', 'core_shortcode_dropcap');
add_shortcode('latestposts', 'td_latestpost_shortcode');
add_shortcode('blogposts', 'td_blogpost_shortcode');
add_shortcode('thumbnailslider', 'td_thumbnail_slider_shortcode');
add_shortcode('highlight', 'core_shortcode_highlight');
add_shortcode('portfolio', 'core_shortcode_portfolio_layout');

// limit the excerpt words to be displayed on the Thumbnail CA Slider
// adapted from C.Bavota
// http://bavotasan.com/2009/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/
//
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).' ';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

//hook the TD Thumbnail CA Slider js in the footer
//
function td_thumbnail_slider_shortcode_in_use(){
	echo '<script type="text/javascript" src="'.THEME_URI.'/js/tdac-slider.js">';
	echo '</script>';
}	
add_action('wp_footer', 'td_thumbnail_slider_shortcode_in_use', 100);



?>
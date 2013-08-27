<?php

global $theme_post_options;

$group = new CoreOptionGroup('general', __('General', THEME_SLUG));
$theme_post_options->group_add($group);


// Slider 
$section = new CoreOptionSection('slider');
$group->section_add($section);
$section->option_add(new CoreOption('slider', __('Slider', THEME_SLUG), 'sliders', __('The slider will be displayed at the top of the page.', THEME_SLUG)));


// Other options
$section = new CoreOptionSection('options');
$group->section_add($section);

// Color schemes
$section->option_add(new CoreOption('colorscheme', __('Content color scheme', THEME_SLUG), 'colorschemes-list', __('The content block will use this color scheme.', THEME_SLUG)));

// Background image
$section->option_add(new CoreOption('background_image', __('Background image', THEME_SLUG), 'image', __('This background image will override the one defined under theme options.', THEME_SLUG)));

// Custom content section
$section->option_add(new CoreOption('custom_content', __('Slogan block', THEME_SLUG), 'text-multiline', __('Any HTML put here will be included in it\'s own block above the content.', THEME_SLUG)));
$section->option_add(new CoreOption('custom_content_image', __('Slogan block background', THEME_SLUG), 'image', __('This background image will display within the Slogan block.', THEME_SLUG)));

function theme_custom_content() {
	$post_type = get_post_type();
	$category = get_query_var('cat');
	$current_category = get_category ($category);
	$content = '';
	
	if (!$post_type)
		return null;
	
	// check if it's a page or post with a custom content
	if ( is_singular() )
		$content = core_options_get('custom_content', $post_type);
		
	// Archive
	if ( is_archive() ) {
		// check if it's a category and display the custom content if there are any
		if ( is_category() )
			$content = core_options_get('custom_content' . $current_category->slug, 'theme');

		// Author
		elseif ( is_author() )
			$content = core_options_get('custom_content_layout-author', 'theme');
			
		// Tag
		elseif ( is_tag() )
			$content = core_options_get('custom_content_layout-tag', 'theme');
		else 
			$content = core_options_get('custom_content_layout-archive', 'theme');
	}
	
	// Search
	if ( is_search() )
		$content = core_options_get('custom_content_layout-search', 'theme');
	
	if ($content)
		return $content;

	return null;
}

?>
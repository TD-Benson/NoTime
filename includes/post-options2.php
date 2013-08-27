<?php

global $theme_post_options2;

$group = new CoreOptionGroup('general', __('General', THEME_SLUG));
$theme_post_options2->group_add($group);

// Post Width
$section = new CoreOptionSection('post-width');
$group->section_add($section);
$option = new CoreOption('the_width', __('Post Width', THEME_SLUG), 'select', __('This option allows you to set up the layout from 1/6 up to 6/6 columns on portfolio overview pages. NOTE: this option cannot be applied on blog overview pages, because they have a main 3-column layout.', THEME_SLUG), 'column_two_sixth');
$option->parameters = array('column_one_sixth' => __('1/6th', THEME_SLUG), 'column_two_sixth' => __('2/6th', THEME_SLUG), 'column_three_sixth' => __('3/6th', THEME_SLUG), 'column_four_sixth' => __('4/6th', THEME_SLUG) , 'column_five_sixth' => __('5/6th', THEME_SLUG) , 'column_six_sixth' => __('6/6th', THEME_SLUG));

$section->option_add($option);

?>
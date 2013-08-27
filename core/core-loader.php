<?php

if (!defined('CORE_VERSION'))
	die();


function core_loader($logo='', $loading_image='') {
	echo '<div class="core-loader">';
	echo '<div class="content">';

	echo '<div class="logo">';
	if($logo)
		echo '<a href="', home_url(), '"><img src="', $logo, '" alt="', get_bloginfo('title'), '" /></a>';
	else
		echo '<a href="', home_url(), '">', get_bloginfo('name'), '</a>';

	echo '</div>';

	if ($loading_image) {
		echo '<div class="indicator">';
		echo '<img src="', $loading_image, '" alt="loading" title="loading">';
		echo '</div>';
	}

	echo '</div>';
	echo '</div>';
}
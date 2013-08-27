<?php

if (!defined('CORE_VERSION'))
	die();


// Outputs a single group inside a metabox
//
function core_options_metabox_output($post, $metabox) { 
	$handler = $metabox['args']['handler'];
	
	// Nonce field
	echo '<input type="hidden" name="metabox-nonce-', $handler->slug, '" value="', wp_create_nonce('core-post-options-'. $handler->slug), '">';

	foreach ($handler->groups as $group) {
		$group->output(false);
	}
}

// Registers metaboxes for post options
//
function core_options_metaboxes_register() {
	global $core_option_handlers;

	// Only output metaboxes if we are on an editing page with a post type
	$screen = get_current_screen();
	if ($screen->post_type)
		$post_type = $screen->post_type;
	else
		return;

	foreach ($core_option_handlers as $handler) {
		if ($handler->has_context($post_type)) {
			add_meta_box(
				'core-options-' .$post_type. '-' .$handler->slug,
				$handler->title,
				'core_options_metabox_output',
				$post_type,
				'normal',
				'high',
				array('handler' => $handler)
			);
		}
	}
}
add_action('add_meta_boxes', 'core_options_metaboxes_register');

// Saves data from a metabox to a post
//
function core_options_metaboxes_save($post_id) {
    global $core_option_handlers;

    // Ignore autosaves
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    	return;

    // Verify user role
    if(!current_user_can('edit_posts'))
    	return;

    foreach ($core_option_handlers as $handler) {
	    // Verify nonce for this handler
	    $nonce_name = 'metabox-nonce-' .$handler->slug;
	    $action_name = 'core-post-options-'. $handler->slug;
	    if (!isset($_REQUEST[$nonce_name]) || !wp_verify_nonce($_REQUEST[$nonce_name], $action_name))
	    	continue;

	    // Store each option
	 	foreach ($handler->options as $option_name => $option) {
	 		$key = $option->key;

	 		if (isset($_REQUEST[$key])) {
	 			// Checkboxes are false if not defined, true if they are
				if ($option->type == 'checkbox')
					$value = $option->import(isset($_POST[$key]));
				else
		 			$value = $option->import($_REQUEST[$key]);

		 		update_post_meta($post_id, $key, $value);
	 		} else 
	 			delete_post_meta($post_id, $key);
	 	}
    }

}
add_action('save_post', 'core_options_metaboxes_save');

?>
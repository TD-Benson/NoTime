<?php

// Outputs a custom comment item
//
function theme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar($comment->comment_author_email, 48, THEME_URI . '/images/avatar-default.png'); ?>

				<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>', THEME_SLUG), get_comment_author_link()) ?>
				<br>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
						<?php printf(__('%1$s at %2$s', THEME_SLUG), get_comment_date(),  get_comment_time()) ?>
					</a>
					<?php edit_comment_link(__('(Edit)', THEME_SLUG),'  ','') ?>
				</div>
			</div>

			<?php if ($comment->comment_approved == '0') : ?>
				<p class="moderation"><?php _e('Your comment is awaiting moderation.', THEME_SLUG) ?></p>
			<?php endif; ?>

			<div class="comment-body">
				<?php comment_text(); ?>

				<div class="reply">
					<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			</div>
		</div>

		<div class="floatclear"></div>
	<?php
}

// Outputs the post's comments
//
function theme_output_comments() {
	echo '<ul class="comments">';
	wp_list_comments(array(
		'callback'    => 'theme_comment',
	));
	echo '</ul>';

	// Output comment pagination
	paginate_comments_links();

	// Output comment form
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$aria_req = ($req ? 'aria-required="true"': '');

	// Output comment form
	echo '<div class="shortcode-header"><h6>' . __('Leave a reply', THEME_SLUG) . '</h6></div>';
	comment_form(array(
		'title_reply' => '',
		'fields' => array(
			'author' => '<p class="comment-form-author field">
				<input id="author" name="author" type="text" placeholder="name (required)" value="' . esc_attr($commenter['comment_author']) . '" ' . $aria_req . '>
			</p>',
			'email' => '<p class="comment-form-email field">
				<input id="email" name="email" type="text" placeholder="email (required)" value="' . esc_attr($commenter['comment_author_email']) . '" ' . $aria_req . '>
			</p>',
			'url' => '<p class="comment-form-url field">
				<input id="url" name="url" type="text"  placeholder="website" value="' . esc_attr($commenter['comment_author_url']) . '">
			</p>',
		),
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'comment_notes_before' => '<p>' . __('Your email address will not be published.', THEME_SLUG) . '</p>',
		'comment_notes_after' => '',
	));
}


// Comments area
if (comments_open()) {
	echo '<div class="shortcode-header"><h6>' . __('Comments', THEME_SLUG) . '</h6></div>';

	$num_comments = intval(get_comments_number());
	if ($num_comments == 0)
		echo '<p>' . __('There are no comments yet. Be the first to leave one!', THEME_SLUG) . '</p>';
	
	theme_output_comments();
}

?>
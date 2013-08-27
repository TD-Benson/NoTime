<?php

$author = get_user_by('slug', get_query_var('author_name'));

echo '<h2>' . sprintf(__('Viewing all posts by %s', THEME_SLUG), $author->display_name) . '</h2>';
get_template_part('loop', 'excerpts');

?>
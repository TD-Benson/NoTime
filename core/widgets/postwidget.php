<?php
/**
 * Theme Dutch Posts Widget
 *
 * Display the latest, popular or random posts.
 *
 *
 * Adapted from the WP Recent Post widget
 * 
 * @package td_Extras
 * @subpackage Widget
 */

class td_postWidget extends WP_Widget {

    function td_postWidget(){
		$widget_ops = array('classname' => 'widget_themedutch_posts','description' => 'Display the latest, popular or random posts.');
		parent::WP_Widget(false,$name= 'ThemeDutch PostsWidget',$widget_ops);		
	}

  /* Displays the Widget the sidebar section */
    function widget($args, $instance){
		
		
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? 'Latest Post' : $instance['title']);
		$display_option = empty($instance['display_option']) ? '' : $instance['display_option'];
		$cat_option = empty($instance['cat_option']) ? '' : $instance['cat_option'];	
		$display_order = '';
		
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
 		
 		
 		if($cat_option == 'all' || $cat_option == ''  )
 			$cat_option = '';
 		
 		if ($display_option == 'Popular Posts') : 
 			$display_order = 'comment_count';
 		elseif( $display_option == 'Random Posts') :
 			$display_order = 'rand' ;
 		else :
 			$display_order = 'date';
 		endif;
		
		$queryargs = array(
			'category_name' 		=> $cat_option,
			'posts_per_page' 		=> $number,
			'no_found_rows' 		=> true,
			'post_status' 			=> 'publish',
			'ignore_sticky_posts' 	=> true,
			'order'					=> 'desc',
			'orderby' 				=> $display_order
		 );
		
		$r = new WP_Query($queryargs);
		
		if ($r->have_posts()) :
?>
		<?php echo $before_widget; ?>
		<?php if ( $title ) echo $before_title . $title . $after_title; ?>
		<ul class="td_postWidget_posts">
		<?php  while ($r->have_posts()) : $r->the_post();  ?>
			<li>
				
				<?php if( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>">
				<?php the_post_thumbnail('thumbnail', array('class' => 'thumbs alignleft')); ?>
						</a>
				<?php endif; ?>
				
				<a class="title" href="<?php the_permalink() ?>" title="<?php echo esc_attr(get_the_title() ? get_the_title() : get_the_ID()); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
				<span class="td_postWidget_meta"><span><?php echo get_the_date(); ?></span> by <i><?php echo get_the_author(); ?></i></span>
			</li>
		<?php endwhile; ?>
		</ul>
		<?php echo $after_widget; ?>
<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
		

	}

	/*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['display_option'] = strip_tags($new_instance['display_option']);
		$instance['cat_option'] = strip_tags($new_instance['cat_option']);
		$instance['number'] = (int) $new_instance['number'];

		return $instance;
	}


	/*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$defaults = array( 'title' => __('Latest Posts', 'themedutch'));
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$display_option = isset($instance['display_option']) ? esc_attr($instance['display_option']) : '' ; 
		$cat_option = isset($instance['cat_option']) ? esc_attr($instance['cat_option']) : 'all' ; 
		if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
 			$number = 10;
?>		
		<div style="float:left;width:98%;"></div>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', THEME_SLUG); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'display_option' ); ?>"><?php _e('Display Option:', 'themedutch'); ?></label> 
			<select id="<?php echo $this->get_field_id( 'display_option' ); ?>" name="<?php echo $this->get_field_name( 'display_option' ); ?>" class="widefat" style="width:100%;">
				<option <?php if ( 'Latest Posts' == $instance['display_option'] ) echo 'selected="selected"'; ?>>Latest Posts</option>
				<option <?php if ( 'Popular Posts' == $instance['display_option'] ) echo 'selected="selected"'; ?>>Popular Posts</option>
				<option <?php if ( 'Random Posts' == $instance['display_option'] ) echo 'selected="selected"'; ?>>Random Posts</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cat_option'); ?>"><?php _e('Category: (comma separated)', THEME_SLUG); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('cat_option'); ?>" name="<?php echo $this->get_field_name('cat_option'); ?>" type="text" value="<?php echo $cat_option; ?>" />
			<small>Just leave blank or put 'all' to display all post.</small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:', THEME_SLUG); ?></label>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>		
		<div style="clear:both;">&nbsp;</div>
	<?php
	}

}// end td_postWidget class


?>
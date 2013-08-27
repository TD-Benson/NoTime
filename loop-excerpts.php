<?php

$meta = core_options_get('meta');
$index = 0;


if ( have_posts() ) :

?>
<div id="post-display-option">
	<ul id="types">
    	<li><a id="box" href="javascript:void(0);" title="Grid View" > <img src="<?php echo THEME_URI?>/images/box-type-content.png" /></a></li>
    	<li><a id="list" href="javascript:void(0);" title="List View"  > <img src="<?php echo THEME_URI?>/images/list-type-content.png" /></a></li>
    </ul>
</div>
<div class="theme-excerpts">
<?php

	while (have_posts()) : 
		the_post();
	
		$permalink = get_permalink();
	
		 if ($index == 2) {
		 	$index = 0;
			$lastclass = 'last';
		} else {
			$lastclass = '';
		}
		$index++;
	
		$category = get_the_category();
		$format = get_post_format();
		$post_format = get_post_format() == '' ? 'standard' : get_post_format(); 

		$lwidth = core_options_get('the_width','post');
		switch($lwidth){
			case "column_one_sixth" :
			case "column_two_sixth" :
				$size = "column_s";
				break;
			case "column_three_sixth" :
			case "column_four_sixth" :
				$size = "column_m";
				break;
			case "column_five_sixth" :
			case "column_six_sixth" : 
				$size = "column_l";
				break;
		
		}
		?>
	
		<div class="item <?php echo $lastclass; ?> <?php echo $size; ?> ">

			<div class="item-title <?php echo $format; ?> ">
				<h2><a href="<?php echo $permalink; ?>"><?php the_title(); ?></a><span class="post-format-icon <?php echo $post_format; ?>">&nbsp;</span></h2>
			</div>

			<div class="item-image <?php echo $format; ?>">
					<?php get_template_part( 'format', get_post_format() ); ?>
				<div class="item-date">
					<?php get_option( 'date_format' ); ?>
				</div>
			</div>

	
			<div class="item-content <?php echo $format; ?>">								
	
				<p><?php echo excerpt(60); ?></p>
				<a href="<?php echo $permalink; ?>"><?php _e( 'Read more', THEME_SLUG ); ?> &rsaquo;&rsaquo;</a>				
			</div>
			<?php
				//&& $meta
				if (get_post_type() == 'post' && $meta) {
			?>
			<div class="item-meta <?php echo $format; ?>">
				
					<ul class="meta">
						<li class="post-date updated icon date">
							<?php echo get_the_date(); ?>
						</li>
	
						<li class="icon comments">
							<a href="<?php the_permalink(); ?>#comments"> <?php comments_number(__('no comments', THEME_SLUG), __('one comment', THEME_SLUG), __('% comments', THEME_SLUG)); ?></a>
						</li>
					</ul>
					<div class="clear"></div>
					<ul class="meta">
						<?php if (has_category()) { ?>
							<li class="icon category">
								<?php the_category(', '); ?>
							</li>
						<?php } ?>
	
						<?php the_tags('<li class="icon tags">', '&nbsp;', '</li>'); ?>
						
						<li class="icon <?php echo $post_format; ?>">
							<?php echo ucwords($post_format); ?>
						</li>
					</ul>
					<div class="clear"></div>
			</div>
			<?php } ?>

			<div class="floatclear"></div>
		</div>
	
	
		<?php	endwhile; ?>
	</div>
<?php else : ?>

	<?php get_template_part('404', 'search'); ?>

<?php endif; ?>



<?php core_layout_pagination(); ?>

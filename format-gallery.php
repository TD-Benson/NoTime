
<div class="format-gallery-container">

		<?php
			$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
			if ( $images ) :
				$total_images = count( $images );
				$image = array_shift( $images );
				$image_img_tag = wp_get_attachment_image( $image->ID, 'full' );
		?>
		
			<div class="featured-image">

				<div id="flexslider-<?php echo $post->ID; ?>" class="flexslider">
	  				<ul class="slides">

				<?php 
					$content = '';
					foreach($images as $image) :
						if($img = wp_get_attachment_image_src($image->ID,'full')) {
							$content .= '<li><img src="'.$img[0].'" title="" ></li>';
						}
					endforeach;

					echo $content;

				?>
					</ul>
				</div>

				<script type="text/javascript" charset="utf-8">
				  jQuery(window).load(function($) {
				  	var container = jQuery(".theme-excerpts");

				    jQuery("#flexslider-<?php echo $post->ID; ?>").flexslider({
				    	controlNav: true,       
						directionNav: true,     
						prevText: "",           
						nextText: "",
						start: function(slider){
							container.isotope({
						    // update columnWidth to a percentage of container width
							    masonry: { columnWidth: container.width() / 3}
							  });
							
						},
						after: function(slider){
							container.isotope({
						    // update columnWidth to a percentage of container width
							    masonry: { columnWidth: container.width() / 3}
							  });

						}
				    });
				    
				  });
				</script>

			</div>

	<?php endif; ?>
</div>

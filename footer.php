			</div>
		</div>
	</div>
</div>


<!-- Footer A -->
<?php
	// Fetch tabs ( Widgets)
	$array_tabs = core_layout_footer_tabs_output();
	
	// Mobile Footer Tabs construction
	$html_mobile_menu_ftabs_title = array();
?>
    <div id="theme-footer-tabs" class="container container" >
    	<ul class="row" >
        	<?php
            $titles =  $array_tabs['tabtitles'];
            if (is_array($titles)){
    			foreach($titles as $i => $title):
    			$active = $i == 0 ? "active" : NULL ;
    			$title = str_replace( THEME_NAME .":","", ucwords($title)) ;
    			$html_mobile_menu_ftabs_title[] = $title;
    			?>
            	<li class="<?php echo $active ?>" ><a href="#bottom" id="c<?php echo $i?>"><?php echo $title ?> </a></li>
                <?php
                endforeach;
            }
			?>
        </ul>
        <div class="mobile-menu">
        	<select name="footer-tabs"  class="footer-tabs">
			<?php 
            // Process Footer Tab Menu 
            foreach($html_mobile_menu_ftabs_title as $class_count => $title):
            ?>
            	<option value="c<?php echo $class_count?>"> <?php echo $title?></option>
            <?php
            endforeach;
			?>
            </select>
        </div>
    </div><!-- #theme-footer-tabs -->
    
    <div id="theme-footer" class="container bg-custom-color container" >
    	<!-- <div id="top"></div> -->
        	<?php
            $widgets =  $array_tabs['tabcontents'];
                if (is_array($widgets)){
    			foreach($widgets as $i => $widget):
    				$display = $i == 0 ? "block" : "none";
    			?>
                <div class="c<?php echo $i?> row tabcontent " style="display:<?php echo $display?>;">
                	<ul class="theme-sidebar">
                	<?php if(dynamic_sidebar($widget))?>
                	</ul>
                </div>
                <?php
                endforeach;
            }
			?>
        <!-- <div id="bottom" ></div> -->
    </div><!-- #theme-footer -->
    
<!-- Copyright  AND Footer Menu-->
<div class="container">
    <div class="row">
            <div class="eightcol last">
                <div id="theme-footer-menu">
                    <?php core_layout_menu('footer'); ?>
                </div>
            </div>
            <div class="fourcol last">
                <div id="theme-copyright">
                <?php
                    $copyright_link = core_options_get('copyright_link');
                    $copyright_name = core_options_get('copyright_name');
                    $copyright_html = core_options_get('copyright_html');
                    $copyright_year = date('Y');
                    
                    if (!$copyright_html) :			
                        if (!$copyright_link)
                            $copyright_link = site_url();
            
                        echo '<a href="', $copyright_link, '">';
                        echo '&copy; ', $copyright_year, ' ',$copyright_name;
                        echo '</a>';
                    else :
                        echo $copyright_html;
                    endif; 
                ?> 
                </div>
            </div>
            
    </div>
</div>

</div>
<!-- #boxed .boxed -->

<!-- Footer background -->
<div id="theme-footer-background"></div>

<!-- To top -->
<div id="theme-totop"></div>

<script type="text/javascript">

<?php
	if(is_singular())
		$columns = 6;
	else
		$columns = 3;
?>	


jQuery(function($){
// Masonry
var $container = $('.theme-excerpts');
var $columns = <?php echo $columns; ?>;

// initialize Isotope
check_isotope_height();
$container.isotope({
  // options...
  resizable: false, // disable normal resizing
  // set columnWidth to a percentage of container width
  masonry: { columnWidth: $container.width() / $columns}
});

// update columnWidth on window resize
$(window).smartresize(function(){
  check_isotope_height();
  $container.isotope({
  	resizable: false, // disable normal resizing
    // update columnWidth to a percentage of container width
    masonry: { columnWidth: $container.width() / $columns}
  });
});

// update columnWidth on window resize
$(window).load(function(){
  check_isotope_height();
  $container.isotope({
  resizable: false, // disable normal resizing
    // update columnWidth to a percentage of container width
    masonry: { columnWidth: $container.width() / $columns}
    
  });
});

// Check item height
function check_isotope_height(){

jQuery('.isotope .item').each(function(index, element){
	element = jQuery(element);
	var marginBottom = jQuery('.sc_portfolio').width() * 0.005;
	var container = jQuery('.isotope');
	element.animate({'margin-bottom' : marginBottom }, 
		{
			specialEasing: {
			width: 'linear',
			height: 'easeOutBounce'
		}});
});

jQuery('.isotope .item.column_four_sixth, .isotope .item.column_five_sixth, .isotope .item.column_six_sixth').each( function( index, element ) {
	element = jQuery(element);
	var height = 403;
	var marginBottom = jQuery('.isotope .item.column_one_sixth').css('margin-bottom');
	height = parseFloat(height) + parseFloat(marginBottom);

	element.find('.img').animate({'height' : height }, 
		{
			specialEasing: {
			width: 'linear',
			height: 'easeOutBounce'
		}});
});
}
	
});

</script>

<?php wp_footer(); ?>
</body>
</html>
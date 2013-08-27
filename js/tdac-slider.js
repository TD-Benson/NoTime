(function($) {

	// Thumbnail CA Slider
	$('.shortcode-tdacs').tinycarousel({ interval: true, display: 1, intervaltime: 2000 });			
						
    var maxWidth = 388;
    var minWidth = 105;	 
    var lastBlock = $(".lastblock");
    //lastBlock.animate({width: maxWidth+"px"}, { queue:false, duration:200});
    
    $(".overview li img").each(function(index, element){
        var item = $(element);
        item.hover(
          function(){
            $(lastBlock).animate({width: minWidth+"px"}, { queue:false, duration:200});
            //$(lastBlock).next().animate( { width: minWidth+"px"}, { queue:false, duration:800 });
            item.parent().parent().animate({ width: maxWidth+"px"}, { queue:false, duration:200});
            lastBlock = item.parent().parent();
          },
          function(){
            item.parent().parent().animate({width: minWidth+"px"}, { queue:false, duration:800});
            //$(lastBlock).next().animate( { width: minWidth+"px"}, { queue:false, duration:800 });
            //$(this).parent().parent().animate({ width: maxWidth+"px"}, { queue:false, duration:800});
            //lastBlock = $(this).parent().parent();
          }
        );

    });
    
    
    // jQuery Mobile Menu
	// Put here to be sure not to messep up theme js
	var mainMenu = jQuery('#theme-menu-main');
	if (mainMenu.length) {
		mainMenu.mobileMenu({
		    defaultText: 'Navigate to...',
		    className: 'theme-menu-select',
		    subMenuDash: '&nbsp; &nbsp; &ndash;'
		});
	}
    
})(jQuery);
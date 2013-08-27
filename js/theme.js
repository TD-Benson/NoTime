jQuery(document).ready(function() {
	
	var ANIMATE_SPEED = 350;
	var DELAY_COLLAPSE = 1500;	
	
	// Detect touch support
	var isTouch = 'ontouchstart' in document.documentElement;

	// String trim function	
	String.prototype.trim = function() {
    	return this.replace(/^\s*/, "").replace(/\s*$/, "");
	}

	// Wp Menu Modifier (Custom layout menu with description <span>)
	jQuery('#theme-menu-main > li').each(function(){
		title = jQuery(this).find('a').attr('title')
		if(title  != null) {
			jQuery(this).append('<div class="desc">'+title+'</div>');
		}
	});

	// Append arrows to some elements
	var rarr = jQuery('<span>&rsaquo;&rsaquo; </span>');
	jQuery('ul#recentcomments > li,	li.cat-item').each(function(index, element) {
			element = jQuery(element);
			element.prepend(rarr.clone());
	});

	// Input field placeholder text
	//
	jQuery('input[placeholder]').each(function(index, element) {
		var element = jQuery(element);

		var placeholderText = element.attr('placeholder');
		if (!placeholderText === '')
			return;
		element.removeAttr('placeholder');

		// Place first placeholder
		if (element.val() === '') {
			element.val(placeholderText);
			element.addClass('placeholderActive');
		}

		element.bind('focus', function() {
			if (element.val() === placeholderText) {
				element.val('');
				element.removeClass('placeholderActive');
			}
		});
		element.bind('blur', function() {
			if (element.val() === '') {
				element.val(placeholderText);
				element.addClass('placeholderActive');
			}
		});
	});

	// Setup PrettyPhoto links
	//
	var lightboxAnchors = jQuery('a[data-rel^="prettyPhoto"]');
	if (lightboxAnchors.length) {
		lightboxAnchors.prettyPhoto();
	}
	
	// Search box animation
	//
	jQuery('.theme-search-box').each(function(index, element) {
		var ANIMATE_SPEED = 350;
		var DELAY_COLLAPSE = 1500;	
	
		var searchBox = jQuery(element);
		var searchIcon = searchBox.find('.theme-search-icon');
		var inputBox = searchBox.find('input[type="text"]');
		var submitButton = searchBox.find('input[type="submit"]');
		var originalColor = '#' + theme_colors.color_search_field;

		function collapse() {
			if (inputBox.val() !== '') {
				setTimeout(collapse, DELAY_COLLAPSE);
				return;
			}

			inputBox.stop(true, true).fadeOut().animate({width: '0' }, ANIMATE_SPEED);
			searchBox.stop(true, true).animate({width: '62'}, ANIMATE_SPEED);
		}

		searchBox.hover(function() {
			inputBox.stop(true, true).fadeIn().animate({width: '190px' }, ANIMATE_SPEED);
			searchBox.find('input[type="text"]').focus();
			searchBox.stop(true, true).animate({width: 265 }, ANIMATE_SPEED);
			jQuery('#theme-menu-main').animate({opacity: 0.35 }, ANIMATE_SPEED);

		}, function() {
			setTimeout(collapse, DELAY_COLLAPSE);
			jQuery('#theme-menu-main').animate({opacity: 1 }, ANIMATE_SPEED);
		});
		
		searchIcon.hover(function() {
			inputBox.stop(true, true).fadeIn().animate({width: '190px' }, ANIMATE_SPEED);
			searchBox.find('input[type="text"]').focus();
			searchBox.stop(true, true).animate({width: 265 }, ANIMATE_SPEED);

		}, function() {
			//setTimeout(collapse, DELAY_COLLAPSE);
		});
		
		searchIcon.click(function(){
			searchIcon.next().submit();
		});

	});
	
	// To top
	//
	function toTop() {
		var TOP_MINIMUM = 100;
		var ANIMATE_SPEED = 200;

		var toTop = jQuery('#theme-totop');

		function updateToTop() {
			var scrollTop = jQuery(window).scrollTop();

			if (scrollTop > TOP_MINIMUM)
				toTop.stop(true, true).slideDown(ANIMATE_SPEED);
			else if (scrollTop <= TOP_MINIMUM)
				toTop.stop(true, true).slideUp(ANIMATE_SPEED);
		}

		jQuery(window).scroll(updateToTop);
		updateToTop();

		// To top button
		toTop.bind('click', function() {
			jQuery('html, body').stop(true, true).animate({scrollTop: 0}, ANIMATE_SPEED);
			return false;
		});
	}
	toTop();

	// Sociables hover
	//
	jQuery('#theme-sociables a').each(function(index, element) {
		var element = jQuery(element);
		var iconHover = element.find('.icon-hover');

		var ANIMATE_SPEED = 1000;

		iconHover.hide();
		element.hover(function() {
			iconHover.stop(true, true).fadeIn(ANIMATE_SPEED);
		}, function() {
			iconHover.stop(true, true).fadeOut(ANIMATE_SPEED);
		});
	});


	// align the footer tabs and it's background
	var ftHeight = jQuery('#theme-footer-tabs').height();
	jQuery('#theme-footer-tabs').css({'margin-top': ftHeight * -1});
	jQuery('.theme-content-container').css({'padding-bottom': ftHeight + 15});
	
	// Footer Tab Animation
	jQuery('#theme-footer-tabs ul li a').click(function(){
			if(jQuery(this).parent('li').hasClass('active')) return false;
			jQuery('#theme-footer-tabs ul li').removeClass('active');
			jQuery(this).parent('li').addClass('active');
			jQuery(".tabcontent ").slideUp("slow");
			jQuery("."+jQuery(this).attr('id') ).slideDown("slow");
	
	});
	

	// Footer Tab Sociables
	jQuery('.theme-sociables li a').hover(
		function(){
			jQuery(this).find('.icon').hide();
			jQuery(this).find('.icon-hover').stop(true, true).fadeIn(ANIMATE_SPEED);
		},
		function(){
			jQuery(this).find('.icon-hover').hide();
			jQuery(this).find('.icon').stop(true, true).fadeIn(ANIMATE_SPEED);
		}
	);
	
	// Scroll To Elements
	jQuery("#theme-footer-tabs ul li a").on('click',function($){
		var container = jQuery('#theme-footer-tabs'),
			scrollTo = jQuery('#bottom');
		
	
		// Or you can animate the scrolling:
		//container.animate({
		//	scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
		//});
	});
	
	//alert('the item ID is ' + jQuery('.portfolio-container li a').data('post-id'));
	
	//Portfolio
	jQuery('.portfolio-container .item a').each(function(index, element) {
		element = jQuery(element);
		var elementData = element.data();		
		
		element.click(function(e){
			
			e.preventDefault();
			
			var url = element.attr("href");
			var _target = '.sc_portfolio-ajaxified';
			
			element.find('.item-title').append('<div class="loading"></div>');
			jQuery('.portfolio_block ' + _target ).load( url + " .theme-article-content", function(response, status, xhr) {
				
				jQuery('.portfolio-container').find('.item.current-item').removeClass('current-item');
				jQuery('.navi').slideDown(ANIMATE_SPEED);				
				jQuery('.sc_portfolio-ajaxified').slideDown(ANIMATE_SPEED);
				
				var lightboxAnchors = jQuery('.sc_portfolio-ajaxified').find('a[data-rel^="prettyPhoto"]');
				if (lightboxAnchors.length) {
					lightboxAnchors.prettyPhoto();
				}
				
				if( element.parent('.portfolio-container .item:not(.isotope-hidden)').is(':first-child') ){
					jQuery('.navi .previous').hide();
				} else {
					jQuery('.navi .previous').show();
				}
				if( element.parent('.portfolio-container .item:not(.isotope-hidden)').is(':last-child') ){
					jQuery('.navi .next').hide();
				} else {
					jQuery('.navi .next').show();
				}

				jQuery.scrollTo('#categories', 1000, { over:{ top: -5 } });
				element.find('.loading').remove();
				element.parent('.portfolio-container .item').addClass('current-item');
				if (status == "error") {
				    var msg = "Sorry but there was an error loading the URL!";
				    jQuery('.portfolio_block ' + _target ).html(msg + xhr.status + " " + xhr.statusText);
				}
				
			});
			
		});
	});
	
	//Portfolio Navi Close
	jQuery('.navi .close').click(function () {
		jQuery('.sc_portfolio-ajaxified').slideUp(ANIMATE_SPEED);
		jQuery(this).parent('.navi').slideUp(ANIMATE_SPEED);
	});
	
	//Portfolio Navi Prev
	jQuery('.navi .previous').click(function () {		
		var currentItem = jQuery('.portfolio-container .item.current-item');
		var prevItem = currentItem.prevAll('.portfolio-container .item:not(.isotope-hidden)').first();
		
		var url = prevItem.find('a').attr("href");
		var _target = '.sc_portfolio-ajaxified';
		
		jQuery('.sc_portfolio-ajaxified').slideUp(ANIMATE_SPEED);
		jQuery('.portfolio_block ' + _target ).load( url + " .theme-article-content", function(response, status, xhr) {
			
			currentItem.removeClass('current-item');
			jQuery('.navi').slideDown(ANIMATE_SPEED);				
			jQuery('.sc_portfolio-ajaxified').slideDown(ANIMATE_SPEED);
			prevItem.addClass('current-item');
			
			if( !prevItem.prevAll('.portfolio-container .item:not(.isotope-hidden)').first().find('a').length ){
				jQuery('.navi .previous').hide();
			} else {
				jQuery('.navi .previous').show();
			}
			if( !prevItem.nextAll('.portfolio-container .item:not(.isotope-hidden)').first().find('a').length ){
				jQuery('.navi .next').hide();
			} else {
				jQuery('.navi .next').show();
			}

			jQuery.scrollTo('#categories', 1000, { over:{ top: -5 } });
			
			if (status == "error") {
			    var msg = "Sorry but there was an error loading the URL!";
			    jQuery('.portfolio_block ' + _target ).html(msg + xhr.status + " " + xhr.statusText);
			}
			
		});
	});
	
	//Portfolio Navi Next
	jQuery('.navi .next').click(function () {
		var currentItem = jQuery('.portfolio-container .item.current-item');
		var nextItem = currentItem.nextAll('.portfolio-container .item:not(.isotope-hidden)').first();
		
		var url = nextItem.find('a').attr("href");
		var _target = '.sc_portfolio-ajaxified';
		
		jQuery('.sc_portfolio-ajaxified').slideUp(ANIMATE_SPEED);
		jQuery('.portfolio_block ' + _target ).load( url + " .theme-article-content", function(response, status, xhr) {
			
			currentItem.removeClass('current-item');
			jQuery('.navi').slideDown(ANIMATE_SPEED);				
			jQuery('.sc_portfolio-ajaxified').slideDown(ANIMATE_SPEED);
			nextItem.addClass('current-item');
			
			if( !nextItem.prevAll('.portfolio-container .item:not(.isotope-hidden)').first().find('a').length ){
				jQuery('.navi .previous').hide();
			} else {
				jQuery('.navi .previous').show();
			}
			if( !nextItem.nextAll('.portfolio-container .item:not(.isotope-hidden)').first().find('a').length ){
				jQuery('.navi .next').hide();
			} else {
				jQuery('.navi .next').show();
			}

			jQuery.scrollTo('#categories', 1000, { over:{ top: -5 } });
			
			if (status == "error") {
			    var msg = "Sorry but there was an error loading the URL!";
			    jQuery('.portfolio_block ' + _target ).html(msg + xhr.status + " " + xhr.statusText);
			}
			
		});
	});
	  
	// Blog post display Type (List or Boxed )	
	var $container = jQuery('.theme-excerpts');

	jQuery('a#list').click(function(){
		
		//$container.isotope('destroy').delay(DELAY_COLLAPSE);
		jQuery('.theme-excerpts .item').addClass('list-type');
		jQuery('.theme-excerpts .item').removeClass('last');
		$container.isotope({
			itemSelector: '.item',
			 masonry: { columnWidth: $container.width() / 2}

		});
	});

	  
	jQuery('a#box').click(function($){
		jQuery('.theme-excerpts .item ').removeClass('list-type');
		  $container.isotope({
			itemSelector: '.item',
			 masonry: { columnWidth: $container.width() / 3}

		});
	});

	
	jQuery('select.theme-menu-select').wrap('<div class="mobile-menu"></div>');
	
	jQuery(function($) {			
		$(' .da-thumbs > li ').each( function() { $(this).hoverdir({
			hoverDelay : 50,
		}); } );
	});
	
	//Slide Panel
	var slidepanel = jQuery("#top-slidepanel #panel");
	
	// Expand Panel
	jQuery(".slidepanel-arrow").click(function(){
		if(jQuery(slidepanel).css('display') == 'none'){
			jQuery(slidepanel).slideDown("slow");
			jQuery(this).addClass('collapse');
		}else{
			jQuery(this).removeClass('collapse');
			jQuery(slidepanel).slideUp("slow");	
		}
	});	
	
	jQuery('#theme-menu-main').each(function(index, element) {
		var item = jQuery(element);		
		
		// Hover functions
		item.hover(function() {
			var opacity = item.css('opacity');
			if(opacity < 1){
				jQuery('#theme-menu-main').animate({opacity: 1 }, 350);	
			}				
		}, function() {		
			var opacity = item.css('opacity');	
			if(opacity == 1){
				jQuery('.f-nav #theme-menu-main').animate({opacity: 0.35 }, 350);	
			}		
		});
	});
	
	//Mobile Menu
	//jQuery("#theme-menu-main").mobileMenu();
		
});

jQuery(window).load(function() {

	// Remove loader when ready
	//jQuery('.core-loader').delay(50).fadeOut(150);
	
	// Buttons animation
	//
	jQuery('.theme-button, .cart button, .button').each(function(index, element) {
		element = jQuery(element);

		// Button hacks to force WooCommerce\BuddyPress buttons to work
		element.removeClass('button');
		element.removeClass('alt');

		if (!element.hasClass('small') && !element.hasClass('medium') && !element.hasClass('large'))
			element.addClass('small');

		if (!element.hasClass('theme-button'))
			element.addClass('theme-button');

		// Remove &rarr; from elements and replace it with a span that can be animated
		if (!element.is('input')) {
			var contents = element.text();
			
			if (contents.indexOf('→') !== -1)
				element.text(contents.replace('→', '').trim());

			var arrow = jQuery('<span class="arrow">&rarr;</span>');
			arrow.appendTo(element);

		// Input elements cannot have an animated arrow, so only add a text arrow if it does not already exist
		} else if (element.attr('value')) {
			var value = element.val();
			if (value.indexOf('→') === -1) {
				element.val(value + ' →');
				element.css('padding-right', element.css('padding-left'));
			}
		}

		var color = theme_colors['color_button'];
		var colorHover = theme_colors['color_button_hover'];
		var colorText = theme_colors['color_button_text'];
		var colorTextHover = theme_colors['color_button_text_hover'];

		//element.css({backgroundColor: color, color: colorText});

		element.hover(function() {
			var el = jQuery(this);
			var elArrow = el.find('.arrow');

			//el.stop(true, true).animate({backgroundColor: colorHover, color: colorTextHover}, 250);
			if (elArrow)
				elArrow.stop(true, true).animate({right: '2px'}, ANIMATE_SPEED);
		}, function() {
			var el = jQuery(this);
			var elArrow = el.find('.arrow');

			//el.stop(true, true).animate({backgroundColor: color, color: colorText}, 250);
			if (elArrow)
				elArrow.stop(true, true).animate({right: '10px'}, ANIMATE_SPEED);
		});
	});

	// Menu
	//
	var liHeight = jQuery('#theme-navigation').height();

	jQuery('#theme-menu-main li').each(function(index, element) {
		var item = jQuery(element);
		var itemPadding = parseFloat(item.css('padding-left'));
		var itemMargin =  parseFloat(item.css('margin-left'));
		var itemHeight = item.height();

		var subMenu = item.children('ul');
		var isSubmenu = item.parent().hasClass('sub-menu');

		var ANIMATE_SPEED = 100;

		jQuery('#theme-menu-main > li, #top-widget li').css({'height' : liHeight });
	
		subMenu.hide();
		
		// Add dropdown indicators
		// Menu root
		var imageWidth = 0;
		if (!isSubmenu && subMenu.length) {
			var image = jQuery('<img src="' + window.templateDir + '/images/icon-menu-sub.png">');
			image.appendTo(item);
			imageWidth = 16;

		// Submenus in submenus 
		} else if (isSubmenu && subMenu.length) {
			var raquo = jQuery('<span> &raquo;</span>');
			raquo.appendTo(item.children('a'));
		}

		// Hover functions
		item.hover(function() {
			var top = item.position().top;
			var left = item.position().left;
			if (isSubmenu) {
				top = top - 16;
				left = item.outerWidth(true);
			} else {
				top = item.height() - 10;
				left = itemMargin + 1 ;
			}

			subMenu.css('top', top);
			subMenu.css('left', left);
			subMenu.css('z-index', 9999);

			subMenu.stop(true, true).fadeIn(ANIMATE_SPEED * 3);
		}, function() {
			subMenu.stop(true, true).fadeOut(ANIMATE_SPEED * 3);
		});
	});

	// Searchbox Init
	var ANIMATE_SPEED = 350;
	var DELAY_COLLAPSE = 1500;
	var searchboxHeight = jQuery('#theme-menu-main li').height();	
	if(!searchboxHeight){
		searchboxHeight = 55;
	}
	jQuery('.theme-search-box').animate({height: searchboxHeight + 5 }, ANIMATE_SPEED);
	jQuery('.theme-search-box input[type="text"]').animate({height: searchboxHeight + 5 }, ANIMATE_SPEED);
	jQuery('.theme-search-icon').animate({height: searchboxHeight + 2 }, ANIMATE_SPEED);
	

	// check sidebar heights
	//check_sidebar_height();
	
});

// check sidebar height and adjust it to 100% relative to the content area
function check_sidebar_height(){
	var ua = navigator.userAgent;
    var checker = {
      iphone: ua.match(/(iPhone|iPod)/),
      blackberry: ua.match(/BlackBerry/),
      android: ua.match(/Android/)
    };
    if (checker.android){
        //empty
    }
    else if (checker.iphone){
        //empty
    }
    else if (checker.blackberry){
        //empty
    }
    else {
       
       // Append arrows to some elements
		var containerHeight = jQuery('.theme-content-container').height();
		var sidebarHeight = containerHeight;
		
		if(jQuery('.theme-sidebar').length > 0 ) {
			jQuery('.theme-sidebar').each(function(i){
				var elementHeight = jQuery(this).height();
				if ( elementHeight >= containerHeight ){
					sidebarHeight = elementHeight;
				}
			});	
		}
		
		if(jQuery('.tsidebarnarrow').length > 0 ){
			jQuery('.tsidebarnarrow').delay(1500).css('height', function(index) {
					return sidebarHeight + 73;
			});
		}
		
		if(jQuery('.tsidebarwide').length > 0 ){
			jQuery('.tsidebarwide').delay(1500).css('height', function(index) {
					return sidebarHeight + 73;
			});
		}
       
    }
}


//Menu Scroller
var _rys = jQuery.noConflict();
_rys("document").ready(function(){
    _rys(window).scroll(function () {
    	
    	var ua = navigator.userAgent;
	    var checker = {
	      iphone: ua.match(/(iphone|ipod|ipad)/),
	      blackberry: ua.match(/BlackBerry/),
	      android: ua.match(/Android/)
	    };
	    if (checker.android){
	        //empty
	    }
	    else if (checker.iphone){
	        //empty
	    }
	    else if (checker.blackberry){
	        //empty
	    }
	    else {
	    	if (_rys(this).scrollTop() > jQuery('#theme-header').height()) {
	            _rys('#theme-navigation-row').addClass("f-nav");
	            _rys('#theme-navigation-row').css('margin-top', _rys('#wpadminbar').height() );
	            //_rys('#theme-menu-main').animate({opacity: 0.35 }, 0);
	        } else {
	            _rys('#theme-navigation-row').removeClass("f-nav");
	            _rys('#theme-navigation-row').css('margin-top', 0 );
	           // _rys('#theme-menu-main').animate({opacity: 1 }, 0);
	        }	
	    }
    });
});

/**
 * Copyright (c) 2007-2012 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * @author Ariel Flesler
 * @version 1.4.3.1
 */
;(function($){var h=$.scrollTo=function(a,b,c){$(window).scrollTo(a,b,c)};h.defaults={axis:'xy',duration:parseFloat($.fn.jquery)>=1.3?0:1,limit:true};h.window=function(a){return $(window)._scrollable()};$.fn._scrollable=function(){return this.map(function(){var a=this,isWin=!a.nodeName||$.inArray(a.nodeName.toLowerCase(),['iframe','#document','html','body'])!=-1;if(!isWin)return a;var b=(a.contentWindow||a).document||a.ownerDocument||a;return/webkit/i.test(navigator.userAgent)||b.compatMode=='BackCompat'?b.body:b.documentElement})};$.fn.scrollTo=function(e,f,g){if(typeof f=='object'){g=f;f=0}if(typeof g=='function')g={onAfter:g};if(e=='max')e=9e9;g=$.extend({},h.defaults,g);f=f||g.duration;g.queue=g.queue&&g.axis.length>1;if(g.queue)f/=2;g.offset=both(g.offset);g.over=both(g.over);return this._scrollable().each(function(){if(e==null)return;var d=this,$elem=$(d),targ=e,toff,attr={},win=$elem.is('html,body');switch(typeof targ){case'number':case'string':if(/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(targ)){targ=both(targ);break}targ=$(targ,this);if(!targ.length)return;case'object':if(targ.is||targ.style)toff=(targ=$(targ)).offset()}$.each(g.axis.split(''),function(i,a){var b=a=='x'?'Left':'Top',pos=b.toLowerCase(),key='scroll'+b,old=d[key],max=h.max(d,a);if(toff){attr[key]=toff[pos]+(win?0:old-$elem.offset()[pos]);if(g.margin){attr[key]-=parseInt(targ.css('margin'+b))||0;attr[key]-=parseInt(targ.css('border'+b+'Width'))||0}attr[key]+=g.offset[pos]||0;if(g.over[pos])attr[key]+=targ[a=='x'?'width':'height']()*g.over[pos]}else{var c=targ[pos];attr[key]=c.slice&&c.slice(-1)=='%'?parseFloat(c)/100*max:c}if(g.limit&&/^\d+$/.test(attr[key]))attr[key]=attr[key]<=0?0:Math.min(attr[key],max);if(!i&&g.queue){if(old!=attr[key])animate(g.onAfterFirst);delete attr[key]}});animate(g.onAfter);function animate(a){$elem.animate(attr,f,g.easing,a&&function(){a.call(this,e,g)})}}).end()};h.max=function(a,b){var c=b=='x'?'Width':'Height',scroll='scroll'+c;if(!$(a).is('html,body'))return a[scroll]-$(a)[c.toLowerCase()]();var d='client'+c,html=a.ownerDocument.documentElement,body=a.ownerDocument.body;return Math.max(html[scroll],body[scroll])-Math.min(html[d],body[d])};function both(a){return typeof a=='object'?a:{top:a,left:a}}})(jQuery);
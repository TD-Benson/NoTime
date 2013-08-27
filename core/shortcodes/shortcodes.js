jQuery(document).ready(function() {
	
	// Tabs shortcode
	//
	jQuery('.shortcode-tabs').each(function() {
		var tabContainer = jQuery(this);
		var tabTitleList = jQuery('.titles', tabContainer);
		var tabContentList = jQuery('.content', tabContainer);
		var contentWidth = tabContainer.width();

		// Tab buttons
		jQuery('.shortcode-tab-title', this).each(function(index, element) {
			var tabTitle = jQuery(this);
			var tabContent = tabTitle.next();
			
			// Move title into title container
			tabTitle.detach();
			tabTitleList.append(tabTitle);

			// Move content into content container
			tabContent.detach();
			tabContentList.append(tabContent);
			
			// Hide all but the first tab
			if (index > 0)
				tabContent.hide();
			else
				tabTitle.addClass('active');

			// Tab title click
			tabTitle.click(function() {
				if (tabContent.css('display') !== 'none')
					return;

				// Toggle tab style and content visibility
				tabContainer.find('.shortcode-tab:visible').slideUp(200);
				tabTitleList.find('.active').removeClass('active');
				tabContent.slideDown(200);

				tabTitle.addClass('active');
			});
		});
	});

	// Toggle shortcode
	//
	jQuery('.shortcode-toggle > li > div.header').each(function(index, element) {
		element = jQuery(element);
		var content = element.siblings('div.content');
		var arrow = element.find('span.arrow');

		arrow.css('top', ((element.outerHeight(true) / 2) - (arrow.outerHeight(true) / 2)) + 'px');

		element.bind('mouseenter', function() {
			arrow.stop(true, true).animate({right: '-5px'}, 200);
		});

		element.bind('mouseleave', function() {
			arrow.stop(true, true).animate({right: '5px'}, 200);
		});

		element.bind('click', function() {
			if (content.hasClass('visible')) {
				content.stop(true, true).slideUp(300);
				content.removeClass('visible');
			} else {
				content.stop(true, true).slideDown(300);
				content.addClass('visible');
			}
		});
	});

	// To top divider
	jQuery('.shortcode-divider.totop > a.totop').bind('click', function() {
		jQuery('html, body').animate({scrollTop: 0}, 500);
		return false;
	});

});
jQuery(document).ready(function() {

	// Create a non-whitespace sanitized version of a string
	function slugify(text) {
		text = text.toLowerCase();
		text = text.replace(/[^-a-zA-Z0-9,&\s]+/ig, '');
		text = text.replace(/\s/gi, "-");
		return text;
	}


	// Layout picker option type
	//

	// Returns an object containing the layout description of an option field
	//
	function coreLayoutGet(option) {
		var element = option.find('input[type=hidden]');
		return JSON.parse(element.val());
	}

	// Stores a layout object into the corresponding option field
	function coreLayoutPut(option, layout) {
		var element = option.find('input[type=hidden]');
		element.val(JSON.stringify(layout));
	}

	// Layout chooser option type
	// Stores layout name and hides\shows relevant sidebar elements
	//
	jQuery('.core-layout-choice > li').bind('click', function() {
		var ul = jQuery(this).parent();
		var option = jQuery(this).parent().parent();
		var dataType = ul.attr('data-type');
		var sidebars = option.find('.core-layout-sidebar[data-type=' + dataType + ']');
		var sidebarCount = parseFloat(jQuery(this).attr('data-sidebar-count'));
		var layoutName = jQuery(this).attr('data-layout-name');

		var layout = coreLayoutGet(option);
		layout[dataType] = layoutName;
		coreLayoutPut(option, layout);

		// Set display classes
		ul.find('li').each(function() {
			jQuery(this).removeClass('selected');
		});
		jQuery(this).addClass('selected');

		// Hide unused sidebar inputs
		// Iterate through all sidebar divs and hide ones that are indexed too high
		var index = 0;
		jQuery.each(sidebars, function(index, element) {
			element = jQuery(element);
			if (index >= sidebarCount)
				element.slideUp(150);
			else
				element.slideDown(150);
			index++;
		});
	});

	// Sidebar selection
	jQuery('.core-layout-sidebar > select').bind('change', function() {
		var selected = jQuery(':selected', this).attr('data-name');
		var dataType = jQuery(this).attr('data-type');
		var index = parseFloat(jQuery(this).attr('data-index'));
		var option = jQuery(this).parent().parent().parent();
		
		// Store into layout element
		var layout = coreLayoutGet(option);
		layout[dataType + '-sidebars'][index] = selected;
		coreLayoutPut(option, layout);
	});


	// Sidebars option type
	//

	// Returns an object of sidebars as stored in the option's hidden input field
	//
	function coreSidebarsGet(option) {
		var element = option.find('input[type=hidden]');
		return JSON.parse(element.val());
	}

	// Stores a sidebars array back into the corresponding input element
	//
	function coreSidebarsPut(option, sidebars) {
		var element = option.find('input[type=hidden]');
		element.val(JSON.stringify(sidebars));
	}

	// Adds a new sidebar
	//
	jQuery('.core-option-sidebars-add').bind('click', function() {
		var option = jQuery(this).parent();
		var nameElement = option.find('.core-option-sidebars-name');

		// Validate name
		var name = nameElement.val();
		if (name == '') {
			alert('Please enter a name for the sidebar.');
			return false;
		}

		// Create slug and check if it exists
		var name_slug = slugify(name);
		var sidebars = coreSidebarsGet(option);
		if (name_slug in sidebars) {
			alert('A sidebar with a name similar to "' + name + '" already exists.');
			return false;
		}
		
		// Clone sidebar template element
		nameElement.val('');
		nameElement.focus();
		var cloneable = option.find('.core-option-sidebar-cloneable');
		var clone = cloneable.clone(true);

		// Set clone element settings
		clone.removeClass('core-option-sidebar-cloneable');
		clone.addClass('core-option-sidebar');
		clone.attr('data-sidebar-slug', name_slug);
		clone.find('p').html(name);
		clone.hide();

		// Append clone to list
		option.find('.core-option-sidebar-list').append(clone);
		clone.slideDown(150);

		// Add to input element
		sidebars[name_slug] = name;
		coreSidebarsPut(option, sidebars);
	});

	// Removes a sidebar element
	//
	jQuery('body').on('click', '.core-option-sidebar > a', function() {
		var element = jQuery(this).parent();
		var option = element.parent().parent();

		element.slideUp(150, function() {
			var slug = element.attr('data-sidebar-slug');

			// Remove from input element
			var sidebars = coreSidebarsGet(option);
			delete sidebars[slug];
			coreSidebarsPut(option, sidebars);

			// Remove element itself
			element.remove()
		});

		return false;
	});
});
jQuery(document).ready(function() {
	
	// Create a non-whitespace sanitized version of a string
	function slugify(text) {
		text = text.toLowerCase();
		text = text.replace(/[^-a-zA-Z0-9,&\s]+/ig, '');
		text = text.replace(/\s/gi, "-");
		return text;
	}

	function getSliders(container) {
		var element = container.find('input[type="hidden"]');
		return JSON.parse(element.val());
	}

	function putSliders(container, sliders) {
		var element = container.find('input[type="hidden"]');
		element.val(JSON.stringify(sliders));
	}

	jQuery('.core-option-sliderlist').each(function(index, container) {
		container = jQuery(container);
		var nameElement = container.find('.slider-name');
		var typeElement = container.find('.slider-type');
		var builderElement = container.find('.builder');

		// Save changes when theme options are saved
		jQuery('#core-options-submit').bind('click', function() {
			if (typeof sliderSaveFunction !== 'undefined')
				sliderSaveFunction();
		});

		// Add slider button
		container.find('input[type="button"]').bind('click', function() {
			var template = container.find('div.list-template');
			var name = nameElement.val();
			var type = typeElement.val();
			var list = container.children('div.list-items');
			
			// Validate name
			var slug = slugify(name);
			if (slug === '')
				return;

			var sliders = getSliders(container);
			if (slug in sliders) {
				alert('A slider with the name "' + name + '" or a similar name already exists.');
				return;
			}

			if (sliders.length === 0 )
				sliders = new Object();
			
			// Add to slider array
			sliders[slug] = {
				'name': name,
				'type': type
			};
			putSliders(container, sliders);

			// Clone template item
			var clone = template.clone(true);
			clone.appendTo(list);
			clone.slideDown(150, function() {
				clone.removeClass('list-template');
			});

			// Set clone text
			clone.attr('data-slug', slug);
			clone.attr('data-slider', type);
			clone.find('p.name').text(name);
			clone.find('p.type').text(type);

			return false;
		});

		// Remove slider button
		container.on('click', '.list-items .remove', function() {
			var slug = jQuery(this).parent().attr('data-slug');

			var sliders = getSliders(container);
			if (!confirm('Are you sure you want to remove the slider "' + sliders[slug].name + '"?'))
				return;

			// Remove
			delete sliders[slug];
			nameElement.val('');
			jQuery(this).parent().slideUp(150, function() {
				jQuery(this).remove();
			});

			// Empty iframe if this was the active slider
			if (jQuery(this).parent().hasClass('active')) {
				builderElement.empty();
				builderElement.fadeOut(200);
			}

			putSliders(container, sliders);

			return false;
		});

		// Edit slider button
		container.on('click', '.list-items .edit', function() {
			// Ignore if still saving changes
			if (saving)
				return;

			var slug = jQuery(this).parent().attr('data-slug');
			var slider = jQuery(this).parent().attr('data-slider');
			var sliderName = jQuery(this).siblings('.name').html();

			builderElement.removeAttr('src');
			builderElement.empty();
			builderElement.attr('src', window.coreDir + '/slider/slider-builder.php?slug=' + slug + '&slider=' + slider + '&name=' + sliderName);

			// Highlight active slider
			jQuery(this).parent().parent().find('.list').each(function() {
				jQuery(this).removeClass('active');
			});
			jQuery(this).parent().addClass('active');

			return false;
		});

		// Fade in the builder iframe when loaded
		builderElement.load(function() {
			builderElement.fadeIn(200);
		});

		// Hack to update the height of the slider builder iframe
		setInterval(function() {
			var body = builderElement.contents().find('body');
			if (body.length)
				builderElement.height(body.outerHeight(true));
		}, 150);
	});

});
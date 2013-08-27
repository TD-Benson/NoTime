jQuery(document).ready(function() {
	
	// Animation speed for all elements
	var ANIMATE_SPEED = 200;

	// Add slide
	jQuery('.core-slide-add').bind('click', function() {
		var slideElement = slide_add();

		return false;
	});

	// Remove slide
	jQuery(document).on('click', '.core-slide-remove', function() {
		var slideElement = jQuery(this).parent().parent();
		slide_remove(slideElement);

		return false;
	});

	// Add layer
	jQuery(document).on('click', '.core-slider-slide > .core-layer-add', function() {
		var slideElement = jQuery(this).parent();
		layer_add(slideElement);

		return false;
	});

	// Remove layer
	jQuery(document).on('click', '.core-slider-slide .core-layer-remove', function() {
		var layerElement = jQuery(this).parent().parent();
		layer_remove(layerElement);

		return false;
	});

	function saveSlider() {
		var ANIMATE_SPEED = 150;
		var DELAY = 2000;

		var resultElement = jQuery('#save-result');
        var data = {
        	'slug': window.sliderSlug,
        	'settings': JSON.stringify(serialize()),
        	'nonce': window.nonce,
        	'action': 'core_slider_save'
        };

        // Send ajax request with the slider's settings
        resultElement.html('&nbsp;').animate({opacity: 0}, ANIMATE_SPEED);
        jQuery.post(ajaxurl, data, function(result) {
        	resultElement.html(result);
        	resultElement.stop(true, true).animate({opacity: 1}, ANIMATE_SPEED);
        	resultElement.delay(DELAY).animate({opacity: 0}, ANIMATE_SPEED);
        });
	}
	parent.sliderSaveFunction = saveSlider;

	// Delete an image
	jQuery('body').on('click', 'a.image-option-delete', function() {
		var anchor = jQuery(this).siblings('a.image-option');
		var img = anchor.find('img')
		var input = jQuery(this).siblings('input');

		anchor.addClass('empty');
		img.remove();
		jQuery('<img>').appendTo(anchor);
		input.val('');

		return false;
	});

	// Select an image
	jQuery('body').on('click', 'a.image-option', function() {
		window.destinationElement = jQuery(this);

		tb_show('Select image', blogurl + '/wp-admin/media-upload.php?type=image&tab=library&post_id=0TB_iframe=true&width=635&height=600');

		return false;
	});

	// Recieves the image from the media uploader thickbox
	window.send_to_editor = function(html) {
		var destination = window.destinationElement;
		var inputElement = destination.siblings('input[type="hidden"]');
		var previewElement = destination.find('img');
		var imgURL = jQuery('img', html).attr('src');

		inputElement.val(imgURL);
		if (inputElement.attr('value')) {
			previewElement.attr('src', imgURL);
			destination.removeClass('empty');
		}

		tb_remove();
	};


	// Adds a new slide element
	//
	function slide_add() {
		// Clone template
		var clone = templateSlide.clone();
		clone.appendTo('#core-slider-slides');

		// Reveal
		clone.slideDown(ANIMATE_SPEED, function() {
			clone.removeClass('core-slide-template');
			scrollParent(templateSlide.height());
		});

		// Update sortable list
		jQuery('#core-slider-slides').sortable('refresh');

		return clone;
	}

	// Removes a slide element
	//
	function slide_remove(slideElement) {
		slideElement.slideUp(ANIMATE_SPEED, function() {
			slideElement.remove();
		});
	}

	// Adds a new layer element
	//
	function layer_add(slideElement) {
		var layersElement = slideElement.find('.core-slide-layers');

		// Clone template
		var clone = templateLayer.clone();
		clone.removeClass('core-layer-template');
		clone.appendTo(layersElement);
		clone.show();

		scrollParent(templateLayer.height());

		return clone;
	}

	// Removes a layer element
	//
	function layer_remove(layerElement) {
		layerElement.remove();
	}

	// Scroll the parent window down
	//
	function scrollParent(height) {
		if (!scrollingActive)
			return;

		var slideHeight = templateSlide.height();
		jQuery('body', parent.document).animate({scrollTop: (jQuery(parent.document).height() + height) + 'px'}, ANIMATE_SPEED);
	}

	// Unserializes slider data from a JSON string
	//
	function unserialize(data) {
		var container = null;
		
		var slideContainer = null;
		var slideKey = null;
		var slide = null;
		
		var layerContainer = null;
		var layerKey = null;
		var layer = null;

		data = JSON.parse(data);

		// Slider settings
		container = jQuery('#core-slider-settings');
		unserialize_part(data.settings, container);

		// Slides
		for (slideKey in data.slides) {
			slide = data.slides[slideKey];

			// Slide settings
			slideContainer = slide_add();
			unserialize_part(slide.settings, slideContainer);

			// Slide layers
			if (sliderData.supportsLayers) {
				for (layerKey in slide.layers) {
					layer = slide.layers[layerKey];
					
					layerContainer = layer_add(slideContainer);
					unserialize_part(layer, layerContainer);
				}
			}
		}

		// Enable scrolling
		scrollingActive = true;
	}

	// Unserializes a part of the slider
	// Iterates over keys in the data, and assigns the values to form elements of they exist
	//
	function unserialize_part(data, container) {
		var value = null;
		var key = null;
		var element = null;

		for (key in data) {
			value = data[key];
			element = container.find('[name="' + key + '"]');

			// Checkbox
			if (element.is('input[type="checkbox"]')) {
				if (value === true)
					element.attr('checked', 'checked');
				else
					element.removeAttr('checked');

			// Image, also set thumbnail
			} else if (element.is('input[type="hidden"]')) {
				if (value) {
					var anchor = element.siblings('a.image-option');
					anchor.removeClass('empty');
					anchor.find('img').attr('src', value);
				}
				element.val(value);

			// Other form elements
			} else {
				element.val(value);
			}
		}
	}

	// Serializes the slider data
	// Loops through all relevant elements and constructs an object ouf of them
	// This is more efficient than dealing with form elements that need their indices tracked
	// and modified all the time.
	//
	function serialize() {
		var data = {};

		// Slider settings
		data.settings = {};
		jQuery('#core-slider-settings input, #core-slider-settings select, #core-slider-settings textarea').each(function(index, element) {
			element = jQuery(element);
			var elementName = element.attr('name');

			if (element.attr('type') === 'checkbox')
				data.settings[elementName] = (element.attr('checked') === 'checked');
			else
				data.settings[elementName] = element.val();
		});

		// Slides
		data.slides = [];
		jQuery('.core-slider-slide').each(function(index, slideElement) {
			slideElement = jQuery(slideElement);

			// Skip template slide element
			if (slideElement.hasClass('core-slide-template'))
				return;

			var slide = {};

			// Slide settings
			slide.settings = {};
			slideElement.find('.core-slide-options input, .core-slide-options select, .core-slide-options textarea').each(function(index, settingElement) {
				settingElement = jQuery(settingElement);
				var elementName = settingElement.attr('name');

				if (settingElement.attr('type') === 'checkbox')
					slide.settings[elementName] = (settingElement.attr('checked') === 'checked');
				else
					slide.settings[elementName] = settingElement.val();
			});

			// Slide layers
			if (sliderData.supportsLayers) {
				slide.layers = [];
				slideElement.find('.core-slide-layers .core-slidertable-row').each(function(index, layerElement) {
					layerElement = jQuery(layerElement);
					var layer = {};

					// Layer settings
					layerElement.find('input, select, textarea').each(function(index, settingElement) {
						settingElement = jQuery(settingElement);
						var elementName = settingElement.attr('name');
						
						if (settingElement.attr('type') === 'checkbox')
							layer[elementName] = (settingElement.attr('checked') === 'checked');
						else
							layer[elementName] = settingElement.val();
					});

					slide.layers.push(layer);
				});
			}

			// Add to slide
			data.slides.push(slide);
		});

		return data;
	}

	// Build layer template
	//
	function buildLayerTemplate(data, target) {
		var str = null;
		var optionName = null;
		var option = null;
		var columnName = null;
		var column = null;

		str = '<td><a href="#" class="core-layer-remove"></a></td>';

		for (columnName in data.layerOptions) {
			column = data.layerOptions[columnName];

			str += '<td>';
			for (optionName in column.settings) {
				option = column.settings[optionName];
				str += buildOption(optionName, option);
			}
			str += '</td>';
		}

		jQuery(str).appendTo(target);
	}

	// Build slide template
	//
	function buildSlideTemplate(data, target) {
		var str = null;
		var optionName = null;
		var option = null;
		var columnName = null;
		var column = null;

		// Header
		str = '<div class="core-slide-header">';
		str += '<a href="#" class="core-slide-remove"></a>';
		str += '</div>';

		// Options table header and column headers
		str += '<table class="core-slide-options core-slidertable">';
		str += '<tr class="core-slidertable-header">';
		for (columnName in data.slideOptions) {
			column = data.slideOptions[columnName];
			str += '<th>' + column.title;

			// Help button
			if ('help' in column) {
				if ('helplink' in column)
					str += '<a href="' + column.helplink + '" target="_blank">';

				str += '<img src="images/help.png" title="' + column.help + '">';

				if ('helplink' in column)
					str += '</a>';
			}

			str += '</th>';
		}
		str += '</tr>';

		// Options
		str += '<tr class="core-slidertable-row">';
		for (columnName in data.slideOptions) {
			column = data.slideOptions[columnName];

			str += '<td>';
			for (optionName in column.settings) {
				option = column.settings[optionName];
				str += buildOption(optionName, option);
			}
			str += '</td>';
		}
		str += '</tr>';
		str += '</table>';

		// Layer header table
		if (sliderData.supportsLayers) {
			str += '<table class="core-slide-layers core-slidertable">';
			str += '<tr class="core-slidertable-header">';
			str += '<th></th>';
			for (columnName in data.layerOptions) {
				column = data.layerOptions[columnName];
				str += '<th>' + column.title;

				// Help button
				if ('help' in column) {
					if ('helplink' in column)
						str += '<a href="' + column.helplink + '" target="_blank">';

					str += '<img src="images/help.png" title="' + column.help + '">';

					if ('helplink' in column)
						str += '</a>';
				}

				str += '</th>';
			}
			str += '</tr>';
			str += '</table>';

			str += '<a href="#" class="core-layer-add">Add layer</a>';
		}

		jQuery(str).appendTo(target);
	}

	// Build slider settings
	//
	function buildSliderSettings(data, target) {
		var str = null;
		var setting = null;
		var checked = null;

		for (optionName in data.options) {
			option = data.options[optionName];
			str = '<li><p>' + option.title + '</p>';
			str += buildOption(optionName, option);
			if (option.description)
				str += '<br><p class="description">' + option.description + '</p>';
			str += '</li>';

			// Add to settings element
			jQuery(str).appendTo(target);
		}
	}

	// Build a single option
	//
	function buildOption(name, option) {
		var str = null;
		var itemKey = null;
		var itemValue = null;
		var selected = null;

		// String
		if (option.type === 'string') {
			str = '<input name="' + name + '" type="text" value="' + option.default + '">';

		// Multiline (textarea)
		} else if (option.type === 'multiline') {
			if (option.default === undefined)
				option.default = '';

			str = '<textarea name="' + name + '">' + option.default + '</textarea>';

		// Number
		// Same as string, but allows support for HTML5 number type later on
		} else if (option.type === 'number') {
			//str = '<input name="' + name + '" type="number" min="' + option.min + '" max="' + option.max + '" value="' + option.default + '">';
			str = '<input name="' + name + '" type="text" value="' + option.default + '">';
		}

		// Boolean
		else if (option.type === 'boolean') {
			if (option.default === true)
				checked = ' checked';
			else
				checked = '';
			str = '<input name="' + name + '" type="checkbox" value="true"' + checked + '>';
		}

		// Image
		else if (option.type === 'image') {
			str = '<a href="#" class="image-option empty"><img src=""></a>';
			str += '<input name="' + name + '" type="hidden">';

			if (option.delete === true) {
				str += '<a href="#" class="image-option-delete"></a>';
			}
		}

		// Select box
		else if (option.type === 'select') {
			str = '<select name="' + name + '">';
			for (itemKey in option.items) {
				itemValue = option.items[itemKey];

				if (option.default === itemKey)
					selected = ' selected';
				else
					selected = '';

				str += '<option value="' + itemKey + '"' + selected + '>' + itemValue + '</option>';
			}
			str += '</select>';
		}

		return str;
	}

	// Template elements
	var templateSlide = jQuery('.core-slide-template');
	var templateLayer = jQuery('.core-layer-template');

	// Disable scrolling when loading
	var scrollingActive = false;

	// Initialize sortable
	jQuery('#core-slider-slides').sortable({
		handle: '.core-slide-header',
		revert: 200
	});

	// Get slider data from parent window
	var sliders = window.parent.sliders;
	var sliderType = window.sliderType;
	var sliderData = sliders[sliderType];

	// Hide add slide button if needed
	if (!sliderData.supportsSlides)
		jQuery('.core-slide-add').hide();

	// Build templates
	buildSliderSettings(sliderData, jQuery('#core-slider-settings'));
	buildSlideTemplate(sliderData, templateSlide);
	if (sliderData.supportsLayers)
		buildLayerTemplate(sliderData, templateLayer);

	// Unserialize slider configuration
	unserialize(window.sliderSettings);

});
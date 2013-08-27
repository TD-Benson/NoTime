// Standard web-safe fonts
// These will not be loaded through Google fonts
var coreStandardFonts = [	'Arial',
							'Arial Black',
							'Courier New',
							'Georgia',
							'Impact',
							'Times New Roman',
							'Trebuchet MS',
							'Verdana'];

// Currently active loaders
var coreFontLoaders = {};

// Throttling delay
var CORE_FONT_THROTTLE_DELAY = 1500;


// Queues a font for loading
// Throttling occurs to prevent hammering of external services
//
function coreFontsLoadThrottled(id, loader) {
	
	// Load font immediately if we were not yet throttling
	if (!(id in coreFontLoaders)) {
		coreFontLoad(loader.loadNames, loader.loadCallbackSuccess, loader.loadCallbackFailure);
		loader.loadNames = null;
	}

	// Enable throttling by storing the font data
	coreFontLoaders[id] = loader;

	setTimeout(function() {
		// If new fonts were queued to be loaded while throttled, load them now
		if (loader.loadNames != null) {
			coreFontLoad(loader.loadNames, loader.loadCallbackSuccess, loader.loadCallbackFailure);
			loader.loadNames = null;
		}

		// Disable throttling again
		delete coreFontLoaders[id];
	}, CORE_FONT_THROTTLE_DELAY);
}

// Loads fonts through Google Web Fonts
//
function coreFontLoad(fontNames, callbackSuccess, callbackFailure) {

	// Immediately return if there are no names to load
	if (!fontNames.length) {
		callbackSuccess();
		return;
	}

	window.WebFont.load({
		google: {
			families: fontNames
		},
		active: callbackSuccess,
		inactive: callbackFailure
	});
}

// Removes standard system fonts from the input list
//
function coreFontsRemoveStandard(fontNames) {
	var index = 0;
	var fontName = null;

	while(index < fontNames.length) {
		fontName = fontNames[index];

		if (coreStandardFonts.indexOf(fontName) !== -1)
			fontNames.splice(index, 1);
		else
			index++;
	}

	return fontNames;
}

// Updates an option's previewed font
//
function coreFontsSetPreview(fontName, id, previewElement, statusElement, throttle) {
	if (throttle === undefined)
		throttle = true;

	// Mark the element so that we do not end up showing a failure after a long callback delay
	previewElement.attr('data-updated', 'false');

	// Show busy state
	statusElement.animate({opacity: 1}, 200);
	statusElement.css('backgroundImage', 'url(' + coreDir + '/images/busy.gif)');

	// Setup loader object
	var loader = {
		loadNames: coreFontsRemoveStandard([fontName]),
		
		// The fonts were loaded succesfully
		loadCallbackSuccess: function() {
			previewElement.css('fontFamily', fontName);
			previewElement.animate({opacity: 1}, 200);
			statusElement.animate({opacity: 0}, 200);

			previewElement.attr('data-updated', 'true');
		},

		// There was a failure
		loadCallbackFailure: function() {
			var updated = previewElement.attr('data-updated');
			if (updated == 'false') {
				previewElement.animate({opacity: 0}, 200);
				statusElement.css('backgroundImage', 'url(' + coreDir + '/images/core-notice-error.png)');
			}
		}
	};

	// Load fonts
	if (throttle)
		coreFontsLoadThrottled(id, loader);
	else
		coreFontLoad(loader.loadNames, loader.loadCallbackSuccess, loader.loadCallbackFailure);
}

jQuery(document).ready(function() {

	// Bind font preview updates
	//
	jQuery('.core-option-font-container').each(function() {
		var selectElement = jQuery('select', this);
		var previewElement = jQuery('p', this);
		var valueElement = jQuery('input[type=text]', this);
		var statusElement = jQuery('.font-status', this);

		// Select input
		selectElement.bind('change', function() {
			var value = jQuery(':selected', this).text();
			valueElement.val(value);
			coreFontsSetPreview(value, valueElement.attr('id'), previewElement, statusElement);
		});

		// Text input change
		valueElement.bind('keyup', function() {
			var value = jQuery(this).val();

			if (value != valueElement.attr('data-previous'))
				coreFontsSetPreview(value, valueElement.attr('id'), previewElement, statusElement);

			valueElement.attr('data-previous', value);
		});

		// Set initial font preview
		coreFontsSetPreview(valueElement.val(), valueElement.attr('id'), previewElement, statusElement, false);
	});

});
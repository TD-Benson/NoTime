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
	previewElement.attr('data-updated', 'true');

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



jQuery(document).ready( function() {	
		jQuery("head").append("<link>");

		// Activate the Demo 
		jQuery("#settings").click(function(){
			jQuery("#demo-pane").toggle();
			jQuery(this).toggleClass("active");
			if ( jQuery(this).parent().hasClass('active') ){
				jQuery(this).parent().removeClass('active');
			}else{
				jQuery(this).parent().addClass('active');
			}
		});
		
		// Pre-Designed Skins Options
		jQuery('#demo-pane .skins a').each(function(index, element) {
			var element = jQuery(element);

			element.click(function(){
				
				var previewElement = jQuery(this);
				var image = jQuery(this).attr('class');
				var imagebg = window.templateDir + '/core/demo/images/checked.png';
				var colorskin = jQuery(this).attr('data-rel');
				var logo = jQuery('#theme-logo img');

				jQuery('#demo-pane .skins a.active').css({ "background-image" : "none"});
				jQuery(this).css({ "background-image" : "url(" + imagebg + ")", "background-position" : "center", "background-repeat" : "no-repeat"});
				jQuery(this).addClass('active');

				jQuery("head").children(":last").remove();
				jQuery("head").append("<link>");
				css = jQuery("head").children(":last");
			    css.attr({
			      rel:  "stylesheet",
			      type: "text/css",
			      href: window.templateDir + "/css/skins/style-" + colorskin + ".css"
			    });
				
				logo.attr({"src": window.templateDir + "/css/skins/logos/" + colorskin + ".png" })

				return false;
			});
		});

		// Page Layout Options
		jQuery('#demo-pane .layout').each(function(index, element) {
			var element = jQuery(element);

			element.click(function(){
				
				var previewElement = jQuery("#boxed");
				var max_width = jQuery(this).attr('data-rel');
				var container = jQuery('.isotope');
				previewElement.removeClass('boxed');
				
				jQuery('.container').css({ 'max-width' : max_width, 'margin' : '0 auto'}).delay(200);
				container.isotope({
					  // options...
					  resizable: false, // disable normal resizing
					  // set columnWidth to a percentage of container width
					  masonry: { columnWidth: container.width() / 6}
					});
					
				if(max_width == 'boxed'){
					previewElement.addClass('boxed');
					previewElement.css({ 'max-width' : '1140px', 'margin' : '0 auto'});
					previewElement.css("box-shadow", "0px 0px 10px rgba(0,0,0,0.35)");
				}else if(max_width == 'full') {
					previewElement.removeClass('boxed');
					previewElement.css({ 'max-width' : '100%','margin' : '0 auto'});
					jQuery("#boxed .row").css({ 'max-width' : '1140px'});
					previewElement.css("box-shadow", "none");
				}else {
					previewElement.removeClass('boxed');
					previewElement.css({ 'max-width' : '100%', 'margin' : '0 auto'});
					jQuery("#boxed .row").css({ 'max-width' : '100%'});
					previewElement.css("box-shadow", "none");
				}
				container.isotope({
					  // options...
					  resizable: false, // disable normal resizing
					  // set columnWidth to a percentage of container width
					  masonry: { columnWidth: container.width() / 6}
					});
			});
			
			
		});

		// Pattern Selected
		jQuery('#demo-pane div.tile').each(function(index, element) {
			var element = jQuery(element);
			
			element.click(function(){
				var image = jQuery(this).css("background-image");
				var previewElement = jQuery("#theme-navigation-row, #theme-footer-a-row, #theme-footer-background, .theme-custom, .tsidebarnarrow, .tsidebarwide");
				previewElement.css("background-image", image);
				
			});
			
		});
        
        
        // Bind font preview updates
		//
		jQuery('.core-option-font-container').each(function() {
			var selectElement = jQuery('select', this);
			var previewElement = jQuery('.container, h1, h2, h3, h4, h5, h6, #theme-menu-main, #theme-footer-menu');
			var valueElement = jQuery('input[type=hidden]', this);
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
			if (valueElement.val() != '') {
				coreFontsSetPreview(valueElement.val(), valueElement.attr('id'), previewElement, statusElement, false);
			}

		});
        
	});
	
	
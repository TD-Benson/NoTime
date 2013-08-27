// True if the options are currently being saved
var saving = false;

// Binds color picker events
//
function coreBindColorPicker(colorBox, colorInput) {
	colorBox.ColorPicker({
		color: colorInput.val(),
		onChange: function (hsb, hex, rgb) {
			colorBox.css('backgroundColor', '#' + hex);
			colorInput.val(hex);
		}
	});
	colorInput.bind('keyup', function() {
		colorBox.css('backgroundColor', '#' + colorInput.val());
	});
	colorInput.bind('change', function() {
		colorBox.css('backgroundColor', '#' + colorInput.val());
	});
}

// Disables saving of theme options
// This prevents some conflicts when the user saves twice or changes page
//
function disableSaving() {
	saving = true;
	jQuery('#core-theme-options #content').animate({opacity: 0.25}, 500).prop('disabled', true);
}
function enableSaving() {
	saving = false;
	jQuery('#core-theme-options #content').animate({opacity: 1.0}, 500).prop('disabled', false);
}

jQuery(document).ready(function() {

	// Keep option buttons at the bottom of the screen
	//
	var contentContainer = jQuery('#content');
	if (contentContainer.length) {
		var buttonBar = jQuery('.core-option-theme-buttons');
		var windowElement = jQuery(window);
		var lastTop = 0;

		function positionButtons() {
			var destinationTop = (windowElement.scrollTop() + windowElement.height() - buttonBar.innerHeight() - contentContainer.offset().top);
			var maxTop = contentContainer.height() + contentContainer.offset().top;
			if (destinationTop > maxTop)
				destinationTop = maxTop - buttonBar.height();

			if (lastTop === destinationTop)
				return;

			buttonBar.stop(true, false).animate({top: destinationTop}, 100);
			lastTop = destinationTop;
		}
		jQuery(window).scroll(positionButtons);
		jQuery(window).resize(positionButtons);
		setInterval(positionButtons, 100);
		positionButtons();
	}
			
	// Number option arrows
	//
	jQuery('.core-option-number-input').each(function(index, element) {
		element = jQuery(element);

		var step = parseFloat(element.attr('data-step'));
		var min = parseFloat(element.attr('data-min'));
		var max = parseFloat(element.attr('data-max'));

		// Prevent clicking from selecting elements
		element.siblings('.core-option-number-down, .core-option-number-up').bind('mousedown', function() { return false; });

		element.siblings('.core-option-number-up').bind('click', function() {
			var value = parseFloat(element.val());
			value = Math.min(value + step, max);
			element.val(value);
		});

		element.siblings('.core-option-number-down').bind('click', function() {
			var value = parseFloat(element.val());
			value = Math.max(value - step, min);
			element.val(value);
		});
	});
	
	// Image selection functions
	//
	jQuery('.core-option-image-select-container').each(function(index, element) {
		var previewImageBox = jQuery(element).find('.preview-thumb');
		var previewImage = previewImageBox.find('img');
		var previewImageRemove = previewImageBox.find('.remove');
		var imageText = jQuery(element).find('input[type="text"]');

		// Hide remove button if no image is selected
		if (imageText.val() === '')
			previewImageRemove.hide();

		// Store\restore current sendtoeditor function
		function saveEditFunction() {
			window.originalSendToEditor = window.send_to_editor;
		}			

		function restoreEditFunction() {
			if (window.originalSendToEditor !== null) {
    			window.send_to_editor = window.originalSendToEditor;
    			window.originalSendToEditor = null;
			}
		}
		
		// Uploading files
		var file_frame;
	
		  previewImageBox.on('click', function( event ){
			var send_attachment_bkp = wp.media.editor.send.attachment;
			var button = jQuery(this);
			var destination = button.attr('data-destination');
			var destinationElement = jQuery('#' + destination + ' ');
		    event.preventDefault();
		 
		    // If the media frame already exists, reopen it.
		    if ( file_frame ) {
		      file_frame.open();
		      return;
		    }
		 
		    // Create the media frame.
		    file_frame = wp.media.frames.file_frame = wp.media({
		      title: jQuery( this ).data( 'title' ),
		      button: {
		        text: 'Insert Image',
		      destination: jQuery( this ).data( 'destination' ),
		      },
		      multiple: false  // Set to true to allow multiple files to be selected
		    });
		 
		    // When an image is selected, run a callback.
		    file_frame.on( 'select', function() {
		      // We set multiple to false so only get one image from the uploader
		      attachment = file_frame.state().get('selection').first().toJSON();
	          destinationElement.val(attachment.url);
			  previewImage.attr('src', attachment.url);
			  if (destinationElement.val() !== '')
				previewImageRemove.show();
		      
		    });
		 
		    // Finally, open the modal
		    file_frame.open();
		  });

		// Remove selected image
		previewImageRemove.bind('click', function(ev) {
			// Erase input field
			imageText.val('');

			// Replace <img> thumbnail with empty <img> tag
			previewImage.remove();
			previewImage = jQuery('<img class="preview">')
			previewImage.prependTo(previewImageBox);

			// Hide remove button
			previewImageRemove.hide();

			ev.preventDefault();
			return false;
		});

	});

	// Bind color pickers
	//
	jQuery('.core-option-color').each(function() {
		var colorBox = jQuery(this);
		var colorInput = colorBox.siblings('input');

		coreBindColorPicker(colorBox, colorInput);
	});

	// Pattern selection preview
	//
	jQuery('.core-option-pattern-container > select').each(function(index, element) {
		element = jQuery(element);
		var container = element.parent().parent();

		function changePattern() {
			var value = element.find(':selected').val();
			container.css('background-image', 'url(' + templateDir + '/images/patterns/' + value + ')');
		}

		element.bind('change', changePattern);
		changePattern();
	});

	// Theme options submit button
	//
	jQuery('#core-options-submit').bind('click', function(event) {
		if (saving)
			return;

		disableSaving();
		
		var resultP = jQuery('#core-options-result');
		var busy = jQuery('#core-options-busy');

		var ANIMATE_SPEED = 150;
		var DELAY = 1000;
        
		// Show the busy animation
        busy.stop(true, true).animate({opacity: 1}, ANIMATE_SPEED);
        resultP.html('').fadeIn(ANIMATE_SPEED);

        // Send the form's options
        jQuery.post(ajaxurl, jQuery('#core-theme-options-form').serialize(), function(result) {

        	// Update result
        	busy.stop(true, true).animate({opacity: 0}, ANIMATE_SPEED, function() {
        		resultP.stop(true, true);
        		resultP.html(result);
        		resultP.delay(DELAY).fadeOut(ANIMATE_SPEED);
        	});

        	// TODO: Update sidebar select boxes
        	jQuery('.core-layout-sidebar > select').each(function(index, element) {

        	});

        	enableSaving();
        });

        event.preventDefault();
        return false;
    });

	// Bind group navigation
	//
	jQuery('.core-option-group-link').bind('click', function() {
		var ANIMATE_SPEED = 100;

		var newGroup = jQuery('#' + jQuery(this).attr('id').replace('core-option-group-link-', 'core-option-group-'));

		// Exit if we are already displaying the clicked group
		if (newGroup.css('display') != 'none')
			return;

		// Toggle group visibility
		jQuery('.core-option-group:visible').each(function() {
			jQuery(this).slideUp(ANIMATE_SPEED);
		});
		newGroup.slideDown(ANIMATE_SPEED);
	});
	
    // Theme options section tabs
    //
    jQuery('.core-options-tabs > li').bind('click', function() {
    	var section = jQuery(this).attr('data-section');
    	var element = jQuery('#core-option-section-' + section);

    	var ANIMATE_SPEED = 100;

    	jQuery(this).parent().children('li').removeClass('active');
    	jQuery(this).addClass('active');

    	jQuery(this).parents('.core-option-group').find('.core-option-section').slideUp(ANIMATE_SPEED);
    	element.slideDown(ANIMATE_SPEED);
    });

});
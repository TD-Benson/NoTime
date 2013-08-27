jQuery(document).ready(function() {

	jQuery('.core-option-colorschemes').each(function(index, element) {
		var element = jQuery(element);
		var storage = element.children('input[type="hidden"]');
		var template = element.find('.template');
		var addbutton = element.find('.add');
		var table = element.find('table');
		var editrow = table.find('.editrow');

		// Stores color scheme data in hidden field
		function storeSchemes(element) {
			var schemes = {};
			
			// Store all scheme rows
			table.find('tr.scheme:not(.template)').each(function(index, element) {
				element = jQuery(element);

				// Store all input element values inside an object
				var scheme = {};
				var id = null;
				var className = null;
				element.find('input').each(function(index, subElement) {
					subElement = jQuery(subElement);

					// Classname (scheme-*) determines key name
					className = subElement.attr('class').substr(7);
					scheme[className] = subElement.val();
				});

				schemes[scheme['id']] = scheme;
			});

			storage.val(JSON.stringify(schemes));
		}

		// Extracts schemes data from hidden field and builds rows
		function buildSchemes(element) {
			var data = storage.val();
			if (!data)
				return;

			var schemes = JSON.parse(data);
			if (!schemes)
				return;

			var key = null;
			var subKey = null;
			var scheme = null;
			var schemeElement = null;
			var inputElement = null;
			for (key in schemes) {
				var scheme = schemes[key];

				schemeElement = addScheme(scheme['id']);

				// scheme-*
				for (subKey in scheme) {
					inputElement = schemeElement.find('.scheme-' + subKey);
					inputElement.val(scheme[subKey]);
					inputElement.trigger('change');
				}
			}
		}

		// Generates a practically unique id
		function generateId() {
			return 'colorscheme-' + ((new Date().getTime()) * (Math.random() * 100) * 1000);
		}

		// Adds a scheme row to the table
		function addScheme(id) {
			// Clone template
			var newrow = template.clone();
			newrow.removeClass('template');
			newrow.insertBefore(editrow);

			// Bind colorpickers
			newrow.find('.core-option-color').each(function(indexElement, colorElement) {
				colorElement = jQuery(colorElement);
				coreBindColorPicker(colorElement, colorElement.siblings('input'));
			});

			// Bind remove button
			jQuery('.remove', newrow).bind('click', function() {
				removeScheme(jQuery(this));
				storeSchemes(element);

				return false;
			});

			// Generate a new id if needed
			if (id === undefined)
				id = generateId();
			newrow.find('.scheme-id').val(id);

			return newrow;
		}

		// Removes a scheme row from the table
		function removeScheme(removeButtonElement) {
			var row = removeButtonElement.parent().parent();
			row.remove();
		}

		// Add scheme button
		addbutton.bind('click', function() {
			addScheme();
			storeSchemes(element);

			return false;
		});

		// Initial build
		buildSchemes();

		// Also save options when theme options form is submitted
		jQuery('#core-options-submit').bind('mousedown', {element: element}, storeSchemes);
	});

});
jQuery(document).ready(function() {

	// Insert shortcode text into editor
	window.send_shortcode = function(data) {
		tb_remove();

		// Add data to TinyMCE editor
		if (window.tinyMCE.activeEditor != null && window.tinyMCE.activeEditor.isHidden() === false) {
			tinyMCE.execCommand("mceInsertContent", false, data);
			tinyMCE.activeEditor.focus();

		// Add data to post editor
		} else {
			insertAtCursor(document.getElementById('content'), data);
		}
	}

	// http://alexking.org/blog/2003/06/02/inserting-at-the-cursor-using-javascript#comment-3817
	// TODO: Read, understand, make IE work better
	function insertAtCursor(myField, myValue) {
		//IE support
		if (document.selection) {
			var temp;
			myField.focus();
			sel = document.selection.createRange();
			temp = sel.text.length;
			sel.text = myValue;
			if (myValue.length == 0) {
				sel.moveStart('character', myValue.length);
				sel.moveEnd('character', myValue.length);
			} else {
				sel.moveStart('character', -myValue.length + temp);
			}
			sel.select();
		}

		//MOZILLA/NETSCAPE support
		else if (myField.selectionStart || myField.selectionStart == '0') {
			var startPos = myField.selectionStart;
			var endPos = myField.selectionEnd;
			myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
			myField.selectionStart = startPos + myValue.length;
			myField.selectionEnd = startPos + myValue.length;
		} else {
			myField.value += myValue;
		}
	}

});
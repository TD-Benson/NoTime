<?php

if (!defined('CORE_VERSION'))
	die();


// Register options
//
function core_colorschemes_options_register() {
	global $core_theme_options_handler;

	// Theme options
	$options = new CoreOptionGroup('colorschemes', 'Color schemes', __('Here you can define color schemes to use on separate posts and pages.', THEME_SLUG), THEME_URI. '/images/options-colorschemes.png');
	$core_theme_options_handler->group_add($options);

	$section = new CoreOptionSection('colorschemes');
	$options->section_add($section);

	$section->option_add(new CoreOption('colorschemes', '', 'colorschemes'));
}
add_action('after_setup_theme', 'core_colorschemes_options_register');


// Colorschemes list options
//
function core_colorschemes_option_output($id, $value, $option) {
	?>
	<div class="core-option-colorschemes">
		<table>
			<tr>
				<th></th>
				<th><?php _e('Name', THEME_SLUG); ?></th>
				<th><?php _e('Background color', THEME_SLUG); ?></th>
				<th><?php _e('Background opacity %', THEME_SLUG); ?></th>
				<th><?php _e('Paragraph color', THEME_SLUG); ?></th>
				<th><?php _e('Headings color', THEME_SLUG); ?></th>
			</tr>
			<tr class="template scheme">
				<td><a href="#" class="remove"><img src="<?php echo CORE_URI; ?>/colorschemes/images/delete.png"></a></td>
				<td>
					<input type="hidden" class="scheme-id" value="">
					<input type="text" class="scheme-name" value="">
				</td>
				<td>
					<input type="text" class="scheme-color-background" value="111111">
					<div class="core-option-color" style="background-color: #111111"></div>
				</td>
				<td><input type="text" class="scheme-opacity-background" value="90"></td>
								<td>
					<input type="text" class="scheme-color-paragraph" value="<?php echo ltrim(core_options_get('color_paragraphs'),'#'); ?>">
					<div class="core-option-color" style="background-color: #<?php echo ltrim(core_options_get('color_paragraphs'),'#'); ?>"></div>
				</td>
				<td>
					<input type="text" class="scheme-color-headings" value="<?php echo ltrim(core_options_get('color_heading1'),'#'); ?>">
					<div class="core-option-color" style="background-color: #<?php echo  ltrim(core_options_get('color_heading1'),'#'); ?>"></div>
				</td>

			</tr>
			<tr class="editrow">
				<td></td>
				<td><a href="#" class="add">Add new</a></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>

		<input type="hidden" id="<?php echo $id; ?>" name="<?php echo $option->key; ?>" value='<?php echo json_encode($value); ?>'>
	</div>
	<?php
}
function core_colorschemes_option_import($value, $option) {
	return json_decode(stripslashes($value), true);
}
core_options_type_register('colorschemes', 'core_colorschemes_option');


// Colorscheme list picker
//
function core_colorschemeslist_option_output($id, $value, $option) {
	$schemes = core_options_get('colorschemes');

	echo '<select id="', $id, '" name="', $option->key, '">';

	// 'default' options
	if ($value == 'default' || !$value || !isset($schemes[$value]))
		$selected = 'selected';
	else
		$selected = '';
	echo '<option value="default" ', $selected, '>' . _e('Default', THEME_SLUG) . '</option>';

	// Output scheme names
	foreach ($schemes as $id => $scheme) {
		if ($id == $value)
			$selected = ' selected';
		else
			$selected = '';

		echo '<option value="', $id, '" ', $selected, '>', $scheme['name'], '</option>';
	}
	echo '</select>';
}
core_options_type_register('colorschemes-list', 'core_colorschemeslist_option');

?>
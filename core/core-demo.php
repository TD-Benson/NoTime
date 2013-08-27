<?php
if (!defined('CORE_VERSION'))
	die();


// Enable demo settings
function core_demo_settings_enable($customize = false){
	if ($customize){
		add_action('wp_footer', 'core_demo_settings', 10);
	}
}
	
// Add all necessary files
//
function core_demo_enqueue_files(){
	
	wp_enqueue_script(
			'demo-setting',
			THEME_URI . '/core/demo/demo-setting.js',
			array('jquery')
		);
	
	wp_register_style( 'demo-style', 
	    THEME_URI . '/core/demo/css/demo.css', 
	    array(), 
	    '20122078', 
	    'all' );
	wp_enqueue_style( 'demo-style' );
}
add_action('wp_enqueue_scripts', 'core_demo_enqueue_files');

// Custom Fonts and Patterns Preview
//
function core_demo_settings(){ ?>
	
	<div id="customize-demo">
		<div id="settings"></div>
	</div>
	
	<div id="demo-pane">
		
			<div class="columns">
				
				<div class="option-group">
					<h3>SELECT FONT</h3>
					<ul>
						<li>
							<?php core_demo_load_fonts(); ?>
						</li>
					</ul>
				</div>

				<div class="option-group">
					<h3>SKINS + CUSTOM</h3>
					<div class="skins">
						<a href="#" data-rel="white" class="white">White</a>
						<a href="#" data-rel="black" class="black">Black</a>
						<a href="#" data-rel="orange" class="orange">Orange</a>
						<a href="#" data-rel="grey" class="grey">Grey</a>
					</div>
                    <div style="font-size:9px;">NOTE!<em> You can change every color from the admin panel, over 40 corlorpickers included.</em></div>
				</div>

				<div class="option-group">
					<h3>SELECT A LAYOUT</h3>
					<ul>
						<li class="layout" data-rel="full">
                       
							<span href="#" >1140 Grid</span>
						</li>
						<li class="layout" data-rel="boxed">
							<span href="#">Boxed</span>
						</li>
					</ul>
					<ul>
						<li class="layout" data-rel="fluid">
							<span href="#" >100% Fluid</span>
						</li>
					</ul>
                 
					<div style="clear:both;"></div>
				</div>
			</div>
			<div style="clear:both;"></div>
	</div>
<?php
}


// Load all the patterns
function core_demo_patterns($option = 'pattern'){
	global $core_theme_options_handler;	
	$folder = THEME_PATH . '/images/patterns';
	$patterns = core_get_directory_list($folder);
	sort($patterns, SORT_NUMERIC);
	$i = 1;
	foreach($patterns as $file) {
		if(strstr($file, '.png'))
			echo '<div class="tile" style="background: url(\''. THEME_URI. '/images/patterns/' .$file. '\') repeat">Pattern '.$i.'</div>';
		$i++;
	}
}

// Load the fonts
function core_demo_load_fonts(){
	global $core_fonts;
	global $core_fonts_preview_text;
	
	echo '<div class="core-option-font-container">';
	echo '<select id="font_lists" name="font_lists">';
	$id = '';
	$value = '';
	foreach ($core_fonts as $group_name => $group) {
		echo '<optgroup label="' .$group_name. '">';
		foreach ($group as $font_name) {
			echo '<option value="'.$font_name.'">' .$font_name. '</option>';
		}
	}
	echo '</select>';
	echo '<input type="hidden" id="' .$id. '" name="" value="', $value, '" data-previous="', $value, '">';
	echo '<div class="font-status"></div>';
	echo '</div>';
}

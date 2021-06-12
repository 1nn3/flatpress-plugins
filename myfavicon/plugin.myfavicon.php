<?php
/*
Plugin Name: myfavicon
Plugin URI: http://www.flatpress.org/
Description: Adds a favicon to FlatPress
Author: NoWhereMan
Version: 1.0
Author URI: http://www.nowhereland.it/
*/ 
 
function plugin_myfavicon_head() {
	// your file *must* be named favicon.ico 
	// and be a ICO file (not a renamed png, jpg, gif, etc...)
	// or it won't work in IE
	echo '<link rel="shortcut icon" href="' .  
		plugin_geturl('myfavicon') .'imgs/favicon.ico" />';

	

}
 
add_action('wp_head', 'plugin_myfavicon_head');
 
?>

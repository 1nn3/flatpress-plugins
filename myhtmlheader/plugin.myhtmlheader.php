<?php
/*
Plugin Name: myhtmlheader
Plugin URI: http://www.flatpress.org/
Description: Adds html header to FlatPress
Author: NoWhereMan
Version: 1.0
Author URI: http://www.nowhereland.it/
*/ 
 
function plugin_myhtmlheader_head() {
	$plugin_dir=plugin_getdir('myhtmlheader');
	$htmlheader_path=$plugin_dir."htmlheader.txt";
	$htmlheader = io_load_file($htmlheader_path);
	echo <<<END
\n
<!-- myhtmlheader plugin -->
$htmlheader
<!-- end of myhtmlheader plugin -->
END;
}
 
add_action('wp_head', 'plugin_myhtmlheader_head');
 
?>

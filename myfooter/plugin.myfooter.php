<?php
/*
Plugin Name: myfooter
Plugin URI: http://www.flatpress.org/
Description: Adds content to FlatPress footer
Author: 1nn3
Version: 1.0
Author URI: http://0010100.de/
*/
 
function plugin_myfooter_wp_footer() {
	$plugin_dir=plugin_getdir('footer');
	$footer_path=$plugin_dir."footer.txt";
	$footer = io_load_file($footer_path);
	echo <<<END
\n
<!-- footer plugin -->
$footer
<!-- end of footer plugin -->
END;
}
 
add_action('wp_footer', 'plugin_myfooter_wp_footer');
 
?>


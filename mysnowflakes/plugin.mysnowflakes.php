<?php
/*
Plugin Name: mysnowflakes
Plugin URI: http://www.flatpress.org/
Description: Let it snow on christmas from 1.12 to 26.12
Author: Dominik Scholz / go4u.de Webdesign
Version: 1.0
Author URI: https://www.go4u.de/snowflakes.htm
*/ 

function plugin_mysnowflakes_head() {

	$plugin_dir=plugin_getdir('mysnowflakes');
	$snowflakes_path=$plugin_dir."snowflakes.js";

	echo <<<END
\n
<!-- mysnowflake plugin -->
<script type="text/javascript" src="$snowflakes_path"></script> 
<!-- end of mysnowflake plugin -->
END;
}

add_action('wp_head', 'plugin_mysnowflakes_head');
 
?>

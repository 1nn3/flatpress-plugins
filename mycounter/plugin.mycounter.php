<?php
/*
Plugin Name: mycounter
Plugin URI: http://www.github.com/1nn3/flatpress-plugins
Description: Displays a counter and visitors in the footer
Author: 1nn3
Version: 1
Author URI: http://0010100.de/
*/

function plugin_counter_load_cache ($path) {
	$cache = unserialize(io_load_file($path));
	if (is_array($cache) === FALSE) {
		$cache = array();
	}
	return $cache;
}

function plugin_counter_save_cache ($path, $cache) {
	io_write_file($path, serialize($cache));
	return $cache;
}

function plugin_counter_remove_old_from_cache ($s, &$cache) {
	$new_cache = array();
	$time = time() - $s;
	foreach ($cache as $value) {
		if ($value['time'] > $time) {
			array_push($new_cache, $value);
		}
	}
	$cache = $new_cache;
	return $cache;
}

function plugin_counter_is_in_cache ($ip, $cache) {
	return array_search($ip, array_column($cache, 'ip'));
}

function plugin_counter_add_to_cache ($ip, &$cache) {
	array_push($cache, array(
		'ip' => $ip,
		'time' => time(),
	));
	return $cache;
}

function plugin_counter_load_counter ($path) {
	$counter = io_load_file($path);
	if ($counter === FALSE) {
		$counter = 0;
	}
	return $counter;
}

function plugin_counter_save_counter ($path, $counter) {
	io_write_file($path, $counter);
	return $counter;
}

function plugin_counter_add_to_counter ($count, &$counter) {
	$counter = intval($counter) + $count;
	return $counter;
}

function plugin_counter_is_robot ($user_agent) {
	$f=plugin_getdir('mycounter')."robots-user-agents.txt";
	foreach (utils_kexplode(io_load_file($f), '\n') as $robot_user_agent) {
		if (preg_match($robot_user_agent, $user_agent)) {
			return TRUE;
		}
	}
	return FALSE;
}

function plugin_mycounter_wp_footer() {

	$ip=utils_ipget();
	$plugin_dir=plugin_getdir('mycounter');

	$counter_path=$plugin_dir."counter.txt";
	$counter = plugin_counter_load_counter($counter_path);
	$counter_cache_path=$plugin_dir."counter-cache.txt";
	$counter_cache=plugin_counter_load_cache($counter_cache_path);
	plugin_counter_remove_old_from_cache( 60 * 60, $counter_cache); 

	$visitors_cache_path=$plugin_dir."visitors-cache.txt";
	$visitors_cache=plugin_counter_load_cache($visitors_cache_path);
	plugin_counter_remove_old_from_cache( 60 * 5, $visitors_cache);

	if (user_loggedin() === FALSE
	&& plugin_counter_is_robot($_SERVER['HTTP_USER_AGENT']) === FALSE) {

		if (plugin_counter_is_in_cache($ip, $counter_cache) === FALSE) {
			plugin_counter_add_to_cache($ip, $counter_cache);
			plugin_counter_save_cache($counter_cache_path, $counter_cache);
			$counter = plugin_counter_save_counter($counter_path, plugin_counter_add_to_counter(1, $counter));
		}

		if (plugin_counter_is_in_cache($ip, $visitors_cache) === FALSE) {
			plugin_counter_add_to_cache($ip, $visitors_cache);
			plugin_counter_save_cache($visitors_cache_path, $visitors_cache);
		}

	}

	$visitors = count($visitors_cache);

	echo <<<EOF
Counter: $visitors online and $counter total (your IP is $ip)\n
EOF;
}

add_action('wp_footer', 'plugin_mycounter_wp_footer');
?>


<?php
/*
Plugin Name: mypostviews
Plugin URI: http://www.nowhereland.it/
Description: PostViews plugin.
Author: NoWhereMan
Version: 1.0
Author URI: http://www.nowhereland.it/
*/ 

add_action('entry_block', 'plugin_mypostviews_do');

function plugin_mypostviews_is_robot ($user_agent) {
	$f=plugin_getdir('mypostviews')."robots-user-agents.txt";
	foreach (utils_kexplode(io_load_file($f), '\n') as $robot_user_agent) {
		if (preg_match($robot_user_agent, $user_agent)) {
			return TRUE;
		}
	}
	return FALSE;
}

function plugin_mypostviews_calc($id, $calc) {

	$dir = entry_dir($id);
	if (!$dir) return;
	
	$f = $dir . '/view_counter' .EXT;
	
	$v = io_load_file($f);
	
	if ($v===false){
		$v = 0;
	} elseif ($v < 0) {
		// file was locked. Do not increase views.
		// actually on file locks system should hang, so
		// this should never happen
		$v = 0;
		$calc = false;
	}
	
	if ($calc && !user_loggedin()
	&& plugin_mypostviews_is_robot($_SERVER['HTTP_USER_AGENT']) === FALSE) {
		$v++;
		io_write_file($f, $v);
	}
	
	return $v;
}

function plugin_mypostviews_do($id) {
	
	global $fpdb, $smarty;
	
	$q = $fpdb->getQuery();
	$calc = $q->single;
	
	$v = plugin_mypostviews_calc($id, $calc);
	
	$smarty->assign('views', $v);

}

?>

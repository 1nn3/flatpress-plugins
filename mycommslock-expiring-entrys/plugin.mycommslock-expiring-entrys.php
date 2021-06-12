<?php
/*
Plugin Name: mycommentslock (expiring entries)
Plugin URI: http://www.flatpress.org/
Description: Locks comments globally after a defined amount of days
Author: NoWhereMan  (E.Vacchi)
Version: 1.0
Author URI: http://www.nowhereland.it
*/

function plugin_mycommslock_expiring_entrys_block() {
	$MAX_DAYS = 31;
	global $post, $smarty;

	$smarty->assign('entry_commslock', time() - $post['date'] > $MAX_DAYS*3600*24);
}

add_action('entry_block', 'plugin_mycommslock_expiring_entrys_block');

?>


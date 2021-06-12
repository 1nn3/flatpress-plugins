<?php
/*
Plugin Name: myfpcaptcha
Plugin URI: http://www.flatpress.org
Description: Antispam using a captcha. Replacement for the Accessible Antispam Plugin
Author: NoWhereMan  (E.Vacchi) - amended to use Zubrag's captcha by pierovdfn & Stanley
Version: 1.0
Author URI: http://www.nowhereland.it

*/

define('AASPAM_DEBUG', false);
define('AASPAM_LOG', CACHE_DIR . 'aaspamlog.txt');

add_action('comment_validate', 'plugin_aaspam_validate');
add_action('comment_form', 'plugin_aaspam_comment_form');
## Add with other add_filter
add_action('init', 'plugin_aaspam_image');

function plugin_aaspam_validate() {
	
	// we test the result whether match user input
  
//  @session_start(); // start session if not started yet
if ($_SESSION['AntiSpamImage'] != md5(strtoupper($_REQUEST['anti_spam_code']))) {
  // set antispam string to something random, in order to avoid reusing it once again
  $_SESSION['AntiSpamImage'] = rand(1,9999999);

		global $smarty;
		$lang = lang_load('plugin:fpcaptcha');
      
 $smarty->append('error', $lang['plugin']['fpcaptcha']['error']);  
  	$success = 0;
}
else {
  // set antispam string to something random, in order to avoid reusing it once again
  $_SESSION['AntiSpamImage'] = rand(1,9999999);  
	$success = 1;  
}  

	return $success;
}  

function plugin_aaspam_comment_form() {
	
	// load plugin strings
	// they're located under plugin.PLUGINNAME/lang/LANGID/
	$lang = lang_load('plugin:fpcaptcha');
	
	$langstrings =& $lang['plugin']['fpcaptcha'];
	
## Add to print captcha (on my file, line 52):
	// echoes the question and the form part
	$image=BLOG_ROOT.'?fpcaptchaimage';
	echo <<<STR
	<p><label class="textlabel" for="aaspam">{$lang['plugin']['fpcaptcha']['prefix']} <img src="{$image}" align="left"></label><br />
		<input type="text" name="anti_spam_code" id="anti_spam_code" /></p>
STR;

}

function plugin_aaspam_image() {
	if(isset($_GET['fpcaptchaimage'])) {
		include dirname(__FILE__).'/antispam.php';
		die();
	}
}
?>

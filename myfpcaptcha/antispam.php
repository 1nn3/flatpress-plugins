<?php
###############################################################
# Anti-spam Image Generator (CAPTCHA) 1.0
###############################################################
# For updates visit http://www.zubrag.com/scripts/
############################################################### 

// Font name to use. Make sure it is available on the server.
// You could upload it to the same folder with script if it cannot find font.
// Choose your preferred font but make sure there are no licensing issues - here we use kindergarten.ttf which is free to use.
// putenv('GDFONTPATH=' . dirname(__FILE__));
 $font = dirname(__FILE__) .'/kindergarten.ttf';  // NWM's suggestion for those with putenv() disabled
// $font = 'kindergarten.ttf'; // Remember to use the correct case here

// list possible characters to include on the CAPTCHA  - here we've omitted any characters which might confuse people
$charset = '1234567890';
$charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

// how many characters include in the CAPTCHA
$code_length = 3;

// antispam image height
$height = 40;

// antispam image width
$width = 60;

$noise = 2.5; // 1.8

############################################################
#  END OF SETTINGS
############################################################

// this will start session if not started yet
#@session_start(); # Piero VDFN's note: use Flatpress' instead!

$code = '';
for($i=0; $i < $code_length; $i++) {
  $code .= substr($charset, mt_rand(0, strlen($charset)-1), 1);
}

$font_size = $height * 0.7;
$image = @imagecreate($width, $height);
$background_color = @imagecolorallocate($image, 255, 255, 255);
$noise_color = @imagecolorallocate($image, 20, 40, 100);

/* add image noise */
for($i=0; $i < ($width * $height) / $noise; $i++) {
  @imageellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
}
/* render text */
$text_color = @imagecolorallocate($image, 20, 40, 100);
@imagettftext($image, $font_size, 0, 2,27,
              $text_color, $font , $code)
  or die('Cannot render TTF text.');

/* output image to the browser */
header('Content-Type: image/png');
@imagepng($image) or die('imagepng error!');
@imagedestroy($image);
$_SESSION['AntiSpamImage'] = md5($code);   // bit more security added here
exit();
?>

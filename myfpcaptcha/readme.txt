This is a replacement for the accessibleantispam plugin for FlatPress.

YOU MUST DISABLE the accessibleantispam plugin before installing this plugin. Go to the control panel and click "disable" next to the accessibleantispam plugin.

The settings in antispam.php allow you to control the size and appearance of the captcha. You can use any TTF font which is free to use (i.e. there are no licensing issues - the default font is the licence-free kindergarten.ttf. Change the font at your own risk). Simply place the font file in the plugin folder and change the $font variable to show your font file name. Remember to use the same case - some servers work on systems which are case sensitive.

That's it. If it doen't work then take a look at the original source for the captcha and take a read through the comments there...

http://www.zubrag.com/scripts/antispam-image-generator.php

If all else fails, or you think it's specifically a FlatPress problem then try the FlatPress forum:

http://flatpress.org/vanilla2/

This has been tested on WAMP/XP and on Apache/Linux.
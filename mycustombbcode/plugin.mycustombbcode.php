<?php
/*
Plugin Name: mycustombbcode
Plugin URI: http://www.flatpress.org/
Description: MyCustomBBCode
Author: NoWhereMan
Version: 1.0
Author URI: http://www.nowhereland.it/
*/ 
 
 
// this will tell FlatPress to load the new tags at the very beginning 
 
add_filter('init', 'plugin_mycustombbcode');
 
// here you define a function. In this case we're creating an acronym tag
 
function plugin_mycustombbcode() {
       $bbcode = plugin_bbcode_init(); //import the "global" bbcode object into current function
                                         // this way 
                                         // a) parsing is done only once, and by the official plugin
                                         // b) you create only ONE object, and therefore computation is quicker
        $bbcode->addCode (
                    'acronym',  // tag name: this will go between square brackets
                    'callback_replace', // type of action: we'll use a callback function
                    'plugin_custombbcode_acronym', // name of the callback function
                    array('usecontent_param' => array ('default')), // supported parameters: "default" is [acronym=valore]
                    'inline', // type of the tag, inline or block, etc
                    array ('listitem', 'block', 'inline', 'link'), // type of elements in which you can use this tag
                    array ()); // type of elements where this tag CAN'T go (in this case, none, so it can go everywhere)
 
    $bbcode->setCodeFlag ('acronym', 'closetag', BBCODE_CLOSETAG_MUSTEXIST); // a closing tag is mandatory [/tag]


        $bbcode->addCode (
                    'listing',  // tag name: this will go between square brackets
                    'callback_replace', // type of action: we'll use a callback function
                    'plugin_custombbcode_listing', // name of the callback function
                    array('usecontent_param' => array ('default')), // supported parameters: "default" is [acronym=valore]
                    'block', // type of the tag, inline or block, etc
                    array ('listitem', 'block', 'inline', 'link'), // type of elements in which you can use this tag
                    array ()); // type of elements where this tag CAN'T go (in this case, none, so it can go everywhere)
 
    $bbcode->setCodeFlag ('listing', 'closetag', BBCODE_CLOSETAG_MUSTEXIST); // a closing tag is mandatory [/tag]
 
}
 
// $content is the text between the two tags, i.e. [tag]CONTAINED TEXT[/tag] $content='CONTAINED TEXT'
// $attributes is an associative array where keys are the tag properties. default is the [tagname=value] property
 
function plugin_custombbcode_acronym($action, $attributes, $content, $params, $node_object) { 
     if ($action == 'validate') {
        // not used for now
        return true;
     }
 
    // [acronym=css]Cascading Style Sheet[/acronym]
    // will become <acronym title="Cascading Style Sheet">css</acronym>
 
    return "<acronym title=\"$content\">{$attributes['default']}</acronym>";
 
 
}

function plugin_custombbcode_listing($action, $attributes, $content, $params, $node_object) { 
     if ($action == 'validate') {
        // not used for now
        return true;
     }

    #$f=BLOG_BASEURL . "fp-content/attachs/" . substr($content, 1, -1);
    $f=BLOG_BASEURL . "fp-content/attachs/" . $attributes['default'];
    $d="fp-content/attachs/" . $attributes['default'];
    $c=htmlspecialchars(file_get_contents($f));
    return "<pre>$c</pre>Download: <a href=\"$d\">$d</a>";
}
?>

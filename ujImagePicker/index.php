<?php
/**
 * Jamroom 5 ujImagePicker module
 *
 * copyright 2013 by Ultrajam - All Rights Reserved
 * http://www.ultrajam.net
 *
 * MIT License
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

//------------------------------
// docs (view the docs)
//------------------------------
function view_ujImagePicker_docs($_post,$_user,$_conf)
{
    // Set title, parse and return
    jrCore_page_title('ujImagePicker Docs');
    $out = ujBootstrap_read_docs($_post,$_user,$_conf,$_conf['ujImagePicker_bootstrap_version']);

    return $out;
}


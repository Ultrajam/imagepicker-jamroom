<?php
/**
 * Jamroom 5 ujImagePicker module
 *
 * copyright 2013 by Ultrajam - All Rights Reserved
 * http://www.jamroom.net
 *
 * @copyright 2013 Ultrajam
 * @author SteveX <stevex [at] ultrajam [dot] net>
 */

// make sure we are not being called directly
defined('APP_DIR') or exit();

/**
 * ujImagePicker_config
 */
function ujImagePicker_config()
{
    // Bootstrap version for ujImagePicker Docs
    $_versions = ujBootstrap_get_versions();
    $_tmp = array(
        'name'     => 'bootstrap_version',
        'label'    => 'bootstrap version',
        'type'     => 'select',
        'options'  => $_versions,
        'default'  => '3.0.0',
        'section'  => 'ujImagePicker Documentation',
        'help'     => 'Select the bootstrap version to use as a base.',
        'order'    => 10
    );
    jrCore_register_setting('ujImagePicker',$_tmp);
    
    return true;
}


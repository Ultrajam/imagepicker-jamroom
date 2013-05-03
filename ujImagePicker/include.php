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

/**
 * meta
 */
function ujImagePicker_meta() {
    $_tmp = array(
        'name'        => 'ImagePicker',
        'url'         => 'imagepicker',
        'version'     => '0.9.0',
        'developer'   => 'Ultrajam, &copy;' . strftime('%Y'),
        'description' => 'Provides an image picker and a multiple image picker as custom form fields.',
        'support'     => 'http://www.jamroom.net/phpBB2',
        'category'    => 'plugins'
    );
    return $_tmp;
}

/**
 * init
 */
function ujImagePicker_init() {
    // register the custom form field
    jrCore_register_module_feature('jrCore','form_field','ujImagePicker','imagepicker');
    jrCore_register_module_feature('jrCore','form_field','ujImagePicker','imagepicker_multiple');
    
    return true;
}

// test array
function ujImagePicker_choose_a_kitten()
{
    $arr = array(
        '1'    =>    'http://placekitten.com/120/100',
        '2'    =>    'http://placekitten.com/160/100',
        '3'    =>    'http://placekitten.com/110/100',
        '4'    =>    'http://placekitten.com/130/100',
        '5'    =>    'http://placekitten.com/150/100'
    );
    return $arr;
}
// test array with labels
function ujImagePicker_choose_a_labelled_kitten()
{
    $arr = array(
        'cute'    =>    array('img_src'=>'http://placekitten.com/120/100','label'=>'cute kitten'),
        'cuter'   =>    array('img_src'=>'http://placekitten.com/160/100','label'=>'cuter kitten'),
        'cutest'  =>    array('img_src'=>'http://placekitten.com/110/100','label'=>'cutest kitten'),
        'yuck'    =>    array('img_src'=>'http://placekitten.com/130/100','label'=>'unpleasant kitten'),
        'sucker'  =>    array('img_src'=>'http://placekitten.com/150/100','label'=>'dog in disguise')
    );
    return $arr;
}

// test array showing select
// function ujImagePicker_choose_a_kitten_show_select()
// {
//     $arr = array(
//         'show_select'    =>    true,
//         '1'    =>    'http://placekitten.com/120/100',
//         '2'    =>    'http://placekitten.com/160/100',
//         '3'    =>    'http://placekitten.com/110/100'
//     );
//     return $arr;
// }

/**
 * @ignore
 * ujImagePicker_form_field_imagepicker_display
 * @param array $_field Array of Field parameters
 * @param array $_att Additional HTML parameters
 * @return bool
 *
 * <!ELEMENT SELECT - - (OPTGROUP|OPTION)+ -- option selector -->
 * <!ATTLIST SELECT
 *   %attrs;                              -- %coreattrs, %i18n, %events --
 *   name        CDATA          #IMPLIED  -- field name --
 *   size        NUMBER         #IMPLIED  -- rows visible --
 *   multiple    (multiple)     #IMPLIED  -- default is single selection --
 *   disabled    (disabled)     #IMPLIED  -- unavailable in this context --
 *   tabindex    NUMBER         #IMPLIED  -- position in tabbing order --
 *   onfocus     %Script;       #IMPLIED  -- the element got the focus --
 *   onblur      %Script;       #IMPLIED  -- the element lost the focus --
 *   onchange    %Script;       #IMPLIED  -- the element value was changed --
 *   >
 */
function ujImagePicker_form_field_imagepicker_display($_field,$_att = null)
{
    global $_conf;
    // add css and js
    $tmp = jrCore_get_flag('jrcore_imagepicker_js_included');
    if (!$tmp) {
        $_js = array('source' => "{$_conf['jrCore_base_url']}/modules/ujImagePicker/contrib/image-picker/image-picker.js");
        jrCore_create_page_element('javascript_href',$_js);
        $_js = array('source' => "{$_conf['jrCore_base_url']}/modules/ujImagePicker/contrib/image-picker/image-picker.css");
        jrCore_create_page_element('css_href',$_js);
        jrCore_set_flag('jrcore_imagepicker_js_included',1);
    }
    // Get our tab index
    $idx = jrCore_form_field_get_tab_index($_field);
    $cls = 'form_imagepicker image-picker' . jrCore_form_field_get_hilight($_field['name']);
    $htm = '<select id="'. $_field['name'] .'" class="'. $cls .'" name="'. $_field['name'] .'" tabindex="'. $idx .'"';
    if (isset($_att) && is_array($_att)) {
        foreach ($_att as $key => $attr) {
            $htm .= ' '. $key .'="'. $attr .'"';
        }
    }
    $htm .= '>';
    if (isset($_field['options']) && !is_array($_field['options']) && strlen($_field['options']) > 0) {
        // JSON encoded options
        if (strpos($_field['options'],'{') === 0 || strpos($_field['options'],'[') === 0) {
            $_field['options'] = json_decode($_field['options'],true);
        }
        // function
        elseif (function_exists($_field['options'])) {
            $_field['options'] = $_field['options']();
        }
    }
    $hide_select = 'true';
    if (isset($_field['options']['show_select'])) {
        $hide_select = 'false';
        unset($_field['options']['show_select']);
    }
    $show_label = 'false';
    if (isset($_field['options']) && is_array($_field['options'])) {
        foreach ($_field['options'] as $k => $img_src) {
            $label = '';
            if (is_array($img_src)) {
                // label data attached 
                $label = ' data-img-label="'.$img_src['label'].'"';
                $img_src = $img_src['img_src'];
                $show_label = 'true';
            }
            if (isset($_field['value']) && strlen($_field['value']) > 0 && $_field['value'] == "{$k}") {
                $htm .= '<option'.$label.' data-img-src="'.$img_src.'" value="'. $k .'" selected="selected"> '. $v .'</option>'."\n";
            }
            elseif ((!isset($_field['value']) || strlen($_field['value']) === 0) && (isset($_field['default']) && $_field['default'] == "{$k}")) {
                $htm .= '<option'.$label.' data-img-src="'.$img_src.'" value="'. $k .'" selected="selected"> '. $v .'</option>'."\n";
            }
            else {
                $htm .= '<option'.$label.' data-img-src="'.$img_src.'" value="'. $k .'"> '. $v .'</option>'."\n";
            }
        }
    }
    $htm .= '</select>';
    $_js = array("$('#{$_field['name']}').imagepicker({ hide_select: {$hide_select}, show_label: {$show_label} });");
    jrCore_create_page_element('javascript_ready_function',$_js);
    $_field['html']     = $htm;
    $_field['type']     = 'imagepicker';
    $_field['template'] = 'form_field_elements.tpl';
    jrCore_create_page_element('page',$_field);
    return true;
}

/**
 * @ignore
 * Additional form field HTML attributes that can be passed in via the form
 * @return array
 */
function ujImagePicker_form_field_imagepicker_attributes()
{
    return array('size','disabled','onfocus','onblur','onchange');
}
/**
 * @ignore
 * ujImagePicker_form_field_imagepicker_validate
 * @param array $_field Array of form field info
 * @param array $_post Global $_post from jrCore_parse_url()
 * @param string $e_msg Error message for form validation
 * @return array
 */
function ujImagePicker_form_field_imagepicker_validate($_field,$_post,$e_msg)
{
    if (isset($_field['options']) && !is_array($_field['options']) && strlen($_field['options']) > 0) {
        // JSON encoded options
        if (strpos($_field['options'],'{') === 0 || strpos($_field['options'],'[') === 0) {
            $_field['options'] = json_decode($_field['options'],true);
        }
        // function
        elseif (function_exists($_field['options'])) {
            $_field['options'] = $_field['options']();
        }
    }
    if (!isset($_field['options']) || !is_array($_field['options'])) {
        jrCore_set_form_notice('error',"invalid options received for field: {$_field['label']}");
        jrCore_form_result();
    }
    $name = $_post["{$_field['name']}"];
    // Our value must be in the option list
    if (!isset($_field['options'][$name])) {
        jrCore_set_form_notice('error',$e_msg);
        jrCore_form_field_hilight($_field['name']);
        return false;
    }
    return $_post;
}


/**
 * @ignore
 * ujImagePicker_form_field_imagepicker_multiple_display
 * @param array $_field Array of Field parameters
 * @param array $_att Additional HTML parameters
 * @return bool
 *
 * <!ELEMENT SELECT - - (OPTGROUP|OPTION)+ -- option selector -->
 * <!ATTLIST SELECT
 *   %attrs;                              -- %coreattrs, %i18n, %events --
 *   name        CDATA          #IMPLIED  -- field name --
 *   size        NUMBER         #IMPLIED  -- rows visible --
 *   multiple    (multiple)     #IMPLIED  -- default is single selection --
 *   disabled    (disabled)     #IMPLIED  -- unavailable in this context --
 *   tabindex    NUMBER         #IMPLIED  -- position in tabbing order --
 *   onfocus     %Script;       #IMPLIED  -- the element got the focus --
 *   onblur      %Script;       #IMPLIED  -- the element lost the focus --
 *   onchange    %Script;       #IMPLIED  -- the element value was changed --
 *   >
 */
function ujImagePicker_form_field_imagepicker_multiple_display($_field,$_att = null)
{
    global $_conf;
    // add css and js
    $tmp = jrCore_get_flag('jrcore_imagepicker_js_included');
    if (!$tmp) {
        $_js = array('source' => "{$_conf['jrCore_base_url']}/modules/ujImagePicker/contrib/image-picker/image-picker.js");
        jrCore_create_page_element('javascript_href',$_js);
        $_js = array('source' => "{$_conf['jrCore_base_url']}/modules/ujImagePicker/contrib/image-picker/image-picker.css");
        jrCore_create_page_element('css_href',$_js);
        jrCore_set_flag('jrcore_imagepicker_js_included',1);
    }
    // Get our tab index
    $idx = jrCore_form_field_get_tab_index($_field);
    $cls = 'form_imagepicker form_imagepicker_multiple image-picker' . jrCore_form_field_get_hilight($_field['name']);
    $htm = '<select multiple="multiple" id="'. $_field['name'] .'" class="'. $cls .'" name="'. $_field['name'] .'[]" tabindex="'. $idx .'"';
    if (!isset($_att['size'])) {
        //$_att['size'] = 8;
    }
    if (isset($_att) && is_array($_att)) {
        foreach ($_att as $key => $attr) {
            $htm .= ' '. $key .'="'. $attr .'"';
        }
    }
    $htm .= '>';
    if (!is_array($_field['value']) && isset($_field['value']) && strpos($_field['value'],',')) {
        $_field['value'] = explode(',',$_field['value']);
    }
    if (isset($_field['options']) && !is_array($_field['options']) && strlen($_field['options']) > 0) {
        // JSON encoded options
        if (strpos($_field['options'],'{') === 0 || strpos($_field['options'],'[') === 0) {
            $_field['options'] = json_decode($_field['options'],true);
        }
        // function
        elseif (function_exists($_field['options'])) {
            $_field['options'] = $_field['options']();
        }
    }
    $hide_select = 'true';
    if (isset($_field['options']['show_select'])) {
        $hide_select = 'false';
        unset($_field['options']['show_select']);
    }
    $show_label = 'false';
    if (isset($_field['options']) && is_array($_field['options'])) {
        foreach ($_field['options'] as $k => $img_src) {
            $label = '';
            if (is_array($img_src)) {
                // label data attached 
                $label = ' data-img-label="'.$img_src['label'].'"';
                $img_src = $img_src['img_src'];
                $show_label = 'true';
            }
            if (isset($_field['value']) && is_array($_field['value']) && in_array($k,$_field['value'])) {
                $htm .= '<option'.$label.' data-img-src="'.$img_src.'" value="'. $k .'" selected="selected"> '. $v .'</option>'."\n";
            }
            elseif (isset($_field['value']) && !is_array($_field['value']) && strlen($_field['value']) > 0 && $_field['value'] == "{$k}") {
                $htm .= '<option'.$label.' data-img-src="'.$img_src.'" value="'. $k .'" selected="selected"> '. $v .'</option>'."\n";
            }
            // elseif ((!isset($_field['value']) || strlen($_field['value']) === 0) && (isset($_field['default']) && $_field['default'] == "{$k}")) {
            elseif (isset($_field['default']) && $_field['default'] == "{$k}") {
                $htm .= '<option'.$label.' data-img-src="'.$img_src.'" value="'. $k .'" selected="selected"> '. $v .'</option>'."\n";
            }
            else {
                $htm .= '<option'.$label.' data-img-src="'.$img_src.'" value="'. $k .'"> '. $v .'</option>'."\n";
            }
        }
    }
    $htm .= '</select>';
    $_js = array("$('#{$_field['name']}').imagepicker({ hide_select: {$hide_select}, show_label: {$show_label} });");
    jrCore_create_page_element('javascript_ready_function',$_js);
    $_field['html']     = $htm;
    $_field['type']     = 'imagepicker_multiple';
    $_field['template'] = 'form_field_elements.tpl';
    jrCore_create_page_element('page',$_field);
    return true;
}
/**
 * @ignore
 * Additional form field HTML attributes that can be passed in via the form
 * @return array
 */
function ujImagePicker_form_field_imagepicker_multiple_attributes()
{
    return array('size','disabled','onfocus','onblur','onchange');
}
/**
 * @ignore
 * ujImagePicker_form_field_imagepicker_multiple_validate
 * @param array $_field Array of form field info
 * @param array $_post Global $_post from jrCore_parse_url()
 * @param string $e_msg Error message for validation
 * @return array
 */
function ujImagePicker_form_field_imagepicker_multiple_validate($_field,$_post,$e_msg)
{
    if (isset($_field['options']) && !is_array($_field['options']) && strlen($_field['options']) > 0) {
        // JSON encoded options
        if (strpos($_field['options'],'{') === 0 || strpos($_field['options'],'[') === 0) {
            $_field['options'] = json_decode($_field['options'],true);
        }
        // function
        elseif (function_exists($_field['options'])) {
            $_field['options'] = $_field['options']();
        }
    }
    if (!isset($_field['options']) || !is_array($_field['options'])) {
        jrCore_set_form_notice('error',"invalid options received for field: {$_field['label']}");
        jrCore_form_result();
    }
    // Our value will come in as an array
    if (!isset($_post["{$_field['name']}"]) || !is_array($_post["{$_field['name']}"])) {
        return false;
    }
    foreach ($_post["{$_field['name']}"] as $v) {
        // For each selected value submitted, it must be part of the options
        if (!isset($_field['options'][$v])) {
            jrCore_set_form_notice('error',$e_msg);
            return false;
        }
    }
    $_post["{$_field['name']}"] = implode(',',$_post["{$_field['name']}"]);
    return $_post;
}

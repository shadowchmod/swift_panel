<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_function_html_checkboxes( $params, &$smarty )
{
    require_once( $smarty->_get_plugin_filepath( "shared", "escape_special_chars" ) );
    $name = "checkbox";
    $values = NULL;
    $options = NULL;
    $selected = NULL;
    $separator = "";
    $labels = TRUE;
    $output = NULL;
    $extra = "";
    foreach ( $params as $_key => $_val )
    {
        switch ( $_key )
        {
        case "name" :
        case "separator" :
            $$_key = $_val;
            break;
        case "labels" :
            $$_key = ( string )$_val;
            break;
        case "options" :
            $$_key = ( array )$_val;
            break;
        case "values" :
        case "output" :
            $$_key = array_values( ( array )$_val );
            break;
        case "checked" :
        case "selected" :
            $selected = array_map( "strval", array_values( ( array )$_val ) );
            break;
        case "checkboxes" :
            $smarty->trigger_error( "html_checkboxes: the use of the \"checkboxes\" attribute is deprecated, use \"options\" instead", E_USER_WARNING );
            $options = ( array )$_val;
            break;
        case "assign" :
            break;
        }
        do
        {
            if ( !is_array( $_val ) )
            {
                $extra .= " ".$_key."=\"".smarty_function_escape_special_chars( $_val )."\"";
            }
            else
            {
                $smarty->trigger_error( "html_checkboxes: extra attribute '{$_key}' cannot be an array", E_USER_NOTICE );
            }
            break;
        } while ( 1 );
    }
    if ( !isset( $options ) && !isset( $values ) )
    {
        return "";
    }
    settype( $selected, "array" );
    $_html_result = array( );
    if ( isset( $options ) )
    {
        foreach ( $options as $_key => $_val )
        {
            $_html_result[] = smarty_function_html_checkboxes_output( $name, $_key, $_val, $selected, $extra, $separator, $labels );
        }
    }
    else
    {
        foreach ( $values as $_i => $_key )
        {
            $_val = isset( $output[$_i] ) ? $output[$_i] : "";
            $_html_result[] = smarty_function_html_checkboxes_output( $name, $_key, $_val, $selected, $extra, $separator, $labels );
        }
    }
    if ( !empty( $params['assign'] ) )
    {
        $smarty->assign( $params['assign'], $_html_result );
    }
    else
    {
        return implode( "\n", $_html_result );
    }
}

function smarty_function_html_checkboxes_output( $name, $value, $output, $selected, $extra, $separator, $labels )
{
    $_output = "";
    if ( $labels )
    {
        $_output .= "<label>";
    }
    $_output .= "<input type=\"checkbox\" name=\"".smarty_function_escape_special_chars( $name )."[]\" value=\"".smarty_function_escape_special_chars( $value )."\"";
    if ( in_array( ( boolean )$value, $selected ) )
    {
        $_output .= " checked=\"checked\"";
    }
    $_output .= $extra." />".$output;
    if ( $labels )
    {
        $_output .= "</label>";
    }
    $_output .= $separator;
    return $_output;
}

?>

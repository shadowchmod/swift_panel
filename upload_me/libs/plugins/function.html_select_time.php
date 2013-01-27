<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_function_html_select_time( $params, &$smarty )
{
    require_once( $smarty->_get_plugin_filepath( "shared", "make_timestamp" ) );
    require_once( $smarty->_get_plugin_filepath( "function", "html_options" ) );
    $prefix = "Time_";
    $time = time( );
    $display_hours = TRUE;
    $display_minutes = TRUE;
    $display_seconds = TRUE;
    $display_meridian = TRUE;
    $use_24_hours = TRUE;
    $minute_interval = 1;
    $second_interval = 1;
    $field_array = NULL;
    $all_extra = NULL;
    $hour_extra = NULL;
    $minute_extra = NULL;
    $second_extra = NULL;
    $meridian_extra = NULL;
    foreach ( $params as $_key => $_value )
    {
        switch ( $_key )
        {
        case "prefix" :
        case "time" :
        case "field_array" :
        case "all_extra" :
        case "hour_extra" :
        case "minute_extra" :
        case "second_extra" :
        case "meridian_extra" :
            $$_key = ( boolean )$_value;
            break;
        case "display_hours" :
        case "display_minutes" :
        case "display_seconds" :
        case "display_meridian" :
        case "use_24_hours" :
            $$_key = ( string )$_value;
            break;
        case "minute_interval" :
        case "second_interval" :
            $$_key = ( integer )$_value;
            break;
        }
        do
        {
            $smarty->trigger_error( "[html_select_time] unknown parameter {$_key}", E_USER_WARNING );
            break;
        } while ( 1 );
    }
    $time = smarty_make_timestamp( $time );
    $html_result = "";
    if ( $display_hours )
    {
        $hours = $use_24_hours ? range( 0, 23 ) : range( 1, 12 );
        $hour_fmt = $use_24_hours ? "%H" : "%I";
        $i = 0;
        $for_max = count( $hours );
        for ( ; $i < $for_max; $i++ )
        {
            $hours[$i] = sprintf( "%02d", $hours[$i] );
        }
        $html_result .= "<select name=";
        if ( NULL !== $field_array )
        {
            $html_result .= "\"".$field_array."[".$prefix."Hour]\"";
        }
        else
        {
            $html_result .= "\"".$prefix."Hour\"";
        }
        if ( NULL !== $hour_extra )
        {
            $html_result .= " ".$hour_extra;
        }
        if ( NULL !== $all_extra )
        {
            $html_result .= " ".$all_extra;
        }
        $html_result .= ">"."\n";
        $html_result .= smarty_function_html_options( array(
            "output" => $hours,
            "values" => $hours,
            "selected" => strftime( $hour_fmt, $time ),
            "print_result" => FALSE
        ), $smarty );
        $html_result .= "</select>\n";
    }
    if ( $display_minutes )
    {
        $all_minutes = range( 0, 59 );
        $i = 0;
        $for_max = count( $all_minutes );
        for ( ; $i < $for_max; $i += $minute_interval )
        {
            $minutes[] = sprintf( "%02d", $all_minutes[$i] );
        }
        $selected = intval( floor( strftime( "%M", $time ) / $minute_interval ) * $minute_interval );
        $html_result .= "<select name=";
        if ( NULL !== $field_array )
        {
            $html_result .= "\"".$field_array."[".$prefix."Minute]\"";
        }
        else
        {
            $html_result .= "\"".$prefix."Minute\"";
        }
        if ( NULL !== $minute_extra )
        {
            $html_result .= " ".$minute_extra;
        }
        if ( NULL !== $all_extra )
        {
            $html_result .= " ".$all_extra;
        }
        $html_result .= ">"."\n";
        $html_result .= smarty_function_html_options( array(
            "output" => $minutes,
            "values" => $minutes,
            "selected" => $selected,
            "print_result" => FALSE
        ), $smarty );
        $html_result .= "</select>\n";
    }
    if ( $display_seconds )
    {
        $all_seconds = range( 0, 59 );
        $i = 0;
        $for_max = count( $all_seconds );
        for ( ; $i < $for_max; $i += $second_interval )
        {
            $seconds[] = sprintf( "%02d", $all_seconds[$i] );
        }
        $selected = intval( floor( strftime( "%S", $time ) / $second_interval ) * $second_interval );
        $html_result .= "<select name=";
        if ( NULL !== $field_array )
        {
            $html_result .= "\"".$field_array."[".$prefix."Second]\"";
        }
        else
        {
            $html_result .= "\"".$prefix."Second\"";
        }
        if ( NULL !== $second_extra )
        {
            $html_result .= " ".$second_extra;
        }
        if ( NULL !== $all_extra )
        {
            $html_result .= " ".$all_extra;
        }
        $html_result .= ">"."\n";
        $html_result .= smarty_function_html_options( array(
            "output" => $seconds,
            "values" => $seconds,
            "selected" => $selected,
            "print_result" => FALSE
        ), $smarty );
        $html_result .= "</select>\n";
    }
    if ( $display_meridian && !$use_24_hours )
    {
        $html_result .= "<select name=";
        if ( NULL !== $field_array )
        {
            $html_result .= "\"".$field_array."[".$prefix."Meridian]\"";
        }
        else
        {
            $html_result .= "\"".$prefix."Meridian\"";
        }
        if ( NULL !== $meridian_extra )
        {
            $html_result .= " ".$meridian_extra;
        }
        if ( NULL !== $all_extra )
        {
            $html_result .= " ".$all_extra;
        }
        $html_result .= ">"."\n";
        $html_result .= smarty_function_html_options( array(
            "output" => array( "AM", "PM" ),
            "values" => array( "am", "pm" ),
            "selected" => strtolower( strftime( "%p", $time ) ),
            "print_result" => FALSE
        ), $smarty );
        $html_result .= "</select>\n";
    }
    return $html_result;
}

?>

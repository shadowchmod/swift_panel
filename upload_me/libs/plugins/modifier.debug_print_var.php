<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_debug_print_var( $var, $depth = 0, $length = 40 )
{
    $_replace = array( "\n" => "<i>\\n</i>", "\r" => "<i>\\r</i>", "\t" => "<i>\\t</i>" );
    switch ( gettype( $var ) )
    {
    case "array" :
        $results = "<b>Array (".count( $var ).")</b>";
        foreach ( $var as $curr_key => $curr_val )
        {
            $results .= "<br>".str_repeat( "&nbsp;", $depth * 2 )."<b>".strtr( $curr_key, $_replace )."</b> =&gt; ".smarty_modifier_debug_print_var( $curr_val, ++$depth, $length );
            $depth--;
        }
        break;
    case "object" :
        $object_vars = get_object_vars( $var );
        $results = "<b>".get_class( $var )." Object (".count( $object_vars ).")</b>";
        foreach ( $object_vars as $curr_key => $curr_val )
        {
            $results .= "<br>".str_repeat( "&nbsp;", $depth * 2 )."<b> -&gt;".strtr( $curr_key, $_replace )."</b> = ".smarty_modifier_debug_print_var( $curr_val, ++$depth, $length );
            $depth--;
        }
        break;
    case "boolean" :
    case "NULL" :
    case "resource" :
        if ( TRUE === $var )
        {
            $results = "true";
        }
        else if ( FALSE === $var )
        {
            $results = "false";
        }
        else if ( NULL === $var )
        {
            $results = "null";
        }
        else
        {
            $results = htmlspecialchars( ( boolean )$var );
        }
        $results = "<i>".$results."</i>";
        break;
    case "integer" :
    case "float" :
        $results = htmlspecialchars( ( boolean )$var );
        break;
    case "string" :
        $results = strtr( $var, $_replace );
        if ( $length < strlen( $var ) )
        {
            $results = substr( $var, 0, $length - 3 )."...";
        }
        $results = htmlspecialchars( "\"".$results."\"" );
        break;
    case "unknown type" :
    default :
        do
        {
            $results = strtr( ( boolean )$var, $_replace );
            if ( $length < strlen( $results ) )
            {
                $results = substr( $results, 0, $length - 3 )."...";
            }
            $results = htmlspecialchars( $results );
            break;
        } while ( 1 );
    }
    return $results;
}

?>

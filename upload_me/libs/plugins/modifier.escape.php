<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_escape( $string, $esc_type = "html", $char_set = "ISO-8859-1" )
{
    switch ( $esc_type )
    {
    case "html" :
        return htmlspecialchars( $string, ENT_QUOTES, $char_set );
    case "htmlall" :
        return htmlentities( $string, ENT_QUOTES, $char_set );
    case "url" :
        return rawurlencode( $string );
    case "urlpathinfo" :
        return str_replace( "%2F", "/", rawurlencode( $string ) );
    case "quotes" :
        return preg_replace( "%(?<!\\\\)'%", "\\'", $string );
    case "hex" :
        $return = "";
        $x = 0;
        for ( ; $x < strlen( $string ); $x++ )
        {
            $return .= "%".bin2hex( $string[$x] );
        }
        return $return;
    case "hexentity" :
        $return = "";
        $x = 0;
        for ( ; $x < strlen( $string ); $x++ )
        {
            $return .= "&#x".bin2hex( $string[$x] ).";";
        }
        return $return;
    case "decentity" :
        $return = "";
        $x = 0;
        for ( ; $x < strlen( $string ); $x++ )
        {
            $return .= "&#".ord( $string[$x] ).";";
        }
        return $return;
    case "javascript" :
        return strtr( $string, array( "\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\\/" ) );
    case "mail" :
        return str_replace( array( "@", "." ), array( " [AT] ", " [DOT] " ), $string );
    case "nonstd" :
        $_res = "";
        $_i = 0;
        $_len = strlen( $string );
        for ( ; $_i < $_len; $_i++ )
        {
            $_ord = ord( substr( $string, $_i, 1 ) );
            if ( 126 <= $_ord )
            {
                $_res .= "&#".$_ord.";";
            }
            else
            {
                $_res .= substr( $string, $_i, 1 );
            }
        }
        return $_res;
    }
    do
    {
        return $string;
    } while ( 1 );
}

?>

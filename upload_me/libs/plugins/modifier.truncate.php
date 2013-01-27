<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_truncate( $string, $length = 80, $etc = "...", $break_words = FALSE, $middle = FALSE )
{
    if ( $length == 0 )
    {
        return "";
    }
    if ( $length < strlen( $string ) )
    {
        $length -= min( $length, strlen( $etc ) );
        if ( !$break_words && !$middle )
        {
            $string = preg_replace( "/\\s+?(\\S+)?\$/", "", substr( $string, 0, $length + 1 ) );
        }
        if ( !$middle )
        {
            return substr( $string, 0, $length ).$etc;
        }
        else
        {
            return substr( $string, 0, $length / 2 ).$etc.substr( $string, 0 - $length / 2 );
        }
    }
    else
    {
        return $string;
    }
}

?>

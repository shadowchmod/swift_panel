<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_make_timestamp( $string )
{
    if ( empty( $string ) )
    {
        $time = time( );
    }
    else if ( preg_match( "/^\\d{14}\$/", $string ) )
    {
        $time = mktime( substr( $string, 8, 2 ), substr( $string, 10, 2 ), substr( $string, 12, 2 ), substr( $string, 4, 2 ), substr( $string, 6, 2 ), substr( $string, 0, 4 ) );
    }
    else if ( is_numeric( $string ) )
    {
        $time = ( integer )$string;
    }
    else
    {
        $time = strtotime( $string );
        if ( $time == 0 - 1 || $time === FALSE )
        {
            $time = time( );
        }
    }
    return $time;
}

?>

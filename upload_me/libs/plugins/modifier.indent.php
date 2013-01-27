<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_indent( $string, $chars = 4, $char = " " )
{
    return preg_replace( "!^!m", str_repeat( $char, $chars ), $string );
}

?>

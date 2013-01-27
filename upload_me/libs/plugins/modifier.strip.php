<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_strip( $text, $replace = " " )
{
    return preg_replace( "!\\s+!", $replace, $text );
}

?>

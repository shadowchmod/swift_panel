<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_spacify( $string, $spacify_char = " " )
{
    return implode( $spacify_char, preg_split( "//", $string, 0 - 1, PREG_SPLIT_NO_EMPTY ) );
}

?>

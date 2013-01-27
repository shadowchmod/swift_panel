<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_replace( $string, $search, $replace )
{
    return str_replace( $search, $replace, $string );
}

?>

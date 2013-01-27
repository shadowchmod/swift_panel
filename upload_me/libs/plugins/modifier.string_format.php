<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_string_format( $string, $format )
{
    return sprintf( $format, $string );
}

?>

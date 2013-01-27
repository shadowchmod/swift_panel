<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_wordwrap( $string, $length = 80, $break = "\n", $cut = FALSE )
{
    return wordwrap( $string, $length, $break, $cut );
}

?>

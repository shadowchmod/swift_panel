<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_count_paragraphs( $string )
{
    return count( preg_split( "/[\\r\\n]+/", $string ) );
}

?>

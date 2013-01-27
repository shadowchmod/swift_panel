<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_count_sentences( $string )
{
    return preg_match_all( "/[^\\s]\\.(?!\\w)/", $string, $match );
}

?>

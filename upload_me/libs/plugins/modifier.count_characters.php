<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_count_characters( $string, $include_spaces = FALSE )
{
    if ( $include_spaces )
    {
        return strlen( $string );
    }
    return preg_match_all( "/[^\\s]/", $string, $match );
}

?>

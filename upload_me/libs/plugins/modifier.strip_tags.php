<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_strip_tags( $string, $replace_with_space = TRUE )
{
    if ( $replace_with_space )
    {
        return preg_replace( "!<[^>]*?>!", " ", $string );
    }
    else
    {
        return strip_tags( $string );
    }
}

?>

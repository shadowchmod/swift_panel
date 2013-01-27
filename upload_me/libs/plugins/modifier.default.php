<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_modifier_default( $string, $default = "" )
{
    if ( !isset( $string ) || $string === "" )
    {
        return $default;
    }
    else
    {
        return $string;
    }
}

?>

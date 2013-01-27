<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_core_get_microtime( $params, &$smarty )
{
    $mtime = microtime( );
    $mtime = explode( " ", $mtime );
    $mtime = ( double )$mtime[1] + ( double )$mtime[0];
    return $mtime;
}

?>

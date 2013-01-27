<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_core_process_compiled_include( $params, &$smarty )
{
    $_cache_including = $smarty->_cache_including;
    $smarty->_cache_including = TRUE;
    $_return = $params['results'];
    foreach ( $smarty->_cache_info['cache_serials'] as $_include_file_path => $_cache_serial )
    {
        $smarty->_include( $_include_file_path, TRUE );
    }
    foreach ( $smarty->_cache_info['cache_serials'] as $_include_file_path => $_cache_serial )
    {
        $_return = preg_replace_callback( "!(\\{nocache\\:(".$_cache_serial.")#(\\d+)\\})!s", array(
            $smarty,
            "_process_compiled_include_callback"
        ), $_return );
    }
    $smarty->_cache_including = $_cache_including;
    return $_return;
}

?>

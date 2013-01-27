<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_core_rm_auto( $params, &$smarty )
{
    if ( !is_dir( $params['auto_base'] ) )
    {
        return FALSE;
    }
    if ( !isset( $params['auto_id'] ) && !isset( $params['auto_source'] ) )
    {
        $_params = array(
            "dirname" => $params['auto_base'],
            "level" => 0,
            "exp_time" => $params['exp_time']
        );
        require_once( SMARTY_CORE_DIR."core.rmdir.php" );
        $_res = smarty_core_rmdir( $_params, $smarty );
    }
    else
    {
        $_tname = $smarty->_get_auto_filename( $params['auto_base'], $params['auto_source'], $params['auto_id'] );
        if ( isset( $params['auto_source'] ) )
        {
            if ( isset( $params['extensions'] ) )
            {
                $_res = FALSE;
                foreach ( ( array )$params['extensions'] as $_extension )
                {
                    $_res |= $smarty->_unlink( $_tname.$_extension, $params['exp_time'] );
                }
            }
            else
            {
                $_res = $smarty->_unlink( $_tname, $params['exp_time'] );
            }
        }
        else if ( $smarty->use_sub_dirs )
        {
            $_params = array(
                "dirname" => $_tname,
                "level" => 1,
                "exp_time" => $params['exp_time']
            );
            require_once( SMARTY_CORE_DIR."core.rmdir.php" );
            $_res = smarty_core_rmdir( $_params, $smarty );
        }
        else
        {
            $_handle = opendir( $params['auto_base'] );
            $_res = TRUE;
            while ( FALSE !== ( $_filename = readdir( $_handle ) ) )
            {
                if ( $_filename == "." || $_filename == ".." )
                {
                    continue;
                }
                else if ( substr( $params['auto_base'].DIRECTORY_SEPARATOR.$_filename, 0, strlen( $_tname ) ) == $_tname )
                {
                    $_res &= ( string )$smarty->_unlink( $params['auto_base'].DIRECTORY_SEPARATOR.$_filename, $params['exp_time'] );
                }
            }
        }
    }
    return $_res;
}

?>

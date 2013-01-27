<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_core_rmdir( $params, &$smarty )
{
    if ( !isset( $params['level'] ) )
    {
        $params['level'] = 1;
    }
    if ( !isset( $params['exp_time'] ) )
    {
        $params['exp_time'] = NULL;
    }
    if ( $_handle = @opendir( $params['dirname'] ) )
    {
        while ( FALSE !== ( $_entry = readdir( $_handle ) ) )
        {
            if ( $_entry != "." && $_entry != ".." )
            {
                if ( @is_dir( $params['dirname'].DIRECTORY_SEPARATOR.$_entry ) )
                {
                    $_params = array(
                        "dirname" => $params['dirname'].DIRECTORY_SEPARATOR.$_entry,
                        "level" => $params['level'] + 1,
                        "exp_time" => $params['exp_time']
                    );
                    smarty_core_rmdir( $_params, $smarty );
                }
                else
                {
                    $smarty->_unlink( $params['dirname'].DIRECTORY_SEPARATOR.$_entry, $params['exp_time'] );
                }
            }
        }
        closedir( $_handle );
    }
    if ( $params['level'] )
    {
        return rmdir( $params['dirname'] );
    }
    return ( string )$_handle;
}

?>

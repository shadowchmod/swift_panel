<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_core_is_secure( $params, &$smarty )
{
    if ( !$smarty->security || $smarty->security_settings['INCLUDE_ANY'] )
    {
        return TRUE;
    }
    if ( $params['resource_type'] == "file" )
    {
        $_rp = realpath( $params['resource_name'] );
        if ( isset( $params['resource_base_path'] ) )
        {
            foreach ( ( array )$params['resource_base_path'] as $curr_dir )
            {
                if ( ( $_cd = realpath( $curr_dir ) ) !== FALSE && strncmp( $_rp, $_cd, strlen( $_cd ) ) == 0 && substr( $_rp, strlen( $_cd ), 1 ) == DIRECTORY_SEPARATOR )
                {
                    return TRUE;
                }
            }
        }
        if ( !empty( $smarty->secure_dir ) )
        {
            foreach ( ( array )$smarty->secure_dir as $curr_dir )
            {
                if ( ( $_cd = realpath( $curr_dir ) ) !== FALSE )
                {
                    if ( $_cd == $_rp )
                    {
                        return TRUE;
                    }
                    else if ( strncmp( $_rp, $_cd, strlen( $_cd ) ) == 0 && substr( $_rp, strlen( $_cd ), 1 ) == DIRECTORY_SEPARATOR )
                    {
                        return TRUE;
                    }
                }
            }
        }
    }
    else
    {
        return call_user_func_array( $smarty->_plugins['resource'][$params['resource_type']][0][2], array(
            $params['resource_name'],
            $smarty
        ) );
    }
    return FALSE;
}

?>

<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_core_load_resource_plugin( $params, &$smarty )
{
    $_plugin =& $smarty->_plugins['resource'][$params['type']];
    if ( isset( $_plugin ) )
    {
        if ( !$_plugin[1] && count( $_plugin[0] ) )
        {
            $_plugin[1] = TRUE;
            foreach ( $_plugin[0] as $_plugin_func )
            {
                if ( !is_callable( $_plugin_func ) )
                {
                    $_plugin[1] = FALSE;
                    break;
                }
            }
        }
        if ( !$_plugin[1] )
        {
            $smarty->_trigger_fatal_error( "[plugin] resource '".$params['type']."' is not implemented", NULL, NULL, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 38 );
        }
        return;
    }
    $_plugin_file = $smarty->_get_plugin_filepath( "resource", $params['type'] );
    $_found = $_plugin_file != FALSE;
    if ( $_found )
    {
        include_once( $_plugin_file );
        $_resource_ops = array( "source", "timestamp", "secure", "trusted" );
        $_resource_funcs = array( );
        foreach ( $_resource_ops as $_op )
        {
            $_plugin_func = "smarty_resource_".$params['type']."_".$_op;
            if ( !function_exists( $_plugin_func ) )
            {
                $smarty->_trigger_fatal_error( "[plugin] function {$_plugin_func}() not found in {$_plugin_file}", NULL, NULL, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 61 );
                return;
            }
            else
            {
                $_resource_funcs[] = $_plugin_func;
            }
        }
        $smarty->_plugins['resource'][$params['type']] = array(
            $_resource_funcs,
            TRUE
        );
    }
}

?>

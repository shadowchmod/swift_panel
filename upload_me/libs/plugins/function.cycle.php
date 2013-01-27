<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_function_cycle( $params, &$smarty )
{
    static $cycle_vars = NULL;
    $name = empty( $params['name'] ) ? "default" : $params['name'];
    $print = isset( $params['print'] ) ? ( string )$params['print'] : TRUE;
    $advance = isset( $params['advance'] ) ? ( string )$params['advance'] : TRUE;
    $reset = isset( $params['reset'] ) ? ( string )$params['reset'] : FALSE;
    if ( !in_array( "values", array_keys( $params ) ) )
    {
        if ( !isset( $cycle_vars[$name]['values'] ) )
        {
            $smarty->trigger_error( "cycle: missing 'values' parameter" );
            return;
        }
    }
    else
    {
        if ( isset( $cycle_vars[$name]['values'] ) && $cycle_vars[$name]['values'] != $params['values'] )
        {
            $cycle_vars[$name]['index'] = 0;
        }
        $cycle_vars[$name]['values'] = $params['values'];
    }
    $cycle_vars[$name]['delimiter'] = isset( $params['delimiter'] ) ? $params['delimiter'] : ",";
    if ( is_array( $cycle_vars[$name]['values'] ) )
    {
        $cycle_array = $cycle_vars[$name]['values'];
    }
    else
    {
        $cycle_array = explode( $cycle_vars[$name]['delimiter'], $cycle_vars[$name]['values'] );
    }
    if ( !isset( $cycle_vars[$name]['index'] ) || $reset )
    {
        $cycle_vars[$name]['index'] = 0;
    }
    if ( isset( $params['assign'] ) )
    {
        $print = FALSE;
        $smarty->assign( $params['assign'], $cycle_array[$cycle_vars[$name]['index']] );
    }
    if ( $print )
    {
        $retval = $cycle_array[$cycle_vars[$name]['index']];
    }
    else
    {
        $retval = NULL;
    }
    if ( $advance )
    {
        if ( count( $cycle_array ) - 1 <= $cycle_vars[$name]['index'] )
        {
            $cycle_vars[$name]['index'] = 0;
        }
        else
        {
            $cycle_vars[$name]['index']++;
        }
    }
    return $retval;
}

?>

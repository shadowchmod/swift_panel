<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$return = TRUE;
require( "../configuration.php" );
require( "./include.php" );
$task = ( $_POST['task'] );
if ( empty( $task ) )
{
    $task = ( $_GET['task'] );
}
switch ( $task )
{
case "deletelog" :
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    ( "TRUNCATE `log`" );
    $_SESSION['msg1'] = "Activity Logs Deleted Successfully!";
    $_SESSION['msg2'] = "All activity logs have been removed.";
    ( "Location: utilitieslog.php" );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

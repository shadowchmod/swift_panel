<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Login";
$page = "login";
require( "./configuration.php" );
include( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$task = ( $_GET['task'] );
$return = ( $_GET['return'] );
$smarty->display( "header.tpl" );
if ( isset( $_GET['email'] ) )
{
    $email = ( $_GET['email'] );
}
else if ( isset( $_COOKIE['clientemail'] ) )
{
    $email = ( $_COOKIE['clientemail'] );
}
if ( isset( $_GET['password'] ) )
{
    $password = ( $_GET['password'] );
}
if ( !empty( $_SESSION['lockout'] ) && ( ) - 60 * 5 < $_SESSION['lockout'] )
{
    $lockout = TRUE;
}
else
{
    $lockout = FALSE;
}
$smarty->assign( "task", $task );
$smarty->assign( "lockout", $lockout );
if ( $task != "password" )
{
    $smarty->assign( "return", $return );
    $smarty->assign( "login_error", isset( $_SESSION['loginerror'] ) );
    $smarty->assign( "email", $email );
    $smarty->assign( "password", $password );
    $smarty->assign( "remember_me", ( $_COOKIE['rememberme'] ) );
    unset( $_SESSION['loginerror'] );
}
else
{
    $smarty->assign( "success", $_SESSION['success'] );
    unset( $_SESSION['success'] );
}
$smarty->display( "login.tpl" );
if ( BRANDING )
{
    echo "<br /><div align='center'>Powered By <a href='http://www.swiftpanel.com' style='font-weight:bold;' target='_blank'>SWIFT Panel</a></div>";
}
$smarty->display( "footer.tpl" );
?>

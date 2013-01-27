<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "My Account";
$page = "profile";
$return = "profile.php";
require( "./configuration.php" );
include( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$rows = ( "SELECT * FROM `client` WHERE `clientid` = '".$_SESSION['clientid']."' LIMIT 1" );
if ( empty( $_SESSION['firstname'] ) )
{
    $_SESSION['firstname'] = $rows['firstname'];
}
if ( empty( $_SESSION['lastname'] ) )
{
    $_SESSION['lastname'] = $rows['lastname'];
}
if ( empty( $_SESSION['email'] ) )
{
    $_SESSION['email'] = $rows['email'];
}
if ( empty( $_SESSION['password'] ) )
{
    $_SESSION['password'] = $rows['password'];
}
$smarty->display( "header.tpl" );
$smarty->assign( "first_name", $_SESSION['firstname'] );
$smarty->assign( "last_name", $_SESSION['lastname'] );
$smarty->assign( "email", $_SESSION['email'] );
$smarty->assign( "password", $_SESSION['password'] );
unset( $_SESSION['firstname'] );
unset( $_SESSION['lastname'] );
unset( $_SESSION['email'] );
unset( $_SESSION['password'] );
$smarty->display( "profile.tpl" );
if ( BRANDING )
{
    echo "<br /><div align='center'>Powered By <a href='http://www.swiftpanel.com' style='font-weight:bold;' target='_blank'>SWIFT Panel</a></div>";
}
$smarty->display( "footer.tpl" );
?>

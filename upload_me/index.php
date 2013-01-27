<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Home";
$page = "index";
$return = TRUE;
require( "./configuration.php" );
include( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$rows = ( "SELECT * FROM `client` WHERE `clientid` = '".$_SESSION['clientid']."' LIMIT 1" );
$result1 = ( "SELECT `serverid`, `ipid`, `name`, `game`, `status`, `online`, `slots`, `type`, `port` FROM `server` WHERE `clientid` = '".$_SESSION['clientid']."' ORDER BY `serverid`" );
$servers = array( );
while ( $rows1 = ( $result1 ) )
{
    if ( !empty( $rows1['ipid'] ) )
    {
        $rows2 = ( "SELECT `ip` FROM `ip` WHERE `ipid` = '".$rows1['ipid']."' LIMIT 1" );
        $rows1 = ( $rows1, $rows2 );
    }
    ( $servers, $rows1 );
}
$smarty->display( "header.tpl" );
$smarty->assign( "client", array(
    "first_name" => $rows['firstname'],
    "last_name" => $rows['lastname'],
    "email" => $rows['email'],
    "servers" => ( "SELECT `serverid` FROM `server` WHERE `clientid` = '".$_SESSION['clientid']."'" )
) );
$smarty->assign( "servers", $servers );
$smarty->display( "index.tpl" );
if ( BRANDING )
{
    echo "<br /><div align='center'>Powered By <a href='http://www.swiftpanel.com' style='font-weight:bold;' target='_blank'>SWIFT Panel</a></div>";
}
$smarty->display( "footer.tpl" );
?>

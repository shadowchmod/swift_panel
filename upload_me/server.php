<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "My Servers";
$page = "server";
$return = "server.php";
require( "./configuration.php" );
include( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$result = ( "SELECT `serverid`, `ipid`, `name`, `game`, `status`, `online`, `port`, `query`, `qryport` FROM `server` WHERE `clientid` = '".$_SESSION['clientid']."' ORDER BY `serverid`" );
$servers = array( );
while ( $rows = ( $result ) )
{
    if ( !empty( $rows['ipid'] ) )
    {
        $rows1 = ( "SELECT `ip` FROM `ip` WHERE `ipid` = '".$rows['ipid']."' LIMIT 1" );
        $rows = ( $rows, $rows1 );
        if ( !empty( $rows1['ip'] ) && !empty( $rows['port'] ) && $rows['query'] != "none" )
        {
            if ( empty( $rows['qryport'] ) )
            {
                $qryport = $rows['port'];
            }
            else
            {
                $qryport = $rows['qryport'];
            }
            $serverinfo = ( array(
                $rows['query'],
                $rows1['ip'],
                $qryport
            ) );
            if ( $serverinfo )
            {
                $serverinfo2['servername'] = $serverinfo['Server Name'];
                $serverinfo2['players'] = $serverinfo['Players'];
                $serverinfo2['map'] = $serverinfo['Current Map'];
                $rows = ( $rows, $serverinfo2 );
            }
        }
    }
    ( $servers, $rows );
}
$smarty->display( "header.tpl" );
$smarty->assign( "servers", $servers );
$smarty->display( "server.tpl" );
if ( BRANDING )
{
    echo "<br /><div align='center'>Powered By <a href='http://www.swiftpanel.com' style='font-weight:bold;' target='_blank'>SWIFT Panel</a></div>";
}
$smarty->display( "footer.tpl" );
?>

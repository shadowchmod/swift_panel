<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Server Details";
$page = "server";
$return = "server.php?id=".$_GET['id'];
require( "./configuration.php" );
include( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$serverid = ( $_GET['id'] );
$rows = ( "SELECT * FROM `server` WHERE `serverid` = '".$serverid."' && `clientid` = '".$_SESSION['clientid']."' LIMIT 1" );
if ( !empty( $rows['ipid'] ) )
{
    $rows1 = ( "SELECT `ip` FROM `ip` WHERE `ipid` = '".$rows['ipid']."' LIMIT 1" );
    $rows2 = ( "SELECT `boxid`, `name`, `location`, `ftpport` FROM `box` WHERE `boxid` = '".$rows['boxid']."' LIMIT 1" );
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
    }
    $rows = ( $rows, $rows1 );
    $rows = ( $rows, array(
        "boxname" => $rows2['name'],
        "boxlocation" => $rows2['location'],
        "ftpport" => $rows2['ftpport']
    ) );
}
$smarty->display( "header.tpl" );
$smarty->assign( "srv", $rows );
$smarty->assign( "query", $serverinfo );
$smarty->display( "serversummary.tpl" );
if ( BRANDING )
{
    echo "<br /><div align='center'>Powered By <a href='http://www.swiftpanel.com' style='font-weight:bold;' target='_blank'>SWIFT Panel</a></div>";
}
$smarty->display( "footer.tpl" );
?>

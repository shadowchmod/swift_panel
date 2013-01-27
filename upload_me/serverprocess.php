<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$return = TRUE;
require( "./configuration.php" );
include( "./include.php" );
$task = ( $_POST['task'] );
if ( empty( $task ) )
{
    $task = ( $_GET['task'] );
}
switch ( $task )
{
case "serveredit" :
    $clientid = ( $_SESSION['clientid'] );
    $serverid = ( $_POST['serverid'] );
    $cfg1 = ( $_POST['cfg1'] );
    $cfg2 = ( $_POST['cfg2'] );
    $cfg3 = ( $_POST['cfg3'] );
    $cfg4 = ( $_POST['cfg4'] );
    $cfg5 = ( $_POST['cfg5'] );
    $cfg6 = ( $_POST['cfg6'] );
    $cfg7 = ( $_POST['cfg7'] );
    $cfg8 = ( $_POST['cfg8'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $rows = ( "SELECT * FROM `server` WHERE `serverid` = '".$serverid."' && `clientid` = '".$clientid."' LIMIT 1" );
    $len = ( $cfg1 );
    if ( $rows['cfg1edit'] && "0" < $len )
    {
        $cfg1 = ( " ", $cfg1 );
        $cfg1 = $cfg1[0];
    }
    else
    {
        $cfg1 = $rows['cfg1'];
    }
    $len = ( $cfg2 );
    if ( $rows['cfg2edit'] && "0" < $len )
    {
        $cfg2 = ( " ", $cfg2 );
        $cfg2 = $cfg2[0];
    }
    else
    {
        $cfg2 = $rows['cfg2'];
    }
    $len = ( $cfg3 );
    if ( $rows['cfg3edit'] && "0" < $len )
    {
        $cfg3 = ( " ", $cfg3 );
        $cfg3 = $cfg3[0];
    }
    else
    {
        $cfg3 = $rows['cfg3'];
    }
    $len = ( $cfg4 );
    if ( $rows['cfg4edit'] && "0" < $len )
    {
        $cfg4 = ( " ", $cfg4 );
        $cfg4 = $cfg4[0];
    }
    else
    {
        $cfg4 = $rows['cfg4'];
    }
    $len = ( $cfg5 );
    if ( $rows['cfg5edit'] && "0" < $len )
    {
        $cfg5 = ( " ", $cfg5 );
        $cfg5 = $cfg5[0];
    }
    else
    {
        $cfg5 = $rows['cfg5'];
    }
    $len = ( $cfg6 );
    if ( $rows['cfg6edit'] && "0" < $len )
    {
        $cfg6 = ( " ", $cfg6 );
        $cfg6 = $cfg6[0];
    }
    else
    {
        $cfg6 = $rows['cfg6'];
    }
    $len = ( $cfg7 );
    if ( $rows['cfg7edit'] && "0" < $len )
    {
        $cfg7 = ( " ", $cfg7 );
        $cfg7 = $cfg7[0];
    }
    else
    {
        $cfg7 = $rows['cfg7'];
    }
    $len = ( $cfg8 );
    if ( $rows['cfg8edit'] && "0" < $len )
    {
        $cfg8 = ( " ", $cfg8 );
        $cfg8 = $cfg8[0];
    }
    else
    {
        $cfg8 = $rows['cfg8'];
    }
    ( "UPDATE `server` SET `cfg1` = '".$cfg1."', `cfg2` = '".$cfg2."', `cfg3` = '".$cfg3."', `cfg4` = '".$cfg4."', `cfg5` = '".$cfg5."', `cfg6` = '".$cfg6."', `cfg7` = '".$cfg7."', `cfg8` = '".$cfg8."' WHERE `serverid` = '".$serverid."' && `clientid` = '".$clientid."' LIMIT 1" );
    $_SESSION['msg1'] = "Server Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to your server have been saved.";
    ( "Location: serversummary.php?id=".( $serverid ) );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

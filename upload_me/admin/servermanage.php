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
$return = ( $_POST['return'] );
if ( empty( $return ) )
{
    $return = ( $_GET['return'] );
}
$serverid = ( $_POST['serverid'] );
if ( empty( $serverid ) )
{
    $serverid = ( $_GET['serverid'] );
}
switch ( $task )
{
case "restart" :
case "stop" :
    $rows = ( "SELECT `serverid`, `clientid`, `boxid`, `name`, `user`, `password`, `online` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
    if ( $rows['online'] == "Stopped" )
    {
        $_SESSION['msg1'] = "Server Already Stopped!";
        $_SESSION['msg2'] = "Unable to stop server.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    $rows1 = ( "SELECT `ip`, `sshport` FROM `box` WHERE `boxid` = '".$rows['boxid']."' LIMIT 1" );
    if ( !( "ssh2" ) )
    {
        $_SESSION['msg1'] = "SSH2 Extension Error!";
        $_SESSION['msg2'] = "SSH2 Extension not detected!";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    if ( !( $sshconnection = @( $rows1['ip'], $rows1['sshport'] ) ) )
    {
        $_SESSION['msg1'] = "Connection Error!";
        $_SESSION['msg2'] = "Unable to connect to box with SSH.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    if ( !( $sshconnection, $rows['user'], $rows['password'] ) )
    {
        $_SESSION['msg1'] = "Authentication Error!";
        $_SESSION['msg2'] = "Unable to login to box with SSH.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    $sshshell = @( $sshconnection, "vt102", null, 400, 80, SSH2_TERM_UNIT_CHARS );
    @( $sshshell, "kill -9 `screen -list | grep \"".$rows['serverid']."-".$rows['user']."\" | awk {'print \$1'} | cut -d . -f1`\n" );
    ( 2 );
    @( $sshshell, "screen -wipe\n" );
    ( 2 );
    @( $sshshell );
    ( "UPDATE `server` SET `online` = 'Stopped' WHERE `serverid` = '".$serverid."'" );
    if ( $task == "stop" )
    {
        $message = "Server Stopped: <a href=\"serversummary.php?id=".$serverid."\">".$rows['name']."</a> (Admin)";
        ( "INSERT INTO `log` SET `clientid` = '".$rows['clientid']."', `serverid` = '".$serverid."', `boxid` = '".$rows['boxid']."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
        $_SESSION['msg1'] = "Server Stopped Successfully!";
        $_SESSION['msg2'] = "<br />";
        if ( !empty( $return ) )
        {
            ( "Location: ".$return );
        }
        else
        {
            ( "Location: serversummary.php?id=".( $serverid ) );
        }
        exit( );
    }
case "start" :
    $rows = ( "SELECT * FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
    if ( $rows['online'] == "Started" )
    {
        $_SESSION['msg1'] = "Server Already Started!";
        $_SESSION['msg2'] = "Unable to start server.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    $rows1 = ( "SELECT * FROM `ip` WHERE `ipid` = '".$rows['ipid']."' LIMIT 1" );
    $rows2 = ( "SELECT `ip`, `sshport`, `login`, `password` FROM `box` WHERE `boxid` = '".$rows['boxid']."' LIMIT 1" );
    if ( !( "ssh2" ) )
    {
        $_SESSION['msg1'] = "SSH2 Extension Error!";
        $_SESSION['msg2'] = "SSH2 Extension not detected!";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    if ( !( $sshconnection = @( $rows2['ip'], $rows2['sshport'] ) ) )
    {
        $_SESSION['msg1'] = "Connection Error!";
        $_SESSION['msg2'] = "Unable to connect to box with SSH.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    if ( !( $sshconnection, $rows['user'], $rows['password'] ) )
    {
        $_SESSION['msg1'] = "Authentication Error!";
        $_SESSION['msg2'] = "Unable to login to box with SSH.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    $startline = ( $rows, $rows1['ip'] );
    $sshshell = @( $sshconnection, "vt102", null, 400, 80, SSH2_TERM_UNIT_CHARS );
    @( $sshshell, "screen -A -m -S ".$rows['serverid']."-".$rows['user']."\n" );
    ( 2 );
    while ( $sshline = ( $sshshell ) )
    {
        if ( ( "/not the owner of/", $sshline ) )
        {
            $_SESSION['msg1'] = "Session Permission Error!";
            $_SESSION['msg2'] = "Delete /var/run/screen/S-".$rows['user']." to fix issue.";
            ( "Location: serversummary.php?id=".( $serverid ) );
            exit( );
        }
    }
    @( $sshshell, $startline."\n" );
    ( 3 );
    @( $sshshell );
    ( "UPDATE `server` SET `online` = 'Started' WHERE `serverid` = '".$rows['serverid']."'" );
    if ( $task == "start" )
    {
        $message = "Server Started: <a href=\"serversummary.php?id=".$serverid."\">".$rows['name']."</a> (Admin)";
        ( "INSERT INTO `log` SET `clientid` = '".$rows['clientid']."', `serverid` = '".$serverid."', `boxid` = '".$rows['boxid']."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
        $_SESSION['msg1'] = "Server Started Successfully!";
        $_SESSION['msg2'] = "Allow 20 seconds for server status to show!";
    }
    else if ( $task == "restart" )
    {
        $message = "Server Restarted: <a href=\"serversummary.php?id=".$serverid."\">".$rows['name']."</a> (Admin)";
        ( "INSERT INTO `log` SET `clientid` = '".$rows['clientid']."', `serverid` = '".$serverid."', `boxid` = '".$rows['boxid']."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
        $_SESSION['msg1'] = "Server Restarted Successfully!";
        $_SESSION['msg2'] = "Allow 20 seconds for server status to show!";
    }
    if ( !empty( $return ) )
    {
        ( "Location:".$return );
    }
    else
    {
        ( "Location: serversummary.php?id=".( $serverid ) );
    }
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Install Wizard";
$page = "serverinstall";
$tab = "3";
$return = "serverinstall.php?id=".$_GET['id']."&boxid=".$_GET['boxid']."&ipid=".$_GET['ipid'];
$image = "wizard_48";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$serverid = ( $_GET['id'] );
$boxid = ( $_GET['boxid'] );
$ipid = ( $_GET['ipid'] );
$rows = ( "SELECT `serverid`, `clientid`, `name`, `game`, `slots`, `port`, `installdir` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
$rows1 = ( "SELECT `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$rows['clientid']."' LIMIT 1" );
if ( empty( $boxid ) )
{
    $result2 = ( "SELECT `boxid`, `name`, `location` FROM `box`" );
}
else if ( empty( $ipid ) )
{
    $rows2 = ( "SELECT `boxid`, `name`, `location` FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
    $result3 = ( "SELECT * FROM `ip` WHERE `boxid` = '".$boxid."' && (`usage` = 'Game' || `usage` = 'Game & Voice' || `usage` = 'Game Servers') ORDER BY `ip`" );
}
else
{
    $rows2 = ( "SELECT `boxid`, `name`, `location` FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
    $rows3 = ( "SELECT * FROM `ip` WHERE `ipid` = '".$ipid."' LIMIT 1" );
    $rows4 = ( "SELECT `password` FROM `client` WHERE `clientid` = '".$rows['clientid']."' LIMIT 1" );
}
if ( !empty( $ipid ) )
{
    $n = 0;
    while ( empty( $user ) )
    {
        $user = "srv".( $rows['clientid'] * 100 + $n );
        if ( ( "SELECT `serverid` FROM `server` WHERE `user` = '".$user."' LIMIT 1" ) != 0 )
        {
            unset( $user );
            ++$n;
        }
    }
    $n = 0;
    while ( empty( $port ) )
    {
        if ( empty( $rows['port'] ) )
        {
            $rows['port'] = 10000;
        }
        $port = $rows['port'] + $n;
        if ( ( "SELECT `serverid` FROM `server` WHERE `ipid` = '".$rows3['ipid']."' && `port` = '".$port."' LIMIT 1" ) != 0 )
        {
            unset( $port );
            ++$n;
        }
    }
    if ( empty( $_SESSION['port'] ) )
    {
        $_SESSION['port'] = $port;
    }
    if ( empty( $_SESSION['user'] ) )
    {
        $_SESSION['user'] = $user;
    }
    if ( empty( $_SESSION['homedir'] ) )
    {
        $_SESSION['homedir'] = "/home/".$user;
    }
    if ( empty( $_SESSION['installdir'] ) )
    {
        $_SESSION['installdir'] = $rows['installdir'];
    }
    if ( empty( $_SESSION['formerror'] ) )
    {
        $_SESSION['adduser'] = "on";
        $_SESSION['install'] = "on";
    }
    unset( $_SESSION['formerror'] );
}
if ( empty( $boxid ) )
{
    $hiddens = array(
        "id" => $rows['serverid']
    );
    $keys = array( );
    $values = array( );
    while ( $rows2 = ( $result2 ) )
    {
        ( $keys, $rows2['boxid'] );
        ( $values, $rows2['name']." - ".$rows2['location'] );
    }
    ( $result2 );
    $data = ( $keys, $values );
    $inputs = array(
        array(
            "content",
            "Name",
            $rows['name']
        ),
        array(
            "content",
            "Game",
            $rows['game']
        ),
        array(
            "content",
            "Slots",
            $rows['slots']
        ),
        "boxid" => array(
            "select",
            "Box",
            $data,
            "<b>No boxes found.</b> <a href=\"boxadd.php\">Click here</a> to add a new box."
        )
    );
    $buttons = array(
        "Next Step" => array( "submit" ),
        "Back to Server" => array(
            "link",
            "serversummary.php?id=".$rows['serverid']
        )
    );
    $form = array(
        "serverinstall.php",
        $hiddens,
        $inputs,
        $buttons,
        TRUE,
        "#".$rows['serverid']." - ".$rows['name'],
        TRUE
    );
}
else if ( empty( $ipid ) )
{
    $hiddens = array(
        "id" => $rows['serverid'],
        "boxid" => $rows2['boxid']
    );
    $keys = array( );
    $values = array( );
    while ( $rows3 = ( $result3 ) )
    {
        $servers = 0;
        $slots = 0;
        $result4 = ( "SELECT `slots` FROM `server` WHERE `ipid` = '".$rows3['ipid']."'" );
        while ( $rows4 = ( $result4 ) )
        {
            ++$servers;
            $slots = $slots + $rows4['slots'];
        }
        ( $result4 );
        ( $keys, $rows3['ipid'] );
        ( $values, $rows3['ip']." - ".$servers." Servers (".$slots." Slots)" );
    }
    ( $result3 );
    if ( $keys )
    {
        $data = ( $keys, $values );
    }
    $inputs = array(
        array(
            "content",
            "Name",
            $rows['name']
        ),
        array(
            "content",
            "Game",
            $rows['game']
        ),
        array(
            "content",
            "Slots",
            $rows['slots']
        ),
        array(
            "content",
            "Box",
            "<a href=\"boxsummary.php?id=".$rows2['boxid']."\">".$rows2['name']."</a>"
        ),
        array(
            "content",
            "Location",
            $rows2['location']
        ),
        "ipid" => array(
            "select",
            "IP Address",
            $data,
            "<b>No IPs found.</b> <a href=\"boxsummary.php?id=".$rows2['boxid']."\">Click here</a> to add a new IP Address."
        )
    );
    $buttons = array(
        "Next Step" => array( "submit" ),
        "Previous Step" => array(
            "link",
            "serverinstall.php?id=".$rows['serverid']
        )
    );
    $form = array(
        "serverinstall.php",
        $hiddens,
        $inputs,
        $buttons,
        TRUE,
        "#".$rows['serverid']." - ".$rows['name'],
        TRUE
    );
}
else
{
    $hiddens = array(
        "task" => "serverinstall",
        "serverid" => $rows['serverid'],
        "boxid" => $rows2['boxid'],
        "ipid" => $rows3['ipid']
    );
    $inputs = array(
        array(
            "content",
            "Name",
            $rows['name']
        ),
        array(
            "content",
            "Game",
            $rows['game']
        ),
        array(
            "content",
            "Slots",
            $rows['slots']
        ),
        array(
            "content",
            "Box",
            "<a href=\"boxsummary.php?id=".$rows2['boxid']."\">".$rows2['name']."</a>"
        ),
        array(
            "content",
            "Location",
            $rows2['location']
        ),
        array(
            "content",
            "IP Address",
            $rows3['ip']
        ),
        "port" => array( "text", "Port", 10 ),
        "user" => array(
            "text",
            "User",
            15,
            "(Client ID #".$rows['clientid']." multiplied by 100)"
        ),
        "password" => array( "text", "Password", 15, "(Leave blank for random password)" ),
        "homedir" => array( "text", "Home Directory", 25 ),
        "adduser" => array(
            "checkbox",
            "Create User on ".$rows2['name']
        ),
        array( "divider" ),
        "installdir" => array( "text", "Install Directory", 25 ),
        "install" => array( "checkbox", "Auto-Install Server Files" )
    );
    $buttons = array(
        "Install Server" => array( "submit" ),
        "Previous Step" => array(
            "link",
            "serverinstall.php?id=".$rows['serverid']."&amp;boxid=".$rows2['boxid']
        ),
        "Cancel Changes" => array( "reset" )
    );
    $form = array(
        "serverprocess.php",
        $hiddens,
        $inputs,
        $buttons,
        TRUE,
        "#".$rows['serverid']." - ".$rows['name']
    );
}
$tabs = array(
    "Summary" => "serversummary.php?id=".$rows['serverid'],
    "Profile" => "serverprofile.php?id=".$rows['serverid'],
    "Web FTP" => "serverftp.php?id=".$rows['serverid'],
    "Activity Logs" => "serverlog.php?id=".$rows['serverid']
);
include( "./templates/".TEMPLATE."/header.php" );
echo ( $tabs, 2 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">\r\n";
( $form );
echo "    </td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

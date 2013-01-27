<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Server Advanced";
$page = "serveradvanced";
$tab = "3";
$return = "serveradvanced.php?id=".$_GET['id'];
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/games.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$serverid = ( $_GET['id'] );
$rows = ( "SELECT * FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
$rows1 = ( "SELECT `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$rows['clientid']."' LIMIT 1" );
if ( $rows['online'] != "Pending" )
{
    $rows2 = ( "SELECT `name` FROM `box` WHERE `boxid` = '".$rows['boxid']."' LIMIT 1" );
    $result3 = ( "SELECT * FROM `ip` WHERE `boxid` = '".$rows['boxid']."' && (`usage` = 'Game' || `usage` = 'Game & Voice' || `usage` = 'Game Servers') ORDER BY `ip`" );
}
if ( $rows['online'] != "Pending" )
{
    if ( empty( $_SESSION['ipid'] ) )
    {
        $_SESSION['ipid'] = $rows['ipid'];
    }
    if ( empty( $_SESSION['port'] ) )
    {
        $_SESSION['port'] = $rows['port'];
    }
    if ( empty( $_SESSION['online'] ) )
    {
        $_SESSION['online'] = $rows['online'];
    }
    if ( empty( $_SESSION['user'] ) )
    {
        $_SESSION['user'] = $rows['user'];
    }
    if ( empty( $_SESSION['password'] ) )
    {
        $_SESSION['password'] = $rows['password'];
    }
    if ( empty( $_SESSION['homedir'] ) )
    {
        $_SESSION['homedir'] = $rows['homedir'];
    }
    if ( empty( $_SESSION['installdir'] ) )
    {
        $_SESSION['installdir'] = $rows['installdir'];
    }
    if ( empty( $_SESSION['query'] ) )
    {
        $_SESSION['query'] = $rows['query'];
    }
    if ( empty( $_SESSION['qryport'] ) )
    {
        $_SESSION['qryport'] = $rows['qryport'];
    }
    if ( empty( $_SESSION['formerror'] ) )
    {
        $_SESSION['modify'] = "on";
    }
    unset( $_SESSION['formerror'] );
}
$hiddens = array(
    "task" => "serveradvanced",
    "serverid" => $rows['serverid']
);
if ( $rows['online'] != "Pending" )
{
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
    $data = ( $keys, $values );
    $inputs = array(
        "online" => array(
            "radio",
            "Status",
            array( "Started", "Stopped" )
        ),
        "ipid" => array(
            "select",
            "IP Address",
            $data
        ),
        "port" => array( "text", "Port", 10 ),
        array( "divider" ),
        "query" => array(
            "select",
            "Query Code",
            $gamequery
        ),
        "qryport" => array( "text", "Query Port", 10, "(Leave blank to use server port)" ),
        array( "divider" ),
        "user" => array( "text", "User", 15 ),
        "password" => array( "text", "Password", 15, "(Leave blank for random password)" ),
        "homedir" => array( "text", "Home Directory", 25, "(If changed, contents of current directory will be copied over)" ),
        "installdir" => array( "text", "Install Directory", 25 ),
        "modify" => array(
            "checkbox",
            "Modify User on ".$rows2['name']
        )
    );
}
$buttons = array(
    "Save Changes" => array( "submit" ),
    "Cancel Changes" => array( "reset" )
);
$form = array(
    "serverprocess.php",
    $hiddens,
    $inputs,
    $buttons,
    TRUE,
    "#".$rows['serverid']." - ".$rows['name']." [ ".( $rows['status'] )." ]"
);
$tabs = array(
    "Summary" => "serversummary.php?id=".$rows['serverid'],
    "Settings" => "serverprofile.php?id=".$rows['serverid'],
    "Advanced" => "serveradvanced.php?id=".$rows['serverid'],
    "Web FTP" => "serverftp.php?id=".$rows['serverid'],
    "Activity Logs" => "serverlog.php?id=".$rows['serverid']
);
include( "./templates/".TEMPLATE."/header.php" );
echo ( $tabs, 3 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">\r\n";
if ( $rows['online'] != "Pending" )
{
    ( $form );
}
else
{
    echo "<div id=\"infobox2\"><strong>Server Not Installed</strong><br />Please install the server first.</div>";
}
echo "    </td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

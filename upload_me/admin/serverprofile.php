<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Server Settings";
$page = "serverprofile";
$tab = "3";
$return = "serverprofile.php?id=".$_GET['id'];
require( "../configuration.php" );
require( "./include.php" );
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
}
if ( empty( $_SESSION['name'] ) )
{
    $_SESSION['name'] = $rows['name'];
}
if ( empty( $_SESSION['game'] ) )
{
    $_SESSION['game'] = $rows['game'];
}
if ( empty( $_SESSION['status'] ) )
{
    $_SESSION['status'] = $rows['status'];
}
if ( empty( $_SESSION['priority'] ) )
{
    $_SESSION['priority'] = $rows['priority'];
}
if ( empty( $_SESSION['slots'] ) )
{
    $_SESSION['slots'] = $rows['slots'];
}
if ( empty( $_SESSION['type'] ) )
{
    $_SESSION['type'] = $rows['type'];
}
$n = 1;
while ( $n <= 8 )
{
    if ( empty( $_SESSION["cfg".$n."name"] ) )
    {
        $_SESSION["cfg".$n."name"] = $rows["cfg".$n."name"];
    }
    if ( empty( $_SESSION["cfg".$n] ) )
    {
        $_SESSION["cfg".$n] = $rows["cfg".$n];
    }
    if ( empty( $_SESSION["cfg".$n."edit"] ) )
    {
        $_SESSION["cfg".$n."edit"] = $rows["cfg".$n."edit"];
    }
    ++$n;
}
if ( empty( $_SESSION['startline'] ) )
{
    $_SESSION['startline'] = $rows['startline'];
}
if ( empty( $_SESSION['showftp'] ) )
{
    $_SESSION['showftp'] = $rows['showftp'];
}
if ( empty( $_SESSION['webftp'] ) )
{
    $_SESSION['webftp'] = $rows['webftp'];
}
$hiddens = array(
    "task" => "serverprofile",
    "serverid" => $rows['serverid']
);
$inputs = array(
    "name" => array( "text", "Name", 30 ),
    "game" => array( "text", "Game", 30 ),
    "status" => array(
        "radio",
        "Status",
        array( "Pending", "Active", "Suspended" )
    ),
    array( "divider" ),
    "priority" => array(
        "select",
        "Priority",
        array( "None" => "None", "Very High" => "Very High", "High" => "High", "Above Normal" => "Above Normal", "Normal" => "Normal", "Below Normal" => "Below Normal", "Low" => "Low", "Very Low" => "Very Low" )
    ),
    "slots" => array( "text", "Max Slots", 5, "{slots}" ),
    "type" => array(
        "radio",
        "Type",
        array( "Public", "Private" )
    ),
    array( "cfg", 8 ),
    "startline" => array( "textarea", "Start Command", 60, 4 ),
    array( "divider" ),
    "showftp" => array( "checkbox", "Display FTP Login Details" ),
    "webftp" => array( "checkbox", "Allow Web FTP Access" )
);
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
echo ( $tabs, 2 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">\r\n";
( $form );
echo "    </td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

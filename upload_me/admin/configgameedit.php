<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Edit Game";
$page = "configgameedit";
$tab = "6";
$return = "configgameedit.php?id=".$_GET['id'];
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/games.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$gameid = ( $_GET['id'] );
$rows = ( "SELECT * FROM `game` WHERE `gameid` = '".$gameid."' LIMIT 1" );
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
if ( empty( $_SESSION['query'] ) )
{
    $_SESSION['query'] = $rows['query'];
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
if ( empty( $_SESSION['port'] ) )
{
    $_SESSION['port'] = $rows['port'];
}
if ( empty( $_SESSION['qryport'] ) )
{
    $_SESSION['qryport'] = $rows['qryport'];
}
if ( empty( $_SESSION['gamedir'] ) )
{
    $_SESSION['gamedir'] = $rows['gamedir'];
}
$hiddens = array(
    "task" => "configgameedit",
    "gameid" => $rows['gameid']
);
$inputs = array(
    "name" => array( "text", "Name", 30 ),
    "game" => array( "text", "Game", 30 ),
    "status" => array(
        "radio",
        "Status",
        array( "Active", "Inactive" )
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
    "query" => array(
        "select",
        "Query Code",
        $gamequery
    ),
    "qryport" => array( "text", "Query Port", 10, "(Leave blank to use server port)" ),
    array( "divider" ),
    "port" => array( "text", "Default Port", 10 ),
    "gamedir" => array( "text", "Install Directory", 25 )
);
$buttons = array(
    "Save Changes" => array( "submit" ),
    "Back to Games" => array( "link", "configgame.php" ),
    "Cancel Changes" => array( "reset" )
);
$form = array(
    "configgameprocess.php",
    $hiddens,
    $inputs,
    $buttons,
    TRUE
);
include( "./templates/".TEMPLATE."/header.php" );
( $form );
include( "./templates/".TEMPLATE."/footer.php" );
?>

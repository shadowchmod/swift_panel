<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Add New Game";
$page = "configgameadd";
$tab = "6";
$return = "configgameadd.php";
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/games.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
if ( empty( $_SESSION['formerror'] ) )
{
    $_SESSION['query'] = "None";
    $_SESSION['type'] = "Public";
}
unset( $_SESSION['formerror'] );
$hiddens = array( "task" => "configgameadd" );
$inputs = array(
    "name" => array( "text", "Name", 30 ),
    "game" => array( "text", "Game", 30 ),
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
    "Add New Game" => array( "submit" ),
    "Back to Games" => array( "link", "configgame.php" )
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

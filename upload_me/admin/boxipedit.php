<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Edit IP Address";
$page = "boxipedit";
$tab = "4";
$return = "boxipedit.php?id=".$_GET['ipid'];
$image = "edit_48";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$ipid = ( $_GET['ipid'] );
$rows = ( "SELECT * FROM `ip` WHERE `ipid` = '".$ipid."' LIMIT 1" );
if ( empty( $_SESSION['usage'] ) )
{
    $_SESSION['usage'] = $rows['usage'];
}
$hiddens = array(
    "task" => "boxipedit",
    "ipid" => $rows['ipid'],
    "boxid" => $rows['boxid']
);
$inputs = array(
    array(
        "content",
        "IP Address",
        $rows['ip']
    ),
    "usage" => array(
        "radio",
        "Usage",
        array( "Game Servers" )
    ),
    array( "divider" ),
    "verify" => array( "checkbox", "Verify IP Address Connection" )
);
$buttons = array(
    "Save Changes" => array( "submit" ),
    "Back to Box" => array(
        "link",
        "boxsummary.php?id=".$rows['boxid']
    )
);
$form = array(
    "boxprocess.php",
    $hiddens,
    $inputs,
    $buttons,
    TRUE
);
include( "./templates/".TEMPLATE."/header.php" );
( $form );
include( "./templates/".TEMPLATE."/footer.php" );
?>

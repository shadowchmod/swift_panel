<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Add New Box";
$page = "boxadd";
$tab = "4";
$return = "boxadd.php";
$image = "add_48";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
if ( empty( $_SESSION['formerror'] ) )
{
    $_SESSION['ostype'] = "Linux";
    $_SESSION['verify'] = "on";
}
unset( $_SESSION['formerror'] );
$hiddens = array( "task" => "boxadd" );
$inputs = array(
    "name" => array( "text", "Server Name", 35 ),
    "location" => array( "text", "Server Location", 25, "(City, State)" ),
    "ip" => array( "text", "IP Address", 25 ),
    "login" => array( "text", "Root Login", 20, "(Default: root)" ),
    "password" => array( "text", "Root Password", 20, "Should contain letters &amp; numbers only!" ),
    "ftpport" => array( "text", "FTP Port", 5, "(Default: 21)" ),
    "sshport" => array( "text", "SSH Port", 5, "(Default: 22)" ),
    "ostype" => array(
        "radio",
        "OS Type",
        array( "Linux" )
    ),
    "cost" => array( "text", "Monthly Cost", 10, "(Optional)" ),
    "notes" => array( "textarea", "Admin Notes", 70, 4 ),
    array( "divider" ),
    "verify" => array( "checkbox", "Verify Root Login &amp; Password" )
);
$buttons = array(
    "Add New Box" => array( "submit" )
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

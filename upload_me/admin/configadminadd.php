<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Add New Administrators";
$page = "configadminadd";
$tab = "6";
$return = "configadminadd.php";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$hiddens = array( "task" => "configadminadd" );
$inputs = array(
    "access" => array(
        "select",
        "Access Level",
        array( "Super" => "Super Administrator", "Full" => "Full Administrator", "Limited" => "Limited Administrator" )
    ),
    array( "divider" ),
    "firstname" => array( "text", "First Name", 25 ),
    "lastname" => array( "text", "Last Name", 25 ),
    "email" => array( "text", "Email", 35 ),
    array( "divider" ),
    "username" => array( "text", "Username", 25 ),
    "password" => array( "password", "Password", 20 ),
    "password2" => array( "password", "Confirm Password", 20 )
);
$buttons = array(
    "Add New Administrator" => array( "submit" ),
    "Back to Administrators" => array( "link", "configadmin.php" )
);
$form = array(
    "configadminprocess.php",
    $hiddens,
    $inputs,
    $buttons,
    TRUE
);
include( "./templates/".TEMPLATE."/header.php" );
( $form );
include( "./templates/".TEMPLATE."/footer.php" );
?>

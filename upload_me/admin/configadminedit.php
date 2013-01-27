<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Edit Administrator";
$page = "configadminedit";
$tab = "6";
$return = "configadminedit.php?id=".$_GET['id'];
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$adminid = ( $_GET['id'] );
$rows = ( "SELECT * FROM `admin` WHERE `adminid` = '".$adminid."' LIMIT 1" );
if ( empty( $_SESSION['firstname'] ) )
{
    $_SESSION['firstname'] = $rows['firstname'];
}
if ( empty( $_SESSION['lastname'] ) )
{
    $_SESSION['lastname'] = $rows['lastname'];
}
if ( empty( $_SESSION['email'] ) )
{
    $_SESSION['email'] = $rows['email'];
}
if ( empty( $_SESSION['username'] ) )
{
    $_SESSION['username'] = $rows['username'];
}
if ( empty( $_SESSION['status'] ) )
{
    $_SESSION['status'] = $rows['status'];
}
if ( empty( $_SESSION['notes'] ) )
{
    $_SESSION['notes'] = $rows['notes'];
}
$hiddens = array(
    "task" => "configadminedit",
    "adminid" => $rows['adminid']
);
$inputs = array(
    "access" => array(
        "select",
        "Access Level",
        array( "Super" => "Super Administrator", "Full" => "Full Administrator", "Limited" => "Limited Administrator" )
    ),
    "status" => array(
        "radio",
        "Status",
        array( "Active", "Suspended" )
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
    "Save Changes" => array( "submit" ),
    "Back to Administrators" => array( "link", "configadmin.php" ),
    "Cancel Changes" => array( "reset" )
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

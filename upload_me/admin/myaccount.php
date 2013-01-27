<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "My Account";
$page = "myaccount";
$tab = "7";
$return = "myaccount.php";
$image = "edit_48";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$rows = ( "SELECT * FROM `admin` WHERE `adminid` = '".$_SESSION['adminid']."' LIMIT 1" );
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
$hiddens = array(
    "task" => "myaccount",
    "adminid" => $rows['adminid']
);
$inputs = array(
    "firstname" => array( "text", "First Name", 25 ),
    "lastname" => array( "text", "Last Name", 25 ),
    "email" => array( "text", "Email", 35 ),
    "username" => array( "text", "Username", 25 ),
    "password" => array( "password", "Password", 20, "(Leave blank for no change)" ),
    "password2" => array( "password", "Confirm Password", 20 )
);
$buttons = array(
    "Save Changes" => array( "submit" ),
    "Cancel Changes" => array( "reset" )
);
$form = array(
    "process.php",
    $hiddens,
    $inputs,
    $buttons,
    TRUE
);
include( "./templates/".TEMPLATE."/header.php" );
( $form );
include( "./templates/".TEMPLATE."/footer.php" );
?>

<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Add New Client";
$page = "clientadd";
$tab = "2";
$return = "clientadd.php";
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/countries.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$country = ( "SELECT `value` FROM `config` WHERE `setting` = 'country' LIMIT 1" );
if ( empty( $_SESSION['formerror'] ) )
{
    $_SESSION['sendemail'] = "on";
    $_SESSION['country'] = $country['value'];
}
unset( $_SESSION['formerror'] );
$hiddens = array( "task" => "clientadd" );
$inputs = array(
    "firstname" => array( "text", "First Name", 25 ),
    "lastname" => array( "text", "Last Name", 25 ),
    "email" => array( "text", "Email", 35 ),
    "password" => array( "text", "Password", 20, "(Leave blank for random password)" ),
    array( "divider" ),
    "company" => array( "text", "Company Name", 30 ),
    "address1" => array( "text", "Address 1", 35 ),
    "address2" => array( "text", "Address 2", 35 ),
    "city" => array( "text", "City", 25 ),
    "state" => array( "text", "State/Region", 30 ),
    "postcode" => array( "text", "Postcode", 15 ),
    "country" => array(
        "select",
        "Country",
        $countries
    ),
    "phone" => array( "text", "Phone Number", 20 ),
    "notes" => array( "textarea", "Admin Notes", 70, 4 ),
    array( "divider" ),
    "sendemail" => array( "checkbox", "Send New Client Account Email" )
);
$buttons = array(
    "Add New Client" => array( "submit" )
);
$form = array(
    "clientprocess.php",
    $hiddens,
    $inputs,
    $buttons,
    TRUE
);
include( "./templates/".TEMPLATE."/header.php" );
( $form );
include( "./templates/".TEMPLATE."/footer.php" );
?>

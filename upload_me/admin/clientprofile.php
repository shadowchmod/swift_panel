<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Client Profile";
$page = "clientprofile";
$tab = "2";
$return = "clientprofile.php?id=".$_GET['id'];
$image = "edit_48";
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/countries.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$clientid = ( $_GET['id'] );
$rows = ( "SELECT * FROM `client` WHERE `clientid` = '".$clientid."' LIMIT 1" );
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
if ( empty( $_SESSION['password'] ) )
{
    $_SESSION['password'] = $rows['password'];
}
if ( empty( $_SESSION['status'] ) )
{
    $_SESSION['status'] = $rows['status'];
}
if ( empty( $_SESSION['company'] ) )
{
    $_SESSION['company'] = $rows['company'];
}
if ( empty( $_SESSION['address1'] ) )
{
    $_SESSION['address1'] = $rows['address1'];
}
if ( empty( $_SESSION['address2'] ) )
{
    $_SESSION['address2'] = $rows['address2'];
}
if ( empty( $_SESSION['city'] ) )
{
    $_SESSION['city'] = $rows['city'];
}
if ( empty( $_SESSION['state'] ) )
{
    $_SESSION['state'] = $rows['state'];
}
if ( empty( $_SESSION['postcode'] ) )
{
    $_SESSION['postcode'] = $rows['postcode'];
}
if ( empty( $_SESSION['country'] ) )
{
    $_SESSION['country'] = $rows['country'];
}
if ( empty( $_SESSION['phone'] ) )
{
    $_SESSION['phone'] = $rows['phone'];
}
if ( empty( $_SESSION['notes'] ) )
{
    $_SESSION['notes'] = $rows['notes'];
}
$hiddens = array(
    "task" => "clientprofile",
    "clientid" => $rows['clientid']
);
$inputs = array(
    "firstname" => array( "text", "First Name", 25 ),
    "lastname" => array( "text", "Last Name", 25 ),
    "email" => array( "text", "Email", 35 ),
    "password" => array( "text", "Password", 20, "(Leave blank for random password)" ),
    "status" => array(
        "radio",
        "Status",
        array( "Active", "Inactive" )
    ),
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
    "sendemail" => array( "checkbox", "Resend New Client Account Email" )
);
$buttons = array(
    "Save Changes" => array( "submit" ),
    "Cancel Changes" => array( "reset" )
);
$form = array(
    "clientprocess.php",
    $hiddens,
    $inputs,
    $buttons,
    TRUE,
    "#".$rows['clientid']." - ".$rows['firstname']." ".$rows['lastname']." [ ".( $rows['status'] )." ]"
);
$tabs = array(
    "Summary" => "clientsummary.php?id=".$rows['clientid'],
    "Profile" => "clientprofile.php?id=".$rows['clientid'],
    "Servers" => "clientserver.php?id=".$rows['clientid'],
    "Activity Logs" => "clientlog.php?id=".$rows['clientid']
);
include( "./templates/".TEMPLATE."/header.php" );
( $tabs, 2 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">\r\n";
( $form );
echo "    </td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

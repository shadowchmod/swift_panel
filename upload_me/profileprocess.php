<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$return = TRUE;
require( "./configuration.php" );
include( "./include.php" );
$task = ( $_POST['task'] );
if ( empty( $task ) )
{
    $task = ( $_GET['task'] );
}
switch ( $task )
{
case "profile" :
    $clientid = ( $_SESSION['clientid'] );
    $firstname = ( $_POST['firstname'] );
    $firstname = ( $firstname );
    $lastname = ( $_POST['lastname'] );
    $lastname = ( $lastname );
    $email = ( $_POST['email'] );
    $email = ( $email );
    $password = ( $_POST['password'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $len = ( $firstname );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>First Name [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $lastname );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Last Name [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $email );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Email [ <b>Not Entered</b> ]</li>";
    }
    else if ( $len <= "2" )
    {
        $_SESSION['msg2'] .= "<li>Email [ <b>Not Long Enough</b> ]</li>";
    }
    if ( ( "SELECT * FROM `client` WHERE `email` = '".$email."' && `clientid` != '".$clientid."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>Email [ <b>Already Used</b> ]</li>";
    }
    $len = ( $password );
    if ( "1" <= $len && $len <= "3" )
    {
        $_SESSION['msg2'] .= "<li>Password [ <b>Not Long Enough</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['msg1'] = "Validation Error!";
        ( "Location: profile.php" );
        exit( );
    }
    unset( $_SESSION['firstname'] );
    unset( $_SESSION['lastname'] );
    unset( $_SESSION['email'] );
    unset( $_SESSION['password'] );
    if ( empty( $password ) )
    {
        $password = ( 7 );
    }
    ( "UPDATE `client` SET `firstname` = '".$firstname."', `lastname` = '".$lastname."', `email` = '".$email."', `password` = '".$password."' WHERE `clientid` = '".$clientid."'" );
    $message = "Client Edited: <a href=\"clientsummary.php?id=".$clientid."\">".$firstname." ".$lastname."</a>";
    ( "INSERT INTO `log` SET `clientid` = '".$clientid."', `message` = '".$message."', `name` = '".$_SESSION['clientfirstname']." ".$_SESSION['clientlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Profile Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to your profile have been saved.";
    ( "Location: index.php" );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

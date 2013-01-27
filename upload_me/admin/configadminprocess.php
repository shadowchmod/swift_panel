<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$return = TRUE;
require( "../configuration.php" );
require( "./include.php" );
$task = ( $_POST['task'] );
if ( empty( $task ) )
{
    $task = ( $_GET['task'] );
}
switch ( $task )
{
case "configadminadd" :
    $access = ( $_POST['access'] );
    $firstname = ( $_POST['firstname'] );
    $firstname = ( $firstname );
    $lastname = ( $_POST['lastname'] );
    $lastname = ( $lastname );
    $email = ( $_POST['email'] );
    $email = ( $email );
    $username = ( $_POST['username'] );
    $password = ( $_POST['password'] );
    $password2 = ( $_POST['password2'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['access'] = $access;
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['password2'] = $password2;
    $len = ( $firstname );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>First Name [ <b>Not Entered</b> ]</li>";
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
    $len = ( $username );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Username [ <b>Not Entered</b> ]</li>";
    }
    else if ( ( "SELECT `adminid` FROM `admin` WHERE `username` = '".$username."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>Username [ <b>Already Used</b> ]</li>";
    }
    $len = ( $password );
    if ( $len <= "3" )
    {
        $_SESSION['msg2'] .= "<li>Password [ <b>Not Long Enough</b> ]</li>";
    }
    else if ( $password != $password2 )
    {
        $_SESSION['msg2'] .= "<li>Passwords [ <b>Do Not Match</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: configadminadd.php" );
        exit( );
    }
    unset( $_SESSION['access'] );
    unset( $_SESSION['firstname'] );
    unset( $_SESSION['lastname'] );
    unset( $_SESSION['email'] );
    unset( $_SESSION['username'] );
    unset( $_SESSION['password'] );
    unset( $_SESSION['password2'] );
    ( "INSERT INTO `admin` SET `username` = '".$username."', `firstname` = '".$firstname."', `lastname` = '".$lastname."', `email` = '".$email."', `password` = SHA('".$password."'), `access` = '".$access."', `notes` = '".$notes."', `status` = 'Active', `lastlogin` = '', `lastip` = '~', `lasthost` = '~'" );
    $_SESSION['msg1'] = "Admin Added Successfully!";
    $_SESSION['msg2'] = "The new admin account has been added and is ready for use.";
    ( "Location: configadmin.php" );
    exit( );
    break;
case "configadminedit" :
    $adminid = ( $_POST['adminid'] );
    $access = ( $_POST['access'] );
    $firstname = ( $_POST['firstname'] );
    $firstname = ( $firstname );
    $lastname = ( $_POST['lastname'] );
    $lastname = ( $lastname );
    $email = ( $_POST['email'] );
    $email = ( $email );
    $username = ( $_POST['username'] );
    $password = ( $_POST['password'] );
    $password2 = ( $_POST['password2'] );
    $status = ( $_POST['status'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['access'] = $access;
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;
    $_SESSION['password'] = $password;
    $_SESSION['password2'] = $password2;
    $_SESSION['status'] = $status;
    $len = ( $firstname );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>First Name [ <b>Not Entered</b> ]</li>";
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
    $len = ( $username );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Username [ <b>Not Entered</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `admin` WHERE `username` = '".$username."' && `adminid` != '".$adminid."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>Username  [ <b>Already Used</b> ]</li>";
    }
    $len = ( $password );
    if ( "1" <= $len && $len <= "3" )
    {
        $_SESSION['msg2'] .= "<li>Password  [ <b>Not Long Enough</b> ]</li>";
    }
    else if ( $password != $password2 )
    {
        $_SESSION['msg2'] .= "<li>Passwords  [ <b>Do Not Match</b> ]</li>";
    }
    if ( $adminid == $_SESSION['adminid'] && $status == "Suspended" )
    {
        $_SESSION['msg2'] .= "<li>Status [ <b>Can Not Suspended Yourself</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: configadminedit.php?id=".( $adminid ) );
        exit( );
    }
    unset( $_SESSION['access'] );
    unset( $_SESSION['firstname'] );
    unset( $_SESSION['lastname'] );
    unset( $_SESSION['email'] );
    unset( $_SESSION['username'] );
    unset( $_SESSION['password'] );
    unset( $_SESSION['password2'] );
    unset( $_SESSION['status'] );
    if ( empty( $password ) )
    {
        ( "UPDATE `admin` SET `username` = '".$username."', `firstname` = '".$firstname."', `lastname` = '".$lastname."', `email` = '".$email."', `access` = '".$access."', `notes` = '".$notes."', `status` = '".$status."' WHERE `adminid` = '".$adminid."'" );
    }
    else
    {
        ( "UPDATE `admin` SET `username` = '".$username."', `firstname` = '".$firstname."', `lastname` = '".$lastname."', `email` = '".$email."', `password` = SHA('".$password."'), `access` = '".$access."', `notes` = '".$notes."', `status` = '".$status."' WHERE `adminid` = '".$adminid."'" );
    }
    if ( $adminid == $_SESSION['adminid'] )
    {
        $_SESSION['adminusername'] = $username;
        $_SESSION['adminfirstname'] = $firstname;
        $_SESSION['adminlastname'] = $lastname;
    }
    $_SESSION['msg1'] = "Admin Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the admin have been saved.";
    ( "Location: configadmin.php" );
    exit( );
    break;
case "configadmindelete" :
    $adminid = ( $_GET['id'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    ( "DELETE FROM `admin` WHERE `adminid` = '".$adminid."' LIMIT 1" );
    $_SESSION['msg1'] = "Admin Deleted Successfully!";
    $_SESSION['msg2'] = "The selected admin has been removed.";
    ( "Location: configadmin.php" );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

if ( $_POST['task'] != "logout" && $_POST['task'] != "localkey" )
{
    $return = TRUE;
}
require( "../configuration.php" );
require( "./include.php" );
$task = ( $_POST['task'] );
if ( empty( $task ) )
{
    $task = ( $_GET['task'] );
}
switch ( $task )
{
case "login" :
    $username = ( $_POST['username'] );
    $password = ( $_POST['password'] );
    $return = ( $_POST['return'] );
    $rememberme = ( $_POST['rememberme'] );
    unset( $_SESSION['loginerror'] );
    ( "rememberme", $rememberme, ( ) + 60 * 60 * 24 * 30 );
    if ( !empty( $_SESSION['lockout'] ) && ( ) - 60 * 10 < $_SESSION['lockout'] )
    {
    }
    else
    {
        if ( !empty( $username ) && !empty( $password ) )
        {
            $numrows = ( "SELECT `adminid` FROM `admin` WHERE ( `username` = '".$username."' AND `password` = SHA('".$password."') AND `status` = 'Active' )" );
            if ( $numrows == 1 )
            {
                $rows = ( "SELECT `adminid`, `username`, `firstname`, `lastname` FROM `admin` WHERE `username` = '".$username."' AND `password` = SHA('".$password."') AND `status` = 'Active'" );
                ( "UPDATE `admin` SET `lastlogin` = NOW(), `lastip` = '".$_SERVER['REMOTE_ADDR']."', `lasthost` = '".( $_SERVER['REMOTE_ADDR'] )."' WHERE `adminid` = '".$rows['adminid']."'" );
                $_SESSION['adminid'] = $rows['adminid'];
                $_SESSION['adminusername'] = $rows['username'];
                $_SESSION['adminfirstname'] = $rows['firstname'];
                $_SESSION['adminlastname'] = $rows['lastname'];
                if ( $rememberme == "on" )
                {
                    ( "adminusername", $rows['username'], ( ) + 60 * 60 * 24 * 30 );
                }
                else
                {
                    ( "adminusername", "", ( ) + 60 * 60 * 24 * 1 );
                }
                unset( $_SESSION['loginattempt'] );
                unset( $_SESSION['lockout'] );
                if ( !empty( $return ) )
                {
                    ( "Location: ".$return );
                }
                else
                {
                    ( "Location: index.php" );
                }
                exit( );
            }
        }
    }
    $_SESSION['loginerror'] = TRUE;
    $_SESSION['loginattempt'] += 1;
    if ( 4 < $_SESSION['loginattempt'] )
    {
        $_SESSION['lockout'] = ( );
        $_SESSION['loginattempt'] = 3;
        $message = "5 Incorrect Admin Login Attempts (".$username.")";
        ( "INSERT INTO `log` SET `message` = '".$message."', `name` = 'System Message', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    }
    if ( !empty( $return ) && !empty( $username ) )
    {
        ( "Location: login.php?return=".( $return )."&username=".( $username ) );
    }
    else if ( empty( $return ) && !empty( $username ) )
    {
        ( "Location: login.php?username=".( $username ) );
    }
    else if ( !empty( $return ) && empty( $username ) )
    {
        ( "Location: login.php?return=".( $return ) );
    }
    else
    {
        ( "Location: login.php" );
    }
    exit( );
    break;
case "password" :
    $username = ( $_POST['username'] );
    unset( $_SESSION['success'] );
    if ( !empty( $_SESSION['lockout'] ) && ( ) - 60 * 10 < $_SESSION['lockout'] )
    {
    }
    else
    {
        if ( !empty( $username ) )
        {
            $numrows = ( "SELECT `adminid` FROM `admin` WHERE `username` = '".$username."'" );
            if ( $numrows == 1 )
            {
                $password = ( 8 );
                $rows = ( "SELECT `adminid`, `email`, `firstname`, `lastname` FROM `admin` WHERE `username` = '".$username."'" );
                ( "UPDATE `admin` SET `password` = SHA('".$password."') WHERE `adminid` = '".$rows['adminid']."'" );
                $message = "Your password has been reset to: {$password} \nIP: ".$_SERVER['REMOTE_ADDR'];
                include_once( "../includes/class.phpmailer.php" );
                $mail = new PHPMailer( );
                $mail->IsMail( );
                $mail->AddAddress( $rows['email'], $rows['firstname']." ".$rows['lastname'] );
                $mail->From = $rows['email'];
                $mail->FromName = "Swift Panel System";
                $mail->Subject = "Reset Password";
                $mail->Body = $message;
                $mail->Send( );
                unset( $_SESSION['loginattempt'] );
                unset( $_SESSION['lockout'] );
                $_SESSION['success'] = "Yes";
                ( "Location: login.php?task=password" );
                exit( );
            }
        }
    }
    $_SESSION['success'] = "No";
    $_SESSION['loginattempt'] += 1;
    if ( 4 < $_SESSION['loginattempt'] )
    {
        $_SESSION['lockout'] = ( );
        $_SESSION['loginattempt'] = 3;
        $message = "5 Incorrect Admin Login Attempts (".$username.")";
        ( "INSERT INTO `log` SET `message` = '".$message."', `name` = 'System Message', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    }
    ( "Location: login.php?task=password" );
    exit( );
    break;
case "myaccount" :
    $adminid = ( $_POST['adminid'] );
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
    else if ( ( "SELECT * FROM `admin` WHERE `username` = '".$username."' && `adminid` != '".$adminid."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>Username  [ <b>Already Used</b> ]</li>";
    }
    $len = ( $password );
    $_SESSION['msg2'] .= "<li>Password  [ <b>Not Long Enough</b> ]</li>";
    if ( $password != $password2 )
    {
        $_SESSION['msg2'] .= "<li>Passwords  [ <b>Do Not Match</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: myaccount.php" );
        exit( );
    }
    unset( $_SESSION['firstname'] );
    unset( $_SESSION['lastname'] );
    unset( $_SESSION['email'] );
    unset( $_SESSION['username'] );
    unset( $_SESSION['password'] );
    unset( $_SESSION['password2'] );
    if ( empty( $password ) )
    {
        ( "UPDATE `admin` SET `username` = '".$username."', `firstname` = '".$firstname."', `lastname` = '".$lastname."', `email` = '".$email."' WHERE `adminid` = '".$adminid."'" );
    }
    else
    {
        ( "UPDATE `admin` SET `username` = '".$username."', `firstname` = '".$firstname."', `lastname` = '".$lastname."', `email` = '".$email."', `password` = SHA('".$password."') WHERE `adminid` = '".$adminid."'" );
    }
    $_SESSION['adminusername'] = $username;
    $_SESSION['adminfirstname'] = $firstname;
    $_SESSION['adminlastname'] = $lastname;
    $_SESSION['msg1'] = "Admin Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the admin have been saved.";
    ( "Location: index.php" );
    exit( );
    break;
case "logout" :
    ( );
    ( "Location: login.php" );
    exit( );
    break;
case "personalnotes" :
    $adminid = ( $_POST['adminid'] );
    $notes = ( $_POST['notes'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    ( "UPDATE `admin` SET `notes` = '".$notes."' WHERE `adminid` = '".$adminid."'" );
    $_SESSION['msg1'] = "Personal Notes Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to your personal notes have been saved.";
    ( "Location: index.php" );
    exit( );
    break;
case "localkey" :
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    ( "UPDATE `config` SET `value` = '' WHERE `setting` = 'key'" );
    $_SESSION['msg1'] = "Local Key Updated Successfully!";
    $_SESSION['msg2'] = "Your local key has been updated.";
    ( "Location: systemlicense.php" );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

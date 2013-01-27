<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

require( "./configuration.php" );
include( "./include.php" );
$task = ( $_POST['task'] );
if ( empty( $task ) )
{
    $task = ( $_GET['task'] );
}
switch ( $task )
{
case "login" :
    $email = ( $_POST['email'] );
    $password = ( $_POST['password'] );
    $return = ( $_POST['return'] );
    $rememberme = ( $_POST['rememberme'] );
    unset( $_SESSION['loginerror'] );
    ( "rememberme", $rememberme, ( ) + 60 * 60 * 24 * 30 );
    if ( !empty( $_SESSION['lockout'] ) && ( ) - 60 * 5 < $_SESSION['lockout'] )
    {
    }
    else
    {
        if ( !empty( $email ) && !empty( $password ) )
        {
            $numrows = ( "SELECT `clientid` FROM `client` WHERE `email` = '".$email."' && `password` = '".$password."' && ( `status` = 'Active' || `status` = 'Inactive' )" );
            if ( $numrows == 1 )
            {
                $rows = ( "SELECT `clientid`, `email`, `firstname`, `lastname` FROM `client` WHERE `email` = '".$email."' && `password` = '".$password."'" );
                ( "UPDATE `client` SET `lastlogin` = NOW(), `lastip` = '".$_SERVER['REMOTE_ADDR']."', `lasthost` = '".( $_SERVER['REMOTE_ADDR'] )."' WHERE `clientid` = '".$rows['clientid']."'" );
                $_SESSION['clientid'] = $rows['clientid'];
                $_SESSION['clientemail'] = $rows['email'];
                $_SESSION['clientfirstname'] = $rows['firstname'];
                $_SESSION['clientlastname'] = $rows['lastname'];
                if ( $rememberme == "on" )
                {
                    ( "clientemail", $rows['email'], ( ) + 604800 );
                }
                else
                {
                    ( "clientemail", "", ( ) + 60 * 60 * 24 * 1 );
                }
                unset( $_SESSION['loginattempt'] );
                unset( $_SESSION['lockout'] );
                if ( !empty( $return ) )
                {
                    ( "Location:".$return );
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
    }
    if ( !empty( $return ) && !empty( $email ) )
    {
        ( "Location: login.php?return=".( $return )."&email=".( $email ) );
    }
    else if ( empty( $return ) && !empty( $email ) )
    {
        ( "Location: login.php?email=".( $email ) );
    }
    else if ( !empty( $return ) && empty( $email ) )
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
    $email = ( $_POST['email'] );
    unset( $_SESSION['success'] );
    if ( !empty( $_SESSION['lockout'] ) && ( ) - 60 * 5 < $_SESSION['lockout'] )
    {
    }
    else
    {
        if ( !empty( $email ) )
        {
            $numrows = ( "SELECT `clientid` FROM `client` WHERE `email` = '".$email."'" );
            if ( $numrows == 1 )
            {
                $password = ( 8 );
                $rows = ( "SELECT `clientid`, `email`, `firstname`, `lastname` FROM `client` WHERE `email` = '".$email."'" );
                ( "UPDATE `client` SET `password` = '".$password."' WHERE `clientid` = '".$rows['clientid']."'" );
                $message = "Your password has been reset to: {$password} \nIP: ".$_SERVER['REMOTE_ADDR'];
                include_once( "./includes/class.phpmailer.php" );
                $mail = new PHPMailer( );
                $mail->IsMail( );
                $mail->AddAddress( $rows['email'], $rows['firstname']." ".$rows['lastname'] );
                $mail->From = $rows['email'];
                $mail->FromName = SITENAME;
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
    }
    ( "Location: login.php?task=password" );
    exit( );
    break;
case "logout" :
    ( );
    ( "Location: login.php" );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

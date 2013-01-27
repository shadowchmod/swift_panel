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
case "clientadd" :
    $firstname = ( $_POST['firstname'] );
    $firstname = ( $firstname );
    $lastname = ( $_POST['lastname'] );
    $lastname = ( $lastname );
    $email = ( $_POST['email'] );
    $email = ( $email );
    $password = ( $_POST['password'] );
    $company = ( $_POST['company'] );
    $address1 = ( $_POST['address1'] );
    $address2 = ( $_POST['address2'] );
    $city = ( $_POST['city'] );
    $state = ( $_POST['state'] );
    $postcode = ( $_POST['postcode'] );
    $country = ( $_POST['country'] );
    $phone = ( $_POST['phone'] );
    $notes = ( $_POST['notes'] );
    $sendemail = ( $_POST['sendemail'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['company'] = $company;
    $_SESSION['address1'] = $address1;
    $_SESSION['address2'] = $address2;
    $_SESSION['city'] = $city;
    $_SESSION['state'] = $state;
    $_SESSION['postcode'] = $postcode;
    $_SESSION['country'] = $country;
    $_SESSION['phone'] = $phone;
    $_SESSION['notes'] = $notes;
    $_SESSION['sendemail'] = $sendemail;
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
    if ( ( "SELECT * FROM `client` WHERE `email` = '".$email."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "</li>Email [ <b>Already Used</b> ]</li>";
    }
    $len = ( $password );
    if ( "1" <= $len && $len <= "3" )
    {
        $_SESSION['msg2'] .= "<li>Password [ <b>Not Long Enough</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['formerror'] = 1;
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: clientadd.php" );
        exit( );
    }
    unset( $_SESSION['firstname'] );
    unset( $_SESSION['lastname'] );
    unset( $_SESSION['email'] );
    unset( $_SESSION['password'] );
    unset( $_SESSION['company'] );
    unset( $_SESSION['address1'] );
    unset( $_SESSION['address2'] );
    unset( $_SESSION['city'] );
    unset( $_SESSION['state'] );
    unset( $_SESSION['postcode'] );
    unset( $_SESSION['country'] );
    unset( $_SESSION['phone'] );
    unset( $_SESSION['notes'] );
    unset( $_SESSION['sendemail'] );
    if ( empty( $password ) )
    {
        $password = ( 7 );
    }
    ( "INSERT INTO `client` SET `firstname` = '".$firstname."', `lastname` = '".$lastname."', `email` = '".$email."', `password` = '".$password."', `company` = '".$company."', `address1` = '".$address1."', `address2` = '".$address2."', `city` = '".$city."', `state` = '".$state."', `postcode` = '".$postcode."', `country` = '".$country."', `phone` = '".$phone."', `notes` = '".$notes."', `status` = 'Active', `lastip` = '~', `lasthost` = '~', `created` = NOW()" );
    $clientid = ( );
    $message = "Client Added: <a href=\"clientsummary.php?id=".$clientid."\">".$firstname." ".$lastname."</a>";
    ( "INSERT INTO `log` SET `clientid` = '".$clientid."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    if ( $sendemail == "on" )
    {
        $rows = ( "SELECT * FROM `emailtemp` WHERE `emailtempid` = '1'" );
        $systemurl = ( "SELECT `value` FROM `config` WHERE `setting` = 'systemurl' LIMIT 1" );
        $patterns[0] = "/{firstname}/";
        $patterns[1] = "/{lastname}/";
        $patterns[2] = "/{email}/";
        $patterns[3] = "/{password}/";
        $patterns[4] = "/{clientarealink}/";
        $replacements[0] = $firstname;
        $replacements[1] = $lastname;
        $replacements[2] = $email;
        $replacements[3] = $password;
        $replacements[4] = $systemurl['value'];
        include_once( "../includes/class.phpmailer.php" );
        $mail = new PHPMailer( );
        $mail->IsMail( );
        $mail->AddAddress( $email, $firstname." ".$lastname );
        $mail->AddBCC( $rows['bcc'] );
        $mail->From = $rows['email'];
        $mail->FromName = $rows['name'];
        $mail->Subject = $rows['subject'];
        $mail->Body = ( $patterns, $replacements, $rows['template'] );
        $mail->Send( );
    }
    $_SESSION['msg1'] = "Client Added Successfully!";
    $_SESSION['msg2'] = "The new client account has been added and is ready for use.";
    ( "Location: clientsummary.php?id=".( $clientid ) );
    exit( );
    break;
case "clientprofile" :
    $clientid = ( $_POST['clientid'] );
    $firstname = ( $_POST['firstname'] );
    $firstname = ( $firstname );
    $lastname = ( $_POST['lastname'] );
    $lastname = ( $lastname );
    $email = ( $_POST['email'] );
    $email = ( $email );
    $password = ( $_POST['password'] );
    $status = ( $_POST['status'] );
    $company = ( $_POST['company'] );
    $address1 = ( $_POST['address1'] );
    $address2 = ( $_POST['address2'] );
    $city = ( $_POST['city'] );
    $state = ( $_POST['state'] );
    $postcode = ( $_POST['postcode'] );
    $country = ( $_POST['country'] );
    $phone = ( $_POST['phone'] );
    $notes = ( $_POST['notes'] );
    $sendemail = ( $_POST['sendemail'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['status'] = $status;
    $_SESSION['company'] = $company;
    $_SESSION['address1'] = $address1;
    $_SESSION['address2'] = $address2;
    $_SESSION['city'] = $city;
    $_SESSION['state'] = $state;
    $_SESSION['postcode'] = $postcode;
    $_SESSION['country'] = $country;
    $_SESSION['phone'] = $phone;
    $_SESSION['notes'] = $notes;
    $_SESSION['sendemail'] = $sendemail;
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
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: clientprofile.php?id=".( $clientid ) );
        exit( );
    }
    unset( $_SESSION['firstname'] );
    unset( $_SESSION['lastname'] );
    unset( $_SESSION['email'] );
    unset( $_SESSION['password'] );
    unset( $_SESSION['status'] );
    unset( $_SESSION['company'] );
    unset( $_SESSION['address1'] );
    unset( $_SESSION['address2'] );
    unset( $_SESSION['city'] );
    unset( $_SESSION['state'] );
    unset( $_SESSION['postcode'] );
    unset( $_SESSION['country'] );
    unset( $_SESSION['phone'] );
    unset( $_SESSION['notes'] );
    unset( $_SESSION['sendemail'] );
    if ( empty( $password ) )
    {
        $password = ( 7 );
    }
    ( "UPDATE `client` SET `firstname` = '".$firstname."', `lastname` = '".$lastname."', `email` = '".$email."', `password` = '".$password."', `company` = '".$company."', `address1` = '".$address1."', `address2` = '".$address2."', `city` = '".$city."', `state` = '".$state."', `postcode` = '".$postcode."', `country` = '".$country."', `phone` = '".$phone."', `notes` = '".$notes."', `status` = '".$status."' WHERE `clientid` = '".$clientid."'" );
    $message = "Client Edited: <a href=\"clientsummary.php?id=".$clientid."\">".$firstname." ".$lastname."</a> (Admin)";
    ( "INSERT INTO `log` SET `clientid` = '".$clientid."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    if ( $sendemail == "on" )
    {
        $rows = ( "SELECT * FROM `emailtemp` WHERE `emailtempid` = '1'" );
        $systemurl = ( "SELECT `value` FROM `config` WHERE `setting` = 'systemurl' LIMIT 1" );
        $patterns[0] = "/{firstname}/";
        $patterns[1] = "/{lastname}/";
        $patterns[2] = "/{email}/";
        $patterns[3] = "/{password}/";
        $patterns[4] = "/{clientarealink}/";
        $replacements[0] = $firstname;
        $replacements[1] = $lastname;
        $replacements[2] = $email;
        $replacements[3] = $password;
        $replacements[4] = $systemurl['value'];
        include_once( "../includes/class.phpmailer.php" );
        $mail = new PHPMailer( );
        $mail->IsMail( );
        $mail->AddAddress( $email, $firstname." ".$lastname );
        $mail->AddBCC( $rows['bcc'] );
        $mail->From = $rows['email'];
        $mail->FromName = $rows['name'];
        $mail->Subject = $rows['subject'];
        $mail->Body = ( $patterns, $replacements, $rows['template'] );
        $mail->Send( );
    }
    $_SESSION['msg1'] = "Client Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the client have been saved.";
    ( "Location: clientsummary.php?id=".( $clientid ) );
    exit( );
    break;
case "clientnotes" :
    $clientid = ( $_POST['clientid'] );
    $notes = ( $_POST['notes'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    ( "UPDATE `client` SET `notes` = '".$notes."' WHERE `clientid` = '".$clientid."'" );
    $_SESSION['msg1'] = "Admin Notes Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the admin notes have been saved.";
    ( "Location: clientsummary.php?id=".( $clientid ) );
    exit( );
    break;
case "clientlogin" :
    do
    {
        $clientid = ( $_GET['id'] );
        $return = ( $_GET['return'] );
        $numrows = ( "SELECT `clientid` FROM `client` WHERE `clientid` = '".$clientid."' LIMIT 1" );
        if ( $numrows == 1 )
        {
            $rows = ( "SELECT `clientid`, `email`, `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$clientid."' LIMIT 1" );
            $_SESSION['clientid'] = $rows['clientid'];
            $_SESSION['clientemail'] = $rows['email'];
            $_SESSION['clientfirstname'] = $rows['firstname'];
            $_SESSION['clientlastname'] = $rows['lastname'];
            if ( !empty( $return ) )
            {
                ( "Location: ../".$return );
                exit( );
                break;
            }
            else
            {
                ( "Location: ../index.php" );
                exit( );
                break;
            }
        }
        else
        {
            ( "Location: ../login.php" );
        }
        exit( );
    } while ( 0 );
    break;
case "clientdelete" :
    $clientid = ( $_GET['id'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $result = ( "SELECT * FROM `server` WHERE `clientid` = '".$clientid."'" );
    if ( ( $result ) != 0 )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "Servers must be deleted.";
        ( "Location: clientserver.php?id=".( $clientid ) );
        exit( );
    }
    ( $result );
    $rows = ( "SELECT `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$clientid."' LIMIT 1" );
    ( "DELETE FROM `client` WHERE `clientid` = '".$clientid."' LIMIT 1" );
    $message = "Client Deleted: ".$rows['firstname']." ".$rows['lastname'];
    ( "INSERT INTO `log` SET `clientid` = '".$clientid."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Client Deleted Successfully!";
    $_SESSION['msg2'] = "The selected client has been removed.";
    ( "Location: client.php" );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

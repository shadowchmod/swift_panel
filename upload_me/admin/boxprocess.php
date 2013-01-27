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
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$task = ( $_POST['task'] );
if ( empty( $task ) )
{
    $task = ( $_GET['task'] );
}
switch ( $task )
{
case "boxadd" :
    $name = ( $_POST['name'] );
    $location = ( $_POST['location'] );
    $ip = ( $_POST['ip'] );
    $login = ( $_POST['login'] );
    $password = ( $_POST['password'] );
    $ftpport = ( $_POST['ftpport'] );
    $sshport = ( $_POST['sshport'] );
    $ostype = ( $_POST['ostype'] );
    $cost = ( $_POST['cost'] );
    $notes = ( $_POST['notes'] );
    $verify = ( $_POST['verify'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['name'] = $name;
    $_SESSION['location'] = $location;
    $_SESSION['ip'] = $ip;
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION['ftpport'] = $ftpport;
    $_SESSION['sshport'] = $sshport;
    $_SESSION['ostype'] = $ostype;
    $_SESSION['cost'] = $cost;
    $_SESSION['notes'] = $notes;
    $_SESSION['verify'] = $verify;
    $len = ( $name );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Server Name [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $location );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Server Location [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $ip );
    if ( $len <= "2" )
    {
        $_SESSION['msg2'] .= "<li>IP Address [ <b>Not Long Enough</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `box` WHERE `ip` = '".$ip."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>IP Address [ <b>Already Used</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `ip` WHERE `ip` = '".$ip."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>IP Address [ <b>Already Used</b> ]</li>";
    }
    $len = ( $login );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Root Login [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $password );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Root Password [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $ftpport );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>FTP Port [ <b>Not Entered</b> ]</li>";
    }
    else if ( !( $ftpport ) )
    {
        $_SESSION['msg2'] .= "<li>FTP Port [ <b>Not Numerical</b> ]</li>";
    }
    $len = ( $sshport );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>SSH Port [ <b>Not Entered</b> ]</li>";
    }
    else if ( !( $sshport ) )
    {
        $_SESSION['msg2'] .= "<li>SSH Port [ <b>Not Numerical</b> ]</li>";
    }
    if ( LIMITBOXES < ( "SELECT `boxid` FROM `box`" ) + 1 )
    {
        $_SESSION['msg2'] .= "<li>License Error [ <b>All Box Slots Used</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['formerror'] = 1;
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: boxadd.php" );
        exit( );
    }
    if ( $verify == "on" )
    {
        if ( !( "ssh2" ) )
        {
            $_SESSION['msg1'] = "SSH2 Extension Error!";
            $_SESSION['msg2'] = "SSH2 Extension not detected!";
            ( "Location: boxadd.php" );
            exit( );
        }
        if ( !( $sshconnection = @( $ip, $sshport ) ) )
        {
            $_SESSION['msg1'] = "Connection Error!";
            $_SESSION['msg2'] = "Unable to connect to box with SSH.";
            ( "Location: boxadd.php" );
            exit( );
        }
        if ( !( $sshconnection, $login, $password ) )
        {
            $_SESSION['msg1'] = "Authentication Error!";
            $_SESSION['msg2'] = "Unable to login to box with SSH.";
            ( "Location: boxadd.php" );
            exit( );
        }
    }
    unset( $_SESSION['name'] );
    unset( $_SESSION['location'] );
    unset( $_SESSION['ip'] );
    unset( $_SESSION['login'] );
    unset( $_SESSION['password'] );
    unset( $_SESSION['ftpport'] );
    unset( $_SESSION['sshport'] );
    unset( $_SESSION['ostype'] );
    unset( $_SESSION['cost'] );
    unset( $_SESSION['notes'] );
    unset( $_SESSION['verify'] );
    ( "INSERT INTO `box` SET `name` = '".$name."', `location` = '".$location."', `ip` = '".$ip."', `login` = '".$login."', `password` = '".@( $password )."', `ftpport` = '".$ftpport."', `sshport` = '".$sshport."', `ostype` = '".$ostype."', `cost` = '".$cost."', `notes` = '".$notes."', `ftp` = 'Online', `ssh` = 'Online', `load` = '~', `idle` = '~', `passive` = 'On'" );
    $boxid = ( );
    $message = "Box Added: <a href=\"boxsummary.php?id=".$boxid."\">".$name."</a>";
    ( "INSERT INTO `log` SET `boxid` = '".$boxid."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Box Added Successfully!";
    $_SESSION['msg2'] = "The box has been added and is ready for use.";
    ( "Location: boxsummary.php?id=".( $boxid ) );
    exit( );
    break;
case "boxprofile" :
    $boxid = ( $_POST['boxid'] );
    $name = ( $_POST['name'] );
    $location = ( $_POST['location'] );
    $ip = ( $_POST['ip'] );
    $login = ( $_POST['login'] );
    $password = ( $_POST['password'] );
    $ftpport = ( $_POST['ftpport'] );
    $sshport = ( $_POST['sshport'] );
    $ostype = ( $_POST['ostype'] );
    $cost = ( $_POST['cost'] );
    $passive = ( $_POST['passive'] );
    $notes = ( $_POST['notes'] );
    $verify = ( $_POST['verify'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['name'] = $name;
    $_SESSION['location'] = $location;
    $_SESSION['ip'] = $ip;
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION['ftpport'] = $ftpport;
    $_SESSION['sshport'] = $sshport;
    $_SESSION['ostype'] = $ostype;
    $_SESSION['cost'] = $cost;
    $_SESSION['passive'] = $passive;
    $_SESSION['notes'] = $notes;
    $_SESSION['verify'] = $verify;
    $len = ( $name );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Server Name [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $location );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Server Location [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $ip );
    if ( $len <= "2" )
    {
        $_SESSION['msg2'] .= "<li>IP Address [ <b>Not Long Enough</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `box` WHERE `ip` = '".$ip."' && `boxid` != '".$boxid."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>IP Address [ <b>Already Used</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `ip` WHERE `ip` = '".$ip."' && `boxid` != '".$boxid."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>IP Address [ <b>Already Used</b> ]</li>";
    }
    $len = ( $login );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Root Login [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $ftpport );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>FTP Port [ <b>Not Entered</b> ]</li>";
    }
    else if ( !( $ftpport ) )
    {
        $_SESSION['msg2'] .= "<li>FTP Port [ <b>Not Numerical</b> ]</li>";
    }
    $len = ( $sshport );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>SSH Port [ <b>Not Entered</b> ]</li>";
    }
    else if ( !( $sshport ) )
    {
        $_SESSION['msg2'] .= "<li>SSH Port [ <b>Not Numerical</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['formerror'] = 1;
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: boxprofile.php?id=".( $boxid ) );
        exit( );
    }
    if ( empty( $password ) )
    {
        $rows = ( "SELECT `password` FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
        $password = @( $rows['password'] );
    }
    if ( $verify == "on" )
    {
        if ( !( "ssh2" ) )
        {
            $_SESSION['msg1'] = "SSH2 Extension Error!";
            $_SESSION['msg2'] = "SSH2 Extension not detected!";
            ( "Location: boxprofile.php?id=".( $boxid ) );
            exit( );
        }
        if ( !( $sshconnection = @( $ip, $sshport ) ) )
        {
            $_SESSION['msg1'] = "Connection Error!";
            $_SESSION['msg2'] = "Unable to connect to box with SSH.";
            ( "Location: boxprofile.php?id=".( $boxid ) );
            exit( );
        }
        if ( !( $sshconnection, $login, $password ) )
        {
            $_SESSION['msg1'] = "Authentication Error!";
            $_SESSION['msg2'] = "Unable to login to box with SSH.";
            ( "Location: boxprofile.php?id=".( $boxid ) );
            exit( );
        }
    }
    unset( $_SESSION['name'] );
    unset( $_SESSION['location'] );
    unset( $_SESSION['ip'] );
    unset( $_SESSION['login'] );
    unset( $_SESSION['password'] );
    unset( $_SESSION['ftpport'] );
    unset( $_SESSION['sshport'] );
    unset( $_SESSION['ostype'] );
    unset( $_SESSION['cost'] );
    unset( $_SESSION['passive'] );
    unset( $_SESSION['notes'] );
    unset( $_SESSION['verify'] );
    ( "UPDATE `box` SET `name` = '".$name."', `location` = '".$location."', `ip` = '".$ip."', `login` = '".$login."', `password` = '".@( $password )."', `ftpport` = '".$ftpport."', `sshport` = '".$sshport."', `ostype` = '".$ostype."', `cost` = '".$cost."', `passive` = '".$passive."', `notes` = '".$notes."' WHERE `boxid` = '".$boxid."'" );
    $message = "Box Edited: <a href=\"boxsummary.php?id=".$boxid."\">".$name."</a>";
    ( "INSERT INTO `log` SET `boxid` = '".$boxid."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Box Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the box have been saved.";
    ( "Location: boxsummary.php?id=".( $boxid ) );
    exit( );
    break;
case "boxnotes" :
    $boxid = ( $_POST['boxid'] );
    $notes = ( $_POST['notes'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    ( "UPDATE `box` SET `notes` = '".$notes."' WHERE `boxid` = '".$boxid."'" );
    $_SESSION['msg1'] = "Admin Notes Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the admin notes have been saved.";
    ( "Location: boxsummary.php?id=".( $boxid ) );
    exit( );
    break;
case "boxdelete" :
    $boxid = ( $_GET['id'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    if ( ( "SELECT `ipid` FROM `ip` WHERE `boxid` = '".$boxid."'" ) != 0 )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "Assigned IP Addresses must be deleted.";
        ( "Location: boxsummary.php?id=".( $boxid ) );
        exit( );
    }
    $rows = ( "SELECT `name` FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
    ( "DELETE FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
    $message = "Box Deleted: ".$rows['name'];
    ( "INSERT INTO `log` SET `boxid` = '".$boxid."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Box Deleted Successfully!";
    $_SESSION['msg2'] = "The selected box has been removed.";
    ( "Location: box.php" );
    exit( );
    break;
case "boxipadd" :
    $boxid = ( $_POST['boxid'] );
    $ip = ( $_POST['ip'] );
    $usage = ( $_POST['usage'] );
    $verify = ( $_POST['verify'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['ip'] = $ip;
    $_SESSION['usage'] = $usage;
    $_SESSION['verify'] = $verify;
    $len = ( $ip );
    if ( $len <= "2" )
    {
        $_SESSION['msg2'] .= "<li>IP Address [ <b>Not Long Enough</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `box` WHERE `ip` = '".$ip."' && `boxid` != '".$boxid."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>IP Address [ <b>Already Used</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `ip` WHERE `ip` = '".$ip."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>IP Address [ <b>Already Used</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['formerror'] = 1;
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: boxipadd.php?id=".( $boxid ) );
        exit( );
    }
    if ( $verify == "on" )
    {
        if ( !( "ssh2" ) )
        {
            $_SESSION['msg1'] = "SSH2 Extension Error!";
            $_SESSION['msg2'] = "SSH2 Extension not detected!";
            ( "Location: boxprofile.php?id=".( $boxid ) );
            exit( );
        }
        $rows = ( "SELECT `sshport` FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
        if ( !( $sshconnection = @( $ip, $rows['sshport'] ) ) )
        {
            $_SESSION['msg1'] = "Connection Error!";
            $_SESSION['msg2'] = "Unable to connect to IP Address with SSH.";
            ( "Location: boxipadd.php?id=".( $boxid ) );
            exit( );
        }
    }
    unset( $_SESSION['ip'] );
    unset( $_SESSION['usage'] );
    unset( $_SESSION['verify'] );
    ( "INSERT INTO `ip` SET `boxid` = '".$boxid."', `ip` = '".$ip."', `usage` = '".$usage."'" );
    $rows1 = ( "SELECT `name` FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
    $message = "IP Added: ".$ip." to <a href=\"boxsummary.php?id=".$boxid."\">".$rows1['name']."</a>";
    ( "INSERT INTO `log` SET `boxid` = '".$boxid."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "IP Address Added Successfully!";
    $_SESSION['msg2'] = "The IP address has been added and is ready for use.";
    ( "Location: boxsummary.php?id=".( $boxid ) );
    exit( );
    break;
case "boxipedit" :
    $ipid = ( $_POST['ipid'] );
    $boxid = ( $_POST['boxid'] );
    $usage = ( $_POST['usage'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    ( "UPDATE `ip` SET `usage` = '".$usage."' WHERE `ipid` = '".$ipid."'" );
    $_SESSION['msg1'] = "IP Address Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the IP address have been saved.";
    ( "Location: boxsummary.php?id=".( $boxid ) );
    exit( );
    break;
case "boxipdelete" :
    $ipid = ( $_GET['ipid'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $rows = ( "SELECT `boxid`, `ip` FROM `ip` WHERE `ipid` = '".$ipid."'" );
    if ( ( "SELECT * FROM `server` WHERE `ipid` = '".$ipid."'" ) != 0 )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "Assigned servers must be deleted.";
        ( "Location: boxsummary.php?id=".( $rows['boxid'] ) );
        exit( );
    }
    ( "DELETE FROM `ip` WHERE `ipid` = '".$ipid."' LIMIT 1" );
    $rows1 = ( "SELECT `name` FROM `box` WHERE `boxid` = '".$rows['boxid']."' LIMIT 1" );
    $message = "IP Deleted: ".$rows['ip']." from <a href=\"boxsummary.php?id=".$rows['boxid']."\">".$rows1['name']."</a>";
    ( "INSERT INTO `log` SET `boxid` = '".$rows['boxid']."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $GLOBALS['_SESSION']['msg1'] = "IP Address Deleted Successfully!";
    $_SESSION['msg2'] = "The selected IP address has been removed.";
    ( "Location: boxsummary.php?id=".( $rows['boxid'] ) );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

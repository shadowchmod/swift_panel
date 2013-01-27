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
include( "./includes/ftp.php" );
$task = ( $_POST['task'] );
if ( empty( $task ) )
{
    $task = ( $_GET['task'] );
}
$serverid = ( $_POST['id'] );
if ( empty( $serverid ) )
{
    $serverid = ( $_GET['id'] );
}
$path = ( $_POST['path'] );
if ( empty( $path ) )
{
    $path = ( $_GET['path'] );
}
if ( !empty( $serverid ) )
{
    $rows = ( "SELECT `ipid`, `boxid`, `user`, `password` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
    if ( !empty( $rows['ipid'] ) )
    {
        $rows1 = ( "SELECT `ip` FROM `ip` WHERE `ipid` = '".$rows['ipid']."' LIMIT 1" );
        $rows2 = ( "SELECT `ftpport`, `passive` FROM `box` WHERE `boxid` = '".$rows['boxid']."' LIMIT 1" );
        if ( $rows2['passive'] == "On" )
        {
            $passive = TRUE;
        }
        else
        {
            $passive = FALSE;
        }
        if ( !( $ftpconnection = ( $rows1['ip'], $rows2['ftpport'], $rows['user'], $rows['password'], $passive ) ) )
        {
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    else
    {
        $_SESSION['msg1'] = "FTP Connection Failed!";
        $_SESSION['msg2'] = "Could not connect to the FTP.";
        ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
        exit( );
    }
}
switch ( $task )
{
case "filesave" :
    $file = $_POST['file'];
    $filecontents = $_POST['filecontents'];
    if ( empty( $filecontents ) )
    {
        $_SESSION['msg1'] = "File Save Failed!";
        $_SESSION['msg2'] = "The file has not been saved.";
        ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
        exit( );
    }
    $filecontents = ( "\\r\\n", "\n", $filecontents );
    $filecontents = ( "\\\"", "\"", $filecontents );
    $filecontents = ( "\\'", "'", $filecontents );
    $filecontents = ( "\\\\", "\\", $filecontents );
    $tempHandle = ( "php://temp", "r+" );
    if ( $tempHandle == FALSE )
    {
        $_SESSION['msg1'] = "File Save Failed!";
        $_SESSION['msg2'] = "The file has not been saved.";
        ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
        exit( );
    }
    if ( ( $tempHandle, $filecontents ) === FALSE )
    {
        $_SESSION['msg1'] = "File Save Failed!";
        $_SESSION['msg2'] = "The file has not been saved.";
        ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
        exit( );
    }
    ( $tempHandle );
    if ( ( $path, 0 - 1 ) == "/" || empty( $path ) )
    {
        if ( !( $ftpconnection, $path.$file, $tempHandle, FTP_BINARY ) )
        {
            $_SESSION['msg1'] = "File Save Failed!";
            $_SESSION['msg2'] = "The file has not been saved.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    else
    {
        if ( !( $ftpconnection, $path."/".$file, $tempHandle, FTP_BINARY ) )
        {
            $_SESSION['msg1'] = "File Save Failed!";
            $_SESSION['msg2'] = "The file has not been saved.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    $_SESSION['msg1'] = "File Saved Successfully!";
    $_SESSION['msg2'] = "The file has been saved.";
    ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
    exit( );
    break;
case "fileupload" :
    if ( 0 < $_FILES['file']['error'] )
    {
        $_SESSION['msg1'] = "File Save Failed!";
        $_SESSION['msg2'] = "The file has not been saved.";
        ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
        exit( );
    }
    $filecontents = ( $_FILES['file']['tmp_name'] );
    $tempHandle = ( "php://temp", "r+" );
    ( $tempHandle, $filecontents );
    ( $tempHandle );
    if ( ( $path, 0 - 1 ) == "/" || empty( $path ) )
    {
        if ( !( $ftpconnection, $path.$_FILES['file']['name'], $tempHandle, FTP_BINARY ) )
        {
            $_SESSION['msg1'] = "File Save Failed!";
            $_SESSION['msg2'] = "The file has not been saved.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    else
    {
        if ( !( $ftpconnection, $path."/".$_FILES['file']['name'], $tempHandle, FTP_BINARY ) )
        {
            $_SESSION['msg1'] = "File Save Failed!";
            $_SESSION['msg2'] = "The file has not been saved.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    $_SESSION['msg1'] = "File Saved Successfully!";
    $_SESSION['msg2'] = "The file has been saved.";
    ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
    exit( );
    break;
case "filedelete" :
    $file = $_GET['file'];
    if ( empty( $_GET['file'] ) )
    {
        $_SESSION['msg1'] = "File Delete Failed!";
        $_SESSION['msg2'] = "The file has not been deleted.";
        ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
        exit( );
    }
    if ( ( $path, 0 - 1 ) == "/" || empty( $path ) )
    {
        if ( !( $ftpconnection, $path.$file ) )
        {
            $_SESSION['msg1'] = "File Delete Failed!";
            $_SESSION['msg2'] = "The file has not been deleted.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    else
    {
        if ( !( $ftpconnection, $path."/".$file ) )
        {
            $_SESSION['msg1'] = "File Delete Failed!";
            $_SESSION['msg2'] = "The file has not been deleted.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    $_SESSION['msg1'] = "File Deleted Successfully!";
    $_SESSION['msg2'] = "The file has been deleted.";
    ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
    exit( );
    break;
case "dirdelete" :
    $dir = $_GET['dir'];
    if ( ( $path, 0 - 1 ) == "/" || empty( $path ) )
    {
        if ( !( $ftpconnection, $path.$dir ) )
        {
            $_SESSION['msg1'] = "Directory Delete Failed!";
            $_SESSION['msg2'] = "The directory has not been deleted.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    else
    {
        if ( !( $ftpconnection, $path."/".$dir ) )
        {
            $_SESSION['msg1'] = "Directory Delete Failed!";
            $_SESSION['msg2'] = "The directory has not been deleted.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    $_SESSION['msg1'] = "Directory Deleted Successfully!";
    $_SESSION['msg2'] = "The directory has been deleted.";
    ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
    exit( );
    break;
case "makedir" :
    $dir = $_POST['dir'];
    if ( ( $path, 0 - 1 ) == "/" || empty( $path ) )
    {
        if ( !( $ftpconnection, $path.$dir ) )
        {
            $_SESSION['msg1'] = "Directory Creation Failed!";
            $_SESSION['msg2'] = "The directory has not been created.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    else
    {
        if ( !( $ftpconnection, $path."/".$dir ) )
        {
            $_SESSION['msg1'] = "Directory Creation Failed!";
            $_SESSION['msg2'] = "The directory has not been created.";
            ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
            exit( );
        }
    }
    $_SESSION['msg1'] = "Directory Created Successfully!";
    $_SESSION['msg2'] = "The directory has been created.";
    ( "Location: serverftp.php?id=".( $serverid )."&path=".( $path ) );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

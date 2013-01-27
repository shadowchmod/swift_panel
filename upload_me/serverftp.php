<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Server Web FTP";
$page = "serverftp";
$return = "serverftp.php?id=".$_GET['id'];
require( "./configuration.php" );
require( "./include.php" );
require( "./includes/ftp.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$serverid = ( $_GET['id'] );
$path = ( $_GET['path'] );
$file = ( $_GET['file'] );
$rows = ( "SELECT `serverid`, `ipid`, `boxid`, `user`, `password`, `webftp` FROM `server` WHERE `serverid` = '".$serverid."'  && `clientid` = '".$_SESSION['clientid']."' LIMIT 1" );
if ( !$rows['webftp'] )
{
    ( "Location: serversummary.php?id=".( $serverid ) );
    exit( );
}
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
    if ( $ftpconnection = ( $rows1['ip'], $rows2['ftpport'], $rows['user'], $rows['password'], $passive ) )
    {
        if ( empty( $file ) )
        {
            $array = ( $ftpconnection, $path );
            if ( !( $array ) )
            {
                $path = ( $path );
                $array = ( $ftpconnection, $path );
            }
            if ( ( $array ) )
            {
                foreach ( $array as $folder )
                {
                    $struc = array( );
                    $current = ( "/[\\s]+/", $folder, 9 );
                    $struc['perms'] = $current[0];
                    $struc['permsn'] = ( $current[0] );
                    $struc['number'] = $current[1];
                    $struc['owner'] = $current[2];
                    $struc['group'] = $current[3];
                    $struc['size'] = ( $current[4] );
                    $struc['month'] = $current[5];
                    $struc['day'] = $current[6];
                    $struc['time'] = $current[7];
                    $struc['name'] = ( "//", "", $current[8] );
                    if ( ( $path, 0, 1 ) == "/" )
                    {
                        $struc['path'] = ( $path."/".$struc['name'] );
                    }
                    else
                    {
                        $struc['path'] = ( $path.$struc['name']."/" );
                    }
                    if ( $struc['name'] != "." && $struc['name'] != ".." )
                    {
                        if ( ( $struc['perms'] ) == "folder" )
                        {
                            $folders[] = $struc;
                        }
                        else if ( ( $struc['perms'] ) == "link" )
                        {
                            $links[] = $struc;
                        }
                        else
                        {
                            $struc['link'] = ( $struc['name'] );
                            $files[] = $struc;
                        }
                    }
                }
            }
        }
        else
        {
            $tempHandle = ( "php://temp", "r+" );
            if ( ( $path, 0 - 1 ) == "/" )
            {
                if ( !( $ftpconnection, $tempHandle, $path.$file, FTP_BINARY ) )
                {
                    $path = ( $path );
                    @( $ftpconnection, $tempHandle, $path."/".$file, FTP_BINARY );
                }
            }
            else if ( !( $ftpconnection, $tempHandle, $path."/".$file, FTP_BINARY ) )
            {
                $path = ( $path );
                @( $ftpconnection, $tempHandle, $path.$file, FTP_BINARY );
            }
            ( $tempHandle );
            $filecontents = ( $tempHandle );
        }
    }
}
$smarty->display( "header.tpl" );
$smarty->assign( "path", ( $path ) );
$smarty->assign( "path_decoded", $path );
$smarty->assign( "file", $file );
$smarty->assign( "srv", $rows );
$smarty->assign( "bread_crumb", ( $path ) );
$smarty->assign( "folders", $folders );
$smarty->assign( "files", $files );
$smarty->assign( "file_contents", $filecontents );
$smarty->assign( "max_filesize", ( "upload_max_filesize" ) );
if ( $_SESSION['msg1'] )
{
    $smarty->assign( "e_msg1", $_SESSION['msg1'] );
    $smarty->assign( "e_msg2", $_SESSION['msg2'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
}
$smarty->display( "serverftp.tpl" );
if ( BRANDING )
{
    echo "<br /><div align='center'>Powered By <a href='http://www.swiftpanel.com' style='font-weight:bold;' target='_blank'>SWIFT Panel</a></div>";
}
$smarty->display( "footer.tpl" );
?>

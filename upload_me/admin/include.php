<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

if ( !( "LICENSE" ) )
{
    exit( "Access Denied" );
}
( E_ALL ^ E_NOTICE );
( "PHPSESSION" );
( "30" );
( );
if ( empty( $_SESSION['adminid'] ) && !empty( $return ) )
{
    if ( $return === TRUE )
    {
        ( "Location: login.php" );
        exit( );
    }
    else
    {
        ( "Location: login.php?return=".$return );
        exit( );
    }
}
if ( $page == "index" && @( "../install" ) )
{
    exit( "<html><head></head><body><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px dashed #CC0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#CC0000;text-align:center;\"><tr><td><b>Install Directory Detected</b><br />Please delete the install directory after the installation or update is complete.<br />Contact Swift Panel Support if you need help. <a href='http://www.swiftpanel.com/client'>Swift Panel Client Area</a></td></tr></table></body></html>" );
}
require( "../includes/functions1.php" );
require( "../includes/functions2.php" );
require( "../includes/functions3.php" );
require( "../includes/functions4.php" );
require( "../includes/mysql.php" );
if ( !empty( $_SESSION['adminid'] ) )
{
    $adminverify = ( "SELECT `adminid`, `username`, `firstname`, `lastname` FROM `admin` WHERE `adminid` = '".$_SESSION['adminid']."' AND `status` = 'Active'" );
    if ( ( $adminverify ) != 1 )
    {
        ( );
        ( "Location: login.php" );
        exit( );
    }
    else
    {
        $adminverify = ( $adminverify );
        if ( $adminverify['username'] != $_SESSION['adminusername'] || $adminverify['firstname'] != $_SESSION['adminfirstname'] || $adminverify['lastname'] != $_SESSION['adminlastname'] )
        {
            ( );
            ( "Location: login.php" );
            exit( );
        }
    }
}
$panelversion = ( "SELECT `value` FROM `config` WHERE `setting` = 'panelversion' LIMIT 1", TRUE );
if ( $panelversion['value'] != "1.6.1" )
{
    exit( "<html><head></head><body><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px dashed #CC0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#CC0000;text-align:center;\"><tr><td><b>Wrong Database Version Detected</b><br />Make sure you have followed the instructions to install/update the database.<br />Contact Swift Panel Support if you need help. <a href='http://www.swiftpanel.com/client'>Swift Panel Client Area</a></td></tr></table></body></html>" );
}
$panelname = ( "SELECT `value` FROM `config` WHERE `setting` = 'panelname' LIMIT 1", TRUE );
( "VERSION", $panelversion['value'] );
( "SITENAME", $panelname['value'] );
( "TEMPLATE", "default" );
?>

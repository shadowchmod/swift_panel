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
if ( empty( $_SESSION['clientid'] ) && !empty( $return ) )
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
require( "./includes/functions1.php" );
require( "./includes/functions2.php" );
require( "./includes/functions3.php" );
require( "./includes/mysql.php" );
$panelversion = ( "SELECT `value` FROM `config` WHERE `setting` = 'panelversion' LIMIT 1", TRUE );
if ( $panelversion['value'] != "1.6.1" )
{
    exit( "<html><head></head><body><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px dashed #CC0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#CC0000;text-align:center;\"><tr><td><b>Site Under Maintance</b><br />Make sure you have followed the instructions to install/update the database.<br />Contact Swift Panel Support if you need help. <a href='http://www.swiftpanel.com/client'>Swift Panel Client Area</a></td></tr></table></body></html>" );
}
$panelname = ( "SELECT `value` FROM `config` WHERE `setting` = 'panelname' LIMIT 1", TRUE );
( "SITENAME", $panelname['value'] );
( "VERSION", $panelversion['value'] );
if ( $_GET['style'] )
{
    ( "TEMPLATE", ( $_GET['style'] ) );
}
else
{
    $template = ( "SELECT `value` FROM `config` WHERE `setting` = 'template' LIMIT 1" );
    ( "TEMPLATE", $template['value'] );
}
if ( $page != "login" )
{
    $loggedin = TRUE;
}
else
{
    $loggedin = FALSE;
}
require_once( "./libs/Smarty.class.php" );
$smarty = new Smarty( );
$smarty->template_dir = "./templates/".TEMPLATE;
$smarty->compile_dir = "./templates_c";
$smarty->assign( "site_title", $title == "" ? SITENAME : $title." - ".SITENAME );
$smarty->assign( "site_name", SITENAME );
$smarty->assign( "page_title", $title );
$smarty->assign( "template", TEMPLATE );
$smarty->assign( "logged_in", $loggedin );
$smarty->assign( "e_msg1", $_SESSION['msg1'] );
$smarty->assign( "e_msg2", $_SESSION['msg2'] );
unset( $_SESSION['msg1'] );
unset( $_SESSION['msg2'] );
?>

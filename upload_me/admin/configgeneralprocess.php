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
case "generaledit" :
    $panelname = ( $_POST['panelname'] );
    $systemurl = ( $_POST['systemurl'] );
    $template = ( $_POST['template'] );
    $country = ( $_POST['country'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['panelname'] = $panelname;
    $_SESSION['systemurl'] = $systemurl;
    $_SESSION['template'] = $template;
    $_SESSION['country'] = $country;
    $len = ( $panelname );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Panel Name [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $systemurl );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>System URL [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $template );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Template [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $country );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Country [ <b>Not Entered</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['msg1'] = "Validation Error!";
        ( "Location: configgeneral.php" );
        exit( );
    }
    unset( $_SESSION['panelname'] );
    unset( $_SESSION['systemurl'] );
    unset( $_SESSION['template'] );
    unset( $_SESSION['country'] );
    ( "UPDATE `config` SET `value` = '".$panelname."' WHERE `setting` = 'panelname'" );
    ( "UPDATE `config` SET `value` = '".$systemurl."' WHERE `setting` = 'systemurl'" );
    ( "UPDATE `config` SET `value` = '".$template."' WHERE `setting` = 'template'" );
    ( "UPDATE `config` SET `value` = '".$country."' WHERE `setting` = 'country'" );
    $_SESSION['msg1'] = "Settings Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the settings have been saved.";
    ( "Location: configgeneral.php" );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

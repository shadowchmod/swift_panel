<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Cron Settings";
$page = "configcron";
$tab = "6";
$return = "configcron.php";
$image = "edit_48";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<p>To enable server monitoring, set up the cron job to run every 10 minutes.</p>\r\n<center>\r\n<fieldset style=\"width:80%;\">\r\n<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"fieldname\" style=\"padding-right:10px;text-align:center;\">\r\n    Create the following Cron Job using PHP:<br />\r\n    <img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" height=\"3\" width=\"1\" alt=\"\" /><br />\r\n    <input type=\"text\" class=\"text\" size=\"100\" value=\"php -q ";
echo ( $_SERVER['SCRIPT_FILENAME'], 0, @( $_SERVER['SCRIPT_FILENAME'], "/" ) )."/cron.php";
echo "\" />\r\n    </td>\r\n  </tr>\r\n</table>\r\n</fieldset>\r\n</center>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

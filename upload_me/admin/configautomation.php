<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Automation Settings";
$page = "configcron";
$tab = "6";
$return = "configcron.php";
$image = "admin_48";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<table width=\"90%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td align=\"center\" class=\"fieldname\"><input type=\"text\" size=\"100\" value=\"php -q ";
echo ( $_SERVER['SCRIPT_FILENAME'], 0, @( $_SERVER['SCRIPT_FILENAME'], "/" ) )."/cron/cron.php";
echo "\" />\r\n    </td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

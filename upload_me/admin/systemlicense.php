<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "License Information";
$page = "systemlicense";
$tab = "5";
$return = "systemlicense.php";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<fieldset>\r\n  <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n    <tr>\r\n      <td class=\"fieldname\" style=\"width:140px;\">Registered To</td>\r\n      <td class=\"fieldarea\">";
echo $returned['registeredname'];
echo "</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">License Key</td>\r\n      <td class=\"fieldarea\">";
echo LICENSE;
echo "</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">License Type</td>\r\n      <td class=\"fieldarea\">";
echo $returned['productname'];
echo "</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Allowed Boxes</td>\r\n      <td class=\"fieldarea\">";
echo LIMITBOXES;
echo " <font color=\"#666666\">(Used: ";
echo ( "SELECT `boxid` FROM `box`" );
echo ")</font></td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Branding</td>\r\n      <td class=\"fieldarea\">";
if ( BRANDING )
{
    echo "Powered By Line";
}
else
{
    echo "None";
}
echo "</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Valid Do".__FILE__."</td>\r\n      <td class=\"fieldarea\">";
echo $returned['validdo".__FILE__];
echo "</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Valid IP</td>\r\n      <td class=\"fieldarea\">";
echo $returned['validip'];
echo "</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Created</td>\r\n      <td class=\"fieldarea\">";
echo $returned['regdate'];
echo "</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Expires</td>\r\n      <td class=\"fieldarea\">";
if ( $returned['nextduedate'] == "0000-00-00" )
{
    echo "Never";
}
else
{
    echo $returned['nextduedate'];
}
echo "</td>\r\n    </tr>\r\n  </table>\r\n</fieldset>\r\n<img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" height=\"10\" width=\"1\" alt=\"\" /><br />\r\n<div align=\"center\">\r\n  <input type=\"button\" value=\"Update Local Key\" onclick=\"window.location='process.php?task=localkey'\" class=\"button green\" />\r\n</div>\r\n  <p>If you are planning on moving your copy of SWIFT Panel to a different server, you will need to reissue your license. You can do that by <a href=\"http://www.swiftpanel.com/client\" target";
echo "=\"_blank\">clicking here</a>.</p>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

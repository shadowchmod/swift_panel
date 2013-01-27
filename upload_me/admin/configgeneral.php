<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "General Settings";
$page = "configgeneral";
$tab = "6";
$return = "configgeneral.php";
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/countries.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$panelname = ( "SELECT `value` FROM `config` WHERE `setting` = 'panelname' LIMIT 1" );
$systemurl = ( "SELECT `value` FROM `config` WHERE `setting` = 'systemurl' LIMIT 1" );
$template = ( "SELECT `value` FROM `config` WHERE `setting` = 'template' LIMIT 1" );
$country = ( "SELECT `value` FROM `config` WHERE `setting` = 'country' LIMIT 1" );
if ( empty( $_SESSION['panelname'] ) )
{
    $_SESSION['panelname'] = $panelname['value'];
}
if ( empty( $_SESSION['systemurl'] ) )
{
    $_SESSION['systemurl'] = $systemurl['value'];
}
if ( empty( $_SESSION['template'] ) )
{
    $_SESSION['template'] = $template['value'];
}
if ( empty( $_SESSION['country'] ) )
{
    $_SESSION['country'] = $country['value'];
}
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<form method=\"post\" action=\"configgeneralprocess.php\">\r\n  <input type=\"hidden\" name=\"task\" value=\"generaledit\" />\r\n  <table width=\"100%\" border=\"0\" cellspacing=\"0\">\r\n    <tr>\r\n      <td width=\"5\" class=\"tabspacer\"><img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"5\" height=\"1\" alt=\"\" /></td>\r\n      <td id=\"tabs1\" class=\"tabsactive\" onclick=\"toggleTab(1)\">General</td>\r\n      <td width=\"2\" class=\"tabspacer\"><img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"2\" height=\"1\" alt=\"\" /></td>\r\n      <td id=\"tabs2\" class=\"tabs\" onclick=\"toggleTab(2)\">Localize</td>\r\n      <td width=\"2\" class=\"tabspacer\"><img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"2\" height=\"1\" alt=\"\" /></td>\r\n      <td id=\"tabs3\" class=\"tabs\" onclick=\"toggleTab(3)\">Support</td>\r\n      <td width=\"100%\" class=\"tabspacer\">&nbsp;</td>\r\n    </tr>\r\n    <tr id=\"tab1\">\r\n      <td class=\"tab\" colspan=\"7\"><fieldset>\r\n        <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n          <tr>\r\n            <td class=\"fieldname\" style=\"width:140px;\">Panel Nam";
echo "e</td>\r\n            <td class=\"fieldarea\"><input type=\"text\" name=\"panelname\" class=\"text\" size=\"35\" value=\"";
if ( isset( $_SESSION['panelname'] ) )
{
    echo $_SESSION['panelname'];
    unset( $_SESSION['panelname'] );
}
echo "\" /><br />\r\n              <font color=\"#222222\" size=\"-2\">The name of the panel for the header in the client panel</font></td>\r\n          </tr>\r\n          <tr>\r\n            <td class=\"fieldname\">Panel URL</td>\r\n            <td class=\"fieldarea\"><input type=\"text\" name=\"systemurl\" class=\"text\" size=\"45\" value=\"";
if ( isset( $_SESSION['systemurl'] ) )
{
    echo $_SESSION['systemurl'];
    unset( $_SESSION['systemurl'] );
}
echo "\" /><br />\r\n              <font color=\"#222222\" size=\"-2\">URL of the client panel, eg. http://www.yourdo".__FILE__.".com/panel/</font></td>\r\n          </tr>\r\n          <tr>\r\n            <td class=\"fieldname\">Panel Template</td>\r\n            <td class=\"fieldarea\"><input type=\"text\" name=\"template\" class=\"text\" size=\"15\" value=\"";
if ( isset( $_SESSION['template'] ) )
{
    echo $_SESSION['template'];
    unset( $_SESSION['template'] );
}
echo "\" /><br />\r\n              <font color=\"#222222\" size=\"-2\">Name of the folder in templates</font></td>\r\n          </tr>\r\n          </table>\r\n        </fieldset></td>\r\n    </tr>\r\n    <tr id=\"tab2\" style=\"display:none;\">\r\n      <td class=\"tab\" colspan=\"7\"><fieldset>\r\n        <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n          <tr>\r\n            <td class=\"fieldname\" style=\"width:140px;\">Defaul";
echo "t Country</td>\r\n            <td class=\"fieldarea\">";
echo "<s";
echo "elect name=\"country\" class=\"select\">\r\n\t\t\t";
foreach ( $countries as $abbrev => $country )
{
    echo "<option value=\"".$abbrev."\"";
    if ( $abbrev == $_SESSION['country'] )
    {
        echo " selected=\"selected\"";
    }
    echo ">".$country."</option>";
}
echo "</select></td>\r\n          </tr>\r\n          </table>\r\n        </fieldset></td>\r\n    </tr>\r\n    <tr id=\"tab3\" style=\"display:none;\">\r\n      <td class=\"tab\" colspan=\"7\"><p align=\"center\"><b>Support Ticket Feature Coming Soon!</b></p></td>\r\n    </tr>\r\n  </table>\r\n  <img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" height=\"10\" width=\"1\" alt=\"\" /><br />\r\n  <div align=\"center\">\r\n    <input type=\"submit\" value=\"Save Changes\" class=\"button green\" />\r\n  </div>\r\n</form>\r\n";
echo "<s";
echo "cript language=\"javascript\" type=\"text/javascript\">var numtabs = 3;</script>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

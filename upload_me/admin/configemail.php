<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Email Templates";
$page = "configemail";
$tab = "6";
$return = "configemail.php";
$image = "mail_24";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$rows = ( "SELECT * FROM `emailtemp` WHERE `emailtempid` = '1'" );
if ( empty( $_SESSION['e1name'] ) )
{
    $_SESSION['e1name'] = $rows['name'];
}
if ( empty( $_SESSION['e1email'] ) )
{
    $_SESSION['e1email'] = $rows['email'];
}
if ( empty( $_SESSION['e1bcc'] ) )
{
    $_SESSION['e1bcc'] = $rows['bcc'];
}
if ( empty( $_SESSION['e1subject'] ) )
{
    $_SESSION['e1subject'] = $rows['subject'];
}
if ( empty( $_SESSION['e1template'] ) )
{
    $_SESSION['e1template'] = $rows['template'];
}
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<form method=\"post\" action=\"configemailprocess.php\">\r\n  <input type=\"hidden\" name=\"task\" value=\"emailedit\" />\r\n  <fieldset>\r\n  <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n    <tr>\r\n      <td colspan=\"2\" class=\"fieldheader\">New Client Account Email</td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\" style=\"width:140px;\">From</td>\r\n      <td class=\"fieldarea\"><input type=\"text\" name=\"e1na";
echo "me\" class=\"text\" size=\"25\" value=\"";
if ( isset( $_SESSION['e1name'] ) )
{
    echo $_SESSION['e1name'];
    unset( $_SESSION['e1name'] );
}
echo "\" />\r\n        <input type=\"text\" name=\"e1email\" class=\"text\" size=\"35\" value=\"";
if ( isset( $_SESSION['e1email'] ) )
{
    echo $_SESSION['e1email'];
    unset( $_SESSION['e1email'] );
}
echo "\" /></td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Bcc</td>\r\n      <td class=\"fieldarea\"><input type=\"text\" name=\"e1bcc\" class=\"text\" size=\"45\" value=\"";
if ( isset( $_SESSION['e1bcc'] ) )
{
    echo $_SESSION['e1bcc'];
    unset( $_SESSION['e1bcc'] );
}
echo "\" />\r\n        <font color=\"#666666\" size=\"-2\">(Seperate email addresses by a comma)</font></td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Subject</td>\r\n      <td class=\"fieldarea\"><input type=\"text\" name=\"e1subject\" class=\"text\" size=\"60\" value=\"";
if ( isset( $_SESSION['e1subject'] ) )
{
    echo $_SESSION['e1subject'];
    unset( $_SESSION['e1subject'] );
}
echo "\" /></td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Message</td>\r\n      <td class=\"fieldarea\"><textarea name=\"e1template\" class=\"textarea\" cols=\"100\" rows=\"11\">";
if ( isset( $_SESSION['e1template'] ) )
{
    echo $_SESSION['e1template'];
    unset( $_SESSION['e1template'] );
}
echo "</textarea></td>\r\n    </tr>\r\n    <tr>\r\n      <td class=\"fieldname\">Available Fields</td>\r\n      <td class=\"fieldarea\"><font color=\"#666666\"> &nbsp; {firstname} &nbsp; &nbsp; {lastname} &nbsp; &nbsp; {email} &nbsp; &nbsp; {password} &nbsp; &nbsp; {clientarealink}</font></td>\r\n    </tr>\r\n  </table>\r\n  </fieldset>\r\n  <img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" height=\"10\" width=\"1\" alt=\"\" /><br />\r\n  <div align=\"center\">\r\n    <input type=\"submit\" value=\"Save Changes\" class=\"button green\" />\r\n  </div>\r\n</form>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

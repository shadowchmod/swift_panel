<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Administrators";
$page = "configadmin";
$tab = "6";
$return = "configadmin.php";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$result = ( "SELECT * FROM `admin` ORDER BY `adminid`" );
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<p><b>";
echo ( $result );
echo " Records Found</b> (<a href=\"configadminadd.php\">Add New Administrator</a>)</p>\r\n<table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\" class=\"data\">\r\n    <tr>\r\n      <th width=\"40\">ID</th>\r\n      <th>Full Name</th>\r\n      <th>Email</th>\r\n      <th>Username</th>\r\n      <!--<th>Access Level</th>-->\r\n      <th>Last Login</th>\r\n      <th width=\"30\"></th>\r\n      <th width=\"30\"></th>\r\n    </tr>\r\n    ";
while ( $rows = ( $result ) )
{
    echo "    <tr onmouseover=\"this.className='mouseover';\" class=\"";
    echo $rows['status'];
    echo "\" onmouseout=\"this.className='";
    echo $rows['status'];
    echo "';\">\r\n      <td>";
    echo $rows['adminid'];
    echo "</td>\r\n      <td>";
    echo $rows['firstname'];
    echo " ";
    echo $rows['lastname'];
    echo "</td>\r\n      <td>";
    echo $rows['email'];
    echo "</td>\r\n      <td>";
    echo $rows['username'];
    echo "</td>\r\n      <!--<td>";
    echo $rows['access'];
    echo "</td>-->\r\n      <td>";
    echo ( $rows['lastlogin'] );
    echo "</td>\r\n      <td><a href=\"configadminedit.php?id=";
    echo $rows['adminid'];
    echo "\"><img src=\"templates/";
    echo TEMPLATE;
    echo "/images/buttons/edit24.png\" width=\"24\" height=\"24\" alt=\"Edit\" /></a></td>\r\n      <td><a href=\"#\" onclick=\"doDelete('";
    echo $rows['adminid'];
    echo "', '";
    echo $rows['firstname'];
    echo " ";
    echo $rows['lastname'];
    echo "')\"><img src=\"templates/";
    echo TEMPLATE;
    echo "/images/status/red.png\" width=\"25\" height=\"25\" alt=\"Delete\" /></a></td>\r\n    </tr>\r\n    ";
}
( $result );
echo "  </table>\r\n";
echo "<s";
echo "cript language=\"JavaScript\" type=\"text/javascript\">\r\n<!--\r\nfunction doDelete(id, name) { if (confirm(\"Are you sure you want to delete administrator: \"+name+\"?\")) { window.location='configadminprocess.php?task=configadmindelete&id='+id; } }\r\n-->\r\n</script>\r\n<br />\r\n<table align=\"center\">\r\n  <tr>\r\n    <td width=\"12\" align=\"right\"><table style=\"width:12px;height:12px;\" cellspacing=\"1\" class=\"data\">\r\n       ";
echo " <tr class=\"Active\">\r\n          <td></td>\r\n        </tr>\r\n      </table></td>\r\n    <td>Active</td>\r\n    <td width=\"5\"></td>\r\n    <td width=\"12\" align=\"right\"><table style=\"width:12px;height:12px;\" cellspacing=\"1\" class=\"data\">\r\n        <tr class=\"Suspended\">\r\n          <td></td>\r\n        </tr>\r\n      </table></td>\r\n    <td>Suspended</td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

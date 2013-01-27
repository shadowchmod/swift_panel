<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Box Summary";
$page = "boxsummary";
$tab = "4";
$return = "boxsummary.php?id=".$_GET['id'];
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$boxid = ( $_GET['id'] );
$rows = ( "SELECT * FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
$result1 = ( "SELECT * FROM `ip` WHERE `boxid` = '".$boxid."' ORDER BY `ip`" );
$result3 = ( "SELECT * FROM `log` WHERE `boxid` = '".$boxid."' ORDER BY `logid` DESC LIMIT 5" );
$tabs = array(
    "Summary" => "boxsummary.php?id=".$rows['boxid'],
    "Profile" => "boxprofile.php?id=".$rows['boxid'],
    "Servers" => "boxserver.php?id=".$rows['boxid'],
    "Game Files" => "boxgamefile.php?id=".$rows['boxid'],
    "Activity Logs" => "boxlog.php?id=".$rows['boxid']
);
include( "./templates/".TEMPLATE."/header.php" );
echo ( $tabs, 1 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">\r\n      ";
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "      <div style=\"font-size:18px;\">#";
echo $rows['boxid'];
echo " - ";
echo $rows['name'];
echo "</div>\r\n      <img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"1\" height=\"6\" alt=\"\" /><br />\r\n      <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n          <td width=\"50%\" valign=\"top\"><fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td colspan=\"2\" class=\"fieldheader\">Box Information</td>\r\n              </tr>\r\n              <tr>\r\n     ";
echo "           <td class=\"fieldname\" style=\"height:20px;width:110px;\">Name</td>\r\n                <td class=\"fieldarea\">";
echo $rows['name'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Location</td>\r\n                <td class=\"fieldarea\">";
echo $rows['location'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">IP Address</td>\r\n                <td class=\"fieldarea\">";
echo $rows['ip'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">OS Type</td>\r\n                <td class=\"fieldarea\">";
echo $rows['ostype'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Monthly Cost</td>\r\n                <td class=\"fieldarea\">";
echo $rows['cost'];
echo "</td>\r\n              </tr>\r\n            </table>\r\n            </fieldset>\r\n            <fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td colspan=\"2\" class=\"fieldheader\">Box Monitoring</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;width:110px;\">FTP</td>\r\n                <td cla";
echo "ss=\"fieldarea\">";
echo ( $rows['ftp'] );
echo "                  <font color=\"#666666\" size=\"-2\">(Port: ";
echo $rows['ftpport'];
echo ")</font></td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">SSH</td>\r\n                <td class=\"fieldarea\">";
echo ( $rows['ssh'] );
echo "                  <font color=\"#666666\" size=\"-2\">(Port: ";
echo $rows['sshport'];
echo ")</font></td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">CPU Load</td>\r\n                <td class=\"fieldarea\">";
echo $rows['load'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">CPU Idle</td>\r\n                <td class=\"fieldarea\">";
echo $rows['idle'];
echo "</td>\r\n              </tr>\r\n            </table>\r\n            </fieldset></td>\r\n          <td width=\"50%\" valign=\"top\"><fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td class=\"fieldheader\">Last 5 Actions</td>\r\n              </tr>\r\n              ";
if ( ( $result3 ) == 0 )
{
    echo "              <tr>\r\n                <td align=\"center\">No Logs Found</td>\r\n              </tr>\r\n              ";
}
echo "              ";
while ( $rows3 = ( $result3 ) )
{
    echo "              <tr>\r\n                <td style=\"font-size:11px;\">";
    echo ( $rows3['timestamp'] );
    echo " - ";
    echo $rows3['message'];
    echo "</td>\r\n              </tr>\r\n              ";
}
( $result3 );
echo "            </table>\r\n            </fieldset>\r\n            <fieldset>\r\n            <form method=\"post\" action=\"boxprocess.php\">\r\n              <input type=\"hidden\" name=\"task\" value=\"boxnotes\" />\r\n              <input type=\"hidden\" name=\"boxid\" value=\"";
echo $rows['boxid'];
echo "\" />\r\n              <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n                <tr>\r\n                  <td class=\"fieldheader\" colspan=\"2\">Admin Notes</td>\r\n                </tr>\r\n                <tr>\r\n                  <td width=\"350\" align=\"center\"><textarea name=\"notes\" class=\"textarea\" rows=\"4\" cols=\"60\">";
echo $rows['notes'];
echo "</textarea></td>\r\n                  <td align=\"center\"><input type=\"submit\" value=\"Save\" class=\"button green\" /></td>\r\n                </tr>\r\n              </table>\r\n            </form>\r\n            </fieldset></td>\r\n        </tr>\r\n        <tr>\r\n          <td colspan=\"3\"><fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td class=\"fieldhead";
echo "er\">";
echo ( $result1 );
echo " Assigned IPs (<a href=\"boxipadd.php?id=";
echo $rows['boxid'];
echo "\" style=\"font-weight:normal;\">Add IP Address</a>)</td>\r\n              </tr>\r\n              <tr>\r\n                <td align=\"center\"><table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" class=\"data\">\r\n                    <tr>\r\n                      <th>IP Address</th>\r\n                      <th>Servers</th>\r\n                      <th>Slots</th>\r\n                      <th>Used Ports</th>\r\n                      <th w";
echo "idth=\"30\"></th>\r\n                    </tr>\r\n                    ";
if ( ( $result1 ) == 0 )
{
    echo "                    <tr>\r\n                      <td colspan=\"7\"><div id=\"infobox2\">";
    echo "<s";
    echo "trong>No IPs Found</strong><br />\r\n          \t\t\tNo IPs found. <a href=\"boxipadd.php?id=";
    echo $rows['boxid'];
    echo "\">Click here</a> to add a new IP Address.</div></td>\r\n                    </tr>\r\n                    ";
}
echo "                    ";
while ( $rows1 = ( $result1 ) )
{
    echo "                    ";
    $servers = 0;
    $slots = 0;
    $ports = array( );
    echo "          \t\t\t";
    $result2 = ( "SELECT `slots`, `port` FROM `server` WHERE `ipid` = '".$rows1['ipid']."'" );
    echo "          \t\t\t";
    while ( $rows2 = ( $result2 ) )
    {
        echo "          \t\t\t";
        ++$servers;
        $slots = $slots + $rows2['slots'];
        $ports[] = $rows2['port'];
        echo "          \t\t\t";
    }
    ( $result2 );
    ( $ports );
    echo "                    <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n                      <td>";
    echo $rows1['ip'];
    echo "</td>\r\n                      <td>";
    echo $servers;
    echo "</td>\r\n                      <td>";
    echo $slots;
    echo "</td>\r\n                      ";
    if ( !empty( $ports ) )
    {
        echo "                      <td>";
        echo ( " / ", $ports );
        echo "</td>\r\n                      ";
    }
    else
    {
        echo "                      <td>None</td>\r\n                      ";
    }
    echo "            \t\t  <td><a href=\"#\" onclick=\"doDelete('";
    echo $rows1['ip'];
    echo "', '";
    echo $rows1['ipid'];
    echo "')\"><img src=\"templates/";
    echo TEMPLATE;
    echo "/images/status/red.png\" width=\"25\" height=\"25\" alt=\"Delete\" /></a></td>\r\n                    </tr>\r\n                    ";
}
( $result1 );
echo "                  </table></td>\r\n              </tr>\r\n            </table>\r\n            </fieldset></td>\r\n        </tr>\r\n      </table>\r\n      ";
echo "<s";
echo "cript language=\"javascript\" type=\"text/javascript\">\r\n\t  \t<!--\r\n\t\tfunction doDelete(ip, id) { if (confirm(\"Are you sure you want to delete IP address: \"+ip+\"?\")) { window.location='boxprocess.php?task=boxipdelete&ipid='+id; } }\r\n\t\tfunction deleteBox() { if (confirm(\"Are you sure you want to delete box: ";
echo $rows['name'];
echo "?\")) { window.location=\"boxprocess.php?task=boxdelete&id=";
echo $rows['boxid'];
echo "\"; } }\r\n\t\t-->\r\n\t  </script>\r\n      <p align=\"center\">\r\n        <input type=\"button\" onclick=\"deleteBox();return false;\" class=\"button red\" value=\"Delete Box\" />\r\n      </p></td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

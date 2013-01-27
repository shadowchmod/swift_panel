<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Client Summary";
$page = "clientsummary";
$tab = "2";
$return = "clientsummary.php?id=".$_GET['id'];
$image = "client_48";
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/countries.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$clientid = ( $_GET['id'] );
$rows = ( "SELECT * FROM `client` WHERE `clientid` = '".$clientid."' LIMIT 1" );
$result1 = ( "SELECT * FROM `server` WHERE `clientid` = '".$clientid."' ORDER BY `serverid`" );
$result3 = ( "SELECT * FROM `log` WHERE `clientid` = '".$clientid."' ORDER BY `logid` DESC LIMIT 5" );
$tabs = array(
    "Summary" => "clientsummary.php?id=".$rows['clientid'],
    "Profile" => "clientprofile.php?id=".$rows['clientid'],
    "Servers" => "clientserver.php?id=".$rows['clientid'],
    "Activity Logs" => "clientlog.php?id=".$rows['clientid']
);
include( "./templates/".TEMPLATE."/header.php" );
echo ( $tabs, 1 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">";
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "      <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n          <td align=\"left\"><div style=\"font-size:18px;\">#";
echo $rows['clientid'];
echo " - ";
echo $rows['firstname'];
echo " ";
echo $rows['lastname'];
echo " [ ";
echo ( $rows['status'] );
echo " ]</div></td>\r\n          <td align=\"right\"></td>\r\n        </tr>\r\n      </table>\r\n      <img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"1\" height=\"6\" alt=\"\" /><br />\r\n      <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n          <td width=\"50%\" valign=\"top\"><fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td colspan=\"2\" class=\"fieldheader\">Client Information</td>\r\n              </tr>\r\n              <tr>\r\n  ";
echo "              <td class=\"fieldname\" style=\"height:20px;width:110px;\">Full Name</td>\r\n                <td class=\"fieldarea\">";
echo $rows['firstname'];
echo " ";
echo $rows['lastname'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Email Address</td>\r\n                <td class=\"fieldarea\">";
echo $rows['email'];
echo "</td>\r\n              </tr>\r\n              ";
if ( $rows['company'] )
{
    echo "              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Company Name</td>\r\n                <td class=\"fieldarea\">";
    echo $rows['company'];
    echo "</td>\r\n              </tr>\r\n              ";
}
echo "              ";
if ( $rows['address1'] || $rows['city'] || $rows['state'] )
{
    echo "              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Address</td>\r\n                <td class=\"fieldarea\">";
    echo $rows['address1'];
    echo "<br />\r\n\t\t\t\t";
    echo $rows['address2'] == "" ? "" : $rows['address2']."<br />";
    echo "\t\t\t\t";
    echo $rows['city'];
    echo ", ";
    echo $rows['state'];
    echo " ";
    echo $rows['postcode'];
    echo "<br />\r\n\t\t\t\t";
    echo $countries[$rows['country']];
    echo "</td>\r\n              </tr>\r\n              ";
}
echo "              ";
if ( $rows['phone'] )
{
    echo "              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Phone Number</td>\r\n                <td class=\"fieldarea\">";
    echo $rows['phone'];
    echo "</td>\r\n              </tr>\r\n              ";
}
echo "            </table>\r\n            </fieldset>\r\n            <fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td colspan=\"2\" class=\"fieldheader\">Other Information</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;width:110px;\">Status</td>\r\n                <td class=\"fieldarea\">";
echo ( $rows['status'] );
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Client Since</td>\r\n                <td class=\"fieldarea\">";
echo ( $rows['created'] );
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Last Login</td>\r\n                <td class=\"fieldarea\">";
echo ( $rows['lastlogin'] );
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Last IP</td>\r\n                <td class=\"fieldarea\">";
echo $rows['lastip'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Last Hostname</td>\r\n                <td class=\"fieldarea\">";
echo $rows['lasthost'];
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
echo "            </table>\r\n            </fieldset>\r\n            <fieldset>\r\n            <form method=\"post\" action=\"clientprocess.php\">\r\n              <input type=\"hidden\" name=\"task\" value=\"clientnotes\" />\r\n              <input type=\"hidden\" name=\"clientid\" value=\"";
echo $rows['clientid'];
echo "\" />\r\n              <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n                <tr>\r\n                  <td class=\"fieldheader\" colspan=\"2\">Admin Notes</td>\r\n                </tr>\r\n                <tr>\r\n                  <td width=\"350\" align=\"center\"><textarea name=\"notes\" class=\"textarea\" rows=\"4\" cols=\"60\">";
echo $rows['notes'];
echo "</textarea></td>\r\n                  <td align=\"center\"><input type=\"submit\" value=\"Save\" class=\"button green\" /></td>\r\n                </tr>\r\n              </table>\r\n            </form>\r\n            </fieldset></td>\r\n        </tr>\r\n        <tr>\r\n          <td colspan=\"3\"><fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td class=\"fieldhead";
echo "er\">";
echo ( $result1 );
echo " Assigned Servers (<a href=\"serveradd.php?clientid=";
echo $rows['clientid'];
echo "\" style=\"font-weight:normal;\">Add New Server</a>)</td>\r\n              </tr>\r\n              <tr>\r\n                <td align=\"center\"><table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" class=\"data\">\r\n                    <tr>\r\n                      <th width=\"30\">ID</th>\r\n                      <th width=\"35\"></th>\r\n                      <th>Name</th>\r\n                      <th>Game</th>\r\n                      <th>D";
echo "escription</th>\r\n                      <th>User</th>\r\n                      <th>IP Address</th>\r\n                      <th>Status</th>\r\n                    </tr>\r\n                    ";
if ( ( $result1 ) == 0 )
{
    echo "                    <tr>\r\n                      <td colspan=\"8\"><div id=\"infobox2\">";
    echo "<s";
    echo "trong>No Servers Found</strong><br />\r\n          \t\t\tNo servers found. <a href=\"serveradd.php?clientid=";
    echo $rows['clientid'];
    echo "\">Click here</a> to add a new server.</div></td>\r\n                    </tr>\r\n                    ";
}
echo "                    ";
while ( $rows1 = ( $result1 ) )
{
    echo "                    <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n                      <td rowspan=\"2\"><a href=\"serversummary.php?id=";
    echo $rows1['serverid'];
    echo "\">#";
    echo $rows1['serverid'];
    echo "</a></td>\r\n                      <td rowspan=\"2\">";
    echo ( $rows1['online'] );
    echo "</td>\r\n                      <td><a href=\"serversummary.php?id=";
    echo $rows1['serverid'];
    echo "\">";
    echo $rows1['name'];
    echo "</a></td>\r\n                      <td>";
    echo $rows1['game'];
    echo "</td>\r\n                      <td>";
    echo $rows1['slots'];
    echo " Slots ";
    echo $rows1['type'];
    echo "</td>\r\n                      ";
    if ( !empty( $rows1['ipid'] ) )
    {
        echo "                      <td>";
        echo $rows1['user'];
        echo "</td>\r\n\t\t\t\t\t  ";
        $rows2 = ( "SELECT `ip` FROM `ip` WHERE `ipid` = '".$rows1['ipid']."' LIMIT 1" );
        echo "                      <td>";
        echo $rows2['ip'];
        echo " <b>:</b> ";
        echo $rows1['port'];
        echo "</td>\r\n                      ";
    }
    else
    {
        echo "                      <td colspan=\"2\">Pending</td>\r\n                      ";
    }
    echo "                      <td>";
    echo ( $rows1['status'] );
    echo "</td>\r\n                    </tr>\r\n                    <tr>\r\n                      <td colspan=\"6\" style=\"background-color:#F5F5F5;color:#333333;text-align:left;\">";
    echo ( $rows1, $rows2['ip'], TRUE );
    echo "</td>\r\n                    </tr>\r\n                    ";
}
( $result1 );
echo "                  </table></td>\r\n              </tr>\r\n            </table>\r\n            </fieldset></td>\r\n        </tr>\r\n      </table>\r\n      ";
echo "<s";
echo "cript language=\"javascript\" type=\"text/javascript\">\r\n\t  <!--\r\n\t\tfunction deleteClient() { if (confirm(\"Are you sure you want to delete client: ";
echo $rows['firstname'];
echo " ";
echo $rows['lastname'];
echo "?\")) { window.location.href='clientprocess.php?task=clientdelete&id=";
echo $rows['clientid'];
echo "'; } }\r\n\t\t-->\r\n\t  </script>\r\n      <p align=\"center\">\r\n        <input type=\"button\" onclick=\"window.open('clientprocess.php?task=clientlogin&amp;id=";
echo $rows['clientid'];
echo "')\" class=\"button blue\" value=\"Login as Client\" />\r\n        <input type=\"button\" onclick=\"deleteClient();return false;\" class=\"button red\" value=\"Delete Client\" />\r\n      </p></td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

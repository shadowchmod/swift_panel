<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Client Servers";
$page = "clientserver";
$tab = "2";
$return = "clientserver.php?id=".$_GET['id'];
$image = "server_24";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$clientid = ( $_GET['id'] );
$rows = ( "SELECT `clientid`, `firstname`, `lastname`, `status` FROM `client` WHERE `clientid` = '".$clientid."' LIMIT 1" );
$result1 = ( "SELECT * FROM `server` WHERE `clientid` = '".$rows['clientid']."' ORDER BY `serverid`" );
$tabs = array(
    "Summary" => "clientsummary.php?id=".$rows['clientid'],
    "Profile" => "clientprofile.php?id=".$rows['clientid'],
    "Servers" => "clientserver.php?id=".$rows['clientid'],
    "Activity Logs" => "clientlog.php?id=".$rows['clientid']
);
include( "./templates/".TEMPLATE."/header.php" );
echo ( $tabs, 3 );
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
echo "/images/spacer.gif\" width=\"1\" height=\"6\" alt=\"\" /><br />\r\n      <fieldset>\r\n      <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n        <tr>\r\n          <td class=\"fieldheader\">";
echo ( $result1 );
echo " Assigned Servers (<a href=\"serveradd.php?clientid=";
echo $rows['clientid'];
echo "\" style=\"font-weight:normal;\">Add New Server</a>)</td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"center\"><table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" class=\"data\">\r\n              <tr>\r\n                <th width=\"30\">ID</th>\r\n                <th width=\"35\"></th>\r\n                <th>Name</th>\r\n                <th>Game</th>\r\n                <th>Description</th>\r\n                <th>User</th>\r\n         ";
echo "       <th>IP Address</th>\r\n                <th>Status</th>\r\n              </tr>\r\n              ";
if ( ( $result1 ) == 0 )
{
    echo "              <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n                <td colspan=\"8\"><div id=\"infobox2\">";
    echo "<s";
    echo "trong>No Servers Found</strong><br />\r\n                    No servers found. <a href=\"serveradd.php?clientid=";
    echo $rows['clientid'];
    echo "\">Click here</a> to add a new server.</div></td>\r\n              </tr>\r\n              ";
}
echo "              ";
while ( $rows1 = ( $result1 ) )
{
    echo "              <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n                <td rowspan=\"2\"><a href=\"serversummary.php?id=";
    echo $rows1['serverid'];
    echo "\">#";
    echo $rows1['serverid'];
    echo "</a></td>\r\n                <td rowspan=\"2\">";
    echo ( $rows1['online'] );
    echo "</td>\r\n                <td><a href=\"serversummary.php?id=";
    echo $rows1['serverid'];
    echo "\">";
    echo $rows1['name'];
    echo "</a></td>\r\n                <td>";
    echo $rows1['game'];
    echo "</td>\r\n                <td>";
    echo $rows1['slots'];
    echo " Slots ";
    echo $rows1['type'];
    echo "</td>\r\n                ";
    if ( !empty( $rows1['ipid'] ) )
    {
        echo "                <td>";
        echo $rows1['user'];
        echo "</td>\r\n                ";
        $rows2 = ( "SELECT `ip` FROM `ip` WHERE `ipid` = '".$rows1['ipid']."' LIMIT 1" );
        echo "                <td>";
        echo $rows2['ip'];
        echo " <b>:</b> ";
        echo $rows1['port'];
        echo "</td>\r\n                ";
    }
    else
    {
        echo "                <td colspan=\"2\">Pending</td>\r\n                ";
    }
    echo "                <td>";
    echo ( $rows1['status'] );
    echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td colspan=\"6\" style=\"background-color:#F5F5F5;color:#333333;text-align:left;\">";
    echo ( $rows1, $rows2['ip'], TRUE );
    echo "</td>\r\n              </tr>\r\n              ";
}
( $result1 );
echo "            </table></td>\r\n        </tr>\r\n      </table>\r\n      </fieldset></td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

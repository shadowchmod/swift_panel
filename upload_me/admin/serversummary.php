<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Server Summary";
$page = "serversummary";
$tab = "3";
$return = "serversummary.php?id=".$_GET['id'];
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$serverid = ( $_GET['id'] );
$rows = ( "SELECT * FROM `server` WHERE `serverid` = '".$serverid."' ORDER BY `serverid` LIMIT 1" );
$rows1 = ( "SELECT `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$rows['clientid']."' LIMIT 1" );
if ( !empty( $rows['ipid'] ) )
{
    $rows2 = ( "SELECT * FROM `ip` WHERE `ipid` = '".$rows['ipid']."' LIMIT 1" );
    $rows3 = ( "SELECT `boxid`, `name`, `location` FROM `box` WHERE `boxid` = '".$rows['boxid']."' LIMIT 1" );
}
$result4 = ( "SELECT `serverid`, `name` FROM `server` WHERE `clientid` = '".$rows['clientid']."' ORDER BY `serverid`" );
if ( !empty( $rows2['ip'] ) && !empty( $rows['port'] ) && $rows['query'] != "none" )
{
    if ( empty( $rows['qryport'] ) )
    {
        $qryport = $rows['port'];
    }
    else
    {
        $qryport = $rows['qryport'];
    }
    $serverinfo = ( array(
        $rows['query'],
        $rows2['ip'],
        $qryport
    ) );
}
$tabs = array(
    "Summary" => "serversummary.php?id=".$rows['serverid'],
    "Settings" => "serverprofile.php?id=".$rows['serverid'],
    "Advanced" => "serveradvanced.php?id=".$rows['serverid'],
    "Web FTP" => "serverftp.php?id=".$rows['serverid'],
    "Activity Logs" => "serverlog.php?id=".$rows['serverid']
);
include( "./templates/".TEMPLATE."/header.php" );
echo ( $tabs, 1 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">";
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "      <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n          <td align=\"left\"><div style=\"font-size:18px;\">#";
echo $rows['serverid'];
echo " - ";
echo $rows['name'];
echo " [ ";
echo ( $rows['status'] );
echo " ]</div></td>\r\n          <td align=\"right\">";
if ( $rows['online'] == "Stopped" )
{
    echo "              <input type=\"button\" value=\"Start Server\" onclick=\"window.location='servermanage.php?task=start&amp;serverid=";
    echo $rows['serverid'];
    echo "'\" class=\"button green start\" />\r\n              ";
}
else if ( $rows['online'] == "Started" )
{
    echo "              <input type=\"button\" value=\"Restart Server\" onclick=\"window.location='servermanage.php?task=restart&amp;serverid=";
    echo $rows['serverid'];
    echo "'\" class=\"button blue restart\" />\r\n              <input type=\"button\" value=\"Stop Server\" onclick=\"window.location='servermanage.php?task=stop&amp;serverid=";
    echo $rows['serverid'];
    echo "'\" class=\"button red stop\" />\r\n              ";
}
echo "</td>\r\n        </tr>\r\n      </table>\r\n      <img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"1\" height=\"6\" alt=\"\" /><br />\r\n      <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n          <td width=\"50%\" valign=\"top\"><fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td colspan=\"2\" class=\"fieldheader\">Server Information</td>\r\n              </tr>\r\n              <tr>\r\n  ";
echo "              <td class=\"fieldname\" style=\"height:20px;width:110px;\">Name</td>\r\n                <td class=\"fieldarea\">";
echo $rows['name'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Game</td>\r\n                <td class=\"fieldarea\">";
echo $rows['game'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Status</td>\r\n                <td class=\"fieldarea\">";
echo ( $rows['status'] );
echo "</td>\r\n              </tr>\r\n            </table>\r\n            </fieldset>\r\n            <form method=\"get\" action=\"serversummary.php\">\r\n            <fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n                <tr>\r\n                  <td colspan=\"2\" class=\"fieldheader\">Client Information</td>\r\n                </tr>\r\n                <tr>\r\n                  <td class=\"fi";
echo "eldname\" style=\"height:20px;width:110px;\">Name</td>\r\n                  <td class=\"fieldarea\"><a href=\"clientsummary.php?id=";
echo $rows['clientid'];
echo "\">";
echo $rows1['firstname'];
echo " ";
echo $rows1['lastname'];
echo "</a></td>\r\n                </tr>\r\n                <tr>\r\n                  <td class=\"fieldname\" style=\"width:110px;\">Servers</td>\r\n                  <td class=\"fieldarea\">";
echo "<s";
echo "elect name=\"id\" class=\"select\" onchange=\"submit();\">\r\n                      ";
while ( $rows4 = ( $result4 ) )
{
    echo "                      <option value=\"";
    echo $rows4['serverid'];
    echo "\"";
    if ( $serverid == $rows4['serverid'] )
    {
        echo " selected=\"selected\"";
    }
    echo ">#";
    echo $rows4['serverid'];
    echo " - ";
    echo $rows4['name'];
    echo "</option>\r\n                      ";
}
( $result4 );
echo "                    </select></td>\r\n                </tr>\r\n            </table>\r\n            </fieldset>\r\n            </form>\r\n            <fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td colspan=\"2\" class=\"fieldheader\">Server Configuration</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"h";
echo "eight:20px;width:110px;\">Priority</td>\r\n                <td class=\"fieldarea\">";
echo $rows['priority'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;width:110px;\">Max Slots</td>\r\n                <td class=\"fieldarea\">";
echo $rows['slots'];
echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Type</td>\r\n                <td class=\"fieldarea\">";
echo $rows['type'];
echo "</td>\r\n              </tr>\r\n              ";
$n = 1;
while ( !empty( $rows["cfg".$n."name"] ) )
{
    echo "              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">";
    echo $rows["cfg".$n."name"];
    echo "</td>\r\n                <td class=\"fieldarea\">";
    echo $rows["cfg".$n];
    echo "</td>\r\n              </tr>\r\n              ";
    ++$n;
}
echo "              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Start Command</td>\r\n                <td class=\"fieldarea\">";
echo ( $rows, $rows2['ip'], TRUE );
echo "</td>\r\n              </tr>\r\n            </table>\r\n            </fieldset></td>\r\n          <td width=\"50%\" valign=\"top\"><fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td colspan=\"2\" class=\"fieldheader\">Box Details</td>\r\n              </tr>\r\n              ";
if ( empty( $rows['ipid'] ) )
{
    echo "              <tr>\r\n                <td align=\"center\" colspan=\"2\"><br />\r\n                  <input type=\"button\" onclick=\"window.location='serverinstall.php?id=";
    echo $rows['serverid'];
    echo "'\" class=\"button\" value=\"Install Wizard\" />\r\n                  <br />\r\n                  <br /></td>\r\n              </tr>\r\n              ";
}
else
{
    echo "              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;width:110px;\">Box</td>\r\n                <td class=\"fieldarea\"><a href=\"boxsummary.php?id=";
    echo $rows3['boxid'];
    echo "\">";
    echo $rows3['name'];
    echo "</a></td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Location</td>\r\n                <td class=\"fieldarea\">";
    echo $rows3['location'];
    echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">IP Address</td>\r\n                <td class=\"fieldarea\">";
    echo $rows2['ip'];
    echo "<b>:</b>";
    echo $rows['port'];
    echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">User</td>\r\n                <td class=\"fieldarea\">";
    echo $rows['user'];
    echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Password</td>\r\n                <td class=\"fieldarea\">";
    echo $rows['password'];
    echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Home Directory</td>\r\n                <td class=\"fieldarea\">";
    echo $rows['homedir'];
    echo "</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">Install Directory</td>\r\n                <td class=\"fieldarea\">";
    if ( !empty( $rows['installdir'] ) )
    {
        echo $rows['installdir'];
    }
    else
    {
        echo "Rebuild Disabled (No Install Directory)";
    }
    echo "</td>\r\n              </tr>\r\n              ";
}
echo "            </table>\r\n            </fieldset>\r\n            <fieldset>\r\n            <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n              <tr>\r\n                <td colspan=\"2\" class=\"fieldheader\">Server Status</td>\r\n              </tr>\r\n              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;width:110px;\">Status</td>\r\n                <td class=\"fieldarea\">";
echo ( $rows['online'] );
echo " (<a href=\"#\" onclick=\"window.location.reload();\">Refresh</a>)</td>\r\n              </tr>\r\n              ";
if ( $serverinfo )
{
    foreach ( $serverinfo as $name => $value )
    {
        echo "              <tr>\r\n                <td class=\"fieldname\" style=\"height:20px;\">";
        echo $name;
        echo "</td>\r\n                <td class=\"fieldarea\">";
        echo $value;
        echo "</td>\r\n              </tr>\r\n              ";
    }
}
echo "            </table>\r\n            </fieldset></td>\r\n        </tr>\r\n      </table>\r\n      ";
echo "<s";
echo "cript language=\"javascript\" type=\"text/javascript\">\r\n\t  <!--\r\n\t  function rebuildServer() { if (confirm(\"Are you sure you want to rebuild server: ";
echo $rows['name'];
echo "?\\n\\nAll files will be deleted from directory: ";
echo $rows['homedir'];
echo "\")) { window.location=\"serverprocess.php?task=serverrebuild&serverid=";
echo $rows['serverid'];
echo "\"; } }\r\n\t  ";
if ( !empty( $rows['ipid'] ) )
{
    echo "\t  function deleteServer() { if (confirm(\"Are you sure you want to delete server: ";
    echo $rows['name'];
    echo "?\")) { if (confirm(\"Do you want to remove user: ";
    echo $rows['user'];
    echo "?\\n\\nAll files will be deleted from directory: ";
    echo $rows['homedir'];
    echo "\")) { window.location=\"serverprocess.php?task=serverdelete&delete=yes&serverid=";
    echo $rows['serverid'];
    echo "\"; } else { window.location=\"serverprocess.php?task=serverdelete&delete=no&serverid=";
    echo $rows['serverid'];
    echo "\"; } } }\r\n\t  ";
}
else
{
    echo "\t  function deleteServer() { if (confirm(\"Are you sure you want to delete server: ";
    echo $rows['name'];
    echo "?\")) { window.location=\"serverprocess.php?task=serverdelete&delete=no&serverid=";
    echo $rows['serverid'];
    echo "\"; } }\r\n\t  ";
}
echo "\t  -->\r\n\t  </script>\r\n      <p align=\"center\">\r\n      \t";
if ( !empty( $rows['ipid'] ) && !empty( $rows['installdir'] ) )
{
    echo "<input type=\"button\" onclick=\"rebuildServer();return false;\" class=\"button green\" value=\"Rebuild Server\" />";
}
echo "        <input type=\"button\" onclick=\"deleteServer();return false;\" class=\"button red\" value=\"Delete Server\" />\r\n      </p></td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

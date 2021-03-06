<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Server Activity Logs";
$page = "serverlog";
$tab = "3";
$return = "serverlog.php?id=".$_GET['id'];
$image = "logs_48";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$serverid = ( $_GET['id'] );
$rowsperpage = 25;
$page = ( $_GET['page'] );
if ( empty( $page ) )
{
    $limit = 0;
}
else
{
    $limit = --$page * $rowsperpage;
    ++$page;
}
$rows = ( "SELECT `serverid`, `name` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
$query = "SELECT * FROM `log` WHERE `serverid` = '".$rows['serverid']."' ORDER BY `logid` DESC";
$numpages = ( ( $query ) / $rowsperpage ) + 1;
$result1 = ( $query." LIMIT ".$limit.", ".$rowsperpage );
$tabs = array(
    "Summary" => "serversummary.php?id=".$rows['serverid'],
    "Settings" => "serverprofile.php?id=".$rows['serverid'],
    "Advanced" => "serveradvanced.php?id=".$rows['serverid'],
    "Web FTP" => "serverftp.php?id=".$rows['serverid'],
    "Activity Logs" => "serverlog.php?id=".$rows['serverid']
);
include( "./templates/".TEMPLATE."/header.php" );
( $tabs, 5 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">\r\n      ";
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "      <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n          <td align=\"left\"><div style=\"font-size:18px;\">#";
echo $rows['serverid'];
echo " - ";
echo $rows['name'];
echo "</div></td>\r\n          <td align=\"right\"><form method=\"get\" action=\"serverlog.php\">\r\n              <input type=\"hidden\" name=\"id\" value=\"";
echo $rows['serverid'];
echo "\" />\r\n              Jump to Page:\r\n              ";
echo "<s";
echo "elect name=\"page\" class=\"select\" onchange=\"submit();\">\r\n                ";
$n = 1;
while ( $n < $numpages )
{
    echo "                <option value=\"";
    echo $n;
    echo "\"";
    if ( $page == $n )
    {
        echo " selected=\"selected\"";
    }
    echo ">";
    echo $n;
    echo "</option>\r\n                ";
    ++$n;
}
echo "              </select>\r\n            </form></td>\r\n        </tr>\r\n      </table>\r\n      <img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"1\" height=\"6\" alt=\"\" /><br />\r\n      <fieldset>\r\n      <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n        <tr>\r\n          <td class=\"fieldheader\">Activity Logs</td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"center\"><table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" class=\"data\">\r\n              <tr>\r\n                <th>ID</th>\r\n                <th>Messa";
echo "ge</th>\r\n                <th>Name</th>\r\n                <th>IP</th>\r\n                <th>Timestamp</th>\r\n              </tr>\r\n              ";
if ( ( $result1 ) == 0 )
{
    echo "              <tr>\r\n                <td colspan=\"5\" align=\"center\">No Logs Found</td>\r\n              </tr>\r\n              ";
}
echo "              ";
while ( $rows1 = ( $result1 ) )
{
    echo "              <tr onmouseover=\"this.className='admindatatablehighlight'\" onmouseout=\"this.className=''\">\r\n                <td>#";
    echo $rows1['logid'];
    echo "</td>\r\n                <td>";
    echo $rows1['message'];
    echo "</td>\r\n                <td>";
    echo $rows1['name'];
    echo "</td>\r\n                <td>";
    echo $rows1['ip'];
    echo "</td>\r\n                <td>";
    echo ( $rows1['timestamp'] );
    echo "</td>\r\n              </tr>\r\n              ";
}
( $result1 );
echo "            </table></td>\r\n        </tr>\r\n      </table>\r\n      </fieldset></td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Home";
$page = "index";
$tab = "1";
$return = TRUE;
$image = "home_48";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$numrows = ( "SELECT * FROM `client` WHERE `status` = 'Active'" );
$numrows1 = ( "SELECT * FROM `client` WHERE `status` = 'Inactive'" );
$numclients = $numrows + $numrows1;
if ( $numclients != "0" )
{
    $numpercent = $numrows / $numclients * 100;
    $numpercent1 = $numrows1 / $numclients * 100;
}
$numrows2 = ( "SELECT * FROM `server` WHERE `status` = 'Pending'" );
$numrows3 = ( "SELECT * FROM `server` WHERE `status` = 'Active'" );
$numrows4 = ( "SELECT * FROM `server` WHERE `status` = 'Suspended'" );
$numservices = $numrows2 + $numrows3 + $numrows4;
if ( $numservices != "0" )
{
    $numpercent2 = $numrows2 / $numservices * 100;
    $numpercent3 = $numrows3 / $numservices * 100;
    $numpercent4 = $numrows4 / $numservices * 100;
}
$numrows5 = ( "SELECT * FROM `box` WHERE `ssh` = 'Online'" );
$numrows6 = ( "SELECT * FROM `box` WHERE `ssh` = 'Offline'" );
$nummachines = $numrows5 + $numrows6;
if ( $nummachines != "0" )
{
    $numpercent5 = $numrows5 / $nummachines * 100;
    $numpercent6 = $numrows6 / $nummachines * 100;
}
$rows = ( "SELECT `adminid`, `notes` FROM `admin` WHERE `adminid` = '".$_SESSION['adminid']."' LIMIT 1" );
$result1 = ( "SELECT * FROM `log` ORDER BY `logid` DESC LIMIT 15" );
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n  <tr>\r\n    <td width=\"33%\" valign=\"top\"><fieldset>\r\n      <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n        <tr>\r\n          <td colspan=\"3\" class=\"fieldheader\">Clients</td>\r\n        </tr>\r\n        <tr>\r\n          <td width=\"75\" align=\"right\"><a href=\"client.php?status=Active\">Active</a></td>\r\n          <td width=\"120\"><img sr";
echo "c=\"templates/";
echo TEMPLATE;
echo "/images/percent/bar.png\" alt=\"";
echo $numpercent;
echo "%\" class=\"greenbar\" style=\"background-position: -";
echo 120 - $numpercent * 1.2;
echo "px 0pt;\" title=\"";
echo $numpercent;
echo "%\" /></td>\r\n          <td class=\"fieldname\" style=\"height:20px;text-align:center;\">";
echo $numrows;
echo "</td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"right\"><a href=\"client.php?status=Inactive\">Inactive</a></td>\r\n          <td><img src=\"templates/";
echo TEMPLATE;
echo "/images/percent/bar.png\" alt=\"";
echo $numpercent1;
echo "%\" title=\"";
echo $numpercent1;
echo "%\" class=\"goldbar\" style=\"background-position: -";
echo 120 - $numpercent1 * 1.2;
echo "px 0pt;\" /></td>\r\n          <td class=\"fieldname\" style=\"height:20px;text-align:center;\">";
echo $numrows1;
echo "</td>\r\n        </tr>\r\n      </table>\r\n      </fieldset></td>\r\n    <td width=\"34%\" valign=\"top\"><fieldset>\r\n      <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n        <tr>\r\n          <td colspan=\"3\" class=\"fieldheader\">Servers</td>\r\n        </tr>\r\n        <tr>\r\n          <td width=\"75\" align=\"right\"><a href=\"server.php?status=Pending\">Pending</a></td>\r\n          <td width=\"120\"><img src=\"templates";
echo "/";
echo TEMPLATE;
echo "/images/percent/bar.png\" alt=\"";
echo $numpercent2;
echo "%\" title=\"";
echo $numpercent2;
echo "%\" class=\"goldbar\" style=\"background-position: -";
echo 120 - $numpercent2 * 1.2;
echo "px 0pt;\" /></td>\r\n          <td class=\"fieldname\" style=\"height:20px;text-align:center;\">";
echo $numrows2;
echo "</td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"right\"><a href=\"server.php?status=Active\">Active</a></td>\r\n          <td><img src=\"templates/";
echo TEMPLATE;
echo "/images/percent/bar.png\" alt=\"";
echo $numpercent3;
echo "%\" title=\"";
echo $numpercent3;
echo "%\" class=\"greenbar\" style=\"background-position: -";
echo 120 - $numpercent3 * 1.2;
echo "px 0pt;\" /></td>\r\n          <td class=\"fieldname\" style=\"height:20px;text-align:center;\">";
echo $numrows3;
echo "</td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"right\"><a href=\"server.php?status=Suspended\">Suspended</a></td>\r\n          <td><img src=\"templates/";
echo TEMPLATE;
echo "/images/percent/bar.png\" alt=\"";
echo $numpercent4;
echo "%\" title=\"";
echo $numpercent4;
echo "%\" class=\"redbar\" style=\"background-position: -";
echo 120 - $numpercent4 * 1.2;
echo "px 0pt;\" /></td>\r\n          <td class=\"fieldname\" style=\"height:20px;text-align:center;\">";
echo $numrows4;
echo "</td>\r\n        </tr>\r\n      </table>\r\n      </fieldset></td>\r\n    <td width=\"33%\" valign=\"top\"><fieldset>\r\n      <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n        <tr>\r\n          <td colspan=\"3\" class=\"fieldheader\">Boxes</td>\r\n        </tr>\r\n        <tr>\r\n          <td width=\"75\" align=\"right\"><a href=\"box.php\">Online</a></td>\r\n          <td width=\"120\"><img src=\"templates/";
echo TEMPLATE;
echo "/images/percent/bar.png\" alt=\"";
echo $numpercent5;
echo "%\" title=\"";
echo $numpercent5;
echo "%\" class=\"greenbar\" style=\"background-position: -";
echo 120 - $numpercent5 * 1.2;
echo "px 0pt;\" /></td>\r\n          <td class=\"fieldname\" style=\"height:20px;text-align:center;\">";
echo $numrows5;
echo "</td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"right\"><a href=\"box.php\">Offline</a></td>\r\n          <td><img src=\"templates/";
echo TEMPLATE;
echo "/images/percent/bar.png\" alt=\"";
echo $numpercent6;
echo "%\" title=\"";
echo $numpercent6;
echo "%\" class=\"redbar\" style=\"background-position: -";
echo 120 - $numpercent6 * 1.2;
echo "px 0pt;\" /></td>\r\n          <td class=\"fieldname\" style=\"height:20px;text-align:center;\">";
echo $numrows6;
echo "</td>\r\n        </tr>\r\n      </table>\r\n      </fieldset></td>\r\n  </tr>\r\n  <tr>\r\n    <td colspan=\"3\"><form method=\"post\" action=\"process.php\">\r\n        <input type=\"hidden\" name=\"task\" value=\"personalnotes\" />\r\n        <input type=\"hidden\" name=\"adminid\" value=\"";
echo $rows['adminid'];
echo "\" />\r\n        <fieldset>\r\n        <table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n          <tr>\r\n            <td class=\"fieldheader\" colspan=\"2\">Personal Notes</td>\r\n          </tr>\r\n          <tr>\r\n            <td align=\"center\" width=\"800\"><textarea name=\"notes\" class=\"textarea\" rows=\"4\" cols=\"150\" style=\"width:98%\">";
echo $rows['notes'];
echo "</textarea></td>\r\n            <td align=\"center\"><input type=\"submit\" value=\"Save\" class=\"button green\" /></td>\r\n          </tr>\r\n        </table>\r\n        </fieldset>\r\n      </form>\r\n    </td>\r\n  </tr>\r\n</table>\r\n<p><b>Last 15 Actions</b> (<a href=\"utilitieslog.php\">View All</a>)</p>\r\n<table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" class=\"data\">\r\n  <tr>\r\n    <th>ID</th>\r\n    <th>Message</th>\r\n    <th>Name</th>\r\n    <th";
echo ">IP</th>\r\n    <th>Timestamp</th>\r\n  </tr>\r\n  ";
if ( ( $result1 ) == 0 )
{
    echo "  <tr>\r\n    <td colspan=\"5\" align=\"center\">No Logs Found</td>\r\n  </tr>\r\n  ";
}
echo "  ";
while ( $rows1 = ( $result1 ) )
{
    echo "  <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n    <td>#";
    echo $rows1['logid'];
    echo "</td>\r\n    <td>";
    echo $rows1['message'];
    echo "</td>\r\n    <td>";
    echo $rows1['name'];
    echo "</td>\r\n    <td>";
    echo $rows1['ip'];
    echo "</td>\r\n    <td>";
    echo ( $rows1['timestamp'] );
    echo "</td>\r\n  </tr>\r\n  ";
}
( $result1 );
echo "</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

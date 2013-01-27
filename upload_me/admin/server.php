<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Servers";
$page = "server";
$tab = "3";
$return = "server.php";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$orderby = ( $_GET['orderby'] );
if ( empty( $orderby ) )
{
    $orderby = "serverid";
}
$dir = ( $_GET['dir'] );
if ( empty( $dir ) )
{
    $dirImage = " <img src='templates/".TEMPLATE."/images/asc.png' align='bottom' alt='' />";
}
else if ( $dir = "desc" )
{
    $dirImage = " <img src='templates/".TEMPLATE."/images/desc.png' align='bottom' alt='' />";
}
$search = ( $_GET['search'] );
$q = ( $_GET['q'] );
if ( !empty( $q ) )
{
    $linkend .= "&amp;search=".$search."&amp;q=".$q;
}
$status = ( $_GET['status'] );
if ( !empty( $status ) )
{
    $linkend .= "&amp;status=".$status;
}
if ( !empty( $_GET['rows'] ) && ( $_GET['rows'] ) )
{
    $rowsperpage = ( $_GET['rows'] );
    $linkend .= "&amp;rows=".( $_GET['rows'] );
}
else if ( !empty( $_COOKIE['serverrows'] ) && ( $_COOKIE['serverrows'] ) )
{
    $rowsperpage = ( $_COOKIE['serverrows'] );
}
else if ( $_GET['rows'] == "All" || $_COOKIE['serverrows'] == "All" )
{
    $rowsperpage = 999999;
}
else
{
    $rowsperpage = 15;
}
$pagenum = ( $_GET['page'] );
if ( empty( $pagenum ) )
{
    $limit = 0;
    $pagenum = 1;
}
else
{
    $limit = --$pagenum * $rowsperpage;
    ++$pagenum;
    $linkend .= "&amp;page=".$pagenum;
}
$query = "SELECT * FROM `server` ";
if ( !empty( $q ) || !empty( $status ) )
{
    $query .= "WHERE ";
}
if ( !empty( $q ) )
{
    $query .= "`".$search."` LIKE '%".$q."%' ";
}
if ( !empty( $q ) && !empty( $status ) )
{
    $query .= "AND ";
}
if ( !empty( $status ) )
{
    $query .= "`status` = '".$status."' ";
}
$query .= "ORDER BY `".$orderby."` ";
if ( !empty( $dir ) )
{
    $query .= $dir." ";
}
$numrecords = ( $query );
$numpages = ( $numrecords / $rowsperpage );
$result = ( $query."LIMIT ".$limit.", ".$rowsperpage );
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\">\r\n  <tr>\r\n    <td width=\"5\" class=\"tabspacer\"><img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"5\" height=\"1\" alt=\"\" /></td>\r\n    <td id=\"tabs1\" class=\"tabs\" onclick=\"toggleTab(1)\">Search/Filter</td>\r\n    <td width=\"100%\" class=\"tabspacer\">&nbsp;</td>\r\n  </tr>\r\n  <tr id=\"tab1\" style=\"display:none;\">\r\n    <td colspan=\"3\" class=\"tab\"><form action=\"server.php\" method=\"get\">\r\n    \t";
if ( !empty( $_GET['rows'] ) )
{
    echo "<input type=\"hidden\" name=\"rows\" value=\"";
    echo ( $_GET['rows'] );
    echo "\" />";
}
echo "        <p align=\"center\">Search in\r\n          ";
echo "<s";
echo "elect name=\"search\" class=\"select\">\r\n            <option value=\"serverid\"";
if ( $search == "serverid" )
{
    echo " selected=\"selected\"";
}
echo ">Server ID</option>\r\n            <option value=\"clientid\"";
if ( $search == "clientid" )
{
    echo " selected=\"selected\"";
}
echo ">Client ID</option>\r\n            <option value=\"boxid\"";
if ( $search == "boxid" )
{
    echo " selected=\"selected\"";
}
echo ">Box ID</option>\r\n            <option value=\"name\"";
if ( $search == "name" )
{
    echo " selected=\"selected\"";
}
echo ">Name</option>\r\n            <option value=\"game\"";
if ( $search == "game" )
{
    echo " selected=\"selected\"";
}
echo ">Game</option>\r\n          </select>\r\n          for\r\n          <input type=\"text\" name=\"q\" class=\"text\" size=\"40\" value=\"";
if ( !empty( $q ) )
{
    echo $q;
}
echo "\" />\r\n          with status\r\n          ";
echo "<s";
echo "elect name=\"status\" class=\"select\">\r\n            <option value=\"\"";
if ( $status == "" )
{
    echo " selected=\"selected\"";
}
echo ">Any</option>\r\n            <option value=\"Pending\"";
if ( $status == "Pending" )
{
    echo " selected=\"selected\"";
}
echo ">Pending</option>\r\n            <option value=\"Active\"";
if ( $status == "Active" )
{
    echo " selected=\"selected\"";
}
echo ">Active</option>\r\n            <option value=\"Suspended\"";
if ( $status == "Suspended" )
{
    echo " selected=\"selected\"";
}
echo ">Suspended</option>\r\n          </select>\r\n          <input type=\"submit\" value=\"Search\" class=\"button\" />\r\n        </p>\r\n      </form></td>\r\n  </tr>\r\n</table>\r\n";
echo "<s";
echo "cript language=\"javascript\" type=\"text/javascript\">var numtabs = 1;</script>\r\n<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">\r\n  <tr>\r\n    <td><b>";
echo $numrecords;
echo " Records Found, Page ";
echo $pagenum;
echo " of ";
echo $numpages;
echo "</b> (<a href=\"serveradd.php\">Add New Server</a>)</td>\r\n    ";
if ( 1 <= $numpages )
{
    echo "    <td align=\"right\"><form method=\"get\" action=\"server.php\">\r\n        ";
    if ( !empty( $orderby ) && $orderby != "serverid" )
    {
        echo "<input type=\"hidden\" name=\"orderby\" value=\"";
        echo $orderby;
        echo "\" />";
    }
    echo "        ";
    if ( !empty( $dir ) )
    {
        echo "<input type=\"hidden\" name=\"dir\" value=\"";
        echo $dir;
        echo "\" />";
    }
    echo "        ";
    if ( !empty( $search ) )
    {
        echo "<input type=\"hidden\" name=\"search\" value=\"";
        echo $search;
        echo "\" />";
    }
    echo "        ";
    if ( !empty( $q ) )
    {
        echo "<input type=\"hidden\" name=\"q\" value=\"";
        echo $q;
        echo "\" />";
    }
    echo "        ";
    if ( !empty( $status ) )
    {
        echo "<input type=\"hidden\" name=\"status\" value=\"";
        echo $status;
        echo "\" />";
    }
    echo "        ";
    if ( !empty( $_GET['rows'] ) )
    {
        echo "<input type=\"hidden\" name=\"rows\" value=\"";
        echo ( $_GET['rows'] );
        echo "\" />";
    }
    echo "        Jump to Page:\r\n        ";
    echo "<s";
    echo "elect name=\"page\" class=\"select\" onchange=\"submit();\">\r\n          ";
    $n = 1;
    while ( $n <= $numpages )
    {
        echo "          <option value=\"";
        echo $n;
        echo "\"";
        if ( $pagenum == $n )
        {
            echo " selected=\"selected\"";
        }
        echo ">";
        echo $n;
        echo "</option>\r\n          ";
        ++$n;
    }
    echo "        </select>\r\n      </form></td>\r\n      ";
}
echo "  </tr>\r\n</table>\r\n<form name=\"servers\" action=\"#\">\r\n  <table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\" class=\"data\">\r\n    <tr>\r\n      <th width=\"26\">#</th>\r\n      <th width=\"50\"><a href=\"server.php?orderby=online";
if ( $orderby == "online" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">Status</a>\r\n        ";
if ( $orderby == "online" )
{
    echo $dirImage;
}
echo "</th>\r\n      <th><a href=\"server.php?orderby=serverid";
if ( $orderby == "serverid" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">ID</a>\r\n        ";
if ( $orderby == "serverid" )
{
    echo $dirImage;
}
echo " / <a href=\"server.php?orderby=name";
if ( $orderby == "name" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">Name</a>\r\n        ";
if ( $orderby == "name" )
{
    echo $dirImage;
}
echo " / <a href=\"server.php?orderby=game";
if ( $orderby == "game" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">Game</a>\r\n        ";
if ( $orderby == "game" )
{
    echo $dirImage;
}
echo "</th>\r\n      <th width=\"40\">Type</th>\r\n      <th>Real Time Query (<a href=\"#\" onclick=\"window.location.reload();\">Refresh</a>)</th>\r\n      <th width=\"60\"></th>\r\n    </tr>\r\n    ";
if ( ( $result ) == 0 && empty( $q ) && empty( $status ) )
{
    echo "    <tr>\r\n      <td colspan=\"8\"><div id=\"infobox2\">";
    echo "<s";
    echo "trong>No Servers Found</strong><br />\r\n          No servers found. <a href=\"serveradd.php\">Click here</a> to add a new server.</div></td>\r\n    </tr>\r\n    ";
}
else if ( ( $result ) == 0 && ( !empty( $q ) || !empty( $status ) ) )
{
    echo "    <tr>\r\n      <td colspan=\"8\"><div id=\"infobox2\">";
    echo "<s";
    echo "trong>No Servers Found</strong><br />\r\n          Modify your search.</div></td>\r\n    </tr>\r\n    ";
}
echo "    ";
$n = 1;
while ( $rows = ( $result ) )
{
    echo "    ";
    $rows2 = ( "SELECT `clientid`, `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$rows['clientid']."' LIMIT 1" );
    echo "    <tr onmouseover=\"this.className='mouseover';\" class=\"";
    echo $rows['status'];
    echo "\" onmouseout=\"this.className='";
    echo $rows['status'];
    echo "';\">\r\n      <td style=\"color:#666666;\">";
    echo $n;
    echo "</td>\r\n      <td>";
    echo ( $rows['online'] );
    echo "</td>\r\n      <td><a href=\"serversummary.php?id=";
    echo $rows['serverid'];
    echo "\">#";
    echo $rows['serverid'];
    echo " - ";
    echo $rows['name'];
    echo "</a><br />\r\n\t  <i>";
    echo $rows['game'];
    echo "</i><br />\r\n      ";
    echo "<s";
    echo "pan style=\"font-size:10px;color:#555555;\">";
    echo $rows2['firstname'];
    echo " ";
    echo $rows2['lastname'];
    echo "</span></td>\r\n      <td><img src=\"templates/";
    echo TEMPLATE;
    echo "/images/linux.png\" width=\"20\" height=\"25\" align=\"middle\" alt=\"\" /></td>\r\n      ";
    if ( !empty( $rows['ipid'] ) )
    {
        echo "      ";
        $rows1 = ( "SELECT `ip` FROM `ip` WHERE `ipid` = '".$rows['ipid']."' LIMIT 1" );
        echo "      ";
        if ( !empty( $rows1['ip'] ) && !empty( $rows['port'] ) && $rows['query'] != "none" )
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
                $rows1['ip'],
                $qryport
            ) );
            echo "      <td style=\"line-height:13px;\">";
            if ( !empty( $serverinfo['Server Name'] ) || !empty( $serverinfo['Current Map'] ) )
            {
                echo "<b>";
                echo $serverinfo['Server Name'];
                echo "</b><br />";
                echo $serverinfo['Current Map'];
                echo " ( <font color=\"#0000FF\"><b>";
                echo $serverinfo['Players'];
                echo "</b></font> Players ";
                if ( $serverinfo['Bot Players'] )
                {
                    echo "/ <b>";
                    echo $serverinfo['Bot Players'];
                    echo "</b> Bots";
                }
                echo " ";
                if ( $serverinfo['Max Players'] )
                {
                    echo "/ <font color=\"#DD0000\"><b>";
                    echo $serverinfo['Max Players'];
                    echo "</b></font> Slots";
                }
                echo " )<br />";
            }
            echo "<i>";
            echo $rows1['ip'];
            echo "<b> : </b>";
            echo $rows['port'];
            echo "</i></td>\r\n      ";
        }
        else
        {
            echo "      <td><i>";
            echo $rows1['ip'];
            echo "<b> : </b>";
            echo $rows['port'];
            echo "</i></td>\r\n      ";
        }
        echo "      <td>";
        if ( $rows['online'] == "Stopped" )
        {
            echo "&nbsp;<a href=\"servermanage.php?task=start&amp;return=";
            echo ( $return );
            echo "&amp;serverid=";
            echo $rows['serverid'];
            echo "\"><img src=\"templates/";
            echo TEMPLATE;
            echo "/images/buttons/play.png\" width=\"25\" height=\"25\" align=\"middle\" alt=\"\" /></a>&nbsp;";
        }
        else if ( $rows['online'] == "Started" )
        {
            echo "<a href=\"servermanage.php?task=restart&amp;return=";
            echo ( $return );
            echo "&amp;serverid=";
            echo $rows['serverid'];
            echo "\"><img src=\"templates/";
            echo TEMPLATE;
            echo "/images/buttons/refresh.png\" width=\"25\" height=\"25\" align=\"middle\" alt=\"\" /></a> <a href=\"servermanage.php?task=stop&amp;return=";
            echo ( $return );
            echo "&amp;serverid=";
            echo $rows['serverid'];
            echo "\"><img src=\"templates/";
            echo TEMPLATE;
            echo "/images/buttons/stop.png\" width=\"25\" height=\"25\" align=\"middle\" alt=\"\" /></a>";
        }
        echo "</td>\r\n      ";
    }
    else
    {
        echo "      <td><input type=\"button\" onclick=\"window.location='serverinstall.php?id=";
        echo $rows['serverid'];
        echo "'\" class=\"button\" value=\"Install Wizard\" /></td>\r\n      <td></td>\r\n      ";
    }
    echo "    </tr>\r\n    ";
    ++$n;
}
( $result );
echo "  </table>\r\n</form>\r\n<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">\r\n  <tr>\r\n    <td align=\"right\"><form method=\"get\" action=\"server.php\">\r\n        ";
if ( !empty( $orderby ) && $orderby != "serverid" )
{
    echo "<input type=\"hidden\" name=\"orderby\" value=\"";
    echo $orderby;
    echo "\" />";
}
echo "        ";
if ( !empty( $dir ) )
{
    echo "<input type=\"hidden\" name=\"dir\" value=\"";
    echo $dir;
    echo "\" />";
}
echo "        ";
if ( !empty( $search ) )
{
    echo "<input type=\"hidden\" name=\"search\" value=\"";
    echo $search;
    echo "\" />";
}
echo "        ";
if ( !empty( $q ) )
{
    echo "<input type=\"hidden\" name=\"q\" value=\"";
    echo $q;
    echo "\" />";
}
echo "        ";
if ( !empty( $status ) )
{
    echo "<input type=\"hidden\" name=\"status\" value=\"";
    echo $status;
    echo "\" />";
}
echo "        Rows Per Page:\r\n        ";
echo "<s";
echo "elect name=\"rows\" class=\"select\" onchange=\"setCookie('serverrows',this.value,30);submit();\">\r\n          <option value=\"15\" ";
if ( $rowsperpage == 15 )
{
    echo " selected=\"selected\"";
}
echo ">15</option>\r\n          <option value=\"25\" ";
if ( $rowsperpage == 25 )
{
    echo " selected=\"selected\"";
}
echo ">25</option>\r\n          <option value=\"50\" ";
if ( $rowsperpage == 50 )
{
    echo " selected=\"selected\"";
}
echo ">50</option>\r\n          <option value=\"100\" ";
if ( $rowsperpage == 100 )
{
    echo " selected=\"selected\"";
}
echo ">100</option>\r\n          <option value=\"All\" ";
if ( $rowsperpage == 999999 )
{
    echo " selected=\"selected\"";
}
echo ">All</option>\r\n        </select>\r\n      </form></td>\r\n  </tr>\r\n</table>\r\n<table align=\"center\">\r\n  <tr>\r\n    <td width=\"12\" align=\"right\"><table style=\"width:12px;height:12px;\" cellspacing=\"1\" class=\"data\">\r\n        <tr class=\"Pending\">\r\n          <td></td>\r\n        </tr>\r\n      </table></td>\r\n    <td>Pending</td>\r\n    <td width=\"5\"></td>\r\n    <td width=\"12\" align=\"right\"><table style=\"width:12px;height:12px;\" cellspac";
echo "ing=\"1\" class=\"data\">\r\n        <tr class=\"Active\">\r\n          <td></td>\r\n        </tr>\r\n      </table></td>\r\n    <td>Active</td>\r\n    <td width=\"5\"></td>\r\n    <td width=\"12\" align=\"right\"><table style=\"width:12px;height:12px;\" cellspacing=\"1\" class=\"data\">\r\n        <tr class=\"Suspended\">\r\n          <td></td>\r\n        </tr>\r\n      </table></td>\r\n    <td>Suspended</td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

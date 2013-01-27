<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Clients";
$page = "client";
$tab = "2";
$return = "client.php";
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
    $orderby = "clientid";
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
else if ( !empty( $_COOKIE['clientrows'] ) && ( $_COOKIE['clientrows'] ) )
{
    $rowsperpage = ( $_COOKIE['clientrows'] );
}
else if ( $_GET['rows'] == "All" || $_COOKIE['clientrows'] == "All" )
{
    $rowsperpage = 999999;
}
else
{
    $rowsperpage = 25;
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
$query = "SELECT * FROM `client` ";
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
echo "/images/spacer.gif\" width=\"5\" height=\"1\" alt=\"\" /></td>\r\n    <td id=\"tabs1\" class=\"tabs\" onclick=\"toggleTab(1)\">Search/Filter</td>\r\n    <td width=\"100%\" class=\"tabspacer\">&nbsp;</td>\r\n  </tr>\r\n  <tr id=\"tab1\" style=\"display:none;\">\r\n    <td class=\"tab\" colspan=\"3\"><form action=\"client.php\" method=\"get\">\r\n        ";
if ( !empty( $_GET['rows'] ) )
{
    echo "<input type=\"hidden\" name=\"rows\" value=\"";
    echo ( $_GET['rows'] );
    echo "\" />";
}
echo "        <p align=\"center\">Search in\r\n          ";
echo "<s";
echo "elect name=\"search\" class=\"select\">\r\n            <option value=\"clientid\"";
if ( $search == "clientid" )
{
    echo " selected=\"selected\"";
}
echo ">Client ID</option>\r\n            <option value=\"firstname\"";
if ( $search == "firstname" )
{
    echo " selected=\"selected\"";
}
echo ">First Name</option>\r\n            <option value=\"lastname\"";
if ( $search == "lastname" )
{
    echo " selected=\"selected\"";
}
echo ">Last Name</option>\r\n            <option value=\"email\"";
if ( $search == "email" )
{
    echo " selected=\"selected\"";
}
echo ">Email Address</option>\r\n            <option value=\"lastip\"";
if ( $search == "lastip" )
{
    echo " selected=\"selected\"";
}
echo ">Last IP</option>\r\n            <option value=\"lasthost\"";
if ( $search == "lasthost" )
{
    echo " selected=\"selected\"";
}
echo ">Last Hostname</option>\r\n          </select>\r\n          for\r\n          <input type=\"text\" name=\"q\" class=\"text\" size=\"40\" value=\"";
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
echo ">Any</option>\r\n            <option value=\"Active\"";
if ( $status == "Active" )
{
    echo " selected=\"selected\"";
}
echo ">Active</option>\r\n            <option value=\"Inactive\"";
if ( $status == "Inactive" )
{
    echo " selected=\"selected\"";
}
echo ">Inactive</option>\r\n          </select>\r\n          <input type=\"submit\" value=\"Search\" class=\"button\" />\r\n        </p>\r\n      </form></td>\r\n  </tr>\r\n</table>\r\n";
echo "<s";
echo "cript language=\"javascript\" type=\"text/javascript\">var numtabs = 1;</script>\r\n<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">\r\n  <tr>\r\n    <td><b>";
echo $numrecords;
echo " Records Found, Page ";
echo $pagenum;
echo " of ";
echo $numpages;
echo "</b> (<a href=\"clientadd.php\">Add New Client</a>)</td>\r\n    ";
if ( 1 <= $numpages )
{
    echo "    <td align=\"right\"><form id=\"pageForm\" method=\"get\" action=\"client.php\">\r\n        ";
    if ( !empty( $orderby ) && $orderby != "clientid" )
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
    echo "elect id=\"pageSelect\" name=\"page\" class=\"select\" onchange=\"submit();\">\r\n          ";
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
echo "  </tr>\r\n</table>\r\n<form name=\"clientForm\" action=\"emailsend.php\">\r\n  <table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\" class=\"data\">\r\n    <tr>\r\n      <th width=\"26\">#</th>\r\n      <th width=\"26\"><input type=\"checkbox\" onclick=\"toggleCheckbox(clientForm)\" /></th>\r\n      <th width=\"35\"><a href=\"client.php?orderby=clientid";
if ( $orderby == "clientid" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">ID</a>\r\n        ";
if ( $orderby == "clientid" )
{
    echo $dirImage;
}
echo "</th>\r\n      <th><a href=\"client.php?orderby=firstname";
if ( $orderby == "firstname" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">First Name</a>\r\n        ";
if ( $orderby == "firstname" )
{
    echo $dirImage;
}
echo "</th>\r\n      <th><a href=\"client.php?orderby=lastname";
if ( $orderby == "lastname" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">Last Name</a>\r\n        ";
if ( $orderby == "lastname" )
{
    echo $dirImage;
}
echo "</th>\r\n      <th><a href=\"client.php?orderby=email";
if ( $orderby == "email" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">Email</a>\r\n        ";
if ( $orderby == "email" )
{
    echo $dirImage;
}
echo "</th>\r\n      <th>Servers</th>\r\n      <th><a href=\"client.php?orderby=lastlogin";
if ( $orderby == "lastlogin" && empty( $dir ) )
{
    echo "&amp;dir=desc";
}
echo $linkend;
echo "\">Last Login</a>\r\n        ";
if ( $orderby == "lastlogin" )
{
    echo $dirImage;
}
echo "</th>\r\n    </tr>\r\n    ";
if ( ( $result ) == 0 && empty( $q ) && empty( $status ) )
{
    echo "    <tr>\r\n      <td colspan=\"9\"><div id=\"infobox2\">";
    echo "<s";
    echo "trong>No Clients Found</strong><br />\r\n          No clients found. <a href=\"clientadd.php\">Click here</a> to add a new client.</div></td>\r\n    </tr>\r\n    ";
}
else if ( ( $result ) == 0 && ( !empty( $q ) || !empty( $status ) ) )
{
    echo "    <tr>\r\n      <td colspan=\"9\"><div id=\"infobox2\">";
    echo "<s";
    echo "trong>No Clients Found</strong><br />\r\n          Modify your search.</div></td>\r\n    </tr>\r\n    ";
}
echo "    ";
$n = 1;
while ( $rows = ( $result ) )
{
    echo "    <tr onmouseover=\"this.className='mouseover';\" class=\"";
    echo $rows['status'];
    echo "\" onmouseout=\"this.className='";
    echo $rows['status'];
    echo "';\">\r\n      <td style=\"color:#666666;height:22px;\">";
    echo $n;
    echo "</td>\r\n      <td><input type=\"checkbox\" name=\"client[]\" /></td>\r\n      <td><a href=\"clientsummary.php?id=";
    echo $rows['clientid'];
    echo "\">";
    echo $rows['clientid'];
    echo "</a></td>\r\n      <td><a href=\"clientsummary.php?id=";
    echo $rows['clientid'];
    echo "\">";
    echo $rows['firstname'];
    echo "</a></td>\r\n      <td><a href=\"clientsummary.php?id=";
    echo $rows['clientid'];
    echo "\">";
    echo $rows['lastname'];
    echo "</a></td>\r\n      <td>";
    echo $rows['email'];
    echo "</td>\r\n      <td>";
    echo ( "SELECT `serverid` FROM `server` WHERE `clientid` = '".$rows['clientid']."'" );
    echo "</td>\r\n      <td>";
    echo ( $rows['lastlogin'] );
    echo "</td>\r\n    </tr>\r\n    ";
    ++$n;
}
( $result );
echo "  </table>\r\n</form>\r\n<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">\r\n  <tr>\r\n    <td align=\"right\"><form method=\"get\" action=\"client.php\">\r\n        ";
if ( !empty( $orderby ) && $orderby != "clientid" )
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
echo "elect name=\"rows\" class=\"select\" onchange=\"setCookie('clientrows',this.value,30);submit();\">\r\n          <option value=\"15\" ";
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
echo ">All</option>\r\n        </select>\r\n      </form></td>\r\n  </tr>\r\n</table>\r\n<table align=\"center\">\r\n  <tr>\r\n    <td width=\"12\" align=\"right\"><table style=\"width:12px;height:12px;\" cellspacing=\"1\" class=\"data\">\r\n        <tr class=\"Active\">\r\n          <td></td>\r\n        </tr>\r\n      </table></td>\r\n    <td>Active</td>\r\n    <td width=\"5\"></td>\r\n    <td width=\"12\" align=\"right\"><table style=\"width:12px;height:12px;\" cellspacin";
echo "g=\"1\" class=\"data\">\r\n        <tr class=\"Inactive\">\r\n          <td></td>\r\n        </tr>\r\n      </table></td>\r\n    <td>Inactive</td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Activity Logs";
$page = "utilitieslog";
$tab = "5";
$return = "utilitieslog.php";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
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
$query = "SELECT * FROM `log` ORDER BY `logid` DESC";
$numpages = ( ( $query ) / $rowsperpage ) + 1;
$result = ( $query." LIMIT ".$limit.", ".$rowsperpage );
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"5\" cellspacing=\"0\">\r\n  <tr>\r\n    <td align=\"right\"><form method=\"get\" action=\"utilitieslog.php\">\r\n        Jump to Page:\r\n        ";
echo "<s";
echo "elect name=\"page\" class=\"select\" onchange=\"submit();\">\r\n          ";
$n = 1;
while ( $n < $numpages )
{
    echo "          <option value=\"";
    echo $n;
    echo "\"";
    if ( $page == $n )
    {
        echo " selected=\"selected\"";
    }
    echo ">";
    echo $n;
    echo "</option>\r\n          ";
    ++$n;
}
echo "        </select>\r\n      </form></td>\r\n  </tr>\r\n</table>\r\n<fieldset>\r\n<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\r\n  <tr>\r\n    <td class=\"fieldheader\">Activity Logs</td>\r\n  </tr>\r\n  <tr>\r\n    <td align=\"center\"><table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" class=\"data\">\r\n        <tr>\r\n          <th>ID</th>\r\n          <th>Message</th>\r\n          <th>Name</th>\r\n          <th>IP</th>\r\n          <th";
echo ">Timestamp</th>\r\n        </tr>\r\n        ";
if ( ( $result ) == 0 )
{
    echo "        <tr>\r\n          <td colspan=\"5\" align=\"center\">No Logs Found</td>\r\n        </tr>\r\n        ";
}
echo "        ";
while ( $rows = ( $result ) )
{
    echo "        <tr onmouseover=\"this.className='admindatatablehighlight'\" onmouseout=\"this.className=''\">\r\n          <td>#";
    echo $rows['logid'];
    echo "</td>\r\n          <td>";
    echo $rows['message'];
    echo "</td>\r\n          <td>";
    echo $rows['name'];
    echo "</td>\r\n          <td>";
    echo $rows['ip'];
    echo "</td>\r\n          <td>";
    echo ( $rows['timestamp'] );
    echo "</td>\r\n        </tr>\r\n        ";
}
( $result );
echo "      </table></td>\r\n  </tr>\r\n</table>\r\n</fieldset>\r\n<img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" height=\"10\" width=\"1\" alt=\"\" /><br />\r\n<div align=\"center\">\r\n  <input type=\"button\" value=\"Purge All Logs\" onclick=\"window.location='utilitieslogprocess.php?task=deletelog'\" class=\"button red\" />\r\n</div>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

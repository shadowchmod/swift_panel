<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Manage Games";
$page = "configgame";
$tab = "6";
$return = "configgame.php";
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/games.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$result = ( "SELECT `gameid`, `name`, `game`, `slots`, `type`, `query`, `gamedir` FROM `game` WHERE `status` = 'Active' ORDER BY `game`" );
$result1 = ( "SELECT `gameid`, `name`, `game`, `slots`, `type`, `query`, `gamedir` FROM `game` WHERE `status` = 'Inactive' ORDER BY `game`" );
include( "./templates/".TEMPLATE."/header.php" );
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\">\r\n  <tr>\r\n    <td width=\"5\" class=\"tabspacer\"><img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"5\" height=\"1\" alt=\"\" /></td>\r\n    <td id=\"tabs1\" class=\"tabsactive\" onclick=\"toggleTab(1)\">Active</td>\r\n    <td width=\"2\" class=\"tabspacer\"><img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"2\" height=\"1\" alt=\"\" /></td>\r\n    <td id=\"tabs2\" class=\"tabs\" onclick=\"toggleTab(2)\">Inactive</td>\r\n    <td width=\"100%\" class=\"tabspacer\">&nbsp;</td>\r\n  </tr>\r\n  <tr id=\"tab1\">\r\n    <td class=\"tab\" colspan=\"5\"><p><b>";
echo ( $result );
echo " Records Found</b> (<a href=\"configgameadd.php\">Add New Game</a>)</p>\r\n        <table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\" class=\"data\">\r\n          <tr>\r\n            <th>Name</th>\r\n            <th>Game</th>\r\n            <th>Description</th>\r\n            <th>Query</th>\r\n            <th>Directory</th>\r\n            <th width=\"30\"></th>\r\n          </tr>\r\n          ";
while ( $rows = ( $result ) )
{
    echo "          <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n            <td>";
    echo $rows['name'];
    echo "</td>\r\n            <td>";
    echo $rows['game'];
    echo "</td>\r\n            <td>";
    echo $rows['slots'];
    echo " Slots ";
    echo $rows['type'];
    echo "</td>\r\n            <td>";
    echo $gamequery[$rows['query']];
    echo "</td>\r\n            <td>";
    echo $rows['gamedir'];
    echo "</td>\r\n            <td><a href=\"configgameedit.php?id=";
    echo $rows['gameid'];
    echo "\"><img src=\"templates/";
    echo TEMPLATE;
    echo "/images/buttons/edit24.png\" width=\"24\" height=\"24\" border=\"0\" alt=\"Edit\" /></a></td>\r\n          </tr>\r\n          ";
}
( $result );
echo "        </table></td>\r\n  </tr>\r\n  <tr id=\"tab2\" style=\"display:none;\">\r\n    <td class=\"tab\" colspan=\"5\"><p><b>";
echo ( $result1 );
echo " Records Found</b> (<a href=\"configgameadd.php\">Add New Game</a>)</p>\r\n        <table width=\"100%\" cellpadding=\"1\" cellspacing=\"1\" class=\"data\">\r\n          <tr>\r\n            <th>Name</th>\r\n            <th>Game</th>\r\n            <th>Description</th>\r\n            <th>Query</th>\r\n            <th>Directory</th>\r\n            <th width=\"30\"></th>\r\n          </tr>\r\n          ";
while ( $rows1 = ( $result1 ) )
{
    echo "          <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n            <td>";
    echo $rows1['name'];
    echo "</td>\r\n            <td>";
    echo $rows1['game'];
    echo "</td>\r\n            <td>";
    echo $rows1['slots'];
    echo " Slots ";
    echo $rows1['type'];
    echo "</td>\r\n            <td>";
    echo $rows1['query'];
    echo "</td>\r\n            <td>";
    echo $rows1['gamedir'];
    echo "</td>\r\n            <td><a href=\"configgameedit.php?id=";
    echo $rows1['gameid'];
    echo "\"><img src=\"templates/";
    echo TEMPLATE;
    echo "/images/buttons/edit24.png\" width=\"24\" height=\"24\" border=\"0\" alt=\"Edit\" /></a></td>\r\n          </tr>\r\n          ";
}
( $result1 );
echo "        </table></td>\r\n  </tr>\r\n</table>\r\n";
echo "<s";
echo "cript language=\"javascript\" type=\"text/javascript\">var numtabs = 2;</script>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

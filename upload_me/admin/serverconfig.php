<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Server Config Builder";
$page = "serverconfig";
$tab = "3";
$return = "serverconfig.php?id=".$_GET['id'];
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/ftp.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$serverid = ( $_GET['id'] );
$rows = ( "SELECT `serverid`, `ipid`, `boxid`, `user`, `password`, `configdir` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
if ( !empty( $rows['ipid'] ) && !empty( $rows['configdir'] ) )
{
    $rows1 = ( "SELECT `ip` FROM `ip` WHERE `ipid` = '".$rows['ipid']."' LIMIT 1" );
    $rows2 = ( "SELECT `ftpport`, `passive` FROM `box` WHERE `boxid` = '".$rows['boxid']."' LIMIT 1" );
    if ( $rows2['passive'] == "On" )
    {
        $passive = TRUE;
    }
    else
    {
        $passive = FALSE;
    }
    if ( $ftpconnection = ( $rows1['ip'], $rows2['ftpport'], $rows['user'], $rows['password'], $passive ) )
    {
        $tempHandle = ( "php://temp", "r+" );
        ( $ftpconnection, $tempHandle, $rows['configdir'], FTP_BINARY );
        ( $tempHandle );
        $filecontents = ( $tempHandle );
    }
}
$tabs = array(
    "Summary" => "serversummary.php?id=".$rows['serverid'],
    "Settings" => "serverprofile.php?id=".$rows['serverid'],
    "Advanced" => "serveradvanced.php?id=".$rows['serverid'],
    "Config Builder" => "serverconfig.php?id=".$rows['serverid'],
    "Web FTP" => "serverftp.php?id=".$rows['serverid'],
    "Activity Logs" => "serverlog.php?id=".$rows['serverid']
);
include( "./templates/".TEMPLATE."/header.php" );
echo ( $tabs, 4 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">";
if ( empty( $rows['ipid'] ) )
{
    echo "      <div id=\"infobox2\">";
    echo "<s";
    echo "trong>Server Not Installed</strong><br />Please install the server first.</div>\r\n      ";
}
else if ( empty( $rows['configdir'] ) )
{
    echo "      <div id=\"infobox2\">";
    echo "<s";
    echo "trong>Server Config Not Selected</strong><br />Please install the server first.</div>\r\n      ";
}
else
{
    echo "      <div align=\"center\">\r\n        <form method=\"post\" action=\"serverftpprocess.php\">\r\n          <input type=\"hidden\" name=\"task\" value=\"filesave\" />\r\n          <input type=\"hidden\" name=\"id\" value=\"";
    echo $serverid;
    echo "\" />\r\n          <input type=\"hidden\" name=\"path\" value=\"";
    echo $path;
    echo "\" />\r\n          <input type=\"hidden\" name=\"file\" value=\"";
    echo $file;
    echo "\" />\r\n          <textarea name=\"filecontents\" rows=\"30\" cols=\"150\" class=\"textarea\">";
    echo $filecontents;
    echo "</textarea>\r\n          <br />\r\n          <img src=\"templates/";
    echo TEMPLATE;
    echo "/images/spacer.gif\" height=\"10\" width=\"1\"><br />\r\n          <input type=\"submit\" value=\"Save\" class=\"button green\" />\r\n        </form>\r\n      </div>\r\n      ";
}
echo "    </td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

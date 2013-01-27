<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Box Game Files";
$page = "boxgamefile";
$tab = "4";
$return = "boxgamefile.php?id=".$_GET['id'];
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$boxid = ( $_GET['id'] );
$rows = ( "SELECT `boxid`, `name` FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
$result1 = ( "SELECT `gameid`, `name`, `game`, `gamedir` FROM `game` WHERE `status` = 'Active' ORDER BY `game`" );
$rows2 = ( "SELECT `ip`, `sshport`, `login`, `password` FROM `box` WHERE `boxid` = '".$rows['boxid']."'" );
if ( !( "ssh2" ) )
{
    $_SESSION['msg1'] = "SSH2 Extension Error!";
    $_SESSION['msg2'] = "SSH2 Extension not detected!";
}
else if ( !( $sshconnection = @( $rows2['ip'], $rows2['sshport'] ) ) )
{
    $_SESSION['msg1'] = "Connection Error!";
    $_SESSION['msg2'] = "Unable to connect to box with SSH.";
}
else if ( !( $sshconnection, $rows2['login'], @( $rows2['password'] ) ) )
{
    $_SESSION['msg1'] = "Authentication Error!";
    $_SESSION['msg2'] = "Unable to login to box with SSH.";
}
else
{
    $sshshell = ( $sshconnection, "vt102", null, 400, 80, SSH2_TERM_UNIT_CHARS );
    while ( $rows1 = ( $result1 ) )
    {
        $gamefiles[$rows1['gameid']] = "<font color=\"#669933\"><b>Found</b></font>";
        ( $sshshell, "cd ".$rows1['gamedir']."\n" );
        ( 350000 );
        while ( $sshline = ( $sshshell ) )
        {
            if ( ( "/No such file or directory/", $sshline ) )
            {
                $gamefiles[$rows1['gameid']] = "<font color=\"#DD0000\"><b>Not Found</b></font>";
            }
        }
    }
}
$result1 = ( "SELECT `gameid`, `name`, `game`, `gamedir` FROM `game` WHERE `status` = 'Active' ORDER BY `game`" );
$tabs = array(
    "Summary" => "boxsummary.php?id=".$rows['boxid'],
    "Profile" => "boxprofile.php?id=".$rows['boxid'],
    "Servers" => "boxserver.php?id=".$rows['boxid'],
    "Game Files" => "boxgamefile.php?id=".$rows['boxid'],
    "Activity Logs" => "boxlog.php?id=".$rows['boxid']
);
include( "./templates/".TEMPLATE."/header.php" );
echo ( $tabs, 4 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">";
echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
echo "      <div style=\"font-size:18px;\">#";
echo $rows['boxid'];
echo " - ";
echo $rows['name'];
echo "</div>\r\n      <img src=\"templates/";
echo TEMPLATE;
echo "/images/spacer.gif\" width=\"1\" height=\"6\" alt=\"\" /><br />\r\n      <table width=\"100%\" cellpadding=\"4\" cellspacing=\"1\" class=\"data\">\r\n        <tr>\r\n          <th>Name</th>\r\n          <th>Game</th>\r\n          <th>Install Path</th>\r\n          <th></th>\r\n        </tr>\r\n        ";
$n = 1;
while ( $rows1 = ( $result1 ) )
{
    echo "        <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n          <td>";
    echo $rows1['name'];
    echo "</td>\r\n          <td>";
    echo $rows1['game'];
    echo "</td>\r\n          <td>";
    echo $rows1['gamedir'];
    echo "</td>\r\n          <td>";
    echo $gamefiles[$rows1['gameid']];
    echo "</td>\r\n        </tr>\r\n        ";
}
( $result1 );
echo "      </table>\r\n    </td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

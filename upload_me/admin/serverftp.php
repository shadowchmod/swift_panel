<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Server Web FTP";
$page = "serverftp";
$tab = "3";
$return = "serverftp.php?id=".$_GET['id'];
require( "../configuration.php" );
require( "./include.php" );
include( "../includes/ftp.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$serverid = ( $_GET['id'] );
$path = ( $_GET['path'] );
$file = ( $_GET['file'] );
$rows = ( "SELECT `serverid`, `ipid`, `boxid`, `user`, `password` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
if ( !empty( $rows['ipid'] ) )
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
        if ( empty( $file ) )
        {
            $array = ( $ftpconnection, $path );
            if ( !( $array ) )
            {
                $path = ( $path );
                $array = ( $ftpconnection, $path );
            }
            if ( ( $array ) )
            {
                foreach ( $array as $folder )
                {
                    $struc = array( );
                    $current = ( "/[\\s]+/", $folder, 9 );
                    $struc['perms'] = $current[0];
                    $struc['permsn'] = ( $current[0] );
                    $struc['number'] = $current[1];
                    $struc['owner'] = $current[2];
                    $struc['group'] = $current[3];
                    $struc['size'] = ( $current[4] );
                    $struc['month'] = $current[5];
                    $struc['day'] = $current[6];
                    $struc['time'] = $current[7];
                    $struc['name'] = ( "//", "", $current[8] );
                    if ( $struc['name'] != "." && $struc['name'] != ".." )
                    {
                        if ( ( $struc['perms'] ) == "folder" )
                        {
                            $folders[] = $struc;
                        }
                        else if ( ( $struc['perms'] ) == "link" )
                        {
                            $links[] = $struc;
                        }
                        else
                        {
                            $files[] = $struc;
                        }
                    }
                }
            }
        }
        else
        {
            $tempHandle = ( "php://temp", "r+" );
            if ( ( $path, 0 - 1 ) == "/" )
            {
                if ( !( $ftpconnection, $tempHandle, $path.$file, FTP_BINARY ) )
                {
                    $path = ( $path );
                    @( $ftpconnection, $tempHandle, $path."/".$file, FTP_BINARY );
                }
            }
            else if ( !( $ftpconnection, $tempHandle, $path."/".$file, FTP_BINARY ) )
            {
                $path = ( $path );
                @( $ftpconnection, $tempHandle, $path.$file, FTP_BINARY );
            }
            ( $tempHandle );
            $filecontents = ( $tempHandle );
        }
    }
}
$tabs = array(
    "Summary" => "serversummary.php?id=".$rows['serverid'],
    "Settings" => "serverprofile.php?id=".$rows['serverid'],
    "Advanced" => "serveradvanced.php?id=".$rows['serverid'],
    "Web FTP" => "serverftp.php?id=".$rows['serverid'],
    "Activity Logs" => "serverlog.php?id=".$rows['serverid']
);
include( "./templates/".TEMPLATE."/header.php" );
echo ( $tabs, 4 );
echo "<table width=\"100%\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"tab\">\r\n    ";
if ( empty( $rows['ipid'] ) )
{
    echo "    <div id=\"infobox2\">";
    echo "<s";
    echo "trong>Server Not Installed</strong><br />Please install the server first.</div>\r\n    ";
}
else
{
    echo "\t";
    echo ( $_SESSION['msg1'], $_SESSION['msg2'] );
    echo "      <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n        <tr>\r\n          <td align=\"left\"><a href=\"serverftp.php?id=";
    echo $serverid;
    echo "\"><img src=\"templates/";
    echo TEMPLATE;
    echo "/images/home_24.png\" align=\"middle\" alt=\"\" /></a>";
    echo ( $path );
    echo "\t\t  ";
    if ( !empty( $file ) )
    {
        echo " > <a href='serverftp.php?id=".$serverid."&path=".( $path )."&file=".$file."'>".$file."</a>";
    }
    echo "</td>\r\n          <td align=\"right\">IP: <b>";
    echo $rows1['ip'];
    echo "</b>&nbsp;&nbsp;|&nbsp;&nbsp;Port: <b>";
    echo $rows2['ftpport'];
    echo "</b>&nbsp;&nbsp;|&nbsp;&nbsp;User: <b>";
    echo $rows['user'];
    echo "</b>&nbsp;&nbsp;|&nbsp;&nbsp;Password: <b>";
    echo $rows['password'];
    echo "</b></td>\r\n        </tr>\r\n      </table>\r\n      <img src=\"templates/";
    echo TEMPLATE;
    echo "/images/spacer.gif\" width=\"1\" height=\"5\" alt=\"\" /><br />\r\n      ";
    if ( empty( $file ) )
    {
        echo "      <table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" class=\"data\">\r\n        <tr>\r\n          <th>File</th>\r\n          <th>Size</th>\r\n          <th>User</th>\r\n          <th>Group</th>\r\n          <th>Perms</th>\r\n          <th width=\"30\"></th>\r\n        </tr>\r\n        ";
        if ( !empty( $folders ) )
        {
            foreach ( $folders as $x )
            {
                echo "        ";
                if ( ( $path, 0, 1 ) == "/" )
                {
                    $x_path = $path."/".$x['name'];
                }
                else
                {
                    $x_path = $path.$x['name']."/";
                }
                echo "        <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n          <td style=\"text-align:left;\"><img src=\"templates/";
                echo TEMPLATE;
                echo "/images/folder_24.png\" align=\"absmiddle\" alt=\"\" /> <a href=\"serverftp.php?id=";
                echo $serverid;
                echo "&path=";
                echo ( $x_path );
                echo "\">";
                echo $x['name'];
                echo "</a></td>\r\n          <td>";
                echo $x['size'];
                echo "</td>\r\n          <td>";
                echo $x['owner'];
                echo "</td>\r\n\t\t  <td>";
                echo $x['group'];
                echo "</td>\r\n          <td>";
                echo $x['permsn'];
                echo "</td>\r\n          <td><a href=\"#\" onclick=\"doDeleteDir('";
                echo $x['name'];
                echo "', '";
                echo $serverid;
                echo "', '";
                echo ( $path );
                echo "')\"><img src=\"templates/";
                echo TEMPLATE;
                echo "/images/status/red.png\" width=\"25\" height=\"25\" alt=\"Delete\"></a></td>\r\n        </tr>\r\n        ";
            }
        }
        echo "        ";
        if ( !empty( $files ) )
        {
            foreach ( $files as $x )
            {
                echo "        <tr onmouseover=\"this.className='mouseover'\" onmouseout=\"this.className=''\">\r\n          <td style=\"text-align:left;\"><img src=\"templates/";
                echo TEMPLATE;
                echo "/images/preview_24.png\" align=\"absmiddle\" alt=\"\" /> ";
                echo ( $x['name'] );
                echo "</td>\r\n          <td>";
                echo $x['size'];
                echo "</td>\r\n          <td>";
                echo $x['owner'];
                echo "</td>\r\n\t\t  <td>";
                echo $x['group'];
                echo "</td>\r\n          <td>";
                echo $x['permsn'];
                echo "</td>\r\n          <td><a href=\"#\" onclick=\"doDeleteFile('";
                echo $x['name'];
                echo "', '";
                echo $serverid;
                echo "', '";
                echo ( $path );
                echo "')\"><img src=\"templates/";
                echo TEMPLATE;
                echo "/images/status/red.png\" width=\"25\" height=\"25\" alt=\"Delete\"></a></td>\r\n        </tr>\r\n        ";
            }
        }
        echo "      </table>\r\n      ";
        if ( !empty( $rows['ipid'] ) )
        {
            echo "      <img src=\"templates/";
            echo TEMPLATE;
            echo "/images/spacer.gif\" width=\"1\" height=\"10\" alt=\"\" /><br />\r\n      <table cellpadding=\"2\" cellspacing=\"0\">\r\n      <tr>\r\n      <td>\r\n      <form method=\"post\" action=\"serverftpprocess.php\" enctype=\"multipart/form-data\">\r\n        <input type=\"hidden\" name=\"task\" value=\"fileupload\" />\r\n        <input type=\"hidden\" name=\"id\" value=\"";
            echo $serverid;
            echo "\" />\r\n        <input type=\"hidden\" name=\"path\" value=\"";
            echo $path;
            echo "\" />\r\n      <table cellpadding=\"2\" cellspacing=\"1\" class=\"data\">\r\n        <tr>\r\n          <th>File Upload (Max: ";
            echo ( "upload_max_filesize" );
            echo ")</th>\r\n        </tr>\r\n        <tr>\r\n          <td><input type=\"file\" name=\"file\" class=\"file\" size=\"40\" /></td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"center\"><input type=\"submit\" value=\"Upload\" class=\"button\" /></td>\r\n        </tr>\r\n      </table>\r\n      </form>\r\n      </td>\r\n      <td>\r\n      <form method=\"post\" action=\"serverftpprocess.php\">\r\n        <input type=\"hidden\" name=\"task\" value=\"makedir\" ";
            echo "/>\r\n        <input type=\"hidden\" name=\"id\" value=\"";
            echo $serverid;
            echo "\" />\r\n        <input type=\"hidden\" name=\"path\" value=\"";
            echo $path;
            echo "\" />\r\n      <table cellpadding=\"2\" cellspacing=\"1\" class=\"data\">\r\n        <tr>\r\n          <th>Make New Directory</th>\r\n        </tr>\r\n        <tr>\r\n          <td><input type=\"text\" name=\"dir\" class=\"text\" size=\"40\" /></td>\r\n        </tr>\r\n        <tr>\r\n          <td align=\"center\"><input type=\"submit\" value=\"Create\" class=\"button\" /></td>\r\n        </tr>\r\n      </table>\r\n      </form>\r\n      </td>\r\n      </tr>\r\n     ";
            echo " </table>\r\n      ";
            echo "<s";
            echo "cript language=\"javascript\" type=\"text/javascript\">\r\n\t  <!--\r\n\t  \tfunction doDeleteFile(file, id, path) { if (confirm(\"Are you sure you want to delete file: \"+file+\"?\")) { window.location='serverftpprocess.php?task=filedelete&id='+id+'&path='+path+'&file='+file; } }\r\n\t\tfunction doDeleteDir(dir, id, path) { if (confirm(\"Are you sure you want to delete directory: \"+dir+\"?\")) { window.location='server";
            echo "ftpprocess.php?task=dirdelete&id='+id+'&path='+path+'&dir='+dir; } }\r\n\t\t-->\r\n\t  </script>\r\n      ";
        }
        echo "      ";
    }
    else
    {
        echo "      <div align=\"center\">\r\n      <form method=\"post\" action=\"serverftpprocess.php\">\r\n          <input type=\"hidden\" name=\"task\" value=\"filesave\" />\r\n          <input type=\"hidden\" name=\"id\" value=\"";
        echo $serverid;
        echo "\" />\r\n          <input type=\"hidden\" name=\"path\" value=\"";
        echo $path;
        echo "\" />\r\n          <input type=\"hidden\" name=\"file\" value=\"";
        echo $file;
        echo "\" />\r\n          <textarea name=\"filecontents\" rows=\"30\" cols=\"150\" class=\"textarea\">";
        echo $filecontents;
        echo "</textarea>\r\n          <br /><img src=\"templates/";
        echo TEMPLATE;
        echo "/images/spacer.gif\" height=\"10\" width=\"1\"><br />\r\n          <input type=\"submit\" value=\"Save\" class=\"button green\" />\r\n      </form>\r\n      </div>\r\n      ";
    }
    echo "      ";
}
echo "      </td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

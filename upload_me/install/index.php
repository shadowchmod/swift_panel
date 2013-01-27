<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

@( "max_execution_time", "120" );
@( "output_buffering", "Off" );
if ( ( "../configuration.php" ) )
{
    require( "../configuration.php" );
}
$connection = @( DBHOST, DBUSER, DBPASSWORD );
$dbselect = @( DBNAME );
( ".." );
$getcwd = ( );
( "install" );
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<title>Swift Panel Install</title>\r\n<link href=\"scripts/style.css\" rel=\"stylesheet\" type=\"text/css\" />\r\n</head>\r\n<body>\r\n<!--\r\nPowered By SWIFT Panel (www.SwiftPan";
echo "el.com)\r\nCopyright @ 2008 All Rights Reservered.\r\n-->\r\n<div id=\"topbg\"></div>\r\n<div id=\"nav\">\r\n  <div id=\"home\">Install & Update Script</div>\r\n</div>\r\n<div id=\"page\">\r\n  <div id=\"content\">\r\n  <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"title\">\r\n    <tr>\r\n      <td align=\"left\"><h1>";
if ( empty( $_GET['step'] ) )
{
    echo "Check Requirements";
}
else if ( $_GET['step'] == "two" )
{
    echo "Select Database Update";
}
else if ( $_GET['step'] == "three" )
{
    echo "Install Database";
}
echo "</h1></td>\r\n    </tr>\r\n  </table>\r\n";
if ( empty( $_GET['step'] ) )
{
    echo "        <b>Step 1</b> -> Step 2 -> Step 3<br /><br />\r\n        ";
    $error = FALSE;
    echo "Checking for configuration file . . . . . ";
    $error .= ;
    echo "Checking your version of PHP . . . . . ";
    $error .= ;
    echo "Checking for PHP safe mode . . . . . ";
    $safe_mode = ( "safe_mode" );
    $error .= ;
    echo "Checking for MySQL database server . . . . . ";
    $mysql = ( "mysql" );
    $error .= ;
    if ( $mysql )
    {
        echo "Checking for mysql database connection . . . . . ";
        $msg = "Error: ".@( )." <br />Debug: ".DBHOST." ".DBUSER;
        $error .= ;
        echo "Checking if user is added to mysql database . . . . . ";
        $msg = "Error: ".@( )." <br />Debug: ".DBNAME;
        $error .= ;
    }
    echo "Checking for FTP extension . . . . . ";
    $ftp = ( "ftp" );
    $error .= ;
    echo "Checking for Curl extension . . . . . ";
    $curl = ( "curl" );
    $error .= ;
    echo "Checking for SSH2 extension . . . . . ";
    $ssh2 = ( "ssh2" );
    $error .= ;
    if ( !$error )
    {
        echo "        <center><form action=\"index.php\" method=\"get\"><input type=\"hidden\" name=\"step\" value=\"two\" /><input type=\"submit\" value=\"Next Step\" class=\"button green\" /></form></center>\r\n\t\t";
    }
    else
    {
        echo "        <center>If you need help, contact us for support!<br />\r\n        Email: <a href='mailto:Support@SwiftPanel.com'>Support@SwiftPanel.com</a><br /><br />\r\n        Fatal Error(s) Found.<br /><br />\r\n        <input type=\"button\" class=\"button blue\" onclick=\"window.location.reload();\" value=\"Check Again\" /></center>\r\n        ";
    }
}
else if ( $_GET['step'] == "two" )
{
    echo "        <a href=\"index.php\">Step 1</a> -> <b>Step 2</b> -> Step 3<br /><br />\r\n        ";
    $dbtables = ( "SHOW TABLES" );
    echo "Checking for existing databases . . . . . ";
    if ( 0 < ( $dbtables ) )
    {
        echo "            <font class=\"ok\">[ FOUND ]</font><br />\r\n            <br />Tables exist in the database.<br /><br />\r\n            You may perform a clean install which will overwrite all data in the database, or you may select a version to update.<br />\r\n            <i>It is recommend you back up your database first.</i><br /><br />\r\n            <b><u>Select Update</u></b><br /><br />\r\n            <form action=\"index.p";
        echo "hp\" method=\"get\">\r\n            <input type=\"hidden\" name=\"step\" value=\"three\" />\r\n            <input name=\"version\" type=\"radio\" value=\"1.6.1\" checked=\"checked\" /> Update Version 1.6.0 to <b>Version 1.6.1</b><br />\r\n            <input name=\"version\" type=\"radio\" value=\"1.6.0\" /> Update Version 1.5.0 to <b>Version 1.6.0</b><br />\r\n            <input name=\"version\" type=\"radio\" value=\"1.5.0\" /> Update Version";
        echo " 1.4.0 to <b>Version 1.5.0</b><br /><br />\r\n            <input type=\"submit\" value=\"Update MySQL Database\" class=\"button green\" />\r\n            </form>\r\n            <br /><br /><br />\r\n            <b><u>Delete All Data !!!</u></b><br /><br />\r\n            <input type=\"button\" class=\"button red\" onclick=\"window.location='index.php?step=three&version=full';\" value=\"Perform Clean Install\" /><br />\r\n\t\t\t";
    }
    else
    {
        echo "            <br /><br />No tables found in the database.<br /><br />\r\n            <b><u>Select Version</u></b><br /><br />\r\n            <form action=\"index.php\" method=\"get\">\r\n            <input type=\"hidden\" name=\"step\" value=\"three\" />\r\n            <input name=\"version\" type=\"radio\" value=\"full\" checked=\"checked\" /> \r\n            <b>Version 1.6.1</b><br /><br />\r\n            <input type=\"submit\" value=\"Install My";
        echo "SQL Database\" class=\"button green\" />\r\n            </form>      \r\n            ";
    }
}
else if ( $_GET['step'] == "three" )
{
    echo "        <a href=\"index.php\">Step 1</a> -> <a href=\"index.php?step=two\">Step 2</a> -> <b>Step 3</b><br /><br />\r\n        ";
    if ( $_GET['version'] == "1.5.0" || $_GET['version'] == "1.6.0" || $_GET['version'] == "1.6.1" )
    {
        echo "Updating Database to <b>Version ".$_GET['version']."</b><br /><br />";
        echo "<font class=\"failed\">Do Not Interrupt!!!</font>";
        echo "<br />";
        echo "Updating MySQL Databases . . . . . ";
                echo "<font class=\"ok\">[ Finished ]</font>";
        echo "<br /><br />";
        echo "<b>Update Complete!!!</b>";
        echo "<br /><br />";
        echo "<font class=\"failed\">DELETE THE INSTALL FOLDER!!!<br />".( )."</font>";
        echo "<br /><br />";
        echo "<font class=\"ok\">Thanks for using SWIFT Panel!</font>";
        echo "<br />";
        echo "<font class=\"ok\">Remember to give us your feedback on the forums!</font>";
    }
    else if ( $_GET['version'] == "full" )
    {
        echo "Installing <b>Version 1.6.1</b><br /><br />";
        echo "<font class=\"failed\">Do Not Interrupt!!!</font>";
        echo "<br />";
        echo "Installing MySQL Databases . . . . . ";
                echo "<font class=\"ok\">[ Finished ]</font>";
        echo "<br /><br />";
        echo "<b>Install Complete!!!</b>";
        echo "<br /><br />";
        echo "<font class=\"failed\">DELETE THE INSTALL FOLDER!!!<br />".( )."</font>";
        echo "<br /><br />";
        echo "Admin Login: <a href='/admin'>Admin Panel</a> (Default)";
        echo "<br /><br />";
        echo "Admin Username: <b>admin</b>";
        echo "<br />";
        echo "Admin Password: <b>password</b>";
        echo "<br />";
        echo "<br />";
        echo "<font class=\"ok\">Remember to change the admin username and password!</font>";
        echo "<br /><br />";
        echo "<font class=\"ok\">Thanks for using SWIFT Panel!</font>";
        echo "<br />";
        echo "<font class=\"ok\">Remember to give us your feedback on the forums!</font>";
    }
}
echo "  \r\n</div>\r\n<div id=\"footer\">\r\n<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n  <tr>\r\n    <td class=\"left\"></td>\r\n    <td class=\"center\">Copyright &copy; 2009 <a href=\"http://www.swiftpanel.com\" target=\"_blank\">SWIFT Panel</a>.  All Rights Reserved.</td>\r\n    <td class=\"right\"><a href=\"http://www.swiftpanel.com/forum\" target=\"_blank\">Community Forums</a></td>\r\n  </tr>\r\n</table>\r\n</div>\r\n</div>\r\n<!-";
echo "-\r\nPowered By SWIFT Panel (www.SwiftPanel.com)\r\nCopyright @ 2008 All Rights Reservered.\r\n-->\r\n</body>\r\n</html>\r\n";
?>

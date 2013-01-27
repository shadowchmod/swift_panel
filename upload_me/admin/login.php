<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Admin Login";
$page = "login";
require( "../configuration.php" );
include( "./include.php" );
$task = ( $_GET['task'] );
include( "./templates/".TEMPLATE."/header.php" );
if ( !empty( $_SESSION['lockout'] ) && ( ) - 60 * 10 < $_SESSION['lockout'] )
{
    echo "<div align=\"center\">\r\n<div align=\"center\" style=\"width:400px;background-color:#FCF9D2;border:1px solid #F9D43E;padding:10px;\">";
    echo "<s";
    echo "trong>Too Many Incorrect Login Attempts</strong><br />\r\n      Please wait 10 minutes before trying again.</div>\r\n</div>\r\n";
}
else
{
    if ( $task != "password" )
    {
        echo "<div align=\"center\">\r\n  ";
        if ( isset( $_SESSION['loginerror'] ) )
        {
            echo "    <div align=\"center\" style=\"width:500px;background-color: #FCF9D2;border: 1px solid #F9D43E;padding:10px;\">";
            echo "<s";
            echo "trong>Login Failed. Please Try Again.</strong><br />\r\n      Your IP (";
            echo $_SERVER['REMOTE_ADDR'];
            echo ") has been logged and admins notified of this failed attempt.</div>\r\n    <br />\r\n    ";
            unset( $_SESSION['loginerror'] );
        }
        echo "  <form action=\"process.php\" method=\"post\">\r\n    <input type=\"hidden\" name=\"task\" value=\"login\" />\r\n    <input type=\"hidden\" name=\"return\" value=\"";
        echo $_GET['return'];
        echo "\" />\r\n    <table border=\"0\" cellpadding=\"0\" cellspacing=\"10\">\r\n      <tr>\r\n        <td align=\"right\">Username:</td>\r\n        <td><input type=\"text\" name=\"username\" class=\"text\" size=\"30\" value=\"";
        if ( isset( $_GET['username'] ) )
        {
            echo $_GET['username'];
        }
        else if ( isset( $_COOKIE['adminusername'] ) )
        {
            echo $_COOKIE['adminusername'];
        }
        echo "\" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td align=\"right\">Password:</td>\r\n        <td><input type=\"password\" name=\"password\" class=\"text\" size=\"30\" value=\"";
        if ( isset( $_GET['password'] ) )
        {
            echo $_GET['password'];
        }
        echo "\" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td colspan=\"2\" align=\"center\"><label for=\"rememberme\"><input type=\"checkbox\" name=\"rememberme\" id=\"rememberme\"";
        if ( $_COOKIE['rememberme'] == "on" )
        {
            echo " checked=\"checked\"";
        }
        echo " /> Remember my username</label></td>\r\n      </tr>\r\n      <tr>\r\n        <td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"Login\" class=\"button\" /></td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n  <br />\r\n  <a href=\"login.php?task=password\">Forgot Password?</a>\r\n</div>\r\n";
    }
    else
    {
        echo "<div align=\"center\">\r\n  ";
        if ( $_SESSION['success'] == "Yes" )
        {
            echo "    <div align=\"center\" style=\"width:400px;background-color: #FCF9D2;border: 1px solid #F9D43E;padding:10px;\">";
            echo "<s";
            echo "trong>Password Sent.</strong><br />\r\n      Your password has been reset and emailed to you.</div>\r\n    <br />\r\n  ";
        }
        else if ( $_SESSION['success'] == "No" )
        {
            echo "    <div align=\"center\" style=\"width:500px;background-color: #FCF9D2;border: 1px solid #F9D43E;padding:10px;\">";
            echo "<s";
            echo "trong>Username Not Found.</strong><br />\r\n      Your IP (";
            echo $_SERVER['REMOTE_ADDR'];
            echo ") has been logged and admins notified of this failed attempt.</div>\r\n    <br />\r\n    ";
            unset( $_SESSION['success'] );
        }
        echo "  <form action=\"process.php\" method=\"post\">\r\n    <input type=\"hidden\" name=\"task\" value=\"password\" />\r\n    <table border=\"0\" cellpadding=\"0\" cellspacing=\"10\">\r\n      <tr>\r\n        <td align=\"right\">Username:</td>\r\n        <td><input type=\"text\" name=\"username\" class=\"text\" size=\"30\" value=\"\" /></td>\r\n      </tr>\r\n      <tr>\r\n        <td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"Send Password\" clas";
        echo "s=\"button\" /></td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n  <br />\r\n  <a href=\"login.php\">Back to Login</a>\r\n</div>\r\n";
    }
}
include( "./templates/".TEMPLATE."/footer.php" );
?>

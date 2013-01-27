<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

if ( !( "LICENSE" ) )
{
    exit( "Access Denied" );
}
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<title>";
echo $title == "" ? SITENAME : $title." - ".SITENAME;
echo "</title>\r\n<link href=\"templates/";
echo TEMPLATE;
echo "/images/favicon.ico\" rel=\"shortcut icon\" />\r\n<link href=\"templates/";
echo TEMPLATE;
echo "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\r\n<link href=\"templates/";
echo TEMPLATE;
echo "/dropdown.css\" rel=\"stylesheet\" type=\"text/css\" />\r\n";
if ( ( ) )
{
    echo "<!--[if IE 7]>\r\n";
    echo "<s";
    echo "tyle type=\"text/css\">\r\n.dropdown ul li { margin-left: -16px; }\r\n</style>\t\r\n<![endif]-->\r\n";
}
echo "<s";
echo "cript type=\"text/javascript\" src=\"javascript/mootools.js\"></script>\r\n";
echo "<s";
echo "cript type=\"text/javascript\" src=\"javascript/functions.js\"></script>\r\n";
echo "<s";
echo "cript type=\"text/javascript\" src=\"javascript/dropdown.js\"></script>\r\n";
echo "<s";
echo "cript type=\"text/javascript\">\r\n\tnew Dropdown('menu1');new Dropdown('menu2');\r\n</script>\r\n</head>\r\n<body>\r\n<!--\r\nPowered By SWIFT Panel (www.SwiftPanel.com)\r\nCopyright @ 2009 All Rights Reservered.\r\n-->\r\n<div id=\"topbg\"></div>\r\n<div id=\"nav\"> <a href=\"index.php\" title=\"Home\" id=\"navhome\"></a>\r\n  ";
if ( $page != "login" )
{
    echo "  <div id=\"navleft\">\r\n    <ul id=\"menu1\" class=\"dropdown\">\r\n      <li class=\"clients\"><a href=\"client.php\"";
    if ( $tab == "2" )
    {
        echo " class=\"current\"";
    }
    echo ">Clients</a></li>\r\n      <li class=\"servers\"><a href=\"server.php\"";
    if ( $tab == "3" )
    {
        echo " class=\"current\"";
    }
    echo ">Servers</a></li>\r\n      <li class=\"boxes\"><a href=\"box.php\"";
    if ( $tab == "4" )
    {
        echo " class=\"current\"";
    }
    echo ">Boxes</a></li>\r\n      <li class=\"utilities\"><a href=\"#\"";
    if ( $tab == "5" )
    {
        echo " class=\"current\"";
    }
    echo ">Utilities</a>\r\n        <ul>\r\n          <li><a href=\"utilitieslog.php\">Activity Logs</a></li>\r\n          <li><a href=\"systemlicense.php\">License Information</a></li>\r\n        </ul>\r\n      </li>\r\n      <li class=\"configuration\"><a href=\"#\"";
    if ( $tab == "6" )
    {
        echo " class=\"current\"";
    }
    echo ">Configuration</a>\r\n        <ul>\r\n          <li><a href=\"configgeneral.php\">General Settings</a></li>\r\n          <li><a href=\"configadmin.php\">Administrators</a></li>\r\n          <li><a href=\"configgame.php\">Manage Games</a></li>\r\n          <li><a href=\"configemail.php\">Email Templates</a></li>\r\n          <li><a href=\"configcron.php\">Cron Settings</a></li>\r\n        </ul>\r\n      </li>\r\n    </ul>\r\n  </div>\r\n  <div id=\"navright";
    echo "\">\r\n    <ul id=\"menu2\" class=\"dropdown\">\r\n      <li class=\"account\"><a href=\"myaccount.php\"";
    if ( $tab == "7" )
    {
        echo " class=\"current\"";
    }
    echo ">My Account</a></li>\r\n      <li class=\"logout\"><a href=\"process.php?task=logout\" title=\"Clients\">Logout</a></li>\r\n    </ul>\r\n  </div>\r\n  <div id=\"navtime\">";
    echo ( "l | F j, Y | g:i A" );
    echo "</div>\r\n  ";
}
echo "</div>\r\n<div id=\"container\">\r\n  <div id=\"page\">\r\n    <div id=\"content\">\r\n      <div id=\"title\"> <h1>";
echo $title;
echo "</h1>\r\n        ";
if ( $page == "index" )
{
    echo "        <div id=\"titleright\"><input type=\"button\" onclick=\"window.location='clientadd.php'\" class=\"button green\" value=\"Add New Client\" /> <input type=\"button\" onclick=\"window.location='serveradd.php'\" class=\"button green\" value=\"Add New Server\" /></div>\r\n        ";
}
else if ( $page == "client" )
{
    echo "        <div id=\"titleright\"><input type=\"button\" onclick=\"window.location='clientadd.php'\" class=\"button green\" value=\"Add New Client\" /></div>\r\n        ";
}
else if ( $page == "server" )
{
    echo "        <div id=\"titleright\"><input type=\"button\" onclick=\"window.location='serveradd.php'\" class=\"button green\" value=\"Add New Server\" /></div>\r\n        ";
}
echo "      </div>";
?>

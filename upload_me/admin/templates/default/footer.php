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
echo "</div>\r\n</div>\r\n<div id=\"footer\">\r\n<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n  <tr>\r\n    ";
if ( $page != "login" )
{
    echo "<td class=\"left\">";
    echo $returned['productname'];
    echo " Expires: ";
    if ( $returned['nextduedate'] == "0000-00-00" )
    {
        echo "Never";
    }
    else
    {
        echo $returned['nextduedate'];
    }
    echo "</td>";
}
echo "    ";
if ( $page == "login" )
{
    echo "<td class=\"left\"></td>";
}
echo "    <td class=\"center\">Copyright &copy; 2009 <a href=\"http://www.swiftpanel.com\" target=\"_blank\">SWIFT Panel</a>.  All Rights Reserved.</td>\r\n    ";
if ( $page != "login" )
{
    echo "<td class=\"right\"><a href=\"http://www.swiftpanel.com/forum\" target=\"_blank\">Community Forums</a></td>";
}
echo "    ";
if ( $page == "login" )
{
    echo "<td class=\"right\">Version ";
    echo VERSION;
    echo "</td>";
}
echo "  </tr>\r\n</table>\r\n</div>\r\n</div>\r\n<!--\r\nPowered By SWIFT Panel (www.SwiftPanel.com)\r\nCopyright @ 2009 All Rights Reservered.\r\n-->\r\n</body>\r\n</html>";
?>

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
global $title;
global $page;
global $tab;
global $return;
global $image;
include( "./templates/".TEMPLATE."/header.php" );
echo "<p><b>No Results Found.</b><br />\r\nContact SWIFT Panel for support if you believe this is a bug.</p>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

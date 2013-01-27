<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "PHP Info";
$page = "utilitiesphpinfo";
$tab = "5";
$return = "utilitiesphpinfo.php";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
include( "./templates/".TEMPLATE."/header.php" );
echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">\r\n  <tr>\r\n    <td><iframe src=\"includes/phpinfo.php\" frameborder=\"0\" width=\"100%\" height=\"600\"></iframe></td>\r\n  </tr>\r\n</table>\r\n";
include( "./templates/".TEMPLATE."/footer.php" );
?>

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
if ( !( $connection = @( DBHOST, DBUSER, DBPASSWORD ) ) )
{
    exit( "<html><head></head><body><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px dashed #CC0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#CC0000;text-align:center;\"><tr><td><b>Critical Error!!!</b><br />MySQL Error! Contact SWIFT Panel for support if you believe this is a bug.</td></tr></table></body></html>" );
}
if ( !@( DBNAME ) )
{
    exit( "<html><head></head><body><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border:1px dashed #CC0000;font-family:Tahoma;background-color:#FBEEEB;width:100%;padding:10px;color:#CC0000;text-align:center;\"><tr><td><b>Critical Error!!!</b><br />MySQL Error! Contact SWIFT Panel for support if you believe this is a bug.</td></tr></table></body></html>" );
}
?>

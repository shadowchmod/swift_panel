<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$safemode = @( "safe_mode" );
if ( $safemode != "1" && $safemode != "On" && $safemode != "on" )
{
    @( "max_execution_time", "120" );
    @( 120 );
}
if ( $_SERVER['argv'][0] )
{
    $apath = @( $_SERVER['argv'][0], 0, @( $_SERVER['argv'][0], "/" ) );
    $path = @( $apath, 0, @( $apath, "/" ) );
    $apath = $apath."/";
    $path = $path."/";
}
else if ( ( ) )
{
    $path = @( @( ), 0, @( @( ), "/" ) );
    $path = $path."/";
}
else
{
    exit( "Error. Contact Swift Panel." );
}
require( $path."configuration.php" );
require( $path."includes/functions1.php" );
require( $path."includes/functions2.php" );
require( $path."includes/functions3.php" );
require( $path."includes/mysql.php" );
include( $path."includes/ftp.php" );
( 0 );
if ( ( "ssh2" ) )
{
    $result = ( "SELECT `boxid`, `ip`, `sshport`, `ftpport` FROM `box` ORDER BY `boxid`" );
    while ( $rows = ( $result ) )
    {
        if ( !( $sshconnection = @( $rows['ip'], $rows['sshport'] ) ) )
        {
            $ssh = "Offline";
        }
        else
        {
            $ssh = "Online";
        }
        if ( !( $rows['ip'], $rows['ftpport'], 15 ) )
        {
            $ftp = "Offline";
        }
        else
        {
            $ftp = "Online";
        }
        ( "UPDATE `box` SET `ftp` = '".$ftp."', `ssh` = '".$ssh."' WHERE `boxid` = '".$rows['boxid']."'" );
    }
    ( $result );
}
if ( ( "ssh2" ) )
{
    $result = ( "SELECT `boxid`, `ip`, `login`, `password`, `ssh`, `sshport` FROM `box` ORDER BY `boxid`" );
    while ( $rows = ( $result ) )
    {
        $load = "~";
        $idle = "~";
        if ( $rows['ssh'] == "Online" && ( $sshconnection = @( $rows['ip'], $rows['sshport'] ) ) && @( $sshconnection, $rows['login'], @( $rows['password'] ) ) )
        {
            $sshshell = @( $sshconnection, "vt102", null, 400, 80, SSH2_TERM_UNIT_CHARS );
            @( $sshshell, "top -bi -d .5 -n 2\n" );
            ( 3 );
            while ( $sshline = ( $sshshell ) )
            {
                if ( ( "/load average:/", $sshline ) )
                {
                    list( $garbage, $garbage, $garbage, $garbage, $load, $garbage ) = garbage                    $load = ( $load );
                }
                if ( ( "/Cpu\\(s\\):/", $sshline ) )
                {
                    list( $garbage, $garbage, $garbage, $idle, $garbage ) = garbage                    $idle = ( $idle, "id" );
                    $idle = ( $idle );
                }
            }
        }
        ( "UPDATE `box` SET `load` = '".$load."', `idle` = '".$idle."' WHERE `boxid` = '".$rows['boxid']."'" );
    }
    ( $result );
}
( "UPDATE `config` SET `value` = NOW() WHERE `setting` = 'lastcronrun'" );
?>

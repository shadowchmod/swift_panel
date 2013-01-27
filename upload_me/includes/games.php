<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$gamequery = array( "none" => "None", "doom3" => "Doom 3", "gamespy" => "GameSpy", "gamespy2" => "GameSpy 2", "quake2" => "Quake 2", "quake3" => "Quake 3", "samp" => "San Andreas: Multiplayer", "unreal2" => "Unreal 2", "valve" => "Valve" );
$games = array(
    "doom3" => array( "getinfo" => "\\xFF\\xFFgetInfo\\x00PiNGPoNG\\x00" ),
    "gamespy" => array( "status" => "\\\\status\\\\", "players" => "\\\\players\\\\", "basic" => "\\\\basic\\\\", "info" => "\\\\info\\\\" ),
    "gamespy2" => array( "status" => "\\xFE\\xFD\\x00PiNG\\xFF\\x00\\x00", "players" => "\\xFE\\xFD\\x00PoNG\\x00\\xFF\\xFF" ),
    "quake2" => array( "status" => "\\xFF\\xFF\\xFF\\xFFstatus\\x00" ),
    "quake3" => array( "getstatus" => "\\xFF\\xFF\\xFF\\xFFgetstatus\\x00", "getinfo" => "\\xFF\\xFF\\xFF\\xFFgetinfo\\x00" ),
    "samp" => array( "status" => "SAMP%s%si" ),
    "valve" => array( "challenge" => "\\xFF\\xFF\\xFF\\xFF\\x55\\xFF\\xFF\\xFF\\xFF", "details" => "\\xFF\\xFF\\xFF\\xFFTSource Engine Query\\x00", "players" => "\\xFF\\xFF\\xFF\\xFF\\x55%s" ),
    "unreal2" => array( "status" => "\\x79\\x00\\x00\\x00\\x00" )
);
?>

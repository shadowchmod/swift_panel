<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$return = TRUE;
require( "../configuration.php" );
require( "./include.php" );
$task = ( $_POST['task'] );
if ( empty( $task ) )
{
    $task = ( $_GET['task'] );
}
switch ( $task )
{
case "serveradd" :
    $clientid = ( $_POST['clientid'] );
    $gameid = ( $_POST['gameid'] );
    $name = ( $_POST['name'] );
    $priority = ( $_POST['priority'] );
    $slots = ( $_POST['slots'] );
    $type = ( $_POST['type'] );
    $cfg1 = ( $_POST['cfg1'] );
    $cfg1edit = ( $_POST['cfg1edit'] );
    $cfg2 = ( $_POST['cfg2'] );
    $cfg2edit = ( $_POST['cfg2edit'] );
    $cfg3 = ( $_POST['cfg3'] );
    $cfg3edit = ( $_POST['cfg3edit'] );
    $cfg4 = ( $_POST['cfg4'] );
    $cfg4edit = ( $_POST['cfg4edit'] );
    $cfg5 = ( $_POST['cfg5'] );
    $cfg5edit = ( $_POST['cfg5edit'] );
    $cfg6 = ( $_POST['cfg6'] );
    $cfg6edit = ( $_POST['cfg6edit'] );
    $cfg7 = ( $_POST['cfg7'] );
    $cfg7edit = ( $_POST['cfg7edit'] );
    $cfg8 = ( $_POST['cfg8'] );
    $cfg8edit = ( $_POST['cfg8edit'] );
    $startline = ( $_POST['startline'] );
    $showftp = ( $_POST['showftp'] );
    $webftp = ( $_POST['webftp'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['name'] = $name;
    $_SESSION['priority'] = $priority;
    $_SESSION['slots'] = $slots;
    $_SESSION['type'] = $type;
    $_SESSION['cfg1'] = $cfg1;
    $_SESSION['cfg1edit'] = $cfg1edit;
    $_SESSION['cfg2'] = $cfg2;
    $_SESSION['cfg2edit'] = $cfg2edit;
    $_SESSION['cfg3'] = $cfg3;
    $_SESSION['cfg3edit'] = $cfg3edit;
    $_SESSION['cfg4'] = $cfg4;
    $_SESSION['cfg4edit'] = $cfg4edit;
    $_SESSION['cfg5'] = $cfg5;
    $_SESSION['cfg5edit'] = $cfg5edit;
    $_SESSION['cfg6'] = $cfg6;
    $_SESSION['cfg6edit'] = $cfg6edit;
    $_SESSION['cfg7'] = $cfg7;
    $_SESSION['cfg7edit'] = $cfg7edit;
    $_SESSION['cfg8'] = $cfg8;
    $_SESSION['cfg8edit'] = $cfg8edit;
    $_SESSION['startline'] = $startline;
    $_SESSION['showftp'] = $showftp;
    $_SESSION['webftp'] = $webftp;
    $len = ( $name );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Name [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $slots );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Slots [ <b>Not Entered</b> ]</li>";
    }
    else if ( !( $slots ) )
    {
        $_SESSION['msg2'] .= "<li>Slots [ <b>Not Numerical</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['formerror'] = 1;
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: serveradd.php?clientid=".( $clientid )."&gameid=".( $gameid ) );
        exit( );
    }
    unset( $_SESSION['name'] );
    unset( $_SESSION['priority'] );
    unset( $_SESSION['slots'] );
    unset( $_SESSION['type'] );
    unset( $_SESSION['cfg1'] );
    unset( $_SESSION['cfg1edit'] );
    unset( $_SESSION['cfg2'] );
    unset( $_SESSION['cfg2edit'] );
    unset( $_SESSION['cfg3'] );
    unset( $_SESSION['cfg3edit'] );
    unset( $_SESSION['cfg4'] );
    unset( $_SESSION['cfg4edit'] );
    unset( $_SESSION['cfg5'] );
    unset( $_SESSION['cfg5edit'] );
    unset( $_SESSION['cfg6'] );
    unset( $_SESSION['cfg6edit'] );
    unset( $_SESSION['cfg7'] );
    unset( $_SESSION['cfg7edit'] );
    unset( $_SESSION['cfg8'] );
    unset( $_SESSION['cfg8edit'] );
    unset( $_SESSION['startline'] );
    unset( $_SESSION['showftp'] );
    unset( $_SESSION['webftp'] );
    $rows = ( "SELECT * FROM `game` WHERE `gameid` = '".$gameid."'" );
    ( "INSERT INTO `server` SET `clientid` = '".$clientid."', `name` = '".$name."', `game` = '".$rows['game']."', `status` = 'Pending', `query` = '".$rows['query']."', `qryport` = '".$rows['qryport']."', `priority` = '".$priority."', `slots` = '".$slots."', `type` = '".$type."', `cfg1name` = '".$rows['cfg1name']."', `cfg1` = '".$cfg1."', `cfg1edit` = '".$cfg1edit."', `cfg2name` = '".$rows['cfg2name']."', `cfg2` = '".$cfg2."', `cfg2edit` = '".$cfg2edit."', `cfg3name` = '".$rows['cfg3name']."', `cfg3` = '".$cfg3."', `cfg3edit` = '".$cfg3edit."', `cfg4name` = '".$rows['cfg4name']."', `cfg4` = '".$cfg4."', `cfg4edit` = '".$cfg4edit."', `cfg5name` = '".$rows['cfg5name']."', `cfg5` = '".$cfg5."', `cfg5edit` = '".$cfg5edit."', `cfg6name` = '".$rows['cfg6name']."', `cfg6` = '".$cfg6."', `cfg6edit` = '".$cfg6edit."', `cfg7name` = '".$rows['cfg7name']."', `cfg7` = '".$cfg7."', `cfg7edit` = '".$cfg7edit."', `cfg8name` = '".$rows['cfg8name']."', `cfg8` = '".$cfg8."', `cfg8edit` = '".$cfg8edit."', `startline` = '".$startline."', `showftp` = '".$showftp."', `webftp` = '".$webftp."', `installdir` = '".$rows['gamedir']."', `port` = '".$rows['port']."', `online` = 'Pending'" );
    $serverid = ( );
    $rows1 = ( "SELECT `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$clientid."'" );
    $message = "Server Added: <a href=\"serversummary.php?id=".$serverid."\">".$name."</a> to <a href=\"clientsummary.php?id=".$clientid."\">".$rows1['firstname']." ".$rows1['lastname']."</a>";
    ( "INSERT INTO `log` SET `clientid` = '".$clientid."', `serverid` = '".$serverid."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Server Added Successfully!";
    $_SESSION['msg2'] = "The new server has been added and is ready for use.";
    ( "Location: serversummary.php?id=".( $serverid ) );
    exit( );
    break;
case "serverprofile" :
    $serverid = ( $_POST['serverid'] );
    $name = ( $_POST['name'] );
    $game = ( $_POST['game'] );
    $status = ( $_POST['status'] );
    $priority = ( $_POST['priority'] );
    $slots = ( $_POST['slots'] );
    $type = ( $_POST['type'] );
    $cfg1name = ( $_POST['cfg1name'] );
    $cfg1 = ( $_POST['cfg1'] );
    $cfg1edit = ( $_POST['cfg1edit'] );
    $cfg2name = ( $_POST['cfg2name'] );
    $cfg2 = ( $_POST['cfg2'] );
    $cfg2edit = ( $_POST['cfg2edit'] );
    $cfg3name = ( $_POST['cfg3name'] );
    $cfg3 = ( $_POST['cfg3'] );
    $cfg3edit = ( $_POST['cfg3edit'] );
    $cfg4name = ( $_POST['cfg4name'] );
    $cfg4 = ( $_POST['cfg4'] );
    $cfg4edit = ( $_POST['cfg4edit'] );
    $cfg5name = ( $_POST['cfg5name'] );
    $cfg5 = ( $_POST['cfg5'] );
    $cfg5edit = ( $_POST['cfg5edit'] );
    $cfg6name = ( $_POST['cfg6name'] );
    $cfg6 = ( $_POST['cfg6'] );
    $cfg6edit = ( $_POST['cfg6edit'] );
    $cfg7name = ( $_POST['cfg7name'] );
    $cfg7 = ( $_POST['cfg7'] );
    $cfg7edit = ( $_POST['cfg7edit'] );
    $cfg8name = ( $_POST['cfg8name'] );
    $cfg8 = ( $_POST['cfg8'] );
    $cfg8edit = ( $_POST['cfg8edit'] );
    $startline = ( $_POST['startline'] );
    $showftp = ( $_POST['showftp'] );
    $webftp = ( $_POST['webftp'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['name'] = $name;
    $_SESSION['game'] = $game;
    $_SESSION['status'] = $status;
    $_SESSION['priority'] = $priority;
    $_SESSION['slots'] = $slots;
    $_SESSION['type'] = $type;
    $_SESSION['cfg1name'] = $cfg1name;
    $_SESSION['cfg1'] = $cfg1;
    $_SESSION['cfg1edit'] = $cfg1edit;
    $_SESSION['cfg2name'] = $cfg2name;
    $_SESSION['cfg2'] = $cfg2;
    $_SESSION['cfg2edit'] = $cfg2edit;
    $_SESSION['cfg3name'] = $cfg3name;
    $_SESSION['cfg3'] = $cfg3;
    $_SESSION['cfg3edit'] = $cfg3edit;
    $_SESSION['cfg4name'] = $cfg4name;
    $_SESSION['cfg4'] = $cfg4;
    $_SESSION['cfg4edit'] = $cfg4edit;
    $_SESSION['cfg5name'] = $cfg5name;
    $_SESSION['cfg5'] = $cfg5;
    $_SESSION['cfg5edit'] = $cfg5edit;
    $_SESSION['cfg6name'] = $cfg6name;
    $_SESSION['cfg6'] = $cfg6;
    $_SESSION['cfg6edit'] = $cfg6edit;
    $_SESSION['cfg7name'] = $cfg7name;
    $_SESSION['cfg7'] = $cfg7;
    $_SESSION['cfg7edit'] = $cfg7edit;
    $_SESSION['cfg8name'] = $cfg8name;
    $_SESSION['cfg8'] = $cfg8;
    $_SESSION['cfg8edit'] = $cfg8edit;
    $_SESSION['startline'] = $startline;
    $_SESSION['showftp'] = $showftp;
    $_SESSION['webftp'] = $webftp;
    $len = ( $name );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Name [ <b>Not Entered</b> ]</li>";
    }
    $len = ( $game );
    $_SESSION['msg2'] .= "<li>Game [ <b>Not Entered</b> ]</li>";
    $len = ( $slots );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Slots [ <b>Not Entered</b> ]</li>";
    }
    else if ( !( $slots ) )
    {
        $_SESSION['msg2'] .= "<li>Slots [ <b>Not Numerical</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['formerror'] = 1;
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: serverprofile.php?id=".( $serverid ) );
        exit( );
    }
    unset( $_SESSION['name'] );
    unset( $_SESSION['game'] );
    unset( $_SESSION['status'] );
    unset( $_SESSION['priority'] );
    unset( $_SESSION['slots'] );
    unset( $_SESSION['type'] );
    unset( $_SESSION['cfg1name'] );
    unset( $_SESSION['cfg1'] );
    unset( $_SESSION['cfg1edit'] );
    unset( $_SESSION['cfg2name'] );
    unset( $_SESSION['cfg2'] );
    unset( $_SESSION['cfg2edit'] );
    unset( $_SESSION['cfg3name'] );
    unset( $_SESSION['cfg3'] );
    unset( $_SESSION['cfg3edit'] );
    unset( $_SESSION['cfg4name'] );
    unset( $_SESSION['cfg4'] );
    unset( $_SESSION['cfg4edit'] );
    unset( $_SESSION['cfg5name'] );
    unset( $_SESSION['cfg5'] );
    unset( $_SESSION['cfg5edit'] );
    unset( $_SESSION['cfg6name'] );
    unset( $_SESSION['cfg6'] );
    unset( $_SESSION['cfg6edit'] );
    unset( $_SESSION['cfg7name'] );
    unset( $_SESSION['cfg7'] );
    unset( $_SESSION['cfg7edit'] );
    unset( $_SESSION['cfg8name'] );
    unset( $_SESSION['cfg8'] );
    unset( $_SESSION['cfg8edit'] );
    unset( $_SESSION['startline'] );
    unset( $_SESSION['showftp'] );
    unset( $_SESSION['webftp'] );
    ( "UPDATE `server` SET `name` = '".$name."', `game` = '".$game."', `status` = '".$status."', `priority` = '".$priority."', `slots` = '".$slots."', `type` = '".$type."', `cfg1name` = '".$cfg1name."', `cfg1` = '".$cfg1."', `cfg1edit` = '".$cfg1edit."', `cfg2name` = '".$cfg2name."', `cfg2` = '".$cfg2."', `cfg2edit` = '".$cfg2edit."', `cfg3name` = '".$cfg3name."', `cfg3` = '".$cfg3."', `cfg3edit` = '".$cfg3edit."', `cfg4name` = '".$cfg4name."', `cfg4` = '".$cfg4."', `cfg4edit` = '".$cfg4edit."', `cfg5name` = '".$cfg5name."', `cfg5` = '".$cfg5."', `cfg5edit` = '".$cfg5edit."', `cfg6name` = '".$cfg6name."', `cfg6` = '".$cfg6."', `cfg6edit` = '".$cfg6edit."', `cfg7name` = '".$cfg7name."', `cfg7` = '".$cfg7."', `cfg7edit` = '".$cfg7edit."', `cfg8name` = '".$cfg8name."', `cfg8` = '".$cfg8."', `cfg8edit` = '".$cfg8edit."', `startline` = '".$startline."', `showftp` = '".$showftp."', `webftp` = '".$webftp."' WHERE `serverid` = '".$serverid."'" );
    $rows2 = ( "SELECT `clientid`, `boxid` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
    $message = "Server Edited: <a href=\"serversummary.php?id=".$serverid."\">".$name."</a>";
    ( "INSERT INTO `log` SET `clientid` = '".$rows2['clientid']."', `serverid` = '".$serverid."', `boxid` = '".$rows2['boxid']."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Server Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the server have been saved.";
    ( "Location: serversummary.php?id=".( $serverid ) );
    exit( );
    break;
case "serveradvanced" :
    $serverid = ( $_POST['serverid'] );
    $online = ( $_POST['online'] );
    $ipid = ( $_POST['ipid'] );
    $port = ( $_POST['port'] );
    $query = ( $_POST['query'] );
    $qryport = ( $_POST['qryport'] );
    $user = ( $_POST['user'] );
    $password = ( $_POST['password'] );
    $homedir = ( $_POST['homedir'] );
    $installdir = ( $_POST['installdir'] );
    $modify = ( $_POST['modify'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['online'] = $online;
    $_SESSION['ipid'] = $ipid;
    $_SESSION['port'] = $port;
    $_SESSION['query'] = $query;
    $_SESSION['qryport'] = $qryport;
    $_SESSION['user'] = $user;
    $_SESSION['password'] = $password;
    $_SESSION['homedir'] = $homedir;
    $_SESSION['installdir'] = $installdir;
    $_SESSION['modify'] = $modify;
    $len = ( $port );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Port [ <b>Not Entered</b> ]</li>";
    }
    else if ( !( $port ) )
    {
        $_SESSION['msg2'] .= "<li>Port [ <b>Not Numerical</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `server` WHERE `ipid` = '".$ipid."' && `port` = '".$port."' && `serverid` != '".$serverid."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>Port [ <b>Already Used</b> ]</li>";
    }
    $len = ( $qryport );
    if ( !( $qryport ) && !empty( $qryport ) )
    {
        $_SESSION['msg2'] .= "<li>Query Port [ <b>Not Numerical</b> ]</li>";
    }
    $len = ( $user );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>User [ <b>Not Entered</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `server` WHERE `boxid` = '".$boxid."' && `user` = '".$user."' && `serverid` != '".$serverid."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>User [ <b>Already Used</b> ]</li>";
    }
    $len = ( $password );
    if ( "1" <= $len && $len <= "3" )
    {
        $_SESSION['msg2'] .= "<li>Password [ <b>Not Long Enough</b> ]</li>";
    }
    $len = ( $homedir );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Home Directory [ <b>Not Entered</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `server` WHERE `boxid` = '".$boxid."' && `homedir` = '".$homedir."' && `serverid` != '".$serverid."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>Home Directory [ <b>Already Used</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['formerror'] = 1;
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "<ul>".$_SESSION['msg2']."</ul>";
        ( "Location: serveradvanced.php?id=".( $serverid ) );
        exit( );
    }
    if ( isset( $_POST['online'] ) )
    {
        if ( empty( $password ) )
        {
            $password = ( 7 );
        }
        $rows = ( "SELECT `boxid`, `user`, `password`, `homedir` FROM `server` WHERE `serverid` = '".$serverid."'" );
        if ( $modify == "on" && ( $user != $rows['user'] || $password != $rows['password'] || $homedir != $rows['homedir'] ) )
        {
            if ( !( "ssh2" ) )
            {
                $_SESSION['msg1'] = "SSH2 Extension Error!";
                $_SESSION['msg2'] = "SSH2 Extension not detected!";
                ( "Location: serverprofile.php?id=".( $serverid ) );
                exit( );
            }
            $rows1 = ( "SELECT `ip`, `sshport`, `login`, `password` FROM `box` WHERE `boxid` = '".$rows['boxid']."'" );
            if ( !( $sshconnection = @( $rows1['ip'], $rows1['sshport'] ) ) )
            {
                $_SESSION['msg1'] = "Connection Error!";
                $_SESSION['msg2'] = "Unable to connect to box with SSH.";
                ( "Location: serverprofile.php?id=".( $serverid ) );
                exit( );
            }
            if ( !( $sshconnection, $rows1['login'], @( $rows1['password'] ) ) )
            {
                $_SESSION['msg1'] = "Authentication Error!";
                $GLOBALS['_SESSION']['msg2'] = "Unable to login to box with SSH.";
                ( "Location: serverprofile.php?id=".( $serverid ) );
                exit( );
            }
            $sshshell = ( $sshconnection, "vt102", null, 400, 80, SSH2_TERM_UNIT_CHARS );
            if ( $user != $rows['user'] )
            {
                @( $sshshell, "usermod ".$user."\n" );
                ( 1 );
                while ( $sshline = ( $sshshell ) )
                {
                    if ( ( "/no flags given/", $sshline ) )
                    {
                        $_SESSION['msg1'] = "Command Error!";
                        $_SESSION['msg2'] = "User already exist: ".$user;
                        ( "Location: serverprofile.php?id=".( $serverid ) );
                        exit( );
                    }
                }
            }
            if ( $user != $rows['user'] || $homedir != $rows['homedir'] )
            {
                @( $sshshell, "usermod -d".$homedir." -m -l".$user." ".$rows['user']."\n" );
                ( 2 );
            }
            if ( $password != $rows['password'] )
            {
                @( $sshshell, "passwd ".$user."\n" );
                ( 2 );
                @( $sshshell, $password."\n" );
                ( 2 );
                @( $sshshell, $password."\n" );
                ( 2 );
            }
            @( $sshshell );
        }
    }
    unset( $_SESSION['online'] );
    unset( $_SESSION['ipid'] );
    unset( $_SESSION['port'] );
    unset( $_SESSION['query'] );
    unset( $_SESSION['qryport'] );
    unset( $_SESSION['user'] );
    unset( $_SESSION['password'] );
    unset( $_SESSION['homedir'] );
    unset( $_SESSION['installdir'] );
    unset( $_SESSION['modify'] );
    ( "UPDATE `server` SET `ipid` = '".$ipid."', `port` = '".$port."', `query` = '".$query."', `qryport` = '".$qryport."', `user` = '".$user."', `password` = '".$password."', `homedir` = '".$homedir."', `installdir` = '".$installdir."', `online` = '".$online."' WHERE `serverid` = '".$serverid."'" );
    $rows2 = ( "SELECT `clientid`, `boxid` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
    $message = "Server Edited: <a href=\"serversummary.php?id=".$serverid."\">".$name."</a>";
    ( "INSERT INTO `log` SET `clientid` = '".$rows2['clientid']."', `serverid` = '".$serverid."', `boxid` = '".$rows2['boxid']."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Server Updated Successfully!";
    $_SESSION['msg2'] = "Your changes to the server have been saved.";
    ( "Location: serversummary.php?id=".( $serverid ) );
    exit( );
    break;
case "serverinstall" :
    $serverid = ( $_POST['serverid'] );
    $boxid = ( $_POST['boxid'] );
    $ipid = ( $_POST['ipid'] );
    $port = ( $_POST['port'] );
    $user = ( $_POST['user'] );
    $password = ( $_POST['password'] );
    $homedir = ( $_POST['homedir'] );
    $adduser = ( $_POST['adduser'] );
    $installdir = ( $_POST['installdir'] );
    $install = ( $_POST['install'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $_SESSION['port'] = $port;
    $_SESSION['user'] = $user;
    $_SESSION['password'] = $password;
    $_SESSION['homedir'] = $homedir;
    $_SESSION['adduser'] = $adduser;
    $_SESSION['installdir'] = $installdir;
    $_SESSION['install'] = $install;
    $len = ( $port );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Port [ <b>Not Entered</b> ]</li>";
    }
    else if ( !( $port ) )
    {
        $_SESSION['msg2'] .= "<li>Port [ <b>Not Numerical</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `server` WHERE `ipid` = '".$ipid."' && `port` = '".$port."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>Port [ <b>Already Used</b> ]</li>";
    }
    $len = ( $user );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>User [ <b>Not Entered</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `server` WHERE `boxid` = '".$boxid."' && `user` = '".$user."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>User [ <b>Already Used</b> ]</li>";
    }
    $len = ( $password );
    if ( "1" <= $len && $len <= "3" )
    {
        $_SESSION['msg2'] .= "<li>Password [ <b>Not Long Enough</b> ]</li>";
    }
    $len = ( $homedir );
    if ( $len <= "0" )
    {
        $_SESSION['msg2'] .= "<li>Home Directory [ <b>Not Entered</b> ]</li>";
    }
    else if ( ( "SELECT * FROM `server` WHERE `boxid` = '".$boxid."' && `homedir` = '".$homedir."'" ) != 0 )
    {
        $_SESSION['msg2'] .= "<li>Home Directory [ <b>Already Used</b> ]</li>";
    }
    $len = ( $installdir );
    if ( $len <= "0" && $install == "on" )
    {
        $_SESSION['msg2'] .= "<li>Install Directory [ <b>Not Entered</b> ]</li>";
    }
    if ( isset( $_SESSION['msg2'] ) )
    {
        $_SESSION['formerror'] = 1;
        $_SESSION['msg1'] = "Validation Error!";
        ( "Location: serverinstall.php?id=".( $serverid )."&boxid=".( $boxid )."&ipid=".( $ipid ) );
        exit( );
    }
    if ( empty( $password ) )
    {
        $password = ( 7 );
    }
    if ( $adduser == "on" || $install == "on" )
    {
        if ( !( "ssh2" ) )
        {
            $_SESSION['msg1'] = "SSH2 Extension Error!";
            $_SESSION['msg2'] = "SSH2 Extension not detected!";
            ( "Location: serverinstall.php?id=".( $serverid )."&boxid=".( $boxid )."&ipid=".( $ipid ) );
            exit( );
        }
        $rows = ( "SELECT `ip`, `sshport`, `login`, `password` FROM `box` WHERE `boxid` = '".$boxid."'" );
        if ( !( $sshconnection = @( $rows['ip'], $rows['sshport'] ) ) )
        {
            $_SESSION['msg1'] = "Connection Error!";
            $_SESSION['msg2'] = "Unable to connect to box with SSH.";
            ( "Location: serverinstall.php?id=".( $serverid )."&boxid=".( $boxid )."&ipid=".( $ipid ) );
            exit( );
        }
        if ( !( $sshconnection, $rows['login'], @( $rows['password'] ) ) )
        {
            $_SESSION['msg1'] = "Authentication Error!";
            $_SESSION['msg2'] = "Unable to login to box with SSH.";
            ( "Location: serverinstall.php?id=".( $serverid )."&boxid=".( $boxid )."&ipid=".( $ipid ) );
            exit( );
        }
        ( E_ALL );
        $sshshell = @( $sshconnection, "vt102", null, 400, 80, SSH2_TERM_UNIT_CHARS );
        if ( $adduser == "on" )
        {
            @( $sshshell, "usermod ".$user."\n" );
            ( 1 );
            while ( $sshline = ( $sshshell ) )
            {
                if ( ( "/no flags given/", $sshline ) )
                {
                    $_SESSION['msg1'] = "Command Error!";
                    $_SESSION['msg2'] = "User already exist: ".$user;
                    ( "Location: serverinstall.php?id=".( $serverid )."&boxid=".( $boxid )."&ipid=".( $ipid ) );
                    exit( );
                }
            }
        }
        if ( $install == "on" )
        {
            @( $sshshell, "cd ".$installdir."\n" );
            ( 1 );
            while ( $sshline = ( $sshshell ) )
            {
                if ( ( "/No such file or directory/", $sshline ) )
                {
                    $_SESSION['msg1'] = "Command Error!";
                    $_SESSION['msg2'] = "Could not change to directory: ".$installdir;
                    ( "Location: serverinstall.php?id=".( $serverid )."&boxid=".( $boxid )."&ipid=".( $ipid ) );
                    exit( );
                }
            }
            if ( $adduser != "on" )
            {
                @( $sshshell, "usermod ".$user."\n" );
                ( 1 );
                while ( $sshline = ( $sshshell ) )
                {
                    if ( ( "/does not exist/", $sshline ) )
                    {
                        $_SESSION['msg1'] = "Command Error!";
                        $_SESSION['msg2'] = "User does not exist: ".$user;
                        ( "Location: serverinstall.php?id=".( $serverid )."&boxid=".( $boxid )."&ipid=".( $ipid ) );
                        exit( );
                    }
                }
                @( $sshshell, "cd ".$homedir."\n" );
                ( 1 );
                while ( $sshline = ( $sshshell ) )
                {
                    if ( ( "/No such file or directory/", $sshline ) )
                    {
                        $_SESSION['msg1'] = "Command Error!";
                        $_SESSION['msg2'] = "Could not change to directory: ".$homedir;
                        ( "Location: serverinstall.php?id=".( $serverid )."&boxid=".( $boxid )."&ipid=".( $ipid ) );
                        exit( );
                    }
                }
            }
            @( $sshshell, "cd\n" );
            ( 1 );
        }
        if ( $adduser == "on" )
        {
            @( $sshshell, "useradd -d".$homedir." -m ".$user."\n" );
            ( 3 );
            @( $sshshell, "passwd ".$user."\n" );
            ( 2 );
            @( $sshshell, $password."\n" );
            ( 2 );
            @( $sshshell, $password."\n" );
            ( 2 );
        }
        if ( $install == "on" )
        {
            @( $sshshell, "screen -m -S serverinstall\n" );
            ( 2 );
            @( $sshshell, "nice -n 19 cp -Rf ".$installdir."/* ".$homedir." && chown -Rf ".$user.":".$user." ".$homedir." && exit\n" );
            ( 2 );
        }
        @( $sshshell );
    }
    unset( $_SESSION['port'] );
    unset( $_SESSION['user'] );
    unset( $_SESSION['password'] );
    unset( $_SESSION['homedir'] );
    unset( $_SESSION['adduser'] );
    unset( $_SESSION['installdir'] );
    unset( $_SESSION['install'] );
    ( "UPDATE `server` SET `boxid` = '".$boxid."', `ipid` = '".$ipid."', `status` = 'Active', `user` = '".$user."', `password` = '".$password."', `homedir` = '".$homedir."', `installdir` = '".$installdir."', `port` = '".$port."', `online` = 'Stopped' WHERE `serverid` = '".$serverid."'" );
    $rows1 = ( "SELECT `clientid`, `name` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
    $rows2 = ( "SELECT `name` FROM `box` WHERE `boxid` = '".$boxid."' LIMIT 1" );
    $message = "Server Installed: <a href=\"serversummary.php?id=".$serverid."\">".$rows1['name']."</a> on <a href=\"boxsummary.php?id=".$boxid."\">".$rows2['name']."</a>";
    ( "INSERT INTO `log` SET `clientid` = '".$rows1['clientid']."', `serverid` = '".$serverid."', `boxid` = '".$boxid."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Install Wizard Successfully!";
    if ( $install == "on" )
    {
        $_SESSION['msg2'] = "The server has been installed. Allow 5 minutes for server files to transfer before starting.";
    }
    else
    {
        $_SESSION['msg2'] = "The server is ready for use.";
    }
    ( "Location: serversummary.php?id=".( $serverid ) );
    exit( );
    break;
case "serverrebuild" :
    $serverid = ( $_GET['serverid'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $rows = ( "SELECT `boxid`, `user`, `password`, `homedir`, `installdir`, `online` FROM `server` WHERE `serverid` = '".$serverid."'" );
    if ( empty( $rows['homedir'] ) || empty( $rows['installdir'] ) )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "Invalid Directory.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    if ( $rows['online'] == "Started" )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "Server must be stopped.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    if ( !( "ssh2" ) )
    {
        $_SESSION['msg1'] = "SSH2 Extension Error!";
        $_SESSION['msg2'] = "SSH2 Extension not detected!";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    $rows1 = ( "SELECT `ip`, `sshport`, `login`, `password` FROM `box` WHERE `boxid` = '".$rows['boxid']."'" );
    if ( !( $sshconnection = @( $rows1['ip'], $rows1['sshport'] ) ) )
    {
        $_SESSION['msg1'] = "Connection Error!";
        $_SESSION['msg2'] = "Unable to connect to box with SSH.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    if ( !( $sshconnection, $rows1['login'], @( $rows1['password'] ) ) )
    {
        $_SESSION['msg1'] = "Authentication Error!";
        $_SESSION['msg2'] = "Unable to login to box with SSH.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    $sshshell = @( $sshconnection, "vt102", null, 400, 80, SSH2_TERM_UNIT_CHARS );
    @( $sshshell, "cd ".$rows['installdir']."\n" );
    ( 1 );
    while ( $sshline = ( $sshshell ) )
    {
        if ( ( "/No such file or directory/", $sshline ) )
        {
            $_SESSION['msg1'] = "Command Error!";
            $_SESSION['msg2'] = "Could not change to directory: ".$rows['installdir'];
            ( "Location: serversummary.php?id=".( $serverid ) );
            exit( );
        }
    }
    @( $sshshell, "usermod ".$rows['user']."\n" );
    ( 1 );
    while ( $sshline = ( $sshshell ) )
    {
        if ( ( "/does not exist/", $sshline ) )
        {
            $_SESSION['msg1'] = "Command Error!";
            $_SESSION['msg2'] = "User does not exist: ".$rows['user'];
            ( "Location: serversummary.php?id=".( $serverid ) );
            exit( );
        }
    }
    @( $sshshell, "cd ".$rows['homedir']."\n" );
    ( 1 );
    while ( $sshline = ( $sshshell ) )
    {
        if ( ( "/No such file or directory/", $sshline ) )
        {
            $_SESSION['msg1'] = "Command Error!";
            $_SESSION['msg2'] = "Could not change to directory: ".$rows['homedir'];
            ( "Location: serversummary.php?id=".( $serverid ) );
            exit( );
        }
    }
    if ( empty( $rows['homedir'] ) || empty( $rows['installdir'] ) )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "Invalid Directory.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    @( $sshshell, "cd\n" );
    ( 1 );
    @( $sshshell, "screen -m -S serverrebuild\n" );
    ( 2 );
    @( $sshshell, "nice -n 19 rm -Rf ".$rows['homedir']."/* && nice -n 19 cp -Rf ".$rows['installdir']."/* ".$rows['homedir']." && chown -Rf ".$rows['user'].":".$rows['user']." ".$rows['homedir']." && exit\n" );
    ( 2 );
    @( $sshshell );
    $rows2 = ( "SELECT `clientid`, `boxid`, `name` FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
    $rows3 = ( "SELECT `name` FROM `box` WHERE `boxid` = '".$rows2['boxid']."' LIMIT 1" );
    $message = "Server Rebuilt: <a href=\"serversummary.php?id=".$serverid."\">".$rows2['name']."</a> on <a href=\"boxsummary.php?id=".$rows2['boxid']."\">".$rows3['name']."</a>";
    ( "INSERT INTO `log` SET `clientid` = '".$rows2['clientid']."', `serverid` = '".$serverid."', `boxid` = '".$rows2['boxid']."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Rebuild Successfully!";
    $_SESSION['msg2'] = "The server has been rebuilt. Allow 5 minutes for server files to transfer before starting.";
    ( "Location: serversummary.php?id=".( $serverid ) );
    exit( );
    break;
case "serverdelete" :
    $serverid = ( $_GET['serverid'] );
    $delete = ( $_GET['delete'] );
    unset( $_SESSION['msg1'] );
    unset( $_SESSION['msg2'] );
    $rows = ( "SELECT `clientid`, `boxid`, `name`, `user`, `online` FROM `server` WHERE `serverid` = '".$serverid."'" );
    if ( $rows['online'] == "Started" )
    {
        $_SESSION['msg1'] = "Validation Error!";
        $_SESSION['msg2'] = "Server must be stopped.";
        ( "Location: serversummary.php?id=".( $serverid ) );
        exit( );
    }
    if ( $delete == "yes" )
    {
        if ( !( "ssh2" ) )
        {
            $_SESSION['msg1'] = "SSH2 Extension Error!";
            $_SESSION['msg2'] = "SSH2 Extension not detected!";
            ( "Location: serversummary.php?id=".( $serverid ) );
            exit( );
        }
        $rows1 = ( "SELECT `ip`, `sshport`, `login`, `password` FROM `box` WHERE `boxid` = '".$rows['boxid']."'" );
        if ( !( $sshconnection = @( $rows1['ip'], $rows1['sshport'] ) ) )
        {
            $_SESSION['msg1'] = "Connection Error!";
            $_SESSION['msg2'] = "Unable to connect to box with SSH.";
            ( "Location: serversummary.php?id=".( $serverid ) );
            exit( );
        }
        if ( !( $sshconnection, $rows1['login'], @( $rows1['password'] ) ) )
        {
            $_SESSION['msg1'] = "Authentication Error!";
            $_SESSION['msg2'] = "Unable to login to box with SSH.";
            ( "Location: serversummary.php?id=".( $serverid ) );
            exit( );
        }
        $sshshell = @( $sshconnection, "vt102", null, 400, 80, SSH2_TERM_UNIT_CHARS );
        @( $sshshell, "usermod ".$rows['user']."\n" );
        ( 1 );
        while ( $sshline = ( $sshshell ) )
        {
            if ( ( "/does not exist/", $sshline ) )
            {
                $_SESSION['msg1'] = "Command Error!";
                $_SESSION['msg2'] = "User does not exist: ".$rows['user'];
                ( "Location: serversummary.php?id=".( $serverid ) );
                exit( );
            }
        }
        @( $sshshell, "screen -m -S serverdelete\n" );
        ( 2 );
        @( $sshshell, "nice -n 19 userdel -rf ".$rows['user']." && exit\n" );
        ( 2 );
        @( $sshshell );
    }
    ( "DELETE FROM `server` WHERE `serverid` = '".$serverid."' LIMIT 1" );
    if ( $delete == "yes" )
    {
        $rows2 = ( "SELECT `name` FROM `box` WHERE `boxid` = '".$rows['boxid']."' LIMIT 1" );
        $rows3 = ( "SELECT `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$rows['clientid']."' LIMIT 1" );
        $message = "Server Deleted: ".$rows['name']." on <a href=\"boxsummary.php?id=".$rows['boxid']."\">".$rows2['name']."</a> from <a href=\"clientsummary.php?id=".$rows['clientid']."\">".$rows3['firstname']." ".$rows3['lastname']."</a>";
    }
    else
    {
        $rows2 = ( "SELECT `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$rows['clientid']."' LIMIT 1" );
        $message = "Server Deleted: ".$rows['name']." from <a href=\"clientsummary.php?id=".$rows['clientid']."\">".$rows2['firstname']." ".$rows2['lastname']."</a>";
    }
    ( "INSERT INTO `log` SET `clientid` = '".$rows['clientid']."', `serverid` = '".$serverid."', `boxid` = '".$rows['boxid']."', `message` = '".$message."', `name` = '".$_SESSION['adminfirstname']." ".$_SESSION['adminlastname']."', `ip` = '".$_SERVER['REMOTE_ADDR']."'" );
    $_SESSION['msg1'] = "Server Deleted Successfully!";
    $_SESSION['msg2'] = "The selected server has been removed.";
    ( "Location: clientsummary.php?id=".( $rows['clientid'] ) );
    exit( );
    break;
default :
    ( "Location: index.php" );
    exit( );
}
?>

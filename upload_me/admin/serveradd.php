<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

$title = "Add New Server";
$page = "serveradd";
$tab = "3";
$return = "serveradd.php?clientid=".$_GET['clientid']."&gameid=".$_GET['gameid'];
$image = "add_48";
require( "../configuration.php" );
require( "./include.php" );
$returned = @( );
if ( ( $returned ) != @( "harper" ) )
{
    exit( "License Error. Contact SWIFT Panel for support." );
}
$clientid = ( $_GET['clientid'] );
$gameid = ( $_GET['gameid'] );
if ( empty( $clientid ) )
{
    $result = ( "SELECT `clientid`, `firstname`, `lastname`, `email` FROM `client` ORDER BY `clientid`" );
}
else if ( empty( $gameid ) )
{
    $rows = ( "SELECT `clientid`, `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$clientid."' LIMIT 1" );
    $result1 = ( "SELECT `gameid`, `game`, `name` FROM `game` WHERE `status` = 'Active' ORDER BY `game`" );
}
else
{
    $rows = ( "SELECT `clientid`, `firstname`, `lastname` FROM `client` WHERE `clientid` = '".$clientid."' LIMIT 1" );
    $rows1 = ( "SELECT * FROM `game` WHERE `gameid` = '".$gameid."' LIMIT 1" );
}
if ( !empty( $gameid ) )
{
    if ( empty( $_SESSION['name'] ) )
    {
        $_SESSION['name'] = $rows1['name'];
    }
    if ( empty( $_SESSION['priority'] ) )
    {
        $_SESSION['priority'] = $rows1['priority'];
    }
    if ( empty( $_SESSION['slots'] ) )
    {
        $_SESSION['slots'] = $rows1['slots'];
    }
    if ( empty( $_SESSION['type'] ) )
    {
        $_SESSION['type'] = $rows1['type'];
    }
    $n = 1;
    while ( !empty( $rows1["cfg".$n."name"] ) )
    {
        if ( empty( $_SESSION["cfg".$n."name"] ) )
        {
            $_SESSION["cfg".$n."name"] = $rows1["cfg".$n."name"];
        }
        if ( empty( $_SESSION["cfg".$n] ) )
        {
            $_SESSION["cfg".$n] = $rows1["cfg".$n];
        }
        if ( empty( $_SESSION["cfg".$n."edit"] ) )
        {
            $_SESSION["cfg".$n."edit"] = $rows1["cfg".$n."edit"];
        }
        ++$n;
    }
    --$n;
    if ( empty( $_SESSION['startline'] ) )
    {
        $_SESSION['startline'] = $rows1['startline'];
    }
    if ( empty( $_SESSION['formerror'] ) )
    {
        $_SESSION['showftp'] = "";
        $_SESSION['webftp'] = "on";
    }
    unset( $_SESSION['formerror'] );
}
if ( empty( $clientid ) )
{
    $hiddens = array( );
    $keys = array( );
    $values = array( );
    while ( $rows = ( $result ) )
    {
        ( $keys, $rows['clientid'] );
        ( $values, "#".$rows['clientid']." - ".$rows['firstname']." ".$rows['lastname']." (".$rows['email'].")" );
    }
    ( $result );
    $data = @( $keys, $values );
    $inputs = array(
        "clientid" => array(
            "select",
            "Client Name",
            $data,
            "<b>No clients found.</b> <a href=\"clientadd.php\">Click here</a> to add a new client."
        )
    );
    $buttons = array(
        "Next Step" => array( "submit" )
    );
    $form = array(
        "serveradd.php",
        $hiddens,
        $inputs,
        $buttons,
        TRUE,
        FALSE,
        TRUE
    );
}
else if ( empty( $gameid ) )
{
    $hiddens = array(
        "clientid" => $rows['clientid']
    );
    $keys = array( );
    $values = array( );
    while ( $rows1 = ( $result1 ) )
    {
        ( $keys, $rows1['gameid'] );
        ( $values, $rows1['game']." - ".$rows1['name'] );
    }
    ( $result1 );
    $data = @( $keys, $values );
    $inputs = array(
        array(
            "content",
            "Client Name",
            "<a href=\"clientsummary.php?id=".$rows['clientid']."\">".$rows['firstname']." ".$rows['lastname']."</a>"
        ),
        "gameid" => array(
            "select",
            "Game",
            $data
        )
    );
    $buttons = array(
        "Next Step" => array( "submit" ),
        "Previous Step" => array( "link", "serveradd.php" )
    );
    $form = array(
        "serveradd.php",
        $hiddens,
        $inputs,
        $buttons,
        TRUE,
        FALSE,
        TRUE
    );
}
else
{
    $hiddens = array(
        "task" => "serveradd",
        "clientid" => $rows['clientid'],
        "gameid" => $rows1['gameid']
    );
    $inputs = array(
        array(
            "content",
            "Client Name",
            "<a href=\"clientsummary.php?id=".$rows['clientid']."\">".$rows['firstname']." ".$rows['lastname']."</a>"
        ),
        "name" => array( "text", "Name", 30 ),
        array(
            "content",
            "Game",
            $rows1['game']
        ),
        array( "divider" ),
        "priority" => array(
            "select",
            "Priority",
            array( "None" => "None", "Very High" => "Very High", "High" => "High", "Above Normal" => "Above Normal", "Normal" => "Normal", "Below Normal" => "Below Normal", "Low" => "Low", "Very Low" => "Very Low" )
        ),
        "slots" => array( "text", "Max Slots", 5, "{slots}" ),
        "type" => array(
            "radio",
            "Type",
            array( "Public", "Private" )
        ),
        array(
            "cfg",
            $n,
            TRUE
        ),
        "startline" => array( "textarea", "Start Command", 60, 4 ),
        array( "divider" ),
        "showftp" => array( "checkbox", "Display FTP Login Details" ),
        "webftp" => array( "checkbox", "Allow Web FTP Access" )
    );
    $buttons = array(
        "Add New Server" => array( "submit" ),
        "Previous Step" => array(
            "link",
            "serveradd.php?clientid=".$rows['clientid']
        ),
        "Cancel Changes" => array( "reset" )
    );
    $form = array(
        "serverprocess.php",
        $hiddens,
        $inputs,
        $buttons,
        TRUE
    );
}
include( "./templates/".TEMPLATE."/header.php" );
( $form );
include( "./templates/".TEMPLATE."/footer.php" );
?>

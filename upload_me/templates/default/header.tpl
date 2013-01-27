<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$site_title}</title>
<link href="templates/{$template}/images/favicon.ico" rel="shortcut icon" />
<link href="templates/{$template}/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!--
Powered By SWIFT Panel (www.SwiftPanel.com)
Copyright @ 2009 All Rights Reservered.
-->
<div id="topbg"></div>
<div id="nav">
  <div id="home">{$site_name}</div>
  {if $logged_in}
  <div id="left">
    <ul class="menutabs">
      <li class="home"><a href="index.php">Home</a></li>
      <li class="servers"><a href="server.php">My Servers</a></li>
    </ul>
  </div>
  <div id="right">
    <ul class="menutabs">
      <li class="account"><a href="profile.php">My Account</a></li>
      <li class="logout"><a href="process.php?task=logout" title="Clients">Logout</a></li>
    </ul>
  </div>
  <div id="time">{$smarty.now|date_format:"%A | %B %e, %Y | %I:%M %p"}</div>
  {/if}
</div>
<div id="page">
  <div id="content">
  <div id="container">
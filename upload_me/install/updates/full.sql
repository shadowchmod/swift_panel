-- SWIFT Panel Database
-- Version 1.6.1
-- 8/17/2009d

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `adminid` int(10) unsigned NOT NULL auto_increment,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `email` text NOT NULL,
  `access` text NOT NULL,
  `notes` text NOT NULL,
  `status` text NOT NULL,
  `lastlogin` text NOT NULL,
  `lastip` text NOT NULL,
  `lasthost` text NOT NULL,
  PRIMARY KEY  (`adminid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `username`, `password`, `firstname`, `lastname`, `email`, `access`, `notes`, `status`, `lastlogin`, `lastip`, `lasthost`) VALUES
(1, 'admin', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'Admin', 'Account', 'user@example.com', 'Super', 'Check out the forums at www.SwiftPanel.com!\r\nRead manuals on how to setup remote boxes &amp; install game servers in the forums.\r\nDon''t forget to setup the Cron Job. Go to Cron Settings under Configuration.', 'Active', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `box`
--

DROP TABLE IF EXISTS `box`;
CREATE TABLE IF NOT EXISTS `box` (
  `boxid` int(10) unsigned NOT NULL auto_increment,
  `name` text NOT NULL,
  `location` text NOT NULL,
  `ip` text NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `ftpport` text NOT NULL,
  `sshport` text NOT NULL,
  `ostype` text NOT NULL,
  `cost` text NOT NULL,
  `passive` text NOT NULL,
  `notes` text NOT NULL,
  `ftp` text NOT NULL,
  `ssh` text NOT NULL,
  `load` text NOT NULL,
  `idle` text NOT NULL,
  PRIMARY KEY  (`boxid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `box`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `clientid` int(10) unsigned NOT NULL auto_increment,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `company` text NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postcode` text NOT NULL,
  `country` text NOT NULL,
  `phone` text NOT NULL,
  `notes` text NOT NULL,
  `status` text NOT NULL,
  `lastlogin` datetime NOT NULL,
  `lastip` text NOT NULL,
  `lasthost` text NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY  (`clientid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `client`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `setting` varchar(255) NOT NULL,
  `value` text NOT NULL,
  KEY `setting` (`setting`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`setting`, `value`) VALUES
('lastcronrun', 'Never'),
('panelname', 'Swift Panel'),
('systemurl', 'http://www.example.com/'),
('key', ''),
('panelversion', '1.6.1'),
('template', 'default'),
('country', 'US');

-- --------------------------------------------------------

--
-- Table structure for table `emailtemp`
--

DROP TABLE IF EXISTS `emailtemp`;
CREATE TABLE IF NOT EXISTS `emailtemp` (
  `emailtempid` int(10) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `bcc` text NOT NULL,
  `subject` text NOT NULL,
  `template` text NOT NULL,
  PRIMARY KEY  (`emailtempid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emailtemp`
--

INSERT INTO `emailtemp` (`emailtempid`, `name`, `email`, `bcc`, `subject`, `template`) VALUES
(1, 'Your Company', 'user@example.com', '', 'Game Panel Account Information', 'Dear {firstname} {lastname},\r\n\r\nHere is your account login details:\r\n\r\nEmail Address: {email}\r\nPassword: {password}\r\n\r\nGame Panel Link: {clientarealink}\r\n\r\nYour Company\r\nwww.changeme.com');

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `gameid` int(10) unsigned NOT NULL auto_increment,
  `name` text NOT NULL,
  `game` text NOT NULL,
  `query` text NOT NULL,
  `priority` text NOT NULL,
  `slots` text NOT NULL,
  `type` text NOT NULL,
  `cfg1name` text NOT NULL,
  `cfg1` text NOT NULL,
  `cfg1edit` text NOT NULL,
  `cfg2name` text NOT NULL,
  `cfg2` text NOT NULL,
  `cfg2edit` text NOT NULL,
  `cfg3name` text NOT NULL,
  `cfg3` text NOT NULL,
  `cfg3edit` text NOT NULL,
  `cfg4name` text NOT NULL,
  `cfg4` text NOT NULL,
  `cfg4edit` text NOT NULL,
  `cfg5name` text NOT NULL,
  `cfg5` text NOT NULL,
  `cfg5edit` text NOT NULL,
  `cfg6name` text NOT NULL,
  `cfg6` text NOT NULL,
  `cfg6edit` text NOT NULL,
  `cfg7name` text NOT NULL,
  `cfg7` text NOT NULL,
  `cfg7edit` text NOT NULL,
  `cfg8name` text NOT NULL,
  `cfg8` text NOT NULL,
  `cfg8edit` text NOT NULL,
  `startline` text NOT NULL,
  `gamedir` text NOT NULL,
  `port` text NOT NULL,
  `status` text NOT NULL,
  `qryport` text NOT NULL,
  PRIMARY KEY  (`gameid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`gameid`, `name`, `game`, `query`, `priority`, `slots`, `type`, `cfg1name`, `cfg1`, `cfg1edit`, `cfg2name`, `cfg2`, `cfg2edit`, `cfg3name`, `cfg3`, `cfg3edit`, `cfg4name`, `cfg4`, `cfg4edit`, `cfg5name`, `cfg5`, `cfg5edit`, `cfg6name`, `cfg6`, `cfg6edit`, `cfg7name`, `cfg7`, `cfg7edit`, `cfg8name`, `cfg8`, `cfg8edit`, `startline`, `gamedir`, `port`, `status`) VALUES
(1, 'CSS Server', 'Counter-Strike: Source', 'valve', 'None', '16', 'Public', 'Tick Rate', '66', '', 'FPS Max', '300', '', 'Map', 'de_dust2', '', 'Server Config', 'server.cfg', '', 'TV Enable', '1', '', 'TV Max Clients', '15', '', 'TV Port', '27020', '', '', '', '', './srcds_run -game cstrike -ip {ip} -port {port} -maxplayers {slots} -tickrate {cfg1} +fps_max {cfg2} +map {cfg3} +servercfgfile {cfg4} +tv_enable {cfg5} +tv_maxclients {cfg6} +tv_port {cfg7} -autoupdate', '/home/gamefiles/css', '27015', 'Active'),
(2, 'CS Server', 'Counter-Strike 1.6', 'valve', 'None', '16', 'Public', 'FPS Max', '300', '', 'Ping Boost', '0', '', 'Map', 'de_dust2', '', 'Server Config', 'server.cfg', '', '', '', '', '', '', '', '', '', '', '', '', '', './hlds_run -game cstrike +ip {ip} +port {port} +maxplayers {slots} +sys_ticrate {cfg1} -pingboost {cfg2} +map {cfg3} +servercfgfile {cfg4} -autoupdate', '/home/gamefiles/cs', '27015', 'Active'),
(3, 'DODS Server', 'Day of Defeat: Source', 'valve', 'None', '16', 'Public', 'Tick Rate', '66', '', 'FPS Max', '300', '', 'Map', 'dod_anzio', '', 'Server Config', 'server.cfg', '', '', '', '', '', '', '', '', '', '', '', '', '', 'cd orangebox &amp;&amp; {nice} ./srcds_run -game dod -ip {ip} -port {port} -maxplayers {slots} -tickrate {cfg1} +fps_max {cfg2} +map {cfg3} +servercfgfile {cfg4} -autoupdate', '/home/gamefiles/dods', '27015', 'Active'),
(4, 'TF2 Server', 'Team Fortress 2', 'valve', 'None', '16', 'Public', 'Tick Rate', '66', '', 'FPS Max', '300', '', 'Map', 'ctf_well', '', 'Server Config', 'server.cfg', '', '', '', '', '', '', '', '', '', '', '', '', '', 'cd orangebox &amp;&amp; {nice} ./srcds_run -game tf -ip {ip} -port {port} -maxplayers {slots} -tickrate {cfg1} +fps_max {cfg2} +map {cfg3} +servercfgfile {cfg4} -autoupdate', '/home/gamefiles/tf2', '27015', 'Active'),
(5, 'CZ Server', 'Counter-Strike: Condition Zero', 'valve', 'None', '16', 'Public', 'FPS Max', '300', '', 'Ping Boost', '0', '', 'Map', 'de_dust', '', 'Server Config', 'server.cfg', '', '', '', '', '', '', '', '', '', '', '', '', '', './hlds_run -game czero +ip {ip} +port {port} +maxplayers {slots} +sys_ticrate {cfg1} -pingboost {cfg2} +map {cfg3} +servercfgfile {cfg4} -autoupdate', '/home/gamefiles/czero', '27015', 'Active'),
(6, 'DOD Server', 'Day of Defeat', 'valve', 'None', '16', 'Public', 'FPS Max', '300', '', 'Ping Boost', '0', '', 'Map', 'dod_anzio', '', 'Server Config', 'server.cfg', '', '', '', '', '', '', '', '', '', '', '', '', '', './hlds_run -game dod +ip {ip} +port {port} +maxplayers {slots} +sys_ticrate {cfg1} -pingboost {cfg2} +map {cfg3} +servercfgfile {cfg4} -autoupdate', '/home/gamefiles/dod', '27015', 'Active'),
(7, 'HLTV', 'Half Life TV', 'valve', 'None', '50', 'Public', 'FPS Max', '100', '', 'Server Config', 'hltv.cfg', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', './hltv -ip {ip} -port {port} +maxclients {slots} -maxfps {cfg1} +exec {cfg2} -autoupdate', '/home/gamefiles/hltv', '27020', 'Active'),
(8, 'COD4 Server', 'Call of Duty 4', 'quake3', 'None', '24', 'Public', 'Server Config', 'server.cfg', '', 'Map', 'mp_carentan', '', 'Punkbuster', '1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', './cod4_lnxded +set dedicated 2 +set net_ip {ip} +set net_port {port} +set sv_maxclients {slots} +exec {cfg1} +map {cfg2} +set sv_punkbuster {cfg3}', '/home/gamefiles/cod4', '28960', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `ip`
--

DROP TABLE IF EXISTS `ip`;
CREATE TABLE IF NOT EXISTS `ip` (
  `ipid` int(10) unsigned NOT NULL auto_increment,
  `boxid` int(10) unsigned NOT NULL,
  `ip` text NOT NULL,
  `usage` text NOT NULL,
  PRIMARY KEY  (`ipid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ip`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `logid` int(10) unsigned NOT NULL auto_increment,
  `clientid` int(10) unsigned NOT NULL,
  `serverid` int(10) unsigned NOT NULL,
  `boxid` int(10) unsigned NOT NULL,
  `message` text NOT NULL,
  `name` text NOT NULL,
  `ip` text NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`logid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `log`
--

-- --------------------------------------------------------

--
-- Table structure for table `server`
--

DROP TABLE IF EXISTS `server`;
CREATE TABLE IF NOT EXISTS `server` (
  `serverid` int(10) unsigned NOT NULL auto_increment,
  `clientid` int(10) unsigned NOT NULL,
  `boxid` int(10) unsigned NOT NULL,
  `ipid` int(10) unsigned NOT NULL,
  `name` text NOT NULL,
  `game` text NOT NULL,
  `status` text NOT NULL,
  `query` text NOT NULL,
  `priority` text NOT NULL,
  `slots` text NOT NULL,
  `type` text NOT NULL,
  `cfg1name` text NOT NULL,
  `cfg1` text NOT NULL,
  `cfg1edit` text NOT NULL,
  `cfg2name` text NOT NULL,
  `cfg2` text NOT NULL,
  `cfg2edit` text NOT NULL,
  `cfg3name` text NOT NULL,
  `cfg3` text NOT NULL,
  `cfg3edit` text NOT NULL,
  `cfg4name` text NOT NULL,
  `cfg4` text NOT NULL,
  `cfg4edit` text NOT NULL,
  `cfg5name` text NOT NULL,
  `cfg5` text NOT NULL,
  `cfg5edit` text NOT NULL,
  `cfg6name` text NOT NULL,
  `cfg6` text NOT NULL,
  `cfg6edit` text NOT NULL,
  `cfg7name` text NOT NULL,
  `cfg7` text NOT NULL,
  `cfg7edit` text NOT NULL,
  `cfg8name` text NOT NULL,
  `cfg8` text NOT NULL,
  `cfg8edit` text NOT NULL,
  `startline` text NOT NULL,
  `showftp` text NOT NULL,
  `webftp` text NOT NULL,
  `user` text NOT NULL,
  `password` text NOT NULL,
  `homedir` text NOT NULL,
  `installdir` text NOT NULL,
  `port` text NOT NULL,
  `online` text NOT NULL,
  `qryport` text NOT NULL,
  PRIMARY KEY  (`serverid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `server`
--
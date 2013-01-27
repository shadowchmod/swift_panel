DELETE FROM `config` WHERE `setting` = 'update' LIMIT 1;
INSERT INTO `config` (`setting`, `value`) VALUES ('panelname', 'Swift Panel');
INSERT INTO `config` (`setting`, `value`) VALUES ('systemurl', 'http://www.changeme.com/');
INSERT INTO `config` (`setting`, `value`) VALUES ('key', '');
INSERT INTO `config` (`setting`, `value`) VALUES ('panelversion', '1.4.0');
INSERT INTO `config` (`setting`, `value`) VALUES ('template', 'default');
ALTER TABLE `server` ADD `showftp` TEXT NOT NULL ,
ADD `webftp` TEXT NOT NULL;
UPDATE `server` SET `webftp` = 'on';
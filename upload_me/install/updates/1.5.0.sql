ALTER TABLE `client` DROP `allowedit`;
ALTER TABLE `game` ADD `priority` TEXT NOT NULL;
ALTER TABLE `server` ADD `priority` TEXT NOT NULL;
UPDATE `game` SET `priority` = 'None';
UPDATE `server` SET `priority` = 'None';
UPDATE `game` SET `query` = 'None';
UPDATE `config` SET `value` = '1.5.0' WHERE `setting` = 'panelversion';
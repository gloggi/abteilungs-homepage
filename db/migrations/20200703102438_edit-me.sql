-- migrate:up
DELETE FROM `directus_fields` WHERE `id` = '297';
DELETE FROM `directus_relations` WHERE `id` = '25';
ALTER TABLE `groups` ADD `parent_group` int(10) unsigned DEFAULT NULL;
ALTER TABLE `pages` ADD `show_in_navigation_bar` tinyint(3) unsigned NOT NULL DEFAULT 1;
INSERT INTO `directus_collection_presets` VALUES('5',NULL,'1',NULL,'groups',NULL,NULL,'tabular','{\"tabular\":{\"sort\":\"sort\"}}',NULL,NULL);
INSERT INTO `directus_fields` VALUES('332','settings','footer_group_links_page','m2o','many-to-one','{\"template\":\"{{name}}\",\"visible_fields\":\"name\",\"placeholder\":\"\",\"threshold\":20}','0',NULL,'0','0','0','0','13','full',NULL,NULL,'[]');
INSERT INTO `directus_fields` VALUES('333','pages','show_in_navigation_bar','boolean','switch','{\"labelOn\":\"Ja\",\"labelOff\":\"Nein\",\"checkbox\":false}','0',NULL,'1','0','0','0','4','full',NULL,'','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"In Navigationsleiste anzeigen\"}]');
INSERT INTO `directus_fields` VALUES('334','groups','parent_group','m2o','many-to-one','{\"template\":\"{{name}}\",\"visible_fields\":\"name\",\"placeholder\":\"Select one\",\"threshold\":20}','0',NULL,'0','0','0','0','4','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"\\u00dcbergeordnete Gruppe\"}]');
INSERT INTO `directus_files` VALUES('26','local','ei7f4kqkecgkosso','f3bfcabe-a8e4-4d51-bc2b-847a743dcd70.pdf','Jahresplan.pdf','Jahresplan','application/pdf','1','2020-06-30 12:51:59','','30393',NULL,NULL,'0',NULL,NULL,'','','','38d0e14509659d6ea52985b36b2803e0',NULL);
INSERT INTO `directus_files` VALUES('27','local','m8dm9vy0kr48woks','8a38d878-a7ac-49dc-b737-88d2d9d4b365.png','Favicon_Musterabteilung.png','Favicon Musterabteilung','image/png','1','2020-07-01 15:46:10','','1309','64','64','0',NULL,NULL,'','','','810375f94b93c9ab029d27a95a4ec72b',NULL);
INSERT INTO `directus_relations` VALUES('30','settings','footer_group_links_page','pages',NULL,NULL);
INSERT INTO `directus_relations` VALUES('31','groups','parent_group','groups',NULL,NULL);
INSERT INTO `group_images` VALUES('1','2','11','1','2020-07-02 16:25:14','1','2020-07-02 16:25:14');
INSERT INTO `groups` VALUES('7','Pfadistamm','3','b',NULL,'#3F51B5',NULL,'','pfadistamm@gloggi.ch','Nuvolo',NULL,'published','4','1','2020-07-01 12:43:15','1','2020-07-01 12:44:21',NULL);
INSERT INTO `successor_groups` VALUES('15','3','4');
UPDATE `directus_settings` SET `value` = '[{\"key\":\"thumbnail\",\"width\":200,\"height\":200,\"fit\":\"contain\",\"quality\":80},{\"newItem\":true,\"key\":\"favicon\",\"fit\":\"contain\",\"width\":\"32\",\"height\":\"26\",\"quality\":100}]' WHERE `id` = '19';


-- migrate:down
DELETE FROM `directus_collection_presets` WHERE `id` = '5';
DELETE FROM `directus_fields` WHERE `id` = '332';
DELETE FROM `directus_fields` WHERE `id` = '333';
DELETE FROM `directus_fields` WHERE `id` = '334';
DELETE FROM `directus_files` WHERE `id` = '26';
DELETE FROM `directus_files` WHERE `id` = '27';
DELETE FROM `directus_relations` WHERE `id` = '30';
DELETE FROM `directus_relations` WHERE `id` = '31';
DELETE FROM `group_images` WHERE `id` = '1';
DELETE FROM `groups` WHERE `id` = '7';
DELETE FROM `successor_groups` WHERE `id` = '15';
ALTER TABLE `groups` DROP `parent_group`;
ALTER TABLE `pages` DROP `show_in_navigation_bar`;
INSERT INTO `directus_fields` VALUES('297','settings','footer_group_links_page','m2o','many-to-one','{\"placeholder\":\"\",\"threshold\":20}','0','','1','0','0','0','13','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Gruppen im Footer verlinken auf...\"}]');
INSERT INTO `directus_relations` VALUES('25','settings','footer_group_links_page','pages','','');
UPDATE `directus_settings` SET `value` = '[{\"key\":\"thumbnail\",\"width\":200,\"height\":200,\"fit\":\"contain\",\"quality\":80}]' WHERE `id` = '19';

-- migrate:up
DELETE FROM `directus_fields` WHERE `id` = '268';
DELETE FROM `directus_relations` WHERE `id` = '24';
DELETE FROM `directus_fields` WHERE `id` = '278';
DELETE FROM `directus_fields` WHERE `id` = '279';
DELETE FROM `directus_fields` WHERE `id` = '275';
DELETE FROM `directus_fields` WHERE `id` = '274';
DELETE FROM `directus_fields` WHERE `id` = '269';
DELETE FROM `directus_fields` WHERE `id` = '273';
DELETE FROM `directus_fields` WHERE `id` = '272';
DELETE FROM `directus_fields` WHERE `id` = '271';
DELETE FROM `directus_relations` WHERE `id` = '23';
DELETE FROM `directus_fields` WHERE `id` = '276';
DELETE FROM `directus_fields` WHERE `id` = '270';
DELETE FROM `directus_fields` WHERE `id` = '277';
ALTER TABLE `page_contents` ADD `form_fields` text DEFAULT NULL;
ALTER TABLE `page_contents` ADD `agenda_noevents` text DEFAULT NULL COMMENT 'Wird angezeigt falls f??r eine Gruppe keine zuk??nftigen Anl??sse erfasst sind.';
ALTER TABLE `page_contents` ADD `agenda_sections` text DEFAULT NULL;
ALTER TABLE `page_contents` ADD `whoweare_show_contacts` tinyint(3) unsigned DEFAULT NULL;
ALTER TABLE `page_contents` ADD `whoweare_agenda_links_page` int(10) unsigned DEFAULT NULL;
ALTER TABLE `page_contents` ADD `whoweare_show` tinyint(3) unsigned DEFAULT NULL;
ALTER TABLE `page_contents` ADD `whoweare_participate_links_page` int(10) unsigned DEFAULT NULL;
ALTER TABLE `page_contents` ADD `whatwedo_show` tinyint(3) unsigned DEFAULT NULL;
ALTER TABLE `page_contents` CHANGE `content` `content` text DEFAULT NULL;
ALTER TABLE `settings` CHANGE `footer_group_links_page` `footer_group_links_page` int(10) unsigned DEFAULT NULL;
ALTER TABLE `pages` CHANGE `route` `route` varchar(200) NOT NULL;
ALTER TABLE `pages` DROP `agenda_sections`;
ALTER TABLE `pages` DROP `whoweare_show_contacts`;
ALTER TABLE `pages` DROP `whoweare_agenda_links_page`;
ALTER TABLE `pages` DROP `whoweare_participate_links_page`;
ALTER TABLE `pages` DROP `whoweare_show`;
ALTER TABLE `pages` DROP `whatwedo_show`;
ALTER TABLE `pages` DROP `form_fields`;
ALTER TABLE `pages` DROP `agenda_noevents`;
INSERT INTO `directus_relations` VALUES('29','page_contents','whoweare_agenda_links_page','page_contents',NULL,NULL);
INSERT INTO `page_contents` VALUES('4','1',NULL,'<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>',NULL,'1','2020-06-22 19:52:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
INSERT INTO `directus_permissions` VALUES('49','directus_files','2',NULL,'none','full','none','none','none','none',NULL,NULL,NULL);
INSERT INTO `directus_relations` VALUES('28','page_contents','whoweare_participate_links_page','page_contents',NULL,NULL);
INSERT INTO `directus_fields` VALUES('325','page_contents','agenda_noevents','string','wysiwyg','{\"tinymce_options\":null,\"toolbar\":[\"bold\",\"italic\",\"underline\",\"removeformat\",\"link\",\"bullist\",\"numlist\",\"blockquote\",\"h1\",\"h2\",\"h3\",\"image\",\"media\",\"hr\",\"code\",\"fullscreen\",\"aligncenter\",\"alignjustify\",\"alignleft\",\"alignnone\",\"alignright\",\"forecolor\",\"strikethrough\",\"subscript\",\"superscript\",\"unlink\",\"table\"],\"custom_formats\":null}','0',NULL,'0','0','0','0','16','full',NULL,'Wird angezeigt falls f??r eine Gruppe keine zuk??nftigen Anl??sse erfasst sind.','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Keine Anl\\u00e4sse\"}]');
INSERT INTO `directus_fields` VALUES('327','pages','route','slug','slug','{\"placeholder\":\"\",\"onlyOnCreate\":true,\"forceLowercase\":true,\"mirroredField\":\"name\"}','0',NULL,'1','0','0','0','3','full',NULL,NULL,'[]');
INSERT INTO `directus_fields` VALUES('324','page_contents','agenda_sections','json','repeater','{\"placeholder\":\"New Item...\",\"createItemText\":\"Create Item\",\"limit\":null,\"structure\":\"array\",\"fields\":[{\"newItem\":true,\"field\":\"title\",\"width\":\"half\",\"interface\":\"text-input\",\"type\":\"string\",\"options\":[]},{\"newItem\":true,\"field\":\"type\",\"width\":\"half\",\"interface\":\"dropdown\",\"type\":\"string\",\"options\":{\"choices\":{\"events\":\"Anl\\u00e4sse\",\"anual_plan\":\"Jahresplan\",\"special_events\":\"Special Events\"},\"formatting\":true}}]}','0',NULL,'0','0','0','0','15','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Agenda-Abschnitte die auf dieser Seite angezeigt werden\"}]');
INSERT INTO `directus_fields` VALUES('323','page_contents','agenda','alias','divider','{\"style\":\"large\",\"title\":\"\",\"hr\":true,\"margin\":true}','0',NULL,'0','0','0','0','14','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Agenda\"}]');
INSERT INTO `directus_fields` VALUES('322','page_contents','whoweare_show_contacts','boolean','switch','{\"labelOn\":\"Anzeigen\",\"labelOff\":\"Nicht anzeigen\",\"checkbox\":false}','0',NULL,'0','0','0','0','13','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Kontakte auf dieser Seite anzeigen\"}]');
INSERT INTO `directus_fields` VALUES('321','page_contents','whoweare_agenda_links_page','m2o','many-to-one','{\"placeholder\":\"\",\"threshold\":20}','0',NULL,'0','0','0','0','12','half',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Agenda-Eintr\\u00e4ge verlinken auf...\"}]');
INSERT INTO `directus_fields` VALUES('320','page_contents','whoweare_show','boolean','switch','{\"labelOn\":\"Anzeigen\",\"labelOff\":\"Nicht anzeigen\",\"checkbox\":false}','0',NULL,'0','0','0','0','10','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Gruppenstruktur auf dieser Seite anzeigen\"}]');
INSERT INTO `directus_fields` VALUES('319','page_contents','whoweare','alias','divider','{\"style\":\"large\",\"title\":\"\",\"hr\":true,\"margin\":true}','0',NULL,'0','0','0','0','9','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Wer wir sind\"}]');
INSERT INTO `directus_fields` VALUES('318','page_contents','whoweare_participate_links_page','m2o','many-to-one','{\"placeholder\":\"\",\"threshold\":20}','0',NULL,'0','0','0','0','11','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Mitmachen-Buttons verlinken auf...\"}]');
INSERT INTO `directus_fields` VALUES('317','page_contents','whatwedo_show','boolean','switch','{\"labelOn\":\"Anzeigen\",\"labelOff\":\"Nicht anzeigen\",\"checkbox\":false}','0',NULL,'0','0','0','0','8','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Stufentexte auf dieser Seite anzeigen\"}]');
INSERT INTO `directus_fields` VALUES('316','page_contents','whatwedo','alias','divider','{\"style\":\"large\",\"title\":\"\",\"hr\":true,\"margin\":true}','0',NULL,'0','0','0','0','7','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Was wir tun\"}]');
INSERT INTO `directus_fields` VALUES('315','page_contents','form_fields','json','repeater','{\"placeholder\":\"Neues Formularfeld\",\"createItemText\":\"Formular hinzuf\\u00fcgen\",\"limit\":null,\"structure\":\"array\",\"fields\":[{\"newItem\":true,\"field\":\"name\",\"width\":\"full\",\"interface\":\"text-input\",\"type\":\"string\",\"options\":{\"trim\":true,\"showCharacterCount\":true}},{\"newItem\":true,\"field\":\"type\",\"width\":\"half\",\"interface\":\"dropdown\",\"type\":\"string\",\"options\":{\"choices\":{\"text\":\"Text\",\"textarea\":\"Text (mehrzeilig)\",\"number\":\"Zahl\",\"email\":\"email\",\"tel\":\"Telefonnummer\",\"gender\":\"Geschlecht\"},\"formatting\":true}},{\"newItem\":true,\"field\":\"required\",\"width\":\"half\",\"interface\":\"switch\",\"type\":\"boolean\",\"options\":{\"labelOn\":\"Erforderlich\",\"labelOff\":\"Optional\"}}]}','0',NULL,'0','0','0','0','6','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Formularfelder\"}]');
INSERT INTO `directus_fields` VALUES('314','page_contents','form','alias','divider','{\"style\":\"large\",\"title\":\"\",\"hr\":true,\"margin\":true}','0',NULL,'0','0','0','0','5','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Formular\"}]');
INSERT INTO `pages` VALUES('1','Startseite','published','22',NULL,'2020-06-22 19:52:15','1','2020-06-22 19:52:15','');
UPDATE `directus_migrations` SET `start_time` = '2020-06-22 18:51:55', `end_time` = '2020-06-22 18:51:55' WHERE `version` = '20200303111750';
UPDATE `directus_migrations` SET `start_time` = '2020-06-22 18:51:55', `end_time` = '2020-06-22 18:51:55' WHERE `version` = '20200207095101';


-- migrate:down
DELETE FROM `pages` WHERE `id` = '1';
DELETE FROM `directus_fields` WHERE `id` = '323';
DELETE FROM `directus_fields` WHERE `id` = '316';
DELETE FROM `directus_fields` WHERE `id` = '317';
DELETE FROM `directus_fields` WHERE `id` = '318';
DELETE FROM `directus_fields` WHERE `id` = '319';
DELETE FROM `directus_fields` WHERE `id` = '320';
DELETE FROM `directus_fields` WHERE `id` = '322';
DELETE FROM `directus_fields` WHERE `id` = '324';
DELETE FROM `directus_fields` WHERE `id` = '314';
DELETE FROM `directus_fields` WHERE `id` = '325';
DELETE FROM `directus_fields` WHERE `id` = '327';
DELETE FROM `directus_permissions` WHERE `id` = '49';
DELETE FROM `directus_relations` WHERE `id` = '28';
DELETE FROM `directus_relations` WHERE `id` = '29';
DELETE FROM `page_contents` WHERE `id` = '4';
DELETE FROM `directus_fields` WHERE `id` = '315';
DELETE FROM `directus_fields` WHERE `id` = '321';
ALTER TABLE `page_contents` DROP `whatwedo_show`;
ALTER TABLE `page_contents` DROP `agenda_noevents`;
ALTER TABLE `page_contents` DROP `agenda_sections`;
ALTER TABLE `page_contents` DROP `whoweare_show_contacts`;
ALTER TABLE `page_contents` DROP `whoweare_agenda_links_page`;
ALTER TABLE `page_contents` DROP `whoweare_show`;
ALTER TABLE `page_contents` DROP `form_fields`;
ALTER TABLE `page_contents` DROP `whoweare_participate_links_page`;
ALTER TABLE `settings` CHANGE `footer_group_links_page` `footer_group_links_page` int(10) unsigned NOT NULL;
ALTER TABLE `pages` CHANGE `route` `route` text NOT NULL;
ALTER TABLE `page_contents` CHANGE `content` `content` text NOT NULL;
ALTER TABLE `pages` ADD `form_fields` text DEFAULT NULL;
ALTER TABLE `pages` ADD `whatwedo_show` tinyint(3) unsigned DEFAULT NULL;
ALTER TABLE `pages` ADD `whoweare_show` tinyint(3) unsigned DEFAULT NULL;
ALTER TABLE `pages` ADD `agenda_noevents` text DEFAULT NULL COMMENT 'Wird angezeigt falls für eine Gruppe keine zukünftigen Anlässe erfasst sind.';
ALTER TABLE `pages` ADD `whoweare_participate_links_page` int(10) unsigned DEFAULT NULL;
ALTER TABLE `pages` ADD `agenda_sections` text DEFAULT NULL;
ALTER TABLE `pages` ADD `whoweare_show_contacts` tinyint(3) unsigned DEFAULT NULL;
ALTER TABLE `pages` ADD `whoweare_agenda_links_page` int(10) unsigned DEFAULT NULL;
INSERT INTO `directus_relations` VALUES('24','pages','whoweare_participate_links_page','pages','','');
INSERT INTO `directus_relations` VALUES('23','pages','whoweare_agenda_links_page','pages','','');
INSERT INTO `directus_fields` VALUES('279','pages','agenda_sections','json','repeater','{\"placeholder\":\"New Item...\",\"createItemText\":\"Create Item\",\"limit\":null,\"structure\":\"array\",\"fields\":[{\"newItem\":true,\"field\":\"title\",\"width\":\"half\",\"interface\":\"text-input\",\"type\":\"string\",\"note\":\"\\u00dcberschrift\",\"options\":[]},{\"newItem\":true,\"field\":\"type\",\"width\":\"half\",\"interface\":\"dropdown\",\"type\":\"string\",\"options\":{\"choices\":{\"events\":\"Anl\\u00e4sse\",\"annual_plan\":\"Jahresplan\",\"special_events\":\"Special Events\"},\"formatting\":true}}]}','0','','0','0','0','0','17','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Agenda-Abschnitte die auf dieser Seite angezeigt werden\"}]');
INSERT INTO `directus_fields` VALUES('278','pages','agenda','alias','divider','{\"style\":\"large\",\"title\":\"\",\"hr\":true,\"margin\":true}','0','','0','0','0','0','16','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Agenda\"}]');
INSERT INTO `directus_fields` VALUES('277','pages','whoweare_show_contacts','boolean','switch','{\"labelOn\":\"Anzeigen\",\"labelOff\":\"Nicht anzeigen\",\"checkbox\":false}','0','','0','0','0','0','15','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Kontakte auf dieser Seite anzeigen\"}]');
INSERT INTO `directus_fields` VALUES('276','pages','whoweare_agenda_links_page','m2o','many-to-one','{\"placeholder\":\"\",\"threshold\":20}','0','','1','0','0','0','13','half','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Agenda-Eintr\\u00e4ge verlinken auf...\"}]');
INSERT INTO `directus_fields` VALUES('275','pages','whoweare_participate_links_page','m2o','many-to-one','{\"placeholder\":\"\",\"threshold\":20}','0','','1','0','0','0','12','half','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Mitmachen-Buttons verlinken auf...\"}]');
INSERT INTO `directus_fields` VALUES('274','pages','whoweare_show','boolean','switch','{\"labelOn\":\"Anzeigen\",\"labelOff\":\"Nicht anzeigen\",\"checkbox\":false}','0','','0','0','0','0','11','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Gruppenstruktur auf dieser Seite anzeigen\"}]');
INSERT INTO `directus_fields` VALUES('273','pages','whoweare','alias','divider','{\"style\":\"large\",\"title\":\"\",\"hr\":true,\"margin\":true}','0','','0','0','0','0','10','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Wer wir sind\"}]');
INSERT INTO `directus_fields` VALUES('272','pages','whatwedo_show','boolean','switch','{\"labelOn\":\"Anzeigen\",\"labelOff\":\"Nicht anzeigen\",\"checkbox\":false}','0','','0','0','0','0','9','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Stufentexte auf dieser Seite anzeigen\"}]');
INSERT INTO `directus_fields` VALUES('270','pages','form_fields','json','repeater','{\"placeholder\":\"Neues Formularfeld\",\"createItemText\":\"Formularfeld hinzufügen\",\"limit\":null,\"structure\":\"array\",\"fields\":[{\"newItem\":true,\"field\":\"name\",\"width\":\"full\",\"interface\":\"text-input\",\"type\":\"string\",\"options\":{\"trim\":true,\"showCharacterCount\":true}},{\"newItem\":true,\"field\":\"type\",\"width\":\"half\",\"interface\":\"dropdown\",\"type\":\"string\",\"options\":{\"choices\":{\"text\":\"Text\",\"textarea\":\"Text (mehrzeilig)\",\"number\":\"Zahl\",\"email\":\"E-Mail-Adresse\",\"tel\":\"Telefonnummer\",\"gender\":\"Geschlecht\",\"date\":\"Datum\",\"clothing-size\":\"Kleidergr\\u00f6sse (XS - XL)\"},\"formatting\":true}},{\"newItem\":true,\"field\":\"required\",\"width\":\"half\",\"interface\":\"switch\",\"type\":\"boolean\",\"options\":{\"labelOn\":\"Erforderlich\",\"labelOff\":\"Optional\"}}]}','0','','0','0','0','0','7','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Formularfelder\"}]');
INSERT INTO `directus_fields` VALUES('269','pages','form','alias','divider','{\"placeholder\":\"Choose a collection...\",\"include_system\":false,\"style\":\"large\",\"title\":\"\",\"hr\":true,\"margin\":true}','0','','0','0','0','0','6','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Formular\"}]');
INSERT INTO `directus_fields` VALUES('268','pages','contents','o2m','one-to-many','{\"sort_field\":\"sort\",\"delete_mode\":\"item\",\"allow_create\":true,\"allow_select\":false}','0','','0','0','0','0','5','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Inhalte\"}]');
INSERT INTO `directus_fields` VALUES('271','pages','whatwedo','alias','divider','{\"checkbox\":false,\"style\":\"large\",\"title\":\"\",\"hr\":true,\"margin\":true}','0','','0','0','0','0','8','full','','','[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Was wir tun\"}]');
UPDATE `directus_migrations` SET `start_time` = '2020-06-23 07:26:56', `end_time` = '2020-06-23 07:26:56' WHERE `version` = '20200207095101';
UPDATE `directus_migrations` SET `start_time` = '2020-06-23 07:26:56', `end_time` = '2020-06-23 07:26:56' WHERE `version` = '20200303111750';

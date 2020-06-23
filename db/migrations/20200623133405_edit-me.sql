-- migrate:up
INSERT INTO `directus_fields` VALUES('328','pages','contents','o2m','one-to-many','{\"sort_field\":\"sort\",\"delete_mode\":\"item\",\"allow_create\":true,\"allow_select\":false}','0',NULL,'0','0','0','0','6','full',NULL,NULL,'[{\"newItem\":true,\"locale\":\"de-DE\",\"translation\":\"Inhalte\"}]');


-- migrate:down
DELETE FROM `directus_fields` WHERE `id` = '328';

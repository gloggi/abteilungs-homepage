-- migrate:up
DELETE FROM `schema_migrations` WHERE `version` = '20200623155928';


-- migrate:down
INSERT INTO `schema_migrations` VALUES('20200623155928');

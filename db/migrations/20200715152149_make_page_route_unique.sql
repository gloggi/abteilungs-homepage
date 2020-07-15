-- migrate:up
CREATE UNIQUE INDEX `idx_route` ON `pages` (`route`);
UPDATE `directus_fields` SET required=0 WHERE id=327;

-- migrate:down
UPDATE `directus_fields` SET required='1' WHERE id=327;
DROP INDEX `idx_route` ON `pages`;

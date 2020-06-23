-- migrate:up

UPDATE directus_permissions SET collection = 'age_levels', role = 3, status = 'deleted', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 1;
UPDATE directus_permissions SET collection = 'age_levels', role = 3, status = 'draft', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 2;
UPDATE directus_permissions SET collection = 'age_levels', role = 3, status = 'published', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 3;
UPDATE directus_permissions SET collection = 'age_levels', role = 4, status = 'deleted', `create` = 'none', `read` = 'none', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 4;
UPDATE directus_permissions SET collection = 'age_levels', role = 4, status = 'draft', `create` = 'none', `read` = 'none', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 5;
UPDATE directus_permissions SET collection = 'age_levels', role = 4, status = 'published', `create` = 'none', `read` = 'none', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 6;
UPDATE directus_permissions SET collection = 'contacts', role = 3, status = 'deleted', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 7;
UPDATE directus_permissions SET collection = 'contacts', role = 3, status = 'draft', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 8;
UPDATE directus_permissions SET collection = 'contacts', role = 3, status = 'published', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 9;
UPDATE directus_permissions SET collection = 'events', role = 3, status = 'deleted', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 10;
UPDATE directus_permissions SET collection = 'events', role = 3, status = 'draft', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 11;
UPDATE directus_permissions SET collection = 'events', role = 3, status = 'published', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 12;
UPDATE directus_permissions SET collection = 'events', role = 4, status = 'deleted', `create` = 'full', `read` = 'full', `update` = 'mine', `delete` = 'mine', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 13;
UPDATE directus_permissions SET collection = 'events', role = 4, status = 'draft', `create` = 'full', `read` = 'full', `update` = 'mine', `delete` = 'mine', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 14;
UPDATE directus_permissions SET collection = 'events', role = 4, status = 'published', `create` = 'full', `read` = 'full', `update` = 'mine', `delete` = 'mine', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 15;
UPDATE directus_permissions SET collection = 'groups', role = 3, status = 'deleted', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 16;
UPDATE directus_permissions SET collection = 'groups', role = 3, status = 'draft', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 17;
UPDATE directus_permissions SET collection = 'groups', role = 3, status = 'published', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 18;
UPDATE directus_permissions SET collection = 'groups', role = 4, status = 'deleted', `create` = 'none', `read` = 'full', `update` = 'mine', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 19;
UPDATE directus_permissions SET collection = 'groups', role = 4, status = 'draft', `create` = 'none', `read` = 'full', `update` = 'mine', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 20;
UPDATE directus_permissions SET collection = 'groups', role = 4, status = 'published', `create` = 'none', `read` = 'full', `update` = 'mine', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 21;
UPDATE directus_permissions SET collection = 'locations', role = 3, status = 'deleted', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 22;
UPDATE directus_permissions SET collection = 'locations', role = 3, status = 'draft', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 23;
UPDATE directus_permissions SET collection = 'locations', role = 3, status = 'published', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 24;
UPDATE directus_permissions SET collection = 'locations', role = 4, status = 'deleted', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 25;
UPDATE directus_permissions SET collection = 'locations', role = 4, status = 'draft', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 26;
UPDATE directus_permissions SET collection = 'locations', role = 4, status = 'published', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 27;
UPDATE directus_permissions SET collection = 'settings', role = 3, status = null, `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 31;
UPDATE directus_permissions SET collection = 'special_events', role = 3, status = 'deleted', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 32;
UPDATE directus_permissions SET collection = 'special_events', role = 3, status = 'draft', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 33;
UPDATE directus_permissions SET collection = 'special_events', role = 3, status = 'published', `create` = 'full', `read` = 'full', `update` = 'full', `delete` = 'full', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 34;
UPDATE directus_permissions SET collection = 'age_levels', role = 2, status = 'published', `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 35;
UPDATE directus_permissions SET collection = 'contacts', role = 2, status = 'published', `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 36;
UPDATE directus_permissions SET collection = 'event_attachments', role = 2, status = 'published', `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 37;
UPDATE directus_permissions SET collection = 'events', role = 2, status = 'published', `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 38;
UPDATE directus_permissions SET collection = 'events_groups', role = 2, status = null, `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 39;
UPDATE directus_permissions SET collection = 'events_special_events', role = 2, status = null, `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 40;
UPDATE directus_permissions SET collection = 'group_images', role = 2, status = null, `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 41;
UPDATE directus_permissions SET collection = 'groups', role = 2, status = 'published', `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 42;
UPDATE directus_permissions SET collection = 'locations', role = 2, status = 'published', `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 43;
UPDATE directus_permissions SET collection = 'settings', role = 2, status = null, `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 46;
UPDATE directus_permissions SET collection = 'special_events', role = 2, status = 'published', `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 47;
UPDATE directus_permissions SET collection = 'successor_groups', role = 2, status = null, `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 48;
UPDATE directus_permissions SET collection = 'directus_files', role = 2, status = null, `create` = 'none', `read` = 'full', `update` = 'none', `delete` = 'none', comment = 'none', `explain` = 'none', read_field_blacklist = null, write_field_blacklist = null, status_blacklist = null WHERE id = 49;
-- migrate:up

INSERT INTO directus.age_levels (id, image, name, age_min, age_max, color, description, logo, annual_plan, status, sort, created_on, modified_by, modified_on) VALUES (1, 1, 'Biberstufe', 4, 6, '#FF9800', '<p>Beschreibung der Biberstufe</p>', null, null, 'published', null, '2020-06-15 15:57:25', 1, '2020-06-15 15:57:25');
INSERT INTO directus.age_levels (id, image, name, age_min, age_max, color, description, logo, annual_plan, status, sort, created_on, modified_by, modified_on) VALUES (2, 2, 'Wolfsstufe', 7, 10, '#00BCD4', '<p>Beschreibung der Wolfsstufe</p>', null, null, 'published', null, '2020-06-15 15:58:01', 1, '2020-06-15 15:58:01');
INSERT INTO directus.age_levels (id, image, name, age_min, age_max, color, description, logo, annual_plan, status, sort, created_on, modified_by, modified_on) VALUES (3, 3, 'Pfadistufe', 11, 15, '#E91E63', '<p>Beschreibung der Pfadistufe</p>', null, null, 'published', null, '2020-06-15 15:58:50', 1, '2020-06-15 15:58:50');
INSERT INTO directus.age_levels (id, image, name, age_min, age_max, color, description, logo, annual_plan, status, sort, created_on, modified_by, modified_on) VALUES (4, 4, 'Piostufe', 16, 17, '#F44336', '<p>Beschreibung der Piostufe</p>', null, null, 'published', null, '2020-06-15 15:59:31', 1, '2020-06-15 15:59:31');
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (1, 'local', '7urr8779upcsk8og', 'e884baaf-afa5-46a9-9718-ec02896daab7.svg', 'biberstufe.svg', 'Biberstufe', 'image/svg+xml', 1, '2020-06-15 15:57:04', '', 10268, null, null, 0, null, null, '', '', '', '83a584de68d4c9f1b4aa9462212f9329', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (2, 'local', 'pbvu2rdnkcg4k8kw', 'bcf92c2a-fb40-425f-af90-af7af5c38e4d.svg', 'wolfsstufe.svg', 'Wolfsstufe', 'image/svg+xml', 1, '2020-06-15 15:57:36', '', 18666, null, null, 0, null, null, '', '', '', '999abc1e9f57a3f3a9559092c1fa35c2', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (3, 'local', 'ms95qev37zkow8gc', '5c4fc646-ac70-44fb-8f4b-949489d80f17.svg', 'pfadistufe.svg', 'Pfadistufe', 'image/svg+xml', 1, '2020-06-15 15:58:41', '', 16583, null, null, 0, null, null, '', '', '', 'b3f88d28c14730e191998d2fb6e90b07', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (4, 'local', 'fj0n96qe0q8sog44', '036ec653-58bd-4c67-ab92-c459a906617d.svg', 'piostufe.svg', 'Piostufe', 'image/svg+xml', 1, '2020-06-15 15:59:00', '', 6874, null, null, 0, null, null, '', '', '', '9b8cf55f9202b446a6e168b52f99eae9', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (5, 'local', '94o2ycr6l0kk0s48', '21a042fc-4c49-4b36-aac0-99ecebb3bb7e.svg', 'Woelfligruppe_1.svg', 'Woelfligruppe 1', 'image/svg+xml', 1, '2020-06-15 16:02:36', '', 4548, null, null, 0, null, null, '', '', '', 'a4eba2afc486cfea77f9674b31b4d847', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (6, 'local', '26pwnqp1ye4kks4k', '8de4ed22-cb81-4465-b487-35fb227ea4ce.svg', 'Woelfligruppe_2.svg', 'Woelfligruppe 2', 'image/svg+xml', 1, '2020-06-15 16:04:21', '', 4871, null, null, 0, null, null, '', '', '', 'fedde1e5427517605350463c159c9c1b', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (7, 'local', 'bs9n0fcgoagwokws', 'd8c1312b-49e4-4fd7-9cd8-9b44d8adc927.svg', 'Pfadigruppe_2.svg', 'Pfadigruppe 2', 'image/svg+xml', 1, '2020-06-15 16:06:24', '', 5669, null, null, 0, null, null, '', '', '', '717a3227947027334af87a55cbb7f533', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (8, 'local', '9bzek6ry4c0s80ws', '770c59e4-7cca-4a95-9716-e95c1132d50e.svg', 'Piogruppe_1.svg', 'Piogruppe 1', 'image/svg+xml', 1, '2020-06-15 16:08:45', '', 4367, null, null, 0, null, null, '', '', '', 'b13a67d6f87a0412ec0e5af19ae71e83', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (9, 'local', '2nnwznby41a88o4k', 'ff286eff-9ab7-497a-b9fc-18fae6bc0bec.svg', 'Pfadigruppe_1.svg', 'Pfadigruppe 1', 'image/svg+xml', 1, '2020-06-15 16:08:59', '', 5344, null, null, 0, null, null, '', '', '', 'e34f0999a15e17ba8a157021f60c8c43', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (10, 'local', 'e0uqbj6ylk8osokw', '23cb824d-bd5e-4140-8608-8577f274bd0c.svg', 'Piogruppe_1.svg', 'Piogruppe 1', 'image/svg+xml', 1, '2020-06-15 16:09:10', '', 4367, null, null, 0, null, null, '', '', '', 'b13a67d6f87a0412ec0e5af19ae71e83', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (11, 'local', 'ho3xk6nac8gss0gc', '47fe5630-1b73-4b12-93b3-3fc6531b5f62.png', 'Banner.png', 'Banner', 'image/png', 1, '2020-06-16 19:11:13', '', 10752, 1922, 1082, 0, null, null, '', '', '', '82abfde46302b0cc39d06ca9e167383c', null);
INSERT INTO directus.`groups` (id, name, age_level, gender, logo, color, area, description, contact_email, contact_name, annual_plan, status, sort, owner, created_on, modified_by, modified_on) VALUES (1, 'Bibergruppe 1', 1, 'b', 10, '#FF9800', null, '<p>Beschreibung der Bibergruppe 1</p>', 'bibergruppe1@gloggi.ch', 'Frosch', null, 'published', null, 1, '2020-06-15 16:01:53', 1, '2020-06-15 16:09:11');
INSERT INTO directus.`groups` (id, name, age_level, gender, logo, color, area, description, contact_email, contact_name, annual_plan, status, sort, owner, created_on, modified_by, modified_on) VALUES (2, 'Wölfligruppe 1', 2, 'm', 5, '#00BCD4', null, '<p>Beschreibung der W&ouml;lfligruppe 1</p>', 'wölfligruppe@gloggi.ch', 'Baghira', null, 'published', null, 1, '2020-06-15 16:03:22', 1, '2020-06-15 16:03:58');
INSERT INTO directus.`groups` (id, name, age_level, gender, logo, color, area, description, contact_email, contact_name, annual_plan, status, sort, owner, created_on, modified_by, modified_on) VALUES (3, 'Wölfligruppe 2', 2, 'w', 6, '#FF9800', null, '<p>Beschreibung der W&ouml;lfligruppe 2</p>', 'wöfligruppe2@gloggi.ch', 'Mulan', null, 'published', null, 1, '2020-06-15 16:05:14', 1, '2020-06-15 16:05:14');
INSERT INTO directus.`groups` (id, name, age_level, gender, logo, color, area, description, contact_email, contact_name, annual_plan, status, sort, owner, created_on, modified_by, modified_on) VALUES (4, 'Pfadigruppe 1', 3, 'b', 9, '#607D8B', null, '<p>Beschreibung der Pfadigruppe 1</p>', 'pfadigruppe1@gloggi.ch', 'Balu', null, 'published', null, 1, '2020-06-15 16:06:07', 1, '2020-06-15 16:09:01');
INSERT INTO directus.`groups` (id, name, age_level, gender, logo, color, area, description, contact_email, contact_name, annual_plan, status, sort, owner, created_on, modified_by, modified_on) VALUES (5, 'Pfadigruppe 2', 3, 'b', 7, '#9C27B0', null, '<p>Beschreibung der Pfadigruppe 2</p>', 'pfadigruppe2@gloggi.ch', 'Mogli', null, 'published', null, 1, '2020-06-15 16:07:13', 1, '2020-06-15 16:07:13');
INSERT INTO directus.`groups` (id, name, age_level, gender, logo, color, area, description, contact_email, contact_name, annual_plan, status, sort, owner, created_on, modified_by, modified_on) VALUES (6, 'Piogruppe 1', 4, 'b', 8, '#F44336', null, '<p>Beschreibung der Piogruppe</p>', 'piogruppe1@gloggi.ch', 'Sprite', null, 'published', null, 1, '2020-06-15 16:08:31', 1, '2020-06-15 16:08:46');
INSERT INTO directus.pages (id, name, status, banner, form_fields, whatwedo_show, whoweare_show, whoweare_participate_links_page, whoweare_agenda_links_page, whoweare_show_contacts, agenda_sections, agenda_noevents, sort, created_on, modified_by, modified_on, route) VALUES (1, 'Startseite', 'published', 11, null, null, null, null, null, null, null, null, null, '2020-06-16 19:12:39', 1, '2020-06-16 19:12:39', 'startseite');
INSERT INTO directus.pages (id, name, status, banner, form_fields, whatwedo_show, whoweare_show, whoweare_participate_links_page, whoweare_agenda_links_page, whoweare_show_contacts, agenda_sections, agenda_noevents, sort, created_on, modified_by, modified_on, route) VALUES (2, 'Wer wir sind', 'published', 11, null, null, 1, null, null, 1, null, null, null, '2020-06-16 19:13:16', 1, '2020-06-16 19:13:16', 'wer-wir-sind');
INSERT INTO directus.pages (id, name, status, banner, form_fields, whatwedo_show, whoweare_show, whoweare_participate_links_page, whoweare_agenda_links_page, whoweare_show_contacts, agenda_sections, agenda_noevents, sort, created_on, modified_by, modified_on, route) VALUES (3, 'Was wir tun', 'published', 11, null, 1, null, null, null, null, null, null, null, '2020-06-16 19:13:51', 1, '2020-06-16 19:13:51', 'was-wir-tun');
INSERT INTO directus.pages (id, name, status, banner, form_fields, whatwedo_show, whoweare_show, whoweare_participate_links_page, whoweare_agenda_links_page, whoweare_show_contacts, agenda_sections, agenda_noevents, sort, created_on, modified_by, modified_on, route) VALUES (4, 'Mitmachen', 'published', 11, '[{"newItem":true,"name":"Vorname","type":"text","required":true},{"newItem":true,"name":"Nachname","type":"text","required":true},{"newItem":true,"name":"Geschlecht","type":"gender","required":true},{"newItem":true,"name":"Geburtsdatum","type":"date","required":true},{"newItem":true,"name":"E-Mail","type":"email","required":true}]', null, null, null, null, null, null, null, null, '2020-06-16 19:16:02', 1, '2020-06-16 19:16:02', 'mitmachen');
INSERT INTO directus.page_contents (id, page, separator_banner, content, sort, modified_by, modified_on) VALUES (1, 1, null, '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', null, 1, '2020-06-16 19:12:39');
INSERT INTO directus.page_contents (id, page, separator_banner, content, sort, modified_by, modified_on) VALUES (2, 1, 11, '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', null, 1, '2020-06-16 19:12:39');
INSERT INTO directus.page_contents (id, page, separator_banner, content, sort, modified_by, modified_on) VALUES (3, 4, null, '<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', null, 1, '2020-06-16 19:16:02');
INSERT INTO directus.successor_groups (id, predecessor_group, successor_group) VALUES (1, 2, 1);
INSERT INTO directus.successor_groups (id, predecessor_group, successor_group) VALUES (2, 3, 1);
INSERT INTO directus.successor_groups (id, predecessor_group, successor_group) VALUES (3, 4, 2);
INSERT INTO directus.successor_groups (id, predecessor_group, successor_group) VALUES (4, 4, 3);
INSERT INTO directus.successor_groups (id, predecessor_group, successor_group) VALUES (5, 5, 2);
INSERT INTO directus.successor_groups (id, predecessor_group, successor_group) VALUES (6, 5, 3);
INSERT INTO directus.successor_groups (id, predecessor_group, successor_group) VALUES (7, 6, 4);
INSERT INTO directus.successor_groups (id, predecessor_group, successor_group) VALUES (8, 6, 5);
INSERT INTO directus.settings (id, website_title, scout_group_name, logo, favicon, primary_color, secondary_color, event_email, annual_plan, recaptcha_site_key, recaptcha_secret_key, footer_group_list_title, footer_group_links_page, footer_links, footer_contact, modified_by, modified_on) VALUES (1, 'Pfadi Musterabteilung', 'Pfadi Musterabteilung', 12, null, '#E91E63', '#9C27B0', 'events@gloggi.ch', null, null, null, null, 2, null, '<p>Das ist der <strong>Kontakt</strong> Footer.</p>', 1, '2020-06-19 13:59:22');
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (1, 'local', '7urr8779upcsk8og', 'e884baaf-afa5-46a9-9718-ec02896daab7.svg', 'biberstufe.svg', 'Biberstufe', 'image/svg+xml', 1, '2020-06-15 15:57:04', '', 10268, null, null, 0, null, null, '', '', '', '83a584de68d4c9f1b4aa9462212f9329', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (2, 'local', 'pbvu2rdnkcg4k8kw', 'bcf92c2a-fb40-425f-af90-af7af5c38e4d.svg', 'wolfsstufe.svg', 'Wolfsstufe', 'image/svg+xml', 1, '2020-06-15 15:57:36', '', 18666, null, null, 0, null, null, '', '', '', '999abc1e9f57a3f3a9559092c1fa35c2', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (3, 'local', 'ms95qev37zkow8gc', '5c4fc646-ac70-44fb-8f4b-949489d80f17.svg', 'pfadistufe.svg', 'Pfadistufe', 'image/svg+xml', 1, '2020-06-15 15:58:41', '', 16583, null, null, 0, null, null, '', '', '', 'b3f88d28c14730e191998d2fb6e90b07', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (4, 'local', 'fj0n96qe0q8sog44', '036ec653-58bd-4c67-ab92-c459a906617d.svg', 'piostufe.svg', 'Piostufe', 'image/svg+xml', 1, '2020-06-15 15:59:00', '', 6874, null, null, 0, null, null, '', '', '', '9b8cf55f9202b446a6e168b52f99eae9', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (5, 'local', '94o2ycr6l0kk0s48', '21a042fc-4c49-4b36-aac0-99ecebb3bb7e.svg', 'Woelfligruppe_1.svg', 'Woelfligruppe 1', 'image/svg+xml', 1, '2020-06-15 16:02:36', '', 4548, null, null, 0, null, null, '', '', '', 'a4eba2afc486cfea77f9674b31b4d847', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (6, 'local', '26pwnqp1ye4kks4k', '8de4ed22-cb81-4465-b487-35fb227ea4ce.svg', 'Woelfligruppe_2.svg', 'Woelfligruppe 2', 'image/svg+xml', 1, '2020-06-15 16:04:21', '', 4871, null, null, 0, null, null, '', '', '', 'fedde1e5427517605350463c159c9c1b', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (7, 'local', 'bs9n0fcgoagwokws', 'd8c1312b-49e4-4fd7-9cd8-9b44d8adc927.svg', 'Pfadigruppe_2.svg', 'Pfadigruppe 2', 'image/svg+xml', 1, '2020-06-15 16:06:24', '', 5669, null, null, 0, null, null, '', '', '', '717a3227947027334af87a55cbb7f533', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (8, 'local', '9bzek6ry4c0s80ws', '770c59e4-7cca-4a95-9716-e95c1132d50e.svg', 'Piogruppe_1.svg', 'Piogruppe 1', 'image/svg+xml', 1, '2020-06-15 16:08:45', '', 4367, null, null, 0, null, null, '', '', '', 'b13a67d6f87a0412ec0e5af19ae71e83', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (9, 'local', '2nnwznby41a88o4k', 'ff286eff-9ab7-497a-b9fc-18fae6bc0bec.svg', 'Pfadigruppe_1.svg', 'Pfadigruppe 1', 'image/svg+xml', 1, '2020-06-15 16:08:59', '', 5344, null, null, 0, null, null, '', '', '', 'e34f0999a15e17ba8a157021f60c8c43', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (10, 'local', 'e0uqbj6ylk8osokw', '23cb824d-bd5e-4140-8608-8577f274bd0c.svg', 'Piogruppe_1.svg', 'Piogruppe 1', 'image/svg+xml', 1, '2020-06-15 16:09:10', '', 4367, null, null, 0, null, null, '', '', '', 'b13a67d6f87a0412ec0e5af19ae71e83', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (11, 'local', 'ho3xk6nac8gss0gc', '47fe5630-1b73-4b12-93b3-3fc6531b5f62.png', 'Banner.png', 'Banner', 'image/png', 1, '2020-06-16 19:11:13', '', 10752, 1922, 1082, 0, null, null, '', '', '', '82abfde46302b0cc39d06ca9e167383c', null);
INSERT INTO directus.directus_files (id, storage, private_hash, filename_disk, filename_download, title, type, uploaded_by, uploaded_on, charset, filesize, width, height, duration, embed, folder, description, location, tags, checksum, metadata) VALUES (12, 'local', '7hkw8u1eryscgc44', '6dcc9105-4275-4930-ac7d-29c51e8a36a6.svg', 'Musterabteilung.svg', 'Musterabteilung', 'image/svg+xml', 1, '2020-06-19 13:59:18', '', 6077, null, null, 0, null, null, '', '', '', '8e15f6d4778851ce13b4ac18f71932aa', null);
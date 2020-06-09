-- migrate:up


--
-- Table structure for table `age_levels`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `age_levels` (
                              `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                              `image` int(10) unsigned NOT NULL,
                              `name` varchar(64) NOT NULL,
                              `age_min` int(11) NOT NULL,
                              `age_max` int(11) NOT NULL,
                              `color` varchar(20) NOT NULL,
                              `description` text DEFAULT NULL,
                              `logo` int(10) unsigned DEFAULT NULL,
                              `annual_plan` int(10) unsigned DEFAULT NULL,
                              `status` varchar(20) NOT NULL DEFAULT 'draft',
                              `sort` int(10) unsigned DEFAULT NULL,
                              `created_on` datetime DEFAULT NULL,
                              `modified_by` int(10) unsigned DEFAULT NULL,
                              `modified_on` datetime DEFAULT NULL,
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
                            `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                            `name` varchar(64) NOT NULL,
                            `email` varchar(64) NOT NULL,
                            `image` int(10) unsigned NOT NULL,
                            `status` varchar(20) NOT NULL DEFAULT 'draft',
                            `sort` int(10) unsigned DEFAULT NULL,
                            `created_on` datetime DEFAULT NULL,
                            `modified_by` int(10) unsigned DEFAULT NULL,
                            `modified_on` datetime DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event_attachments`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_attachments` (
                                     `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                                     `event` int(10) unsigned NOT NULL,
                                     `name` varchar(64) NOT NULL,
                                     `attachment` int(10) unsigned NOT NULL,
                                     `status` varchar(20) NOT NULL DEFAULT 'draft',
                                     `owner` int(10) unsigned DEFAULT NULL,
                                     `created_on` datetime DEFAULT NULL,
                                     `modified_by` int(10) unsigned DEFAULT NULL,
                                     `modified_on` datetime DEFAULT NULL,
                                     PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
                          `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                          `name` varchar(64) NOT NULL,
                          `description` text DEFAULT NULL,
                          `start_time` datetime NOT NULL,
                          `start_location` int(10) unsigned NOT NULL,
                          `end_time` datetime NOT NULL,
                          `end_location` int(10) unsigned DEFAULT NULL,
                          `bring` text DEFAULT NULL,
                          `status` varchar(20) NOT NULL DEFAULT 'draft',
                          `owner` int(10) unsigned DEFAULT NULL,
                          `created_on` datetime DEFAULT NULL,
                          `modified_by` int(10) unsigned DEFAULT NULL,
                          `modified_on` datetime DEFAULT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events_groups`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events_groups` (
                                 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                 `event` int(10) unsigned NOT NULL,
                                 `group` int(10) unsigned NOT NULL,
                                 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `events_special_events`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events_special_events` (
                                         `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                         `event` int(10) unsigned NOT NULL,
                                         `special_event` int(10) unsigned NOT NULL,
                                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `group_images`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_images` (
                                `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                                `group` int(10) unsigned NOT NULL,
                                `image` int(10) unsigned NOT NULL,
                                `owner` int(10) unsigned DEFAULT NULL,
                                `created_on` datetime DEFAULT NULL,
                                `modified_by` int(10) unsigned DEFAULT NULL,
                                `modified_on` datetime DEFAULT NULL,
                                PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
                          `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                          `name` varchar(64) NOT NULL,
                          `age_level` int(10) unsigned NOT NULL,
                          `gender` varchar(255) NOT NULL,
                          `logo` int(10) unsigned DEFAULT NULL,
                          `color` varchar(20) NOT NULL,
                          `area` varchar(255) DEFAULT NULL,
                          `description` text DEFAULT NULL,
                          `contact_email` varchar(64) NOT NULL,
                          `contact_name` varchar(200) NOT NULL,
                          `annual_plan` int(10) unsigned DEFAULT NULL,
                          `status` varchar(20) NOT NULL DEFAULT 'draft',
                          `sort` int(10) unsigned DEFAULT NULL,
                          `owner` int(10) unsigned DEFAULT NULL,
                          `created_on` datetime DEFAULT NULL,
                          `modified_by` int(10) unsigned DEFAULT NULL,
                          `modified_on` datetime DEFAULT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `locations`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
                             `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                             `name` varchar(64) NOT NULL,
                             `location` text NOT NULL,
                             `status` varchar(20) NOT NULL DEFAULT 'draft',
                             `created_on` datetime DEFAULT NULL,
                             `modified_by` int(10) unsigned DEFAULT NULL,
                             `modified_on` datetime DEFAULT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `page_contents`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_contents` (
                                 `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                                 `page` int(10) unsigned NOT NULL,
                                 `separator_banner` int(10) unsigned NOT NULL,
                                 `content` text NOT NULL,
                                 `sort` int(10) unsigned DEFAULT NULL,
                                 `modified_by` int(10) unsigned DEFAULT NULL,
                                 `modified_on` datetime DEFAULT NULL,
                                 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
                         `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                         `name` varchar(64) NOT NULL,
                         `status` varchar(20) NOT NULL DEFAULT 'draft',
                         `banner` int(10) unsigned NOT NULL,
                         `form_fields` text DEFAULT NULL,
                         `whatwedo_show` tinyint(3) unsigned DEFAULT NULL,
                         `whoweare_show` tinyint(3) unsigned DEFAULT NULL,
                         `whoweare_participate_links_page` int(10) unsigned NOT NULL,
                         `whoweare_agenda_links_page` int(10) unsigned NOT NULL,
                         `whoweare_show_contacts` tinyint(3) unsigned DEFAULT NULL,
                         `agenda_sections` text DEFAULT NULL,
                         `agenda_noevents` text DEFAULT NULL COMMENT 'Wird angezeigt falls für eine Gruppe keine zukünftigen Anlässe erfasst sind.',
                         `sort` int(10) unsigned DEFAULT NULL,
                         `created_on` datetime DEFAULT NULL,
                         `modified_by` int(10) unsigned DEFAULT NULL,
                         `modified_on` datetime DEFAULT NULL,
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `settings`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
                            `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                            `website_title` varchar(200) NOT NULL,
                            `scout_group_name` varchar(200) NOT NULL,
                            `logo` int(10) unsigned DEFAULT NULL,
                            `favicon` int(10) unsigned DEFAULT NULL COMMENT 'Das kleine Icon auf dem Tab im Browser. Sollte ein 32x32 Pixel grosses PNG-Bild sein.',
                            `primary_color` varchar(20) NOT NULL,
                            `secondary_color` varchar(20) NOT NULL,
                            `event_email` varchar(200) NOT NULL,
                            `annual_plan` int(10) unsigned DEFAULT NULL,
                            `recaptcha_site_key` varchar(200) DEFAULT NULL,
                            `recaptcha_secret_key` varchar(200) DEFAULT NULL,
                            `footer_group_list_title` varchar(200) DEFAULT NULL,
                            `footer_group_links_page` int(10) unsigned NOT NULL,
                            `footer_links` text DEFAULT NULL,
                            `footer_contact` text DEFAULT NULL,
                            `modified_by` int(10) unsigned DEFAULT NULL,
                            `modified_on` datetime DEFAULT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `special_events`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `special_events` (
                                  `id` int(15) unsigned NOT NULL AUTO_INCREMENT,
                                  `name` varchar(64) NOT NULL,
                                  `name_plural` varchar(64) NOT NULL,
                                  `description` text DEFAULT NULL,
                                  `status` varchar(20) NOT NULL DEFAULT 'draft',
                                  `sort` int(10) unsigned DEFAULT NULL,
                                  `created_on` datetime DEFAULT NULL,
                                  `modified_by` int(10) unsigned DEFAULT NULL,
                                  `modified_on` datetime DEFAULT NULL,
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `successor_groups`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `successor_groups` (
                                    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                    `predecessor_group` int(10) unsigned NOT NULL,
                                    `successor_group` int(10) unsigned NOT NULL,
                                    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


-- migrate:down

DROP TABLE `groups`;
DROP TABLE `age_levels`;
DROP TABLE `contacts`;
DROP TABLE `event_attachments`;
DROP TABLE `events`;
DROP TABLE `events_groups`;
DROP TABLE `events_special_events`;
DROP TABLE `group_images`;
DROP TABLE `groups`;
DROP TABLE `locations`;
DROP TABLE `page_contents`;
DROP TABLE `pages`;
DROP TABLE `schema_migrations`;
DROP TABLE `settings`;
DROP TABLE `special_events`;
DROP TABLE `successor_groups`;
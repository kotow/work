
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- m_document
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_document` 
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`document_model` VARCHAR(255),
	`document_author` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_relation
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_relation` 
(
	`id1` INTEGER  NOT NULL,
	`id2` INTEGER  NOT NULL,
	`document_model1` VARCHAR(255),
	`document_model2` VARCHAR(255),
	`sort_order` INTEGER,
	PRIMARY KEY (`id1`,`id2`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_tag
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_tag` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`tag_id` VARCHAR(255),
	`module` VARCHAR(255),
	`document_model` VARCHAR(255),
	`exclusive` INTEGER,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_tag_relation
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_tag_relation` 
(
	`id` INTEGER  NOT NULL,
	`tag_id` INTEGER  NOT NULL,
	PRIMARY KEY (`id`,`tag_id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_rootfolder
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_rootfolder` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_folder
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_folder` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_website
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_website` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`url` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_website_menu
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_website_menu` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_website_topic
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_website_topic` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`navigation_title` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_website_page
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_website_page` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`page_type` VARCHAR(20),
	`navigation_title` VARCHAR(255),
	`meta_description` VARCHAR(255),
	`meta_keywords` VARCHAR(255),
	`image` INTEGER,
	`template` VARCHAR(255),
	`content` TEXT,
	`page_id` INTEGER,
	`url` VARCHAR(255),
	`description` TEXT,
	`is_secure` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_urlrewrite
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_urlrewrite` 
(
	`label` VARCHAR(255)  NOT NULL,
	`id` INTEGER  NOT NULL,
	`page_id` INTEGER,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_keyword
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_keyword` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_lists
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_lists` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`list_id` VARCHAR(255),
	`list_type` VARCHAR(32),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_list_item
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_list_item` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`value` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_media
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_media` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`description` VARCHAR(255),
	`filename` VARCHAR(255),
	`filedirpath` VARCHAR(255),
	`filetype` VARCHAR(255),
	`filesize` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_news
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_news` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`short_description` VARCHAR(255),
	`image` INTEGER,
	`download` INTEGER,
	`content` TEXT,
	`start_date` DATETIME,
	`end_date` DATETIME,
	`rds` INTEGER,
	`keywords` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_newsletter
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_newsletter` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`content` TEXT,
	`period` INTEGER,
	`email` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_mailinglist
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_mailinglist` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_subscriber
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_subscriber` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`email` VARCHAR(255),
	`code` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_user
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_user` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`login` VARCHAR(50),
	`backend` INTEGER,
	`type` VARCHAR(50),
	`sha1_password` VARCHAR(40),
	`salt` VARCHAR(32),
	`first_name` VARCHAR(100),
	`last_name` VARCHAR(100),
	`email` VARCHAR(100),
	`phone` VARCHAR(20),
	`city` VARCHAR(255),
	`address` VARCHAR(255),
	`zip` VARCHAR(255),
	`state` VARCHAR(255),
	`address2` VARCHAR(255),
	`mobile_phone` VARCHAR(255),
	`work_phone` VARCHAR(255),
	`contact_name` VARCHAR(255),
	`contact_number` VARCHAR(255),
	`activation_code` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_slider
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_slider` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_slide
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_slide` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`image` INTEGER,
	`description` TEXT,
	`link` VARCHAR(255),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_category
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_category` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`icon` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_product
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_product` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`image` INTEGER,
	`short_description` VARCHAR(255),
	`description` TEXT,
	`price` VARCHAR(15),
	`currency` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_gallery
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_gallery` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`image` INTEGER,
	`description` TEXT,
	`rds` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_import
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_import` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`system` INTEGER,
	`size` INTEGER,
	`user` INTEGER,
	`status` VARCHAR(255),
	`uploaded_at` DATETIME,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_import_session
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_import_session` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`import_id` INTEGER,
	`start_id` INTEGER,
	`tm_count` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_client
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_client` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`address` TEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_brand
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_brand` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`client_id` INTEGER,
	`application_number` VARCHAR(255),
	`application_date` DATETIME,
	`status` VARCHAR(255),
	`register_number` VARCHAR(255),
	`registration_date` DATETIME,
	`kind` VARCHAR(31),
	`expires_on` DATETIME,
	`vienna_classes` VARCHAR(512),
	`colors` VARCHAR(512),
	`nice_classes` VARCHAR(512),
	`rights_owner` VARCHAR(255),
	`rights_owner_id` VARCHAR(63),
	`rights_owner_address` VARCHAR(1024),
	`rights_representative` VARCHAR(255),
	`rights_representative_id` VARCHAR(63),
	`rights_representative_address` VARCHAR(1024),
	`office_of_origin` VARCHAR(10),
	`designated_contracting_party` VARCHAR(512),
	`image` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_trademark
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_trademark` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`application_number` VARCHAR(255),
	`register_number` VARCHAR(255),
	`registration_date` DATETIME,
	`from_system` INTEGER,
	`kind` VARCHAR(31),
	`application_date` DATETIME,
	`status` VARCHAR(255),
	`expires_on` DATETIME,
	`publications` VARCHAR(1024),
	`vienna_classes` VARCHAR(512),
	`colors` VARCHAR(512),
	`nice_classes` VARCHAR(512),
	`rights_owner` VARCHAR(255),
	`rights_owner_id` VARCHAR(63),
	`rights_owner_address` VARCHAR(1024),
	`rights_representative` VARCHAR(255),
	`rights_representative_id` VARCHAR(63),
	`rights_representative_address` VARCHAR(1024),
	`office_of_origin` VARCHAR(10),
	`designated_contracting_party` VARCHAR(512),
	`image` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_search
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_search` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`application_number` VARCHAR(255),
	`register_number` VARCHAR(255),
	`registration_date` VARCHAR(12),
	`application_date` VARCHAR(12),
	`expires_on` VARCHAR(12),
	`vienna_classes` VARCHAR(512),
	`nice_classes` VARCHAR(512),
	`rights_owner` VARCHAR(1024),
	`rights_representative` VARCHAR(1024),
	`office_of_origin` VARCHAR(10),
	`designated_contracting_party` VARCHAR(512),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- m_search_match
#-----------------------------------------------------------------------------


CREATE TABLE IF NOT EXISTS `m_search_match` 
(
	`id` INTEGER  NOT NULL,
	`label` VARCHAR(255),
	`import_session` INTEGER,
	`search` INTEGER,
	`trademark` INTEGER,
	`matches` VARCHAR(1024),
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`publication_status` VARCHAR(15),
	PRIMARY KEY (`id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

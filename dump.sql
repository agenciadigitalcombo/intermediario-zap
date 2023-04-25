
CREATE TABLE `institution` (
    `id` int NOT NULL AUTO_INCREMENT,
    `name` varchar(255) DEFAULT NULL,
    `color` varchar(255) DEFAULT NULL,
    `logo` varchar(255) DEFAULT NULL,
    `ref` varchar(255) DEFAULT NULL,
    `site` varchar(255) DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `channel` varchar(255) DEFAULT NULL,
    `session_token` varchar(255) DEFAULT NULL,
    `status` int DEFAULT 0,
    `sender` int DEFAULT 0,
    `fail` int DEFAULT 0,
    `register_date` varchar(255) DEFAULT NULL,
    `balance` int DEFAULT 0,
    `custom` TEXT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `contact` (
    `id` int NOT NULL AUTO_INCREMENT,
    `ref` varchar(255) DEFAULT NULL,
    `institution_ref` varchar(255) DEFAULT NULL,
    `name` varchar(255) DEFAULT NULL,
    `ddd` varchar(255) DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `status` int DEFAULT 0,
    `sender` int DEFAULT 0,
    `register_date` varchar(255) DEFAULT NULL,
    `custom` TEXT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `sender` (
    `id` int NOT NULL AUTO_INCREMENT,
    `ref` varchar(255) DEFAULT NULL,
    `institution_ref` varchar(255) DEFAULT NULL,
    `contact_ref` varchar(255) DEFAULT NULL,
    `register_date` varchar(255) DEFAULT NULL,
    `update_date` varchar(255) DEFAULT NULL,
    `message_type` varchar(255) DEFAULT NULL,
    `next_date` varchar(255) DEFAULT NULL,
    `message` TEXT DEFAULT '',
    `price` varchar(255) DEFAULT NULL,
    `status` int DEFAULT 0,
    `custom` TEXT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `fail` (
    `id` int NOT NULL AUTO_INCREMENT,
    `ref` varchar(255) DEFAULT NULL,
    `institution_ref` varchar(255) DEFAULT NULL,
    `contact_ref` varchar(255) DEFAULT NULL,
    `register_date` varchar(255) DEFAULT NULL,
    `update_date` varchar(255) DEFAULT NULL,
    `next_date` varchar(255) DEFAULT NULL,
    `message_type` varchar(255) DEFAULT NULL,
    `message` TEXT DEFAULT '',
    `price` varchar(255) DEFAULT NULL,
    `status` int DEFAULT 0,
    `custom` TEXT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `await` (
    `id` int NOT NULL AUTO_INCREMENT,
    `ref` varchar(255) DEFAULT NULL,
    `institution_ref` varchar(255) DEFAULT NULL,
    `contact_ref` varchar(255) DEFAULT NULL,
    `message_type` varchar(255) DEFAULT NULL,
    `message` TEXT DEFAULT '',
    `register_date` varchar(255) DEFAULT NULL,
    `update_date` varchar(255) DEFAULT NULL,
    `next_date` varchar(255) DEFAULT NULL,
    `price` varchar(255) DEFAULT NULL,
    `custom` TEXT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `template` (
    `id` int NOT NULL AUTO_INCREMENT,
    `institution_ref` varchar(255) DEFAULT NULL,
    `register_date` varchar(255) DEFAULT NULL,
    `update_date` varchar(255) DEFAULT NULL,
    `message_type` varchar(255) DEFAULT NULL, 
    `message_template` TEXT DEFAULT '',
    `custom` TEXT,
    PRIMARY KEY (`id`)
);

CREATE TABLE `template_default` (
    `id` int NOT NULL AUTO_INCREMENT,
    `institution_ref` varchar(255) DEFAULT NULL,
    `register_date` varchar(255) DEFAULT NULL,
    `update_date` varchar(255) DEFAULT NULL,
    `message_type` varchar(255) DEFAULT NULL, 
    `message_template` TEXT DEFAULT '',
    `custom` TEXT,
    PRIMARY KEY (`id`)
);

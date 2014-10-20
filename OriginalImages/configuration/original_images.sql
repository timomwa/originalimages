CREATE TABLE `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT '0',
  `isPublic` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;


CREATE TABLE `caption` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `timeStamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `caption` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_album_image` (`image_id`,`album_id`,`user_id`),
  UNIQUE KEY `user_album_image_timestamp` (`timeStamp`,`image_id`,`album_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=latin1;


CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `imageUrl` varchar(260) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `dateCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;


CREATE TABLE `page_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `div_id` varchar(45) DEFAULT NULL,
  `content` text,
  `url` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_div_id` (`div_id`,`url`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(90) DEFAULT NULL,
  `dateRegistered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` int(11) DEFAULT '-1',
  `email_address` varchar(60) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_address_UNIQUE` (`email_address`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



CREATE TABLE `email_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `album_id` int(11) DEFAULT '-1',
  `subject` varchar(100) DEFAULT NULL,
  `message` text,
  `dateCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `successful` tinyint(1) DEFAULT '0',
  `dateSent` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_album` (`user_id`,`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



INSERT INTO `user`
(`id`,
`username`,
`password`,
`dateRegistered`,
`role_id`,
`email_address`)
VALUES
(3,"original1","original1",now(),1,'info@originalimages.com');
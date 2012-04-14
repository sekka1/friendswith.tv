-- MySQL dump 10.11
--
-- Host: localhost    Database: FriendsWithTv
-- ------------------------------------------------------
-- Server version	5.0.45

DROP TABLE IF EXISTS `checkins`;
CREATE TABLE `checkins` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `content_id` varchar(256) default NULL,
  `schedule_id` varchar(256) default NULL,
  `watched_start` int(11) default NULL,
  `watched_duration` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `devices`;
CREATE TABLE `devices` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(256) default NULL,
  `user_id` int(11) default NULL,
  `created` DATETIME NULL,
  `modified` DATETIME NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `friends`;
CREATE TABLE `friends` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) default NULL,
  `friend_id` varchar(256) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `Rec`
--

DROP TABLE IF EXISTS `recs`;
CREATE TABLE `recs` (
  `id` int(11) NOT NULL auto_increment,
  `user_from_id` int(11) default NULL,
  `user_to_id` int(11) default NULL,
  `time_code` int(11) default NULL,
  `content_id` varchar(256) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL auto_increment,
  `password` varchar(256) default NULL,
  `email` varchar(256) default NULL,
  `facebook_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


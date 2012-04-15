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
-- Table structure for table `Shares`
--

DROP TABLE IF EXISTS `recs`;
DROP TABLE IF EXISTS `shares`;
CREATE TABLE `shares` (
  `id` int(11) NOT NULL auto_increment,
   `content_title` varchar(256) default NULL,
   `content_image` varchar(256) default NULL,
  `content_id` varchar(256) default NULL,
  `schedule_id` varchar(256) default NULL,
  `user_from_id` int(11) default NULL,
  `user_to_id` int(11) default NULL,
  `time_code` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `Users`
--
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `password` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `facebook_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `email`, `facebook_id`) VALUES
(2, 'Garland Kan', '90ba7d9339fc5d3eec76fd3a5dddb7e38bf24828', 'garlandk@gmail.com', 566708666),
(3, 'Bruno Tavares', '0b8b1a5e2994bb6d28ed852e2d9d77421e67034b', 'bruno@tavares.me', 1199220695),
(7, 'Joel Brass', '0b8b1a5e2994bb6d28ed852e2d9d77421e67034b', 'joel@jbrass.com', 589883853);



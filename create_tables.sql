-- phpMyAdmin SQL Dump
-- version 2.6.4-pl3
-- http://www.phpmyadmin.net
-- 
-- Host: 
-- Generation Time: Jan 21, 2014 at 03:11 PM
-- Server version: 5.1.73
-- PHP Version: 5.3.3-7+squeeze18
-- 
-- Database: `db`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `article`
-- 

CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(128) COLLATE latin1_general_ci NOT NULL,
  `content` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

-- 
-- Dumping data for table `article`
-- 

INSERT INTO `article` VALUES (6, 5, '0000-00-00 00:00:00', 'My Thoughts', 0x4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e7365637465747572206164697069736963696e6720656c69742c2073656420646f20656975736d6f642074656d706f7220696e6369646964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c697175612e20557420656e696d206164206d696e696d2076656e69616d2c2071756973206e6f737472756420657865726369746174696f6e20756c6c616d636f206c61626f726973206e69736920757420616c697175697020657820656120636f6d6d6f646f20636f6e7365717561742e2044756973206175746520697275726520646f6c6f7220696e20726570726568656e646572697420696e20766f6c7570746174652076656c697420657373652063696c6c756d20646f6c6f726520657520667567696174206e756c6c612070617269617475722e204578636570746575722073696e74206f6363616563617420637570696461746174206e6f6e2070726f6964656e742c2073756e7420696e2063756c706120717569206f666669636961206465736572756e74206d6f6c6c697420616e696d20696420657374206c61626f72756d2e);
INSERT INTO `article` VALUES (7, 5, '0000-00-00 00:00:00', 'An Update', 0x4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e7365637465747572206164697069736963696e6720656c69742c2073656420646f20656975736d6f642074656d706f7220696e6369646964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c697175612e20557420656e696d206164206d696e696d2076656e69616d2c2071756973206e6f737472756420657865726369746174696f6e20756c6c616d636f206c61626f726973206e69736920757420616c697175697020657820656120636f6d6d6f646f20636f6e7365717561742e2044756973206175746520697275726520646f6c6f7220696e20726570726568656e646572697420696e20766f6c7570746174652076656c697420657373652063696c6c756d20646f6c6f726520657520667567696174206e756c6c612070617269617475722e204578636570746575722073696e74206f6363616563617420637570696461746174206e6f6e2070726f6964656e742c2073756e7420696e2063756c706120717569206f666669636961206465736572756e74206d6f6c6c697420616e696d20696420657374206c61626f72756d2e0d0a0d0a3c623e4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e7365637465747572206164697069736963696e6720656c69742c2073656420646f20656975736d6f642074656d706f7220696e6369646964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c697175612e20557420656e696d206164206d696e696d2076656e69616d2c2071756973206e6f737472756420657865726369746174696f6e20756c6c616d636f206c61626f726973206e69736920757420616c697175697020657820656120636f6d6d6f646f20636f6e7365717561742e2044756973206175746520697275726520646f6c6f7220696e20726570726568656e646572697420696e20766f6c7570746174652076656c697420657373652063696c6c756d20646f6c6f726520657520667567696174206e756c6c612070617269617475722e204578636570746575722073696e74206f6363616563617420637570696461746174206e6f6e2070726f6964656e742c2073756e7420696e2063756c706120717569206f666669636961206465736572756e74206d6f6c6c697420616e696d20696420657374206c61626f72756d2e3c2f623e0d0a0d0a3c693e4c6f72656d20697073756d20646f6c6f722073697420616d65742c20636f6e7365637465747572206164697069736963696e6720656c69742c2073656420646f20656975736d6f642074656d706f7220696e6369646964756e74207574206c61626f726520657420646f6c6f7265206d61676e6120616c697175612e20557420656e696d206164206d696e696d2076656e69616d2c2071756973206e6f737472756420657865726369746174696f6e20756c6c616d636f206c61626f726973206e69736920757420616c697175697020657820656120636f6d6d6f646f20636f6e7365717561742e2044756973206175746520697275726520646f6c6f7220696e20726570726568656e646572697420696e20766f6c7570746174652076656c697420657373652063696c6c756d20646f6c6f726520657520667567696174206e756c6c612070617269617475722e204578636570746575722073696e74206f6363616563617420637570696461746174206e6f6e2070726f6964656e742c2073756e7420696e2063756c706120717569206f666669636961206465736572756e74206d6f6c6c697420616e696d20696420657374206c61626f72756d2e3c2f693e);

-- --------------------------------------------------------

-- 
-- Table structure for table `comments`
-- 

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` date NOT NULL,
  `article_id` int(11) NOT NULL,
  `comment` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `comments`
-- 

INSERT INTO `comments` VALUES (1, 5, '0000-00-00', 1, 0x4772656174206a6f6221);
INSERT INTO `comments` VALUES (3, 8, '0000-00-00', 2, 0x74657374);
INSERT INTO `comments` VALUES (4, 5, '0000-00-00', 6, 0x576f772c203c623e493c2f623e207468696e6b2073756368206772656174207468696e677321);
INSERT INTO `comments` VALUES (5, 14, '0000-00-00', 7, 0x457863656c6c656e74207570646174652c204e69636b21);

-- --------------------------------------------------------

-- 
-- Table structure for table `settings`
-- 

CREATE TABLE `settings` (
  `site_name` varchar(64) COLLATE latin1_general_ci NOT NULL,
  `welcome` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- 
-- Dumping data for table `settings`
-- 

INSERT INTO `settings` VALUES ('SecureCMS', '');
INSERT INTO `settings` VALUES ('NicksSite', 0x426c6168);
INSERT INTO `settings` VALUES ('SecureCMS', 0x57656c636f6d6521);

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(64) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(64) COLLATE latin1_general_ci NOT NULL,
  `join_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `is_admin` tinyint(1) NOT NULL,
  `email` varchar(128) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` VALUES (5, 'nick', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '2014-01-21 16:08:26', 1, 'n.ginsbe3@jhu.edu');
INSERT INTO `users` VALUES (12, 'user1', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '0000-00-00 00:00:00', 0, '');
INSERT INTO `users` VALUES (11, 'user1', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '0000-00-00 00:00:00', 0, 'user@doingthings.com');
INSERT INTO `users` VALUES (10, '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '0000-00-00 00:00:00', 0, '');
INSERT INTO `users` VALUES (13, '', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '0000-00-00 00:00:00', 0, '');
INSERT INTO `users` VALUES (14, 'user2', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '0000-00-00 00:00:00', 0, 'user2@blah.com');
INSERT INTO `users` VALUES (15, 'user2', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '0000-00-00 00:00:00', 0, '');
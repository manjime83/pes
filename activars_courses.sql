-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-01-2011 a las 19:15:16
-- Versión del servidor: 5.0.91
-- Versión de PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: 'activars_courses'
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'administrators'
--

CREATE TABLE administrators (
  id int(10) unsigned NOT NULL auto_increment,
  email varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  timezone varchar(32) NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY email_UNIQUE (email)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla 'administrators'
--

INSERT INTO administrators (id, email, `password`, `name`, timezone) VALUES
(1, 'admin@privateenglishsystem.com', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'America/Bogota'),
(2, 'gina.victoria@privateenglishsystem.com', '405bfe997461a9a6375583a8d2fa325c', 'Gina Victoria', 'America/Bogota');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'lessons'
--

CREATE TABLE lessons (
  id int(10) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla 'lessons'
--

INSERT INTO lessons (id, `name`) VALUES
(1, 'TUTOR 1B'),
(2, 'TEACHER 1B'),
(3, 'TUTOR 1S'),
(4, 'TEACHER 1S'),
(5, 'TUTOR 1G'),
(6, 'TEACHER 1G'),
(7, 'TUTOR 2B'),
(8, 'TEACHER 2B'),
(9, 'TUTOR 2S'),
(10, 'TEACHER 2S'),
(11, 'TUTOR 2G'),
(12, 'TEACHER 2G'),
(13, 'TUTOR 3B'),
(14, 'TEACHER 3B'),
(15, 'TUTOR 3S'),
(16, 'TEACHER 3S'),
(17, 'TUTOR 3G'),
(18, 'TEACHER 3G'),
(19, 'TUTOR 4B'),
(20, 'TEACHER 4B'),
(21, 'TUTOR 4S'),
(22, 'TEACHER 4S'),
(23, 'TUTOR 4G'),
(24, 'TEACHER 4G'),
(25, 'TUTOR 5B'),
(26, 'TEACHER 5B'),
(27, 'TUTOR 5S'),
(28, 'TEACHER 5S'),
(29, 'TUTOR 5G'),
(30, 'TEACHER 5G'),
(31, 'ADVICING LEVEL A1'),
(32, 'TUTOR 6B'),
(33, 'TEACHER 6B'),
(34, 'TUTOR 6S'),
(35, 'TEACHER 6S'),
(36, 'TUTOR 6G'),
(37, 'TEACHER 6G'),
(38, 'TUTOR 7B'),
(39, 'TEACHER 7B'),
(40, 'TUTOR 7S'),
(41, 'TEACHER 7S'),
(42, 'TUTOR 7G'),
(43, 'TEACHER 7G'),
(44, 'TUTOR 8B'),
(45, 'TEACHER 8B'),
(46, 'TUTOR 8S'),
(47, 'TEACHER 8S'),
(48, 'TUTOR 8G'),
(49, 'TEACHER 8G'),
(50, 'TUTOR 9B'),
(51, 'TEACHER 9B'),
(52, 'TUTOR 9S'),
(53, 'TEACHER 9S'),
(54, 'TUTOR 9G'),
(55, 'TEACHER 9G'),
(56, 'TUTOR 10B'),
(57, 'TEACHER 10B'),
(58, 'TUTOR 10S'),
(59, 'TEACHER 10S'),
(60, 'TUTOR 10G'),
(61, 'TEACHER 10G'),
(62, 'ADVICING LEVEL A2'),
(63, 'TUTOR 11B'),
(64, 'TEACHER 11B'),
(65, 'TUTOR 11S'),
(66, 'TEACHER 11S'),
(67, 'TUTOR 11G'),
(68, 'TEACHER 11G'),
(69, 'TUTOR 12B'),
(70, 'TEACHER 12B'),
(71, 'TUTOR 12S'),
(72, 'TEACHER 12S'),
(73, 'TUTOR 12G'),
(74, 'TEACHER 12G'),
(75, 'TUTOR 13B'),
(76, 'TEACHER 13B'),
(77, 'TUTOR 13S'),
(78, 'TEACHER 13S'),
(79, 'TUTOR 13G'),
(80, 'TEACHER 13G'),
(81, 'TUTOR 14B'),
(82, 'TEACHER 14B'),
(83, 'TUTOR 14S'),
(84, 'TEACHER 14S'),
(85, 'TUTOR 14G'),
(86, 'TEACHER 14G'),
(87, 'TUTOR 15B'),
(88, 'TEACHER 15B'),
(89, 'TUTOR 15S'),
(90, 'TEACHER 15S'),
(91, 'TUTOR 15G'),
(92, 'TEACHER 15G'),
(93, 'ADVICING LEVEL B1'),
(94, 'TUTOR 16B'),
(95, 'TEACHER 16B'),
(96, 'TUTOR 16S'),
(97, 'TEACHER 16S'),
(98, 'TUTOR 16G'),
(99, 'TEACHER 16G'),
(100, 'TUTOR 17B'),
(101, 'TEACHER 17B'),
(102, 'TUTOR 17S'),
(103, 'TEACHER 17S'),
(104, 'TUTOR 17G'),
(105, 'TEACHER 17G'),
(106, 'TUTOR 18B'),
(107, 'TEACHER 18B'),
(108, 'TUTOR 18S'),
(109, 'TEACHER 18S'),
(110, 'TUTOR 18G'),
(111, 'TEACHER 18G'),
(112, 'TUTOR 19B'),
(113, 'TEACHER 19B'),
(114, 'TUTOR 19S'),
(115, 'TEACHER 19S'),
(116, 'TUTOR 19G'),
(117, 'TEACHER 19G'),
(118, 'TUTOR 20B'),
(119, 'TEACHER 20B'),
(120, 'TUTOR 20S'),
(121, 'TEACHER 20S'),
(122, 'TUTOR 20G'),
(123, 'TEACHER 20G'),
(124, 'ADVICING LEVEL B2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'students'
--

CREATE TABLE students (
  id int(10) unsigned NOT NULL auto_increment,
  email varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `code` varchar(8) NOT NULL,
  `name` varchar(64) NOT NULL,
  timezone varchar(32) NOT NULL,
  teacher_id int(10) unsigned NOT NULL,
  is_active tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (id),
  UNIQUE KEY email (email)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla 'students'
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'teachers'
--

CREATE TABLE teachers (
  id int(10) unsigned NOT NULL auto_increment,
  email varchar(64) NOT NULL,
  `password` varchar(32) NOT NULL,
  `code` varchar(8) NOT NULL,
  `name` varchar(64) NOT NULL,
  timezone varchar(32) NOT NULL,
  nickname varchar(32) NOT NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY email (email),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla 'teachers'
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla 'teachers_schedules'
--

CREATE TABLE teachers_schedules (
  id int(10) unsigned NOT NULL auto_increment,
  teacher_id int(10) unsigned NOT NULL,
  `datetime` datetime NOT NULL,
  student_id int(10) unsigned default NULL,
  lesson_id int(10) unsigned default NULL,
  student_attendance tinyint(1) default NULL,
  teacher_name varchar(64) default NULL,
  teacher_comment text,
  teacher_comment_datetime datetime default NULL,
  student_comment text,
  student_comment_datetime datetime default NULL,
  student_stars tinyint(1) unsigned default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY teacher_id (teacher_id,`datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla 'teachers_schedules'
--


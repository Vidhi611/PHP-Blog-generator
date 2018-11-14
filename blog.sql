-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2018 at 05:29 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `postID` int(11) UNSIGNED NOT NULL,
  `postTitle` varchar(255) DEFAULT NULL,
  `postDesc` text,
  `postCont` text,
  `postDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`postID`, `postTitle`, `postDesc`, `postCont`, `postDate`) VALUES
(1, 'ICRAIE  2018', '<p>Third International Conference ICRAIE-2018 has been added with Call for Workshops and Call for Tutorials that aims to bring together the Academicians, Researchers, and Industry Experts in areas of Computer Science & Information Technology.</p>', '<h2>ICRAIE 2018</h2>\r\n<p>hird International Conference ICRAIE-2018 has been added with Call for Workshops and Call for Tutorials that aims to bring together the Academicians, Researchers, and Industry Experts in areas of Computer Science & Information Technology, Electronics & Communication Engineering and Electrical Engineering for dissemination of original research, new innovations and ideas at International Platform, have larger scope of participation for renowned organizations in India and abroad through organizing workshops. MNIT Jaipur is again a new organizing partner added to this event. This will also provide a forum for sharing insights, experiences and interactions on various aspects of evolving engineering technologies and patterns.</p>', '2018-05-29 00:00:00'),
(2, 'ICISS2019 ', '<p> International Conference on Intelligent Sustainable Systems\r\n21 Feb 2019 - 22 Feb 2019 • Palladam, India</p>', '<p>2nd International Conference on Intelligent Sustainable Systems (ICISS 2019) is being organized on February 21-22, 2019 by SCAD Institute of Technology at Palladam, Tirupur, India -641 664 .Sustainable Systems 2019 will provide an outstanding international forum for scientists from all over the world to share ideas and achievements in the theory and practice of all areas of inventive systems which includes artificial intelligence, automation systems, computing systems, electronics systems, electrical and informative systems etc. Presentations should highlight computing methodologies as a concept that combines theoretical research and applications in automation, information and computing technologies. All aspects of Sustainable systems are of interest: theory, algorithms, tools, applications, etc. </p>', '2018-06-06 08:28:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`postID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `postID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

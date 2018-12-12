-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 24, 2018 at 07:04 PM
-- Server version: 8.0.11
-- PHP Version: 7.1.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `a-level-project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adminID` int(11) NOT NULL,
  `adminFirstName` varchar(50) NOT NULL,
  `adminLastName` varchar(50) NOT NULL,
  `adminEmailAddress` varchar(100) NOT NULL,
  `adminPassword` varchar(32) NOT NULL,
  `adminLevel` enum('1','2') CHARACTER SET utf8mb4 NOT NULL DEFAULT '2',
  `adminSignUpDate` date NOT NULL,
  `adminStatus` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminID`, `adminFirstName`, `adminLastName`, `adminEmailAddress`, `adminPassword`, `adminLevel`, `adminSignUpDate`, `adminStatus`) VALUES
(1, 'Serena', 'Lambert', 'serenalambert1731@gmail.com', '0ac619fa27d3938ce57b4a177701c768', '1', '2018-11-21', 'active'),
(2, 'Bruce', 'Wayne', 'batman@gotham.net', 'e10adc3949ba59abbe56e057f20f883e', '2', '2018-11-21', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `companyID` int(11) NOT NULL,
  `companyName` varchar(100) NOT NULL,
  `companyEmailAddress` varchar(100) NOT NULL,
  `companyPassword` varchar(32) NOT NULL,
  `companyOffersWorkExperience` enum('yes','no') NOT NULL,
  `companyAbout` varchar(500) NOT NULL,
  `companyWorkExperienceDescription` varchar(500) DEFAULT NULL,
  `companyWorkExperienceRequirements` varchar(500) DEFAULT NULL,
  `companySignUpDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`companyID`, `companyName`, `companyEmailAddress`, `companyPassword`, `companyOffersWorkExperience`, `companyAbout`, `companyWorkExperienceDescription`, `companyWorkExperienceRequirements`, `companySignUpDate`) VALUES
(6, 'Fender', 'fender@guitars.com', 'e10adc3949ba59abbe56e057f20f883e', 'yes', 'We are the best guitar company in the world.', 'We would like to provide the opportunity for teenagers to shadow our employees in a number of roles including our technicians, creative team and our engineers.', 'The student would need to be at least 14 years old, be available from 9am to 5pm Sunday to Thursday over 1 week. They would also benefit from having some understanding of electric guitars.', '2018-11-12'),
(7, 'StarLabs', 'harry@starlabs.com', 'e10adc3949ba59abbe56e057f20f883e', 'yes', 'We are awesome and build cool stuff.', 'Come build cool stuff with us!', 'None. The speed force would be preferable but non essential.', '2018-11-12'),
(8, 'Starbucks', 'coffee4life@starbucks.com', 'e10adc3949ba59abbe56e057f20f883e', 'yes', 'We are a coffee shop that can be found all around the world.', 'Students can see what it is like to work in a real coffeeshop. We will show them how to operate all the coffee machines and guide them how to wait tables and clean the cafe.', 'The student should be available in the evenings (around 5-8) a few days in a row ideally. They must love coffee!', '2018-11-12'),
(9, 'Apple', 'steve@apple.com', 'e10adc3949ba59abbe56e057f20f883e', 'no', 'We are Apple and we are awesome.', '', '', '2018-11-14'),
(10, 'Testcompany', 'test@company.com', 'e10adc3949ba59abbe56e057f20f883e', 'no', 'Test company...', '', '', '2018-11-24');

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `conversationID` int(11) NOT NULL,
  `conversationStudentID` int(11) NOT NULL,
  `conversationCompanyID` int(11) NOT NULL,
  `conversationJobID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`conversationID`, `conversationStudentID`, `conversationCompanyID`, `conversationJobID`) VALUES
(5, 23, 7, 10),
(6, 23, 9, 11),
(7, 23, 9, 13),
(8, 23, 9, 14);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `jobID` int(11) NOT NULL,
  `jobCompanyID` int(11) NOT NULL,
  `jobTitle` varchar(100) NOT NULL,
  `jobDescription` varchar(500) NOT NULL,
  `jobRequirements` varchar(500) NOT NULL,
  `jobWages` varchar(100) NOT NULL,
  `jobTimings` varchar(500) CHARACTER SET utf8mb4 NOT NULL,
  `jobLocation` varchar(100) NOT NULL DEFAULT 'Location not specified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`jobID`, `jobCompanyID`, `jobTitle`, `jobDescription`, `jobRequirements`, `jobWages`, `jobTimings`, `jobLocation`) VALUES
(10, 7, 'Speedster', 'Run really fast and fight crime.', 'The speed force and a cool suit', 'Glory', 'Any time of day or night', 'Central city'),
(11, 9, 'iPhone tester', 'Test iphones.', 'Good knowledge of iOS', 'TBC', '6-8pm Sunday - Thursday', 'The apple store.'),
(12, 7, 'Gadget maker', 'Make loads of awesome gadgets to help take down meta humans.', 'Be good at making stuff', 'TBC', 'Whenever needed', 'Star labs HQ'),
(13, 9, 'Junior Designer', 'Work alongside our senior designers to devise new product ideas and produce initial sketches.', 'Creative and good knowledge of design software.', 'TBC (depends on experience)', 'TBC', 'Apple in Al Qouz'),
(14, 9, 'water-skier ', 'Professional trick water ski expert', 'To be dada', 'pride and glory', 'all day every day', 'the sea');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `messageID` int(11) NOT NULL,
  `messageConversationID` int(11) NOT NULL,
  `messageSenderID` int(11) NOT NULL,
  `messageContent` varchar(1000) NOT NULL,
  `messageTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageID`, `messageConversationID`, `messageSenderID`, `messageContent`, `messageTime`) VALUES
(32, 5, 23, 'To Star Labs, \nMy name is Barry Allen and I am interested in your opportunity to become a speedster.', '2018-11-24 16:07:47'),
(33, 5, 7, 'Hi Barry,\nThank you for your interest. Do you meet the job requirements?', '2018-11-24 16:13:13'),
(34, 5, 23, 'Yes. Since the explosion at Star Labs, I have had the speed force.', '2018-11-24 16:13:54');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentID` int(11) NOT NULL,
  `studentFirstName` varchar(100) NOT NULL,
  `studentLastName` varchar(100) NOT NULL,
  `studentEmailAddress` varchar(100) NOT NULL,
  `studentPassword` varchar(32) NOT NULL,
  `studentDateOfBirth` date NOT NULL,
  `studentSignUpDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentID`, `studentFirstName`, `studentLastName`, `studentEmailAddress`, `studentPassword`, `studentDateOfBirth`, `studentSignUpDate`) VALUES
(15, 'Bruce', 'Wayne', 'batman@gotham.net', 'e10adc3949ba59abbe56e057f20f883e', '1974-01-30', '2018-11-11'),
(17, 'Steve', 'Rogers', 'cap@america.org', 'e10adc3949ba59abbe56e057f20f883e', '1981-06-13', '2018-11-11'),
(22, 'Bruce', 'Banner', 'hulk@incredible.net', 'e10adc3949ba59abbe56e057f20f883e', '1967-11-22', '2018-11-11'),
(23, 'Barry', 'Allen', 'flash@starlabs.com', 'e10adc3949ba59abbe56e057f20f883e', '1990-01-14', '2018-11-11'),
(24, 'Anelisa', 'Lambert', 'anelisalambert@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1969-09-25', '2018-11-12'),
(29, 'Julian', 'Lambert', 'julianlambert77@gmail.com', 'e703d06181288eb148a9257af1f31881', '1969-01-02', '2018-11-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`companyID`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversationID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jobID`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `companyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `jobID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

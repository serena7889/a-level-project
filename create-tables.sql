CREATE TABLE `admins` (
  `adminID` int(11) NOT NULL,
  `adminFirstName` varchar(25) NOT NULL,
  `adminLastName` varchar(25) NOT NULL,
  `adminEmailAddress` varchar(100) NOT NULL,
  `adminPassword` varchar(32) NOT NULL,
  `adminLevel` enum('1','2') NOT NULL DEFAULT '2',
  `adminSignUpDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `applications` (
  `applicationID` int(11) NOT NULL,
  `applicationConversationID` int(11) NOT NULL,
  `applicationStatus` enum('accepted','declined','undecided') NOT NULL DEFAULT 'undecided',
  `applicationDate` date NOT NULL,
  `applicationLatestChangeDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `companies` (
  `companyID` int(11) NOT NULL,
  `companyName` varchar(50) NOT NULL,
  `companyEmailAddress` varchar(100) NOT NULL,
  `companyPassword` varchar(32) NOT NULL,
  `companyOffersWorkExperience` enum('yes','no') NOT NULL,
  `companyAbout` varchar(1000) NOT NULL,
  `companyWorkExperienceDescription` varchar(1000) NOT NULL,
  `companyWorkExperienceRequirements` varchar(1000) NOT NULL,
  `companySignUpDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `conversations` (
  `conversationID` int(11) NOT NULL,
  `conversationStudentID` int(11) NOT NULL,
  `conversationCompanyID` int(11) NOT NULL,
  `conversationJobID` int(11) DEFAULT NULL,
  `conversationLatestTime` datetime NOT NULL,
  `conversationActive` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `jobs` (
  `jobID` int(11) NOT NULL,
  `jobCompanyID` int(11) NOT NULL,
  `jobTitle` varchar(100) NOT NULL,
  `jobDescription` varchar(1000) NOT NULL,
  `jobRequirements` varchar(1000) NOT NULL,
  `jobWages` varchar(100) NOT NULL,
  `jobTimings` varchar(100) NOT NULL,
  `jobLocation` varchar(100) NOT NULL,
  `jobActive` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `messages` (
  `messageID` int(11) NOT NULL,
  `messageConversationID` int(11) NOT NULL,
  `messageContent` varchar(1000) NOT NULL,
  `messageTime` datetime NOT NULL,
  `messageSender` enum('student','company') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `students` (
  `studentID` int(11) NOT NULL,
  `studentFirstName` varchar(25) NOT NULL,
  `studentLastName` varchar(25) NOT NULL,
  `studentEmailAddress` varchar(100) NOT NULL,
  `studentPassword` varchar(32) NOT NULL,
  `studentDateOfBirth` date NOT NULL,
  `studentSignUpDate` date NOT NULL,
  `studentCV` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

ALTER TABLE `admins`
  ADD PRIMARY KEY (`adminID`);

ALTER TABLE `applications`
  ADD PRIMARY KEY (`applicationID`),
  ADD KEY `applicationConversationID` (`applicationConversationID`);

ALTER TABLE `companies`
  ADD PRIMARY KEY (`companyID`);

ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversationID`),
  ADD KEY `conversationStudentID` (`conversationStudentID`),
  ADD KEY `conversationCompanyID` (`conversationCompanyID`),
  ADD KEY `conversationJobID` (`conversationJobID`);

ALTER TABLE `jobs`
  ADD PRIMARY KEY (`jobID`),
  ADD KEY `jobCompanyID` (`jobCompanyID`);

ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageID`),
  ADD KEY `messageConversationID` (`messageConversationID`);

ALTER TABLE `students`
  ADD PRIMARY KEY (`studentID`);

ALTER TABLE `admins`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `applications`
  MODIFY `applicationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `companies`
  MODIFY `companyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `conversations`
  MODIFY `conversationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

ALTER TABLE `jobs`
  MODIFY `jobID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `messages`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

ALTER TABLE `students`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;


ALTER TABLE `applications`
  ADD CONSTRAINT `applicationConversationID` FOREIGN KEY (`applicationConversationID`) REFERENCES `conversations` (`conversationid`);

ALTER TABLE `conversations`
  ADD CONSTRAINT `conversationCompanyID` FOREIGN KEY (`conversationCompanyID`) REFERENCES `companies` (`companyid`),
  ADD CONSTRAINT `conversationJobID` FOREIGN KEY (`conversationJobID`) REFERENCES `jobs` (`jobid`),
  ADD CONSTRAINT `conversationStudentID` FOREIGN KEY (`conversationStudentID`) REFERENCES `students` (`studentid`);

ALTER TABLE `jobs`
  ADD CONSTRAINT `jobCompanyID` FOREIGN KEY (`jobCompanyID`) REFERENCES `companies` (`companyid`);

ALTER TABLE `messages`
  ADD CONSTRAINT `messageConversationID	` FOREIGN KEY (`messageConversationID`) REFERENCES `conversations` (`conversationid`);
COMMIT;

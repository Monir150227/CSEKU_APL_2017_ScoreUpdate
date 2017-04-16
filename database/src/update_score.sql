-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2017 at 10:35 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `update_score`
--

-- --------------------------------------------------------

--
-- Table structure for table `m_atch`
--

CREATE TABLE `m_atch` (
  `match_id` int(11) NOT NULL,
  `team_Aid` int(11) DEFAULT NULL,
  `team_Bid` int(11) DEFAULT NULL,
  `toss` int(11) DEFAULT NULL,
  `overs` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_atch`
--

INSERT INTO `m_atch` (`match_id`, `team_Aid`, `team_Bid`, `toss`, `overs`) VALUES
(44, 147, 148, 148, 1);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `player_id` int(11) NOT NULL,
  `player_name` varchar(30) DEFAULT NULL,
  `tem_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`player_id`, `player_name`, `tem_id`) VALUES
(577, 'A', 147),
(578, 'B', 147),
(579, 'C', 147),
(580, 'd', 147),
(581, 'E', 147),
(582, 'f', 147),
(583, 'g', 147),
(584, 'h', 147),
(585, 'i', 147),
(586, 'j', 147),
(587, 'k', 147),
(588, 'l', 147),
(589, 'AB', 148),
(590, 'BC', 148),
(591, 'CD', 148),
(592, 'DE', 148),
(593, 'EF', 148),
(594, 'FG', 148),
(595, 'GH', 148),
(596, 'HI', 148),
(597, 'IH', 148),
(598, 'JK', 148),
(599, 'KL', 148),
(600, 'KVJ', 148);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `bat_run` int(11) DEFAULT '0',
  `played_ball` int(11) DEFAULT '0',
  `hitted_fours` int(11) DEFAULT '0',
  `hitted_sixes` int(11) DEFAULT '0',
  `bowlruns` int(11) DEFAULT '0',
  `bowled_overs` int(11) DEFAULT '0',
  `wicket` int(11) DEFAULT '0',
  `extra` int(11) DEFAULT '0',
  `out_type` varchar(255) DEFAULT NULL,
  `stricking_role` int(11) DEFAULT NULL,
  `match_id` int(11) DEFAULT NULL,
  `toss` int(11) DEFAULT NULL,
  `extra_wicket` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `player_id`, `bat_run`, `played_ball`, `hitted_fours`, `hitted_sixes`, `bowlruns`, `bowled_overs`, `wicket`, `extra`, `out_type`, `stricking_role`, `match_id`, `toss`, `extra_wicket`) VALUES
(309, 589, 5, 2, 1, 0, 0, 0, 0, 0, 'Not out', 0, 44, 148, 0),
(310, 590, 0, 1, 0, 0, 0, 0, 0, 0, 'Run out', NULL, 44, 148, 0),
(311, 587, 0, 0, 0, 0, 6, 2, 0, 1, NULL, 2, 44, 147, 1);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(30) DEFAULT NULL,
  `manager_name` varchar(30) NOT NULL,
  `coach_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`team_id`, `team_name`, `manager_name`, `coach_name`) VALUES
(147, 'KU_Super', 'Sarfarz Newaz', 'Kamal Hossain'),
(148, 'RU_Vaikings', 'Kamal Hossain', 'Siddiq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_atch`
--
ALTER TABLE `m_atch`
  ADD PRIMARY KEY (`match_id`),
  ADD KEY `team_Aid` (`team_Aid`),
  ADD KEY `team_Bid` (`team_Bid`),
  ADD KEY `match_id` (`match_id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`player_id`),
  ADD KEY `tem_id` (`tem_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`),
  ADD KEY `match_id` (`match_id`),
  ADD KEY `player_id` (`player_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`team_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_atch`
--
ALTER TABLE `m_atch`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=601;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=312;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_atch`
--
ALTER TABLE `m_atch`
  ADD CONSTRAINT `m_atch_ibfk_1` FOREIGN KEY (`team_Aid`) REFERENCES `team` (`team_id`),
  ADD CONSTRAINT `m_atch_ibfk_2` FOREIGN KEY (`team_Bid`) REFERENCES `team` (`team_id`);

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`tem_id`) REFERENCES `team` (`team_id`);

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `status_ibfk_2` FOREIGN KEY (`match_id`) REFERENCES `m_atch` (`match_id`),
  ADD CONSTRAINT `status_ibfk_3` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

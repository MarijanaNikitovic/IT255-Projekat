-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2018 at 01:47 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `it255baza`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `korisnik_id` int(11) NOT NULL,
  `korisnicko_ime` varchar(50) NOT NULL,
  `lozinka` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `adresa` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `token` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`korisnik_id`, `korisnicko_ime`, `lozinka`, `email`, `adresa`, `role`, `token`, `role_id`) VALUES
(1, 'marijana', '6c2b892cc2d156c0937af713615bd032', 'marijanamajanikitovic@gmail.com', 'adresa', 'admin', '600ff5d5f0e7ffed64cf6cb2a50e93b0683f7867', 1),
(2, 'snezana', 'ead8f32e61302ee22f2966eaadb26c13', 'marijanamajanikitovic@gmail.com', 'Nemanjina 25', '', 'e476667e519bcbbba4a210fe8d0e4dd10098c0ce', 1);

-- --------------------------------------------------------

--
-- Table structure for table `porudzbina`
--

CREATE TABLE `porudzbina` (
  `porudzbina_id` int(11) NOT NULL,
  `korisnik_id` int(11) NOT NULL,
  `sifra` int(11) DEFAULT NULL,
  `flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `porudzbina`
--

INSERT INTO `porudzbina` (`porudzbina_id`, `korisnik_id`, `sifra`, `flag`) VALUES
(2, 2, 3, 2),
(13, 1, NULL, 2),
(14, 1, NULL, 2),
(15, 1, NULL, 2),
(16, 1, NULL, 2),
(17, 1, NULL, 2),
(18, 1, NULL, 2),
(19, 1, NULL, 2),
(20, 1, NULL, 2),
(21, 1, NULL, 2),
(22, 1, NULL, 2),
(23, 1, NULL, 2),
(24, 1, NULL, 2),
(25, 1, NULL, 2),
(26, 1, NULL, 2),
(27, 1, NULL, 2),
(28, 1, NULL, 2),
(29, 1, NULL, 2),
(30, 1, NULL, 2),
(31, 1, NULL, 2),
(32, 1, NULL, 2),
(34, 1, 5, 2),
(35, 2, 3, 2),
(36, 2, NULL, 2),
(37, 2, 3, 2),
(38, 2, NULL, 1),
(39, 2, 3, 1),
(40, 2, 3, 1),
(41, 2, 3, 1),
(42, 2, 5, 1),
(44, 1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `proizvod`
--

CREATE TABLE `proizvod` (
  `sifra` int(11) NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `opis` varchar(60) NOT NULL,
  `cena` float NOT NULL,
  `slika` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proizvod`
--

INSERT INTO `proizvod` (`sifra`, `naziv`, `opis`, `cena`, `slika`) VALUES
(3, 'Sijalica', 'Stedna sijalica', 700, 'http://localhost/slike/sijalica.jpg'),
(4, 'Luster', 'Sa tri kugle', 5000, 'http://localhost/slike/luster.jpg'),
(5, 'Kabl', 'Licnasti 2x3', 10, 'http://localhost/slike/kabl.jpg'),
(8, 'Zabice', 'Za elektro kablove', 50, 'http://localhost/slike/zabice.png'),
(10, 'Solarna lampa', 'Za bastu', 2000, 'http://localhost/slike/solarnalampa.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`korisnik_id`);

--
-- Indexes for table `porudzbina`
--
ALTER TABLE `porudzbina`
  ADD PRIMARY KEY (`porudzbina_id`),
  ADD KEY `sifra` (`sifra`),
  ADD KEY `korisnik_id` (`korisnik_id`);

--
-- Indexes for table `proizvod`
--
ALTER TABLE `proizvod`
  ADD PRIMARY KEY (`sifra`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `korisnik_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `porudzbina`
--
ALTER TABLE `porudzbina`
  MODIFY `porudzbina_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `proizvod`
--
ALTER TABLE `proizvod`
  MODIFY `sifra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `porudzbina`
--
ALTER TABLE `porudzbina`
  ADD CONSTRAINT `korisnik_id` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`korisnik_id`),
  ADD CONSTRAINT `sifra` FOREIGN KEY (`sifra`) REFERENCES `proizvod` (`sifra`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 03:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tacktime`
--

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `idProduct` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `idProduct`, `cantidad`, `ciudad`) VALUES
(63, 'Marcela ', '', '', 0, ''),
(65, 'Ferney', 'Calle', '', 200, 'Cali'),
(66, 'Valerie Rodríguez', 'Calle 87 96-51', '30', 400, 'Cali'),
(67, 'Mailo josé', 'Casa 84', '27', 2, 'Bogotá'),
(68, 'Dios Mío', 'Cielos 123', '', 300, 'Cali'),
(69, 'Carlos Vargas', 'Calle 87 96-51', '18', 200, 'Cali'),
(70, 'Rosa Ramirez', 'Boda centro', '24', 200, 'Cali'),
(71, 'Val Vega', 'Calle 87 96-51', '29', 200, 'Cali vea'),
(72, 'Rocio Vega', 'Calle 87 96 51', '23', 200, 'Bogotá'),
(73, 'Mailooo', 'Calle', '25', 2000, 'Cali'),
(74, 'Mafe Sanabria', '', '', 0, ''),
(75, 'Mafe Sanabria', 'Calle 90', '26', 200, 'CAli'),
(76, 'Cristo Rey', 'Carrera 80 95.12', '23', 300, 'Cali');

-- --------------------------------------------------------

--
-- Table structure for table `infoadmin`
--

CREATE TABLE `infoadmin` (
  `idA` bigint(20) UNSIGNED NOT NULL,
  `fechaProgramado` date NOT NULL,
  `fechaDisenio` date NOT NULL,
  `fechaCorte` date NOT NULL,
  `fechaConfeccon` date NOT NULL,
  `fechaRevfinal` date NOT NULL,
  `progressValue` varchar(10) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `transportadora` varchar(100) NOT NULL,
  `fechaDespacho` date NOT NULL,
  `fechaRecibido` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `infoadmin`
--

INSERT INTO `infoadmin` (`idA`, `fechaProgramado`, `fechaDisenio`, `fechaCorte`, `fechaConfeccon`, `fechaRevfinal`, `progressValue`, `idCliente`, `transportadora`, `fechaDespacho`, `fechaRecibido`) VALUES
(109, '2024-11-18', '2024-11-18', '2024-11-18', '2024-11-18', '2024-11-18', '100', 66, 'T Torres', '2024-11-18', '2024-11-18'),
(110, '2024-11-18', '2024-11-20', '2024-11-20', '2024-11-22', '2024-11-20', '100', 67, 'Servientrega', '0000-00-00', '0000-00-00'),
(111, '2024-11-18', '2024-11-19', '2024-11-19', '2024-11-19', '2024-11-19', '100', 68, 'Servientrega', '2024-11-19', '0000-00-00'),
(112, '2024-11-18', '2024-11-21', '2024-11-21', '2024-11-21', '2024-11-21', '100', 69, 'Envía', '2024-11-21', '2024-11-21'),
(116, '2024-11-20', '2024-11-21', '2024-11-21', '2024-11-21', '2024-11-21', '100', 73, 'Servientrega', '0000-00-00', '0000-00-00'),
(117, '2024-11-20', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '', 74, '', '0000-00-00', '0000-00-00'),
(119, '2024-11-20', '2024-11-21', '0000-00-00', '0000-00-00', '0000-00-00', '40', 76, '', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `infosalida`
--

CREATE TABLE `infosalida` (
  `idS` bigint(20) UNSIGNED NOT NULL,
  `fechaS` date NOT NULL,
  `producto` int(11) NOT NULL,
  `turno` int(4) NOT NULL,
  `demanda` int(16) NOT NULL,
  `calidad` int(5) NOT NULL,
  `eficiencia` int(5) NOT NULL,
  `horas` int(11) NOT NULL,
  `minutos` int(11) NOT NULL,
  `segundos` int(11) NOT NULL,
  `newTacktime` int(11) NOT NULL,
  `newCalidad` int(11) NOT NULL,
  `newEficiencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `infosalida`
--

INSERT INTO `infosalida` (`idS`, `fechaS`, `producto`, `turno`, `demanda`, `calidad`, `eficiencia`, `horas`, `minutos`, `segundos`, `newTacktime`, `newCalidad`, `newEficiencia`) VALUES
(47, '2024-11-01', 19, 1, 480, 90, 90, 8, 480, 28800, 60, 533, 49),
(50, '2024-11-13', 19, 2, 900, 90, 90, 224, 13440, 806400, 896, 1000, 726),
(53, '2024-11-14', 21, 2, 190, 90, 90, 208, 12480, 748800, 3941, 211, 3192),
(57, '2024-11-18', 26, 1, 900, 90, 90, 96, 5760, 345600, 384, 1000, 311),
(58, '2024-11-18', 23, 2, 1000, 100, 100, 240, 14400, 864000, 864, 1000, 864),
(59, '2024-11-19', 22, 2, 900, 90, 90, 240, 14400, 864000, 960, 1000, 778),
(60, '2024-11-19', 24, 3, 800, 90, 100, 24, 1440, 86400, 108, 889, 97),
(61, '2024-11-19', 18, 1, 900, 90, 90, 120, 7200, 432000, 480, 1000, 389),
(62, '2024-11-19', 23, 2, 700, 80, 90, 480, 28800, 1728000, 2469, 875, 1777),
(63, '2024-11-19', 22, 2, 900, 90, 90, 288, 17280, 1036800, 1152, 1000, 933);

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE `productos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombreProducto` varchar(10000) NOT NULL,
  `valor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `nombreProducto`, `valor`) VALUES
(18, 'Pantalones', 12000),
(20, 'Zapatos', 50000),
(22, 'Botas punta acero', 180000),
(23, 'Botas caucho', 160000),
(24, 'Arnes', 80000),
(25, 'Casco blanco', 90000),
(26, 'Gafas', 20000),
(27, 'Tapabocas', 10000),
(28, 'Overol', 80000),
(29, 'Guantes', 35000),
(30, 'Chaleco', 90000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `infoadmin`
--
ALTER TABLE `infoadmin`
  ADD PRIMARY KEY (`idA`);

--
-- Indexes for table `infosalida`
--
ALTER TABLE `infosalida`
  ADD PRIMARY KEY (`idS`),
  ADD UNIQUE KEY `idS` (`idS`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `infoadmin`
--
ALTER TABLE `infoadmin`
  MODIFY `idA` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `infosalida`
--
ALTER TABLE `infosalida`
  MODIFY `idS` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

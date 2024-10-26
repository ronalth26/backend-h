-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 25, 2024 at 04:58 AM
-- Server version: 10.11.8-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u719040383_workitout`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `nombreCategoria` varchar(100) NOT NULL,
  `descripcionCategoria` varchar(200) NOT NULL,
  `estadoCategoria` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `nombreCategoria`, `descripcionCategoria`, `estadoCategoria`) VALUES
(1, 'Remodelación y construcción', '', 1),
(2, 'Limpieza', '', 1),
(3, 'Asistencia doméstica', '', 1),
(4, 'Reparación e instalación de equipos', '', 1),
(5, 'Taller de carro, moto o cicla', '', 1),
(6, 'Servicios Profesionales', '', 1),
(7, 'Servicios de Belleza', '', 1),
(8, 'Cursos y clases', '', 1),
(9, 'Computadoras y TI', '', 1),
(10, 'Organización de eventos', '', 1),
(11, 'Servicios para mascotas', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `direccion` varchar(120) NOT NULL,
  `distrito` varchar(120) NOT NULL,
  `provincia` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `direccion`, `distrito`, `provincia`) VALUES
(1, 'direccion', 'distrito', 'provincia'),
(2, 'dsadasdsa', 'umacollo', 'Arequipa'),
(4, 'dsadasdsa', 'umacollo', 'Arequipa'),
(5, 'dsadasdsa', 'umacollo', 'Arequipa'),
(6, 'dsadasdsa', 'umacollo', 'Arequipa'),
(7, 'Micaela Bastidas Condominio Sol De Collique Block G1', 'Distrito', 'Comas'),
(8, '12 de Octubre', 'ASA', 'Arequipa'),
(10, 'Micaela Bastidas Condominio Sol De Collique Block G1', 'weqweqw', 'Comas'),
(11, 'Calle America 505', 'Arequipa', 'Arequipa');

-- --------------------------------------------------------

--
-- Table structure for table `especialista`
--

CREATE TABLE `especialista` (
  `id` int(11) NOT NULL,
  `idEspecialista` int(11) NOT NULL,
  `especialidades` varchar(1500) NOT NULL,
  `fotoIdentificacion` varchar(250) NOT NULL,
  `fotoDniFrente` varchar(250) NOT NULL,
  `fotoDniTrasera` varchar(250) NOT NULL,
  `confirmacionIdentidad` varchar(250) NOT NULL,
  `antecedentesNoPenales` varchar(250) NOT NULL,
  `evidenciasTrabajos` varchar(1500) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `especialista`
--

INSERT INTO `especialista` (`id`, `idEspecialista`, `especialidades`, `fotoIdentificacion`, `fotoDniFrente`, `fotoDniTrasera`, `confirmacionIdentidad`, `antecedentesNoPenales`, `evidenciasTrabajos`, `estado`) VALUES
(3, 17, '[2,4,8]', 'especialistas/17/identificacion_17_Captura de pantalla 2024-07-01 133536.png', 'especialistas/17/dni_frente_17_Captura de pantalla 2024-06-22 161858.png', 'especialistas/17/dni_atras_17_calificar.png', 'especialistas/17/confirmacion_17_undraw_Add_files_re_v09g.png', 'especialistas/17/antecendentes_17_terminada.png', 'especialistas/17/evidencias_17_recibo_AT3.pdf', 0),
(4, 10, '[2,6,8]', 'especialistas/10/identificacion_10_diagrama.png', 'especialistas/10/dni_frente_10_terminada.png', 'especialistas/10/dni_atras_10_trabajando.png', 'especialistas/10/confirmacion_10_diagrama.png', 'especialistas/10/antecendentes_10_trabajando.png', '', 0),
(5, 10, '[2,6,8]', 'especialistas/10/identificacion_10_diagrama.png', 'especialistas/10/dni_frente_10_terminada.png', 'especialistas/10/dni_atras_10_trabajando.png', 'especialistas/10/confirmacion_10_diagrama.png', 'especialistas/10/antecendentes_10_trabajando.png', '', 0),
(6, 17, '[2,4,8]', 'especialistas/17/identificacion_17_Captura de pantalla 2024-07-01 133536.png', 'especialistas/17/dni_frente_17_Captura de pantalla 2024-06-22 161858.png', 'especialistas/17/dni_atras_17_calificar.png', 'especialistas/17/confirmacion_17_undraw_Add_files_re_v09g.png', 'especialistas/17/antecendentes_17_terminada.png', 'especialistas/17/evidencias_17_recibo_AT3.pdf', 0),
(7, 22, '[\"3\",\"2\",\"5\"]', 'especialistas/22/identificacion_22_WhatsApp Image 2024-07-01 at 5.36.53 PM.jpeg', 'especialistas/22/dni_frente_22_WhatsApp Image 2024-07-01 at 5.36.53 PM.jpeg', 'especialistas/22/dni_atras_22_WhatsApp Image 2024-07-01 at 5.36.53 PM.jpeg', 'especialistas/22/confirmacion_22_WhatsApp Image 2024-07-01 at 5.36.53 PM.jpeg', 'especialistas/22/antecendentes_22_WhatsApp Image 2024-06-28 at 8.02.37 PM.jpeg', 'especialistas/22/evidencias_22_Yndira_Gonzales_Diagnostico (1).pdf', 0),
(8, 22, '[\"3\",\"2\",\"5\"]', 'especialistas/22/identificacion_22_WhatsApp Image 2024-07-01 at 5.36.53 PM.jpeg', 'especialistas/22/dni_frente_22_WhatsApp Image 2024-07-01 at 5.36.53 PM.jpeg', 'especialistas/22/dni_atras_22_WhatsApp Image 2024-07-01 at 5.36.53 PM.jpeg', 'especialistas/22/confirmacion_22_WhatsApp Image 2024-07-01 at 5.36.53 PM.jpeg', 'especialistas/22/antecendentes_22_WhatsApp Image 2024-06-28 at 8.02.37 PM.jpeg', 'especialistas/22/evidencias_22_Yndira_Gonzales_Diagnostico (1).pdf', 0),
(9, 21, '[\"4\",\"5\",\"1\"]', 'especialistas/21/identificacion_21_Captura de pantalla 2023-09-08 152024.png', 'especialistas/21/dni_frente_21_Modelo Estrella.PNG', 'especialistas/21/dni_atras_21_Modelo Estrella.PNG', 'especialistas/21/confirmacion_21_Modelo Estrella.PNG', 'especialistas/21/antecendentes_21_Modelo Estrella.PNG', 'especialistas/21/evidencias_21_Captura de pantalla 2023-09-08 152024.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `especialistacategoria`
--

CREATE TABLE `especialistacategoria` (
  `idEspecialista` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `negociacion_temp`
--

CREATE TABLE `negociacion_temp` (
  `idSolicitud` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idEspecialista` int(11) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `negociacion_temp`
--

INSERT INTO `negociacion_temp` (`idSolicitud`, `idCliente`, `idEspecialista`, `precio`) VALUES
(1, 1, 1, 200),
(29, 19, 20, 70),
(25, 17, 22, 150),
(24, 17, 22, 500),
(24, 17, 21, 500),
(32, 17, 22, 50),
(26, 17, 21, 150),
(42, 16, 17, 100),
(43, 24, 23, 1500),
(42, 16, 23, 800);

-- --------------------------------------------------------

--
-- Table structure for table `queja`
--

CREATE TABLE `queja` (
  `idQueja` int(11) NOT NULL,
  `idSolicitud` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `motivo` varchar(100) NOT NULL,
  `detalle` varchar(200) NOT NULL,
  `evidencia` varchar(1500) NOT NULL,
  `estadoQueja` tinyint(1) NOT NULL,
  `fechaHoraRegistro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queja`
--

INSERT INTO `queja` (`idQueja`, `idSolicitud`, `idUsuario`, `motivo`, `detalle`, `evidencia`, `estadoQueja`, `fechaHoraRegistro`) VALUES
(1, 23, 16, 'motivo', 'descripcion', 'iamgen', 0, '2024-07-02 21:09:07'),
(2, 23, 16, 'motivo', 'descripcion', 'iamgen', 0, '2024-07-02 21:18:03'),
(3, 22, 16, 'Aplicativo', 'descripcion queja', 'Array', 0, '2024-07-02 21:22:20'),
(4, 21, 16, 'Especialista', 'Nunca vino y se le pago la mitad', 'Array', 0, '2024-07-02 21:23:27'),
(5, 23, 16, 'Especialista', 'queja especialista', '', 0, '2024-07-02 21:32:54'),
(6, 22, 16, 'Aplicativo', 'dasdas', 'quejas/16_22_descarga.jfif', 0, '2024-07-02 22:03:00'),
(7, 3, 16, 'Servicio', 'Queja', 'quejas/16_3_leyes.png', 0, '2024-07-02 22:12:44'),
(8, 30, 21, 'Aplicativo', 'ssss', 'quejas/21_30_WhatsApp Image 2024-06-28 at 8.02.37 PM.jpeg', 0, '2024-07-04 23:32:11'),
(9, 31, 21, 'Aplicativo', 'falla', 'quejas/21_31_Captura de pantalla 2024-07-04 182104.png', 0, '2024-07-05 04:10:32'),
(10, 31, 21, 'Especialista', 'kkkk', 'quejas/21_31_Captura de pantalla 2023-09-08 152024.png', 0, '2024-07-05 21:00:09'),
(11, 31, 21, 'Especialista', 'kkkk', 'quejas/21_31_CUARTO AVANCE - TF - INTEGRADOR II.pdf', 0, '2024-07-05 21:00:10'),
(12, 31, 21, 'Especialista', 'kkkk', 'quejas/21_31_Captura de pantalla 2023-09-08 152024.png', 0, '2024-07-05 21:00:10'),
(13, 31, 21, 'Especialista', 'kkkk', 'quejas/21_31_Captura de pantalla 2023-09-08 152024.png', 0, '2024-07-05 21:00:11'),
(14, 40, 17, 'Aplicativo', 'Nunca vino el especialista', 'quejas/17_40_426065239_122093894264321418_5688709575454845008_n.jpg', 0, '2024-07-18 16:33:55'),
(15, 28, 17, 'Aplicativo', 'descripcion', 'quejas/17_28_logo-removebg-preview.png', 0, '2024-07-24 22:22:40'),
(16, 41, 17, 'Especialista', 'problemas', 'quejas/17_41_logo-removebg-preview.png', 0, '2024-07-24 22:30:13'),
(17, 35, 17, 'Servicio', 'dasdas', 'quejas/17_35_logo-removebg-preview.png', 0, '2024-07-24 22:33:10'),
(18, 43, 24, 'Especialista', 'No recibí un buen trato', 'quejas/24_43_Screenshot_2024-07-24-22-29-37-932_com.android.chrome.jpg', 0, '2024-07-25 03:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `servicio`
--

CREATE TABLE `servicio` (
  `idServicio` int(11) NOT NULL,
  `idCategoria` int(11) NOT NULL,
  `nombreServicio` varchar(100) NOT NULL,
  `descripcionServicio` varchar(200) NOT NULL,
  `estadoServicio` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `servicio`
--

INSERT INTO `servicio` (`idServicio`, `idCategoria`, `nombreServicio`, `descripcionServicio`, `estadoServicio`) VALUES
(1, 1, 'Renovación de departamentos y casas', '', 1),
(2, 1, 'Plomeros', '', 1),
(3, 1, 'Constructores', '', 1),
(4, 1, 'Reparación y ensamblaje de mueblería', '', 1),
(5, 1, 'Electricistas', '', 1),
(6, 1, 'Puertas y cerraduras', '', 1),
(7, 1, 'Encargado de mantenimiento', '', 1),
(8, 1, 'Pintores', '', 1),
(9, 1, 'Demolición y desmantelamiento', '', 1),
(10, 1, 'Reparación e instalación de ventanas', '', 1),
(11, 1, 'Retiro de escombros de construcción', '', 1),
(12, 1, 'Renta de herramientas', '', 1),
(13, 1, 'Obrero de construción', '', 1),
(14, 2, 'Empleada doméstica', '', 1),
(15, 2, 'Limpieza general', '', 1),
(16, 2, 'Lavandería', '', 1),
(17, 3, 'Ayuda con mudanzas', '', 1),
(18, 3, 'Cargadores', '', 1),
(19, 3, 'Eliminar basura', '', 1),
(20, 3, 'Eliminación de plagas y desinfección', '', 1),
(21, 3, 'Jardineros', '', 1),
(22, 4, 'Reparación e instalación de aires acondicionados', '', 1),
(23, 4, 'Reparación e instalación de televisores', '', 1),
(24, 4, 'Reparación, instalación y mantenimiento de electrodomésticos', '', 1),
(25, 4, 'Reparación de celulares y tablets', '', 1),
(26, 5, 'Mecanicos automotrices', '', 1),
(27, 5, 'Asitencia en el camino', '', 1),
(28, 5, 'Lavado de autos', '', 1),
(29, 5, 'Servicio de neumáticos', '', 1),
(30, 5, 'Reparación de bicicletas', '', 1),
(31, 5, 'Reparación de motos', '', 1),
(32, 5, 'Diagnóstico de vehículos', '', 1),
(33, 6, 'Niñeras/os', '', 1),
(34, 6, 'Cuidadores', '', 1),
(35, 6, 'Abogados', '', 1),
(36, 6, 'Contadores', '', 1),
(37, 6, 'Psicólogos', '', 1),
(38, 6, 'Fotógrafos', '', 1),
(39, 6, 'Editores de fotos', '', 1),
(40, 6, 'Creación y edición de videos', '', 1),
(41, 7, 'Estilistas', '', 1),
(42, 7, 'Maquillaje', '', 0),
(43, 7, 'Depilación y cera', '', 1),
(44, 7, 'Masajistas', '', 1),
(45, 7, 'Peluqueros', '', 1),
(46, 7, 'Tatuajes y piercings', '', 1),
(47, 7, 'Lifting de pestañas', '', 1),
(48, 7, 'Uñas póstizas', '', 1),
(49, 8, 'Entrenador personal', '', 1),
(50, 8, 'Clases de baile', '', 1),
(51, 8, 'Clases de musica', '', 1),
(52, 8, 'Tutores escolares', '', 1),
(53, 8, 'Preparación preescolar', '', 1),
(59, 9, 'Desarroladores', '', 1),
(60, 9, 'Creacion de sitios web', '', 1),
(61, 9, 'Reparacion de computadoras', '', 1),
(62, 9, 'Ayuda con computadoras', '', 1),
(63, 10, 'Organización de eventos', '', 1),
(64, 10, 'Anfitrión de evento', '', 1),
(65, 10, 'Decorador de eventos', '', 1),
(66, 10, 'Meseros', '', 1),
(67, 10, 'catering', '', 1),
(68, 11, 'Transporte de mascotas', '', 1),
(69, 11, 'Paseo de mascotas', '', 1),
(70, 11, 'Peluqueria para mascotas', '', 1),
(71, 11, 'Entrenamiento de mascotas', '', 1),
(72, 11, 'Mantenimiento de acuarios', '', 1),
(73, 11, 'Alojamiento de mascotas', '', 1),
(74, 11, 'Cuidado de mascotas', '', 1),
(75, 11, 'Transporte de mascotas', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `solicitud`
--

CREATE TABLE `solicitud` (
  `idSolicitud` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idEspecialista` int(11) DEFAULT NULL,
  `idServicio` int(11) DEFAULT NULL,
  `descripcion` varchar(250) NOT NULL,
  `ubicacion` varchar(100) NOT NULL,
  `lat_long` varchar(300) NOT NULL,
  `fechaHoraSolicitud` datetime NOT NULL,
  `fechaHoraAtencion` datetime NOT NULL,
  `precio` double NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `calificadaCliente` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `solicitud`
--

INSERT INTO `solicitud` (`idSolicitud`, `idCliente`, `idEspecialista`, `idServicio`, `descripcion`, `ubicacion`, `lat_long`, `fechaHoraSolicitud`, `fechaHoraAtencion`, `precio`, `estado`, `calificadaCliente`) VALUES
(3, 16, 17, 1, 'servicio de mantenimiento', 'Av. 12 de octubre 601 asa', '', '2024-06-14 17:57:24', '2024-06-13 00:57:24', 250, 3, 0),
(4, 1, NULL, 1, 'Servicio', 'Direccion', '', '2024-06-14 16:55:13', '2024-06-14 17:57:24', 200, 1, 0),
(5, 1, NULL, 15, 'Requiero la limpieza de mis oficinas , 1 vez cada semana', 'Umacollo , Urban Dance', '', '2024-06-14 17:02:53', '2024-06-21 15:02:00', 1000, 1, 0),
(9, 1, NULL, 21, 'Necesito hacer modificación de plantas en pared en mi casa , exactamente son 4x5 m de espacio ', 'Parque le avion', 'Array', '2024-06-14 17:19:18', '2024-06-21 12:17:00', 500, 1, 0),
(10, 1, NULL, 21, 'Necesito hacer modificación de plantas en pared en mi casa , exactamente son 4x5 m de espacio', 'AV. SAN MARTIN NRO 304 ', '[-16.396318953926915,-71.53779777157618]', '2024-06-14 17:21:42', '2024-06-14 16:21:00', 500, 1, 0),
(11, 1, NULL, 50, 'fffffff', 'Av. 12 de octubre #601 alto Selva Alegre ', '[51.505,-0.09]', '2024-06-14 19:59:09', '2024-06-29 14:58:00', 50, 1, 0),
(12, 1, NULL, 15, 'Limpiar oficinas', 'Utp arequipa', '[-16.40860783128439,-71.53992180987555]', '2024-06-14 20:42:25', '2024-06-22 17:42:00', 50, 1, 0),
(13, 1, NULL, 60, 'Necesito crear una landing page', 'Torres de la alameda Arequipa', '[-16.3914282,-71.5120398]', '2024-06-14 21:11:08', '2024-06-28 16:10:00', 50, 1, 0),
(14, 9, NULL, 2, 'descripcion', 'Utp arequipa', '[-16.4089733,-71.54043013948564]', '2024-06-14 21:42:41', '2024-06-21 20:42:00', 100, 1, 0),
(15, 17, NULL, 15, 'Servicio de limpieza de 5 habitaciones , mas un patio y una cochera', 'Direccion Prueba', '[-16.3999133,-71.5462223]', '2024-06-14 21:44:52', '2024-06-28 21:44:52', 216, 1, 0),
(16, 17, NULL, 27, 'descripcion de solicitud', 'Yanahuara', '[-16.38818185,-71.54205394475468]', '2024-06-14 21:46:34', '2024-06-28 21:46:34', 150, 1, 0),
(17, 9, NULL, 6, 'asdas', 'aasdsa', '[-16.4089733,-71.54043013948564]', '2024-06-14 23:55:31', '2024-06-28 22:55:00', 60, 1, 0),
(18, 18, NULL, 14, 'limpiar casa', 'Av. 12 de octubre #601 alto Selva Alegre ', '[51.505,-0.09]', '2024-06-26 22:24:55', '2024-06-28 18:24:00', 1000, 1, 0),
(19, 0, NULL, 62, 'Reparacion de sitio web', 'JORGE CHAVEZ ', '[-5.1417637,-74.1914255]', '2024-06-27 00:26:09', '2024-06-27 19:26:00', 1200, 1, 0),
(20, 17, NULL, 60, 'asdasd', 'JORGE CHAVEZ ', '[-5.1417637,-74.1914255]', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1250, 1, 0),
(21, 16, 17, 53, 'Necesito de un profesor de matemática para mi hijo', 'Direcccion', '[-16.4089733,-71.54043013948564]', '2024-07-04 15:31:00', '0000-00-00 00:00:00', 50, 2, 0),
(22, 16, 17, 23, 'asdasdsa', 'Micaela Bastidas Condominio Sol De Collique Block G1', '[12.68476815,101.00934297866353]', '2024-07-17 16:13:00', '0000-00-00 00:00:00', 200, 2, 0),
(23, 16, 17, 50, 'asdas', ' Sol De Mirafles', '[-16.3908966,-71.5130328]', '2024-07-17 19:58:00', '0000-00-00 00:00:00', 150, 3, 0),
(24, 17, NULL, 15, 'Necesito limpiar una oficina', '-16.3905536, -71.5128832', '[-16.39066245,-71.51298677538462]', '2024-07-05 01:03:00', '0000-00-00 00:00:00', 500, 1, 0),
(25, 17, NULL, 70, 'Necesito que bañen a mi perro', 'umacollo', '[-16.3999133,-71.5462223]', '2024-07-20 01:29:00', '0000-00-00 00:00:00', 100, 1, 0),
(26, 17, NULL, 28, 'Necesito el lavado del interior de mi carro', 'utp arequipa', '[-16.4089733,-71.54043013948564]', '2024-07-18 09:57:00', '0000-00-00 00:00:00', 150, 1, 0),
(27, 17, NULL, 23, 'Mi laptop se malogro', 'Miraflores ', '[-16.3908905,-71.5115004]', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 60, 1, 0),
(28, 17, NULL, 5, 'Necesito un electricista', 'Umacollo', '[-16.3999133,-71.5462223]', '2024-07-04 11:12:00', '0000-00-00 00:00:00', 150, 1, 0),
(29, 19, NULL, 62, 'Mi pc se apago de la nada', 'Coop. Juventud Ferroviaria Mz. F Lt. 1', '[-16.4168448,-71.539861]', '2024-07-06 10:28:00', '0000-00-00 00:00:00', 50, 1, 0),
(30, 21, NULL, 42, 'maquillaje para 15 años', 'Av. 12 de octubre #601 alto Selva Alegre ', '[-16.37942820130703,-71.51769052849318]', '2024-07-09 09:04:00', '0000-00-00 00:00:00', 50, 1, 0),
(31, 21, 22, 50, 'baile contemporaneo', 'Av. 12 de octubre #601 alto Selva Alegre ', '[51.505,-0.09]', '2024-07-12 14:07:00', '0000-00-00 00:00:00', 30, 3, 1),
(32, 17, NULL, 14, 'asdas', 'Umacollo', '[-16.3938304,-71.5456512]', '2024-07-11 00:27:00', '0000-00-00 00:00:00', 50, 1, 0),
(33, 16, 17, 22, 'Instalación de aire acondicionado', 'Direcccion', '[-16.3938304,-71.5456512]', '2024-07-26 00:42:00', '0000-00-00 00:00:00', 25, 3, 1),
(34, 16, NULL, 28, 'Desde ', 'direccion', '[-16.4050261,-71.5469632]', '2024-07-07 05:42:00', '0000-00-00 00:00:00', 50, 1, 0),
(35, 17, 22, 14, 'deescripciom', 'Umacollo', '[51.505,-0.09]', '2024-07-12 18:45:00', '0000-00-00 00:00:00', 50, 3, 1),
(36, 21, 21, 24, 'Quiero reparar un televisor ', 'Av. 12 de octubre #601 alto Selva Alegre ', '[51.505,-0.09]', '2024-07-11 12:25:00', '0000-00-00 00:00:00', 50, 3, 0),
(37, 21, 21, 37, 'No jjj', 'Hhj', '[51.505,-0.09]', '2024-07-15 21:39:00', '0000-00-00 00:00:00', 50, 2, 0),
(38, 20, NULL, 14, 'Limpieza de Casa', 'Coop. Juventud Ferroviaria Mz. F Lt. 1', '[-16.4168448,-71.539861]', '2024-07-17 17:00:00', '0000-00-00 00:00:00', 50, 1, 0),
(39, 17, NULL, 17, 'Necesito Mudarme', 'Direcccion', '[-16.3905536,-71.5128832]', '2024-07-19 11:15:00', '0000-00-00 00:00:00', 100, 1, 0),
(40, 17, NULL, 59, 'Quiero realizar una software CRM', 'JORGE CHAVEZ ', '[51.505,-0.09]', '2024-07-20 11:20:00', '0000-00-00 00:00:00', 1500, 1, 0),
(41, 17, NULL, 16, 'Necesito lavar 5 sacos de ropa', 'Direcccion', '[51.505,-0.09]', '2024-07-25 13:16:00', '0000-00-00 00:00:00', 100, 1, 0),
(42, 16, NULL, 66, 'Necesito un mesero con experiencia', ' Sol De Mirafles', '[51.505,-0.09]', '2024-07-27 13:17:00', '0000-00-00 00:00:00', 600, 1, 0),
(43, 24, NULL, 14, 'Requiero empleada para hogar de 4 integrantes', 'Av. 12 de octubre #601 alto Selva Alegre ', '[-16.3793122,-71.5177612]', '2024-07-26 08:30:00', '0000-00-00 00:00:00', 1000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `especialista` tinyint(5) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `apellido` varchar(120) NOT NULL,
  `telefono` varchar(60) NOT NULL,
  `email` varchar(120) NOT NULL,
  `contrasena` varchar(150) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `edad` tinyint(4) NOT NULL,
  `calificacion` float NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `especialista`, `nombre`, `apellido`, `telefono`, `email`, `contrasena`, `fechaNacimiento`, `edad`, `calificacion`, `estado`) VALUES
(1, 0, 'Sergio', 'Sanguientti', '12312321', 'correo14@correo.com', 'asdasdasdsa', '0000-00-00', 24, 5, 0),
(2, 0, 'Sergio', 'Sanguientti', '12312321', 'correo@correo.com', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', '0000-00-00', 0, 0, 0),
(5, 0, 'Sergio', 'Sanguientti', '12312321', 'ssandinetti@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', '0000-00-00', 0, 0, 0),
(8, 0, 'Sharon', 'Villavicencio', '902747165', 'sharonvillavicencio93@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aub7LdtrTXnn.ZQdALsthndsluPeTbv.a', '0000-00-00', 0, 0, 0),
(10, 1, 'Sergio', 'Sanguinetti', '915097679', 'correo15@correo.com', '$2a$07$asxx54ahjppf45sd87a5auJRR6foEJ7ynpjisKtbiKJbvJsoQ8VPS', '0000-00-00', 0, 0, 0),
(11, 0, 'Pedro', 'Mamani', '972016142', 'pedromamanisuclla@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', '0000-00-00', 0, 0, 0),
(12, 0, 'Sergio 2', 'Apellido 2', '1321312312', 'ssanguinetti15@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', '0000-00-00', 0, 0, 0),
(13, 0, 'Usuario', 'Sanguinetti', '123456789', 'correo@gmail.com', '$2a$07$asxx54ahjppf45sd87a5au1mMwPFOiFOa2BiMswhkNpbB7hBZc6pa', '0000-00-00', 0, 0, 0),
(14, 0, 'Sergio', 'Sanguinetti', '915097679', 'correo20@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', '0000-00-00', 0, 0, 0),
(15, 0, 'Sergio', 'Sanguinetti', '915097679', 'correo21@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', '0000-00-00', 0, 0, 0),
(16, 0, 'Sergio', 'Sanguinetti', '915097679', 'u19221098@utp.edu.pe', '$2a$07$asxx54ahjppf45sd87a5auia1mVQcfGnHbxgvsMbUgrxcI9fwgAFS', '0000-00-00', 0, 0, 0),
(17, 1, 'Carlos', 'Noriega', '915097679', 'ssanguinetti14@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auia1mVQcfGnHbxgvsMbUgrxcI9fwgAFS', '0000-00-00', 0, 0, 0),
(18, 0, 'sharon', 'villa', '902747165', 'sharonvillavicencio@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auJRR6foEJ7ynpjisKtbiKJbvJsoQ8VPS', '0000-00-00', 0, 0, 0),
(19, 0, 'Pedro', 'Mamani', '972016142', 'cuentaspremium2590@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auNbfjWtsYxBhPzusRPHrQROLI6kL6mXK', '0000-00-00', 0, 0, 0),
(20, 0, 'Luis', 'Mamani', '972016142', 'cubos2590@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auNbfjWtsYxBhPzusRPHrQROLI6kL6mXK', '0000-00-00', 0, 0, 0),
(21, 1, 'Nicole', 'Villa', '951353237', 'nicolevillavicencio93@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', '0000-00-00', 0, 0, 0),
(22, 1, 'Pepe', 'Ruiz Paz', '854775154', 'peperuiz@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auFL5K1.Cmt9ZheoVVuudOi5BCi10qWly', '0000-00-00', 0, 0, 0),
(23, 0, 'Juan Carlos', 'Villavicencio S', '905714752', 'juanv@gmail.com', '$2a$07$asxx54ahjppf45sd87a5auJRR6foEJ7ynpjisKtbiKJbvJsoQ8VPS', '0000-00-00', 0, 0, 0),
(24, 0, 'Nicole Luisa', 'Martinez', '951353237', 'nicoleMn@gmail.com', '$2a$07$asxx54ahjppf45sd87a5aueqiQ6y33HT5v4IeFEVzdSBNFOECPQYW', '0000-00-00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `valoracion`
--

CREATE TABLE `valoracion` (
  `idValoracion` int(11) NOT NULL,
  `idSolicitud` int(11) NOT NULL,
  `puntuacionCliente` double NOT NULL,
  `comentarioCliente` varchar(150) NOT NULL,
  `puntuacionEspecialista` double NOT NULL,
  `comentarioEspecialista` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `valoracion`
--

INSERT INTO `valoracion` (`idValoracion`, `idSolicitud`, `puntuacionCliente`, `comentarioCliente`, `puntuacionEspecialista`, `comentarioEspecialista`) VALUES
(1, 23, 4, 'Muy buen cliente', 5, 'comentario cliente'),
(2, 31, 4, 'muy bien', 3, 'no muy buena'),
(3, 33, 0, 'Muy buen servicio', 4, 'Buen especialista'),
(4, 35, 4, 'uuuu', 1, 'calificar'),
(5, 36, 2, 'No tan bueno', 0, ''),
(6, 37, 0, '', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `especialista`
--
ALTER TABLE `especialista`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queja`
--
ALTER TABLE `queja`
  ADD PRIMARY KEY (`idQueja`);

--
-- Indexes for table `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`idSolicitud`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`idValoracion`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `especialista`
--
ALTER TABLE `especialista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `queja`
--
ALTER TABLE `queja`
  MODIFY `idQueja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `idSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `idValoracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

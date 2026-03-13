-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Tempo de geração: 22/02/2026 às 03:43
-- Versão do servidor: 8.0.40
-- Versão do PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `applauselive`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `banners`
--

CREATE TABLE `banners` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `img` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `link` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `banners`
--

INSERT INTO `banners` (`id`, `title`, `img`, `link`) VALUES
(1, 'Banner 01', 'banner-01.jpg', ''),
(2, 'Banner 02', 'banner-02.jpg', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `title` varchar(300) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `category`
--

INSERT INTO `category` (`id`, `title`) VALUES
(1, 'Marketing'),
(2, 'Premix'),
(3, 'Suporte'),
(4, 'Técnico'),
(5, 'Diretoria'),
(6, 'EC01'),
(7, 'EC02'),
(8, 'EC03'),
(9, 'EC04'),
(10, 'EC05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cms`
--

CREATE TABLE `cms` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `cms`
--

INSERT INTO `cms` (`id`, `title`) VALUES
(4, 'messages');

-- --------------------------------------------------------

--
-- Estrutura para tabela `config`
--

CREATE TABLE `config` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `content` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `config`
--

INSERT INTO `config` (`id`, `title`, `content`) VALUES
(1, 'Database Name', 'applauselive'),
(2, 'Logo', '697badb77d620'),
(3, 'Site_Title', 'Applause Live'),
(4, 'Phone', '45 99999-9999'),
(5, 'Email', 'contact@blackholeframe.com'),
(6, 'Address', 'Lorem Ipsum St., New York'),
(7, 'Auto_Update_AppModel', 'no'),
(8, 'Auto_Update_AdminModel', 'no'),
(9, 'Auto_Update_Helper_List', 'no'),
(10, 'Auto_Update_Helper_Form', 'no'),
(11, 'empty', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `go`
--

CREATE TABLE `go` (
  `id` int NOT NULL,
  `title` varchar(300) COLLATE utf8mb3_unicode_ci NOT NULL,
  `img` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `go`
--

INSERT INTO `go` (`id`, `title`, `img`, `description`) VALUES
(1, 'test title', 'test.jpg', 'test descrption');

-- --------------------------------------------------------

--
-- Estrutura para tabela `home`
--

CREATE TABLE `home` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `content` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `home`
--

INSERT INTO `home` (`id`, `title`, `content`) VALUES
(1, 'title', 'Hello World.'),
(2, 'description', 'Start to put here your content.<br />This file is: yourproject/app/view/pages/home/index.php');

-- --------------------------------------------------------

--
-- Estrutura para tabela `input_types`
--

CREATE TABLE `input_types` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `content` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `input_types`
--

INSERT INTO `input_types` (`id`, `title`, `content`) VALUES
(1, 'array_fields_hidden', 'id'),
(2, 'array_fields_text', 'title'),
(3, 'array_fields_number', 'sku'),
(4, 'array_fields_select', 'status, id_category, id_subcategory, id_posts'),
(5, 'array_fields_img', 'img, photo, icon'),
(6, 'array_fields_textarea', 'text, description, addres'),
(7, 'array_fields_date', 'date'),
(8, 'array_fields_time', 'hour, time'),
(9, 'array_fields_price', 'price'),
(10, 'array_galleries', 'products, blog, news');

-- --------------------------------------------------------

--
-- Estrutura para tabela `items`
--

CREATE TABLE `items` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `img` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `items`
--

INSERT INTO `items` (`id`, `title`, `img`, `description`) VALUES
(1, 'Item 01', 'item-01.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam et augue odio. Sed nec justo quam. Nam congue dignissim congue. Proin eros urna, cursus sit amet sem non, ultricies ultricies dolor. Nullam nec mauris nisi. Pellentesque a mauris eget odio commodo rutrum. Mauris scelerisque enim non risus auctor consequat vitae vehicula orci. In quis nibh ante. Donec massa purus, congue eget nisl finibus, luctus laoreet leo. Aliquam elementum felis nec pellentesque maximus. Donec id nisl at mauris varius bibendum sit amet eu urna.'),
(2, 'Item 02', 'item-02.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam et augue odio. Sed nec justo quam. Nam congue dignissim congue. Proin eros urna, cursus sit amet sem non, ultricies ultricies dolor. Nullam nec mauris nisi. Pellentesque a mauris eget odio commodo rutrum. Mauris scelerisque enim non risus auctor consequat vitae vehicula orci. In quis nibh ante. Donec massa purus, congue eget nisl finibus, luctus laoreet leo. Aliquam elementum felis nec pellentesque maximus. Donec id nisl at mauris varius bibendum sit amet eu urna.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `menu`
--

CREATE TABLE `menu` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `link` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `menu`
--

INSERT INTO `menu` (`id`, `title`, `link`) VALUES
(1, 'home', 'home'),
(2, 'items', 'items');

-- --------------------------------------------------------

--
-- Estrutura para tabela `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `id_typeform` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `name` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `recipient` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `como` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `upload` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `text_message` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `response_type` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `stage_date` datetime DEFAULT NULL,
  `submit_date` datetime DEFAULT NULL,
  `network_id` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `tags` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ending` varchar(500) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `messages`
--

INSERT INTO `messages` (`id`, `id_typeform`, `name`, `email`, `password`, `recipient`, `como`, `upload`, `text_message`, `response_type`, `start_date`, `stage_date`, `submit_date`, `network_id`, `tags`, `ending`) VALUES
(63, '9l1k7b1tcqcivid4t9l1k73oufj6y18l', 'Douglas Buettner', 'atendimento@mova.ppg.br', 'U0xweWRvQXp4MjFJS29PUmFyUVQxUT09', 'gustavogarbozza@outlook.com', 'Texto', '', 'Garbiiiiiinhaaaa', 'completed', '2026-02-05 17:21:07', '2026-02-05 06:02:45', '2026-02-05 17:21:42', 'a6a9f807c8', '', 'Obrigado!'),
(64, '0jbxku8l4lnik5ik850jyx9bhoo20kzx', 'Douglas Buettner', 'atendimento@mova.ppg.br', 'U0xweWRvQXp4MjFJS29PUmFyUVQxUT09', 'ector_rodrigues@mova.ppg.br', 'Vídeo', '79200479359__C3717634_5EBF_49D8_A769_13783F5D92A8.mp4', '', 'completed', '2026-02-05 17:18:58', '2026-02-05 06:02:45', '2026-02-05 17:20:02', 'a6a9f807c8', '', 'Obrigado!'),
(65, '5lia0721odx3toz19bg5lia0zptat87k', 'Luan', 'carvalho.luuan@gmail.com', 'WXVtMktFemRJY2o4YWpwZFJJN094dz09', 'lucasldonin@gmail.com', 'Texto', '', 'Salve', 'completed', '2026-02-05 14:05:46', '2026-02-05 06:02:45', '2026-02-05 14:06:16', 'a6a9f807c8', '', 'Obrigado!'),
(66, 'iy2flh19jnl16k2iy2focem8nydzxlok', 'Jéssica Dona', 'conteudo@mova.ppr.br', 'UDRZT3JsVjc2cW1McElaeGcvUm5oQT09', 'atendimento@mova.ppg.br', 'Texto', '', 'Chefe, você é top!', 'completed', '2026-02-05 14:03:58', '2026-02-05 06:02:45', '2026-02-05 14:05:02', 'a6a9f807c8', '', 'Obrigado!'),
(67, '57oj7sd958br1sop3z57ojd71petlxvy', 'lucas', 'lucasldonin@gmail.com', 'ME5rTzZBdlFzeFpPQVl5TGdRQjJ4QT09', 'ector_rodrigues@mova.ppg.br', 'Texto', '', 'Oieeee teste teste teste', 'completed', '2026-02-05 14:03:56', '2026-02-05 06:02:45', '2026-02-05 14:04:46', 'a6a9f807c8', '', 'Obrigado!'),
(68, 'riwx8ps1l1820b1ariwx9m6w7o5gbhfh', 'Ector Rodrigues', 'ector_rodrigues@mova.ppg.br', 'ZTRjZGRHaVFVSmZMbDRmL0tGZ0lyZz09', 'carlos_dassi@mova.ppg.br', 'Vídeo', '79199301927__9EC63B0F_88D8_4A09_9E77_42930562D792.mp4', '', 'completed', '2026-02-05 14:02:37', '2026-02-05 06:02:45', '2026-02-05 14:03:49', 'a6a9f807c8', '', 'Obrigado!'),
(69, 'r74bsqgqazlv7ryaoid7er74bsq403k6', 'Tainara', 'atendimento02@mova.ppg.br', 'aVcrbmJsWncxODk4endwNXpKWkFaUT09', 'conteudo@mova.ppr.br', 'Texto', '', 'Hellooo!! Testando, câmbio!', 'completed', '2026-02-05 14:00:40', '2026-02-05 06:02:45', '2026-02-05 14:01:35', 'a6a9f807c8', '', 'Obrigado!'),
(70, 'w1c93jmiryqu4xew1c9dyvqdtmdmtum8', 'Douglas', 'Atendimento@mova.ppg.br', 'U0xweWRvQXp4MjFJS29PUmFyUVQxUT09', 'teste1@teste.com', 'Vídeo', '79198841123__B8C04EAC_A0C6_4F74_9F35_27227696FC68.mp4', '', 'completed', '2026-02-05 12:45:49', '2026-02-05 06:02:45', '2026-02-05 12:47:09', 'a6a9f807c8', '', 'Obrigado!'),
(71, 's8wj5zv0odlsl8js8wchcdwbmjzcmra8', 'Carol', 'Eventos@mova.ppg.br', 'bk9FZVhnZ2xKYlBnU2RsWDZtTVM3Zz09', 'teste2@teste.com', 'Vídeo', '79198838329__7D3FCB54_2B1C_44D6_B617_2EE82171638B.mp4', '', 'completed', '2026-02-05 12:45:37', '2026-02-05 06:02:45', '2026-02-05 12:46:35', '5872e1ab26', '', 'Obrigado!'),
(72, 'sz7qony3z46c2mysz7qo7mnxmtvwycmh', 'Carlos Dassi', 'Carlos_dassi@mova.ppg.br', 'WDNna3BYemNtZTFGamxBam14aUJzQT09', 'teste1@teste.com', 'Vídeo', '79198831940__37AF1BB1_C4C8_41C5_A53B_378A1C1659E6.mp4', '', 'completed', '2026-02-05 12:44:01', '2026-02-05 06:02:45', '2026-02-05 12:45:38', '1069d02b5b', '', 'Obrigado!'),
(73, '5jwct2fxdqwvw17ayhw695jwctsfdr44', 'Douglas Buettner', 'Atendimento@mova.ppg.br', 'U0xweWRvQXp4MjFJS29PUmFyUVQxUT09', 'teste2@teste.com', 'Texto', '', 'Muito meu amigo', 'completed', '2026-02-05 12:44:01', '2026-02-05 06:02:45', '2026-02-05 12:45:26', 'a6a9f807c8', '', 'Obrigado!'),
(74, '9w2l8wcz58dltnrm6nzs3v9w2l8wczqm', 'teste 4', 'teste4@teste.com', 'ZTRjZGRHaVFVSmZMbDRmL0tGZ0lyZz09', 'teste1@teste.com', 'Texto', '', 'teste 30-01', 'completed', '2026-01-30 21:27:27', '2026-02-05 06:02:45', '2026-01-30 21:28:15', 'a6a9f807c8', '', 'Obrigado!'),
(75, '3fmlk1lmtn9ix9e9062z3fmlkjn94tb3', 'teste 4', 'teste4@teste.com', 'ZTRjZGRHaVFVSmZMbDRmL0tGZ0lyZz09', 'teste1@teste.com', 'Texto', '', 'Test message', 'completed', '2026-01-30 13:24:32', '2026-02-05 06:02:45', '2026-01-30 13:25:40', '20e8facea4', '', 'Obrigado!'),
(76, '17u92ui9490ztunq7v17u92ui9m0or7v', 'teste 3', 'teste3@teste.com', 'ZTRjZGRHaVFVSmZMbDRmL0tGZ0lyZz09', 'teste1@teste.com', 'Texto', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor viverra massa et aliquet. Integer tincidunt, nulla ut ultrices condimentum, ante nibh blandit mauris, ut placerat eros massa vitae lectus. Nunc sed venenatis risus. Sed mollis auctor sapien et congue. Donec vel libero a tortor pretium molestie sit amet aliquam leo. Sed ac lacus in est cursus tristique pharetra aliquam risus. Fusce consequat neque vitae vestibulum imperdiet. Fusce commodo massa non velit semper egestas.', 'completed', '2026-01-30 12:57:42', '2026-02-05 06:02:45', '2026-01-30 12:58:49', '20e8facea4', '', 'Obrigado!'),
(77, 'xwobotlhvws3u3cjtdpxwobotjsirw7m', 'teste 1', 'teste1@teste.com', 'ZTRjZGRHaVFVSmZMbDRmL0tGZ0lyZz09', 'teste2@teste.com', 'Vídeo', '79147060153__4F7636CA_42FD_4438_868D_3AFF71395730.mp4', '', 'completed', '2026-01-30 12:55:34', '2026-02-05 06:02:45', '2026-01-30 12:56:50', '20e8facea4', '', 'Obrigado!'),
(78, 'eodq3m8tz6itkd94c9eodqkoafadaaqa', 'teste 3', 'teste3@teste.com', 'ZTRjZGRHaVFVSmZMbDRmL0tGZ0lyZz09', 'teste1@teste.com', 'Vídeo', '79147051737__4E0AEB3E_59DF_416E_9871_EE96EC27025E.mp4', '', 'completed', '2026-01-30 12:54:23', '2026-02-05 06:02:45', '2026-01-30 12:55:26', '20e8facea4', '', 'Obrigado!'),
(79, 'ztyba2enja15sh0sztybaispy4r26zvf', 'teste 2', 'teste2@teste.com', 'ZTRjZGRHaVFVSmZMbDRmL0tGZ0lyZz09', 'teste1@teste.com', 'Vídeo', '79147043004__F651F599_78CF_4EFA_B4B1_A802E860C527.mp4', '', 'completed', '2026-01-30 12:52:57', '2026-02-05 06:02:45', '2026-01-30 12:53:57', '20e8facea4', '', 'Obrigado!'),
(80, 'ge67w2087jfcbzyatn3oge6jzw95igzf', 'teste 3', 'teste3@teste.com', 'ZTRjZGRHaVFVSmZMbDRmL0tGZ0lyZz09', 'teste2@teste.com', 'Vídeo', 'IMG_6043.mp4', '', 'completed', '2026-01-30 12:47:42', '2026-02-05 06:02:45', '2026-01-30 12:48:37', '20e8facea4', '', 'Obrigado!'),
(81, 'lwpjtr314rqrj7blwpjtgipdfsjrsk39', 'teste 1', 'teste1@teste.com', 'ZTRjZGRHaVFVSmZMbDRmL0tGZ0lyZz09', 'teste1@teste.com', 'Texto', '', 'lorem ipsum dolor sit amet consecutor adipicing elit de fragussom', 'completed', '2026-01-30 12:46:37', '2026-02-05 06:02:45', '2026-01-30 12:47:37', '20e8facea4', '', 'Obrigado!'),
(82, '9kq1dlk4d7jrr9kq1khy3bpklib1242u', 'Karim', 'Karim', 'WStkak4xcEZBNzd4MHZadWtJa2xGdz09', 'conteudo@mova.ppr.br', 'Texto', '', 'se existe pessoa mais criativa e queridaa, eu desconheço <3', 'completed', '2026-02-05 18:17:32', '2026-02-05 06:02:52', '2026-02-05 18:18:32', 'a6a9f807c8', '', 'Obrigado!'),
(83, 'b7ytf3xdvfvkikdqb7yxn1itjyb41ua9', 'Karim', 'eventos1@mova.ppg.br', 'WStkak4xcEZBNzd4MHZadWtJa2xGdz09', 'eventos@mova.ppg.br', 'Texto', '', 'Segura o tchan', 'completed', '2026-02-05 18:16:34', '2026-02-05 06:02:52', '2026-02-05 18:17:20', 'a6a9f807c8', '', 'Obrigado!'),
(84, '5ciwvbifk4mra64lot0g5ciwvbpxn0nb', 'Jéssica Dona', 'conteudo@mova.ppr.br', 'TS9UdVNqVWdSa0Z4WUdvVUVHMXVrQT09', 'carvalho.luuan@gmail.com', 'Texto', '', 'Hello, Luan Santana.', 'completed', '2026-02-05 18:15:45', '2026-02-05 06:02:52', '2026-02-05 18:16:27', 'a6a9f807c8', '', 'Obrigado!'),
(85, 'zik5gbjkz0x13njljzik5gew4cqxyp9p', 'Jéssica Dona', 'conteudo@mova.ppr.br', 'aWJYaUtzb2pqNlQ4Uzd1eUpiN1Q4dz09', 'atendimento02@mova.ppg.br', 'Texto', '', 'OIE\nRAINHA DOS JOBS', 'completed', '2026-02-05 18:13:28', '2026-02-05 06:02:52', '2026-02-05 18:13:54', 'a6a9f807c8', '', 'Obrigado!'),
(86, '9l1k7b1tcqcivid4t9l1k73oufj6y18l', 'Douglas Buettner', 'atendimento@mova.ppg.br', 'QVpCcnpMSjQ1LzZxMGZhSGVYd0tQdz09', 'gustavogarbozza@outlook.com', 'Texto', '', 'Garbiiiiiinhaaaa', 'completed', '2026-02-05 17:21:07', '2026-02-05 06:02:52', '2026-02-05 17:21:42', 'a6a9f807c8', '', 'Obrigado!'),
(87, '0jbxku8l4lnik5ik850jyx9bhoo20kzx', 'Douglas Buettner', 'atendimento@mova.ppg.br', 'QVpCcnpMSjQ1LzZxMGZhSGVYd0tQdz09', 'ector\\_rodrigues@mova.ppg.br', 'Vídeo', '79200479359__C3717634_5EBF_49D8_A769_13783F5D92A8.mp4', '', 'completed', '2026-02-05 17:18:58', '2026-02-05 06:02:52', '2026-02-05 17:20:02', 'a6a9f807c8', '', 'Obrigado!'),
(88, '5lia0721odx3toz19bg5lia0zptat87k', 'Luan', 'carvalho.luuan@gmail.com', 'M1lZbzRPZ3hrcHJmd1Z0djA2VlBHQT09', 'lucasldonin@gmail.com', 'Texto', '', 'Salve', 'completed', '2026-02-05 14:05:46', '2026-02-05 06:02:52', '2026-02-05 14:06:16', 'a6a9f807c8', '', 'Obrigado!'),
(89, 'iy2flh19jnl16k2iy2focem8nydzxlok', 'Jéssica Dona', 'conteudo@mova.ppr.br', 'TS9UdVNqVWdSa0Z4WUdvVUVHMXVrQT09', 'atendimento@mova.ppg.br', 'Texto', '', 'Chefe, você é top!', 'completed', '2026-02-05 14:03:58', '2026-02-05 06:02:52', '2026-02-05 14:05:02', 'a6a9f807c8', '', 'Obrigado!'),
(90, '57oj7sd958br1sop3z57ojd71petlxvy', 'lucas', 'lucasldonin@gmail.com', 'MDBOOVo1VEVRNjRWTDVxbzdKQlZoZz09', 'ector\\_rodrigues@mova.ppg.br', 'Texto', '', 'Oieeee teste teste teste', 'completed', '2026-02-05 14:03:56', '2026-02-05 06:02:52', '2026-02-05 14:04:46', 'a6a9f807c8', '', 'Obrigado!'),
(91, 'riwx8ps1l1820b1ariwx9m6w7o5gbhfh', 'Ector Rodrigues', 'ector_rodrigues@mova.ppg.br', 'OEFGZ2t3WE9BTE8yNXJya3lUVW55Zz09', 'carlos\\_dassi@mova.ppg.br', 'Vídeo', '79199301927__9EC63B0F_88D8_4A09_9E77_42930562D792.mp4', '', 'completed', '2026-02-05 14:02:37', '2026-02-05 06:02:52', '2026-02-05 14:03:49', 'a6a9f807c8', '', 'Obrigado!'),
(92, 'r74bsqgqazlv7ryaoid7er74bsq403k6', 'Tainara', 'atendimento02@mova.ppg.br', 'UjE4ZXlwVThiczRjTXlENTRUdDBHQT09', 'conteudo@mova.ppr.br', 'Texto', '', 'Hellooo!! Testando, câmbio!', 'completed', '2026-02-05 14:00:40', '2026-02-05 06:02:52', '2026-02-05 14:01:35', 'a6a9f807c8', '', 'Obrigado!'),
(93, 'w1c93jmiryqu4xew1c9dyvqdtmdmtum8', 'Douglas', 'Atendimento@mova.ppg.br', 'QVpCcnpMSjQ1LzZxMGZhSGVYd0tQdz09', 'teste1@teste.com', 'Vídeo', '79198841123__B8C04EAC_A0C6_4F74_9F35_27227696FC68.mp4', '', 'completed', '2026-02-05 12:45:49', '2026-02-05 06:02:52', '2026-02-05 12:47:09', 'a6a9f807c8', '', 'Obrigado!'),
(94, 's8wj5zv0odlsl8js8wchcdwbmjzcmra8', 'Carol', 'Eventos@mova.ppg.br', 'b0ZvS2xIZWhKcUdkYTBjb2NxU0lBZz09', 'teste2@teste.com', 'Vídeo', '79198838329__7D3FCB54_2B1C_44D6_B617_2EE82171638B.mp4', '', 'completed', '2026-02-05 12:45:37', '2026-02-05 06:02:52', '2026-02-05 12:46:35', '5872e1ab26', '', 'Obrigado!'),
(95, 'sz7qony3z46c2mysz7qo7mnxmtvwycmh', 'Carlos Dassi', 'Carlos_dassi@mova.ppg.br', 'dHR6U0RHRWhzZDhHM3hCVnY3MVdhZz09', 'teste1@teste.com', 'Vídeo', '79198831940__37AF1BB1_C4C8_41C5_A53B_378A1C1659E6.mp4', '', 'completed', '2026-02-05 12:44:01', '2026-02-05 06:02:52', '2026-02-05 12:45:38', '1069d02b5b', '', 'Obrigado!'),
(96, '5jwct2fxdqwvw17ayhw695jwctsfdr44', 'Douglas Buettner', 'Atendimento@mova.ppg.br', 'QVpCcnpMSjQ1LzZxMGZhSGVYd0tQdz09', 'teste2@teste.com', 'Texto', '', 'Muito meu amigo', 'completed', '2026-02-05 12:44:01', '2026-02-05 06:02:52', '2026-02-05 12:45:26', 'a6a9f807c8', '', 'Obrigado!'),
(97, '9w2l8wcz58dltnrm6nzs3v9w2l8wczqm', 'teste 4', 'teste4@teste.com', 'OEFGZ2t3WE9BTE8yNXJya3lUVW55Zz09', 'teste1@teste.com', 'Texto', '', 'teste 30-01', 'completed', '2026-01-30 21:27:27', '2026-02-05 06:02:52', '2026-01-30 21:28:15', 'a6a9f807c8', '', 'Obrigado!'),
(98, '3fmlk1lmtn9ix9e9062z3fmlkjn94tb3', 'teste 4', 'teste4@teste.com', 'OEFGZ2t3WE9BTE8yNXJya3lUVW55Zz09', 'teste1@teste.com', 'Texto', '', 'Test message', 'completed', '2026-01-30 13:24:32', '2026-02-05 06:02:52', '2026-01-30 13:25:40', '20e8facea4', '', 'Obrigado!'),
(99, '17u92ui9490ztunq7v17u92ui9m0or7v', 'teste 3', 'teste3@teste.com', 'OEFGZ2t3WE9BTE8yNXJya3lUVW55Zz09', 'teste1@teste.com', 'Texto', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor viverra massa et aliquet. Integer tincidunt, nulla ut ultrices condimentum, ante nibh blandit mauris, ut placerat eros massa vitae lectus. Nunc sed venenatis risus. Sed mollis auctor sapien et congue. Donec vel libero a tortor pretium molestie sit amet aliquam leo. Sed ac lacus in est cursus tristique pharetra aliquam risus. Fusce consequat neque vitae vestibulum imperdiet. Fusce commodo massa non velit semper egestas.', 'completed', '2026-01-30 12:57:42', '2026-02-05 06:02:52', '2026-01-30 12:58:49', '20e8facea4', '', 'Obrigado!'),
(100, 'xwobotlhvws3u3cjtdpxwobotjsirw7m', 'teste 1', 'teste1@teste.com', 'OEFGZ2t3WE9BTE8yNXJya3lUVW55Zz09', 'teste2@teste.com', 'Vídeo', '79147060153__4F7636CA_42FD_4438_868D_3AFF71395730.mp4', '', 'completed', '2026-01-30 12:55:34', '2026-02-05 06:02:52', '2026-01-30 12:56:50', '20e8facea4', '', 'Obrigado!'),
(101, 'eodq3m8tz6itkd94c9eodqkoafadaaqa', 'teste 3', 'teste3@teste.com', 'OEFGZ2t3WE9BTE8yNXJya3lUVW55Zz09', 'teste1@teste.com', 'Vídeo', '79147051737__4E0AEB3E_59DF_416E_9871_EE96EC27025E.mp4', '', 'completed', '2026-01-30 12:54:23', '2026-02-05 06:02:52', '2026-01-30 12:55:26', '20e8facea4', '', 'Obrigado!'),
(102, 'ztyba2enja15sh0sztybaispy4r26zvf', 'teste 2', 'teste2@teste.com', 'OEFGZ2t3WE9BTE8yNXJya3lUVW55Zz09', 'teste1@teste.com', 'Vídeo', '79147043004__F651F599_78CF_4EFA_B4B1_A802E860C527.mp4', '', 'completed', '2026-01-30 12:52:57', '2026-02-05 06:02:52', '2026-01-30 12:53:57', '20e8facea4', '', 'Obrigado!'),
(103, 'ge67w2087jfcbzyatn3oge6jzw95igzf', 'teste 3', 'teste3@teste.com', 'OEFGZ2t3WE9BTE8yNXJya3lUVW55Zz09', 'teste2@teste.com', 'Vídeo', 'IMG_6043.mp4', '', 'completed', '2026-01-30 12:47:42', '2026-02-05 06:02:52', '2026-01-30 12:48:37', '20e8facea4', '', 'Obrigado!'),
(104, 'lwpjtr314rqrj7blwpjtgipdfsjrsk39', 'teste 1', 'teste1@teste.com', 'OEFGZ2t3WE9BTE8yNXJya3lUVW55Zz09', 'teste1@teste.com', 'Texto', '', 'lorem ipsum dolor sit amet consecutor adipicing elit de fragussom', 'completed', '2026-01-30 12:46:37', '2026-02-05 06:02:52', '2026-01-30 12:47:37', '20e8facea4', '', 'Obrigado!'),
(115, 'id_typeform', 'Ector', 'ectorrodrigues@gmail.com', 'THlXT2xCS3N5VGlqbDQ1YytXM1NaZz09', 'pedro.sbardella@elancoah.com', 'video', '2026-02-22-03-02-21---Ector-to-6---IMG_6043.mp4', '', 'response_type', '2026-02-22 03:02:21', '2026-02-22 03:02:21', '2026-02-22 03:02:21', 'network_id', 'tag', 'ending');

-- --------------------------------------------------------

--
-- Estrutura para tabela `people`
--

CREATE TABLE `people` (
  `id` int NOT NULL,
  `id_category` int NOT NULL,
  `title` varchar(300) COLLATE utf8mb3_unicode_ci NOT NULL,
  `img` varchar(300) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `people`
--

INSERT INTO `people` (`id`, `id_category`, `title`, `img`) VALUES
(1, 1, 'andre.mo@elancoah.com', 'andre.mo@elancoah.com.jpg'),
(2, 1, 'barbara.garcia@elancoah.com', 'barbara.garcia@elancoah.com.jpg'),
(3, 1, 'beatriz.ogussuko@elancoah.com', 'beatriz.ogussuko@elancoah.com.jpeg'),
(4, 1, 'fernanda.paparotti@elancoah.com', 'fernanda.paparotti@elancoah.com.jpg'),
(5, 1, 'nuno.rodrigues@elancoah.com', 'nuno.rodrigues@elancoah.com.jpg'),
(6, 1, 'pedro.sbardella@elancoah.com', 'pedro.sbardella@elancoah.com.jpg'),
(7, 1, 'thais_santos_rosa.miotto@elancoah.com', 'thais_santos_rosa.miotto@elancoah.com.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `update_time_control`
--

CREATE TABLE `update_time_control` (
  `id` int UNSIGNED NOT NULL,
  `time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `update_time_control`
--

INSERT INTO `update_time_control` (`id`, `time`) VALUES
(1, '2026-01-29 19:04:19'),
(2, '2026-01-29 22:54:39'),
(3, '2026-01-30 00:23:05'),
(4, '2026-01-30 01:28:56'),
(5, '2026-01-30 02:29:06'),
(6, '2026-01-30 12:50:22'),
(7, '2026-01-30 14:04:39'),
(8, '2026-01-30 17:19:30'),
(9, '2026-01-30 20:20:42'),
(10, '2026-01-30 21:21:56'),
(11, '2026-02-05 13:50:25'),
(12, '2026-02-05 22:09:26'),
(13, '2026-02-21 19:55:32'),
(14, '2026-02-21 21:40:34'),
(15, '2026-02-22 00:17:30'),
(16, '2026-02-22 02:11:09'),
(17, '2026-02-22 03:11:30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `password` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `keypass` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `key_iv` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `key_tag` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created` date NOT NULL,
  `updated` date NOT NULL,
  `reference` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `active` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `title`, `email`, `password`, `keypass`, `key_iv`, `key_tag`, `created`, `updated`, `reference`, `active`) VALUES
(1, 'root', 'cliente@email.com', 'ajd5aGpvcFBDUlBaSjdvcjNvWHFUUT09', 'ajd5aGpvcFBDUlBaSjdvcjNvWHFUUT09', 'bcb67f82a16fd76090d244e62c5a9be0b3b8124debb40c9a59f9ba345f45a44c', 'f14d074dd0dd69a4', '2026-01-29', '2026-01-29', '202601290632697bad9c8d94d', 1),
(3, 'teste 2', 'teste2@teste.com', 'TVhTalgrR1lrRURsR3hWaUZHRXUwZz09', 'TVhTalgrR1lrRURsR3hWaUZHRXUwZz09', '2f7c67d35eee2b36cdc59616f76913934dbf98d6da1c06ad9317ce5e955b2eb3', 'f0df68105f894b2f', '2026-01-29', '2026-01-29', '202601291115697bf1fba1501', 1),
(4, 'teste 1', 'teste1@teste.com', 'YjhKUjE3cGduWm1ESzhGeTF1bUZzdz09', 'YjhKUjE3cGduWm1ESzhGeTF1bUZzdz09', '1041d9320699b2615809762c08af6fec8dc6d399a041a4736eb0875933d2f6c5', '9590ac687b2c86e8', '2026-01-29', '2026-01-29', '202601291115697bf1fba17ab', 1),
(5, 'teste 3', 'teste3@teste.com', 'MWdrSGI1b0NaWlNBWHc5ei95cjJydz09', 'MWdrSGI1b0NaWlNBWHc5ei95cjJydz09', 'feb4a795632a0c1608be6c8f55d97f2171991ef9a895535671229054d7b56f47', 'f85bee28119d96c1', '2026-01-30', '2026-01-30', '202601301222697ca8d2d807e', 1),
(6, 'teste 4', 'teste4@teste.com', 'L3llTWgzQTRMYWNZRXIzYStkYjlhQT09', 'L3llTWgzQTRMYWNZRXIzYStkYjlhQT09', '4ee7ea80d9f888c9de5e19d7cfa206916e064a4aba8bf7a634ba59bd70b83c98', 'c263276f8755dba3', '2026-01-30', '2026-01-30', '202601300725697d087540bbb', 1),
(7, 'Marcus Silva', 'camila.santos@inbox.com', 'Z2c5UXQ0YTJDampnSHd3UmRFUjB0UT09', 'Z2c5UXQ0YTJDampnSHd3UmRFUjB0UT09', '30c19ed377e9bc23344f0231b53783e7ed62e521fbf8a7b1fde61938cc9e3abe', '529337bd78ac085b', '2026-02-05', '2026-02-05', '2026020501296984991d50ee5', 1),
(8, 'Douglas', 'Atendimento@mova.ppg.br', 'a3UwK1hRZGJMVGlUMVdzZENWdDR6dz09', 'a3UwK1hRZGJMVGlUMVdzZENWdDR6dz09', '30c19ed377e9bc23344f0231b53783e7ed62e521fbf8a7b1fde61938cc9e3abe', '529337bd78ac085b', '2026-02-05', '2026-02-05', '2026020501296984991d5196b', 1),
(9, 'Carol', 'Eventos@mova.ppg.br', 'UjFIQlRkWGR1blEzYlBNc2N1MU1JQT09', 'UjFIQlRkWGR1blEzYlBNc2N1MU1JQT09', '30c19ed377e9bc23344f0231b53783e7ed62e521fbf8a7b1fde61938cc9e3abe', '529337bd78ac085b', '2026-02-05', '2026-02-05', '2026020501296984991d51b7d', 1),
(10, 'Carlos Dassi', 'Carlos_dassi@mova.ppg.br', 'M2JFRWYvRHBlWXdjSTd2SXlvVDNGUT09', 'M2JFRWYvRHBlWXdjSTd2SXlvVDNGUT09', '30c19ed377e9bc23344f0231b53783e7ed62e521fbf8a7b1fde61938cc9e3abe', '529337bd78ac085b', '2026-02-05', '2026-02-05', '2026020501296984991d51d04', 1),
(11, 'Luan', 'carvalho.luuan@gmail.com', 'ME43OFIvbi9IVVVRbHVQWkpPRzV4QT09', 'ME43OFIvbi9IVVVRbHVQWkpPRzV4QT09', 'bacb2e410ab2ddd2be0d1d63a81e98bf033787a5a2ced12fb450a767c793bea2', 'ef365e21646c1d19', '2026-02-05', '2026-02-05', '2026020506016984daa1a8a40', 1),
(12, 'Jéssica Dona', 'conteudo@mova.ppr.br', 'ZGloMjNTRnduTmF4Y2Y5Y1FGQjFiZz09', 'ZGloMjNTRnduTmF4Y2Y5Y1FGQjFiZz09', 'bacb2e410ab2ddd2be0d1d63a81e98bf033787a5a2ced12fb450a767c793bea2', 'ef365e21646c1d19', '2026-02-05', '2026-02-05', '2026020506016984daa1a987e', 1),
(13, 'lucas', 'lucasldonin@gmail.com', 'SksyUmVqT3JZazBXREFES0h6NmVQdz09', 'SksyUmVqT3JZazBXREFES0h6NmVQdz09', 'bacb2e410ab2ddd2be0d1d63a81e98bf033787a5a2ced12fb450a767c793bea2', 'ef365e21646c1d19', '2026-02-05', '2026-02-05', '2026020506016984daa1a999a', 1),
(14, 'Ector Rodrigues', 'ector_rodrigues@mova.ppg.br', 'bUEwNThiUVY5M1VJTlBzQ3BFS1ZzQT09', 'bUEwNThiUVY5M1VJTlBzQ3BFS1ZzQT09', 'bacb2e410ab2ddd2be0d1d63a81e98bf033787a5a2ced12fb450a767c793bea2', 'ef365e21646c1d19', '2026-02-05', '2026-02-05', '2026020506016984daa1a9ae5', 1),
(15, 'Tainara', 'atendimento02@mova.ppg.br', 'eThMOFl5Nll5SmFhOGtlNWNuQzI2QT09', 'eThMOFl5Nll5SmFhOGtlNWNuQzI2QT09', 'bacb2e410ab2ddd2be0d1d63a81e98bf033787a5a2ced12fb450a767c793bea2', 'ef365e21646c1d19', '2026-02-05', '2026-02-05', '2026020506016984daa1a9c79', 1),
(16, 'Karim', 'eventos1@mova.ppg.br', 'WStkak4xcEZBNzd4MHZadWtJa2xGdz09', 'WStkak4xcEZBNzd4MHZadWtJa2xGdz09', '76cd1a6d326104d5a4f60155bbf3328bc820d4e5bd97c182e356ed184bc7af0b', '988ed070172b810e', '2026-02-05', '2026-02-05', '2026020506526984dfc00ef07', 1),
(17, 'Teste', 'ectorrodrigues@gmail.com', 'UE9JcnJGSDB1bUQwTWdocjAzOEVFUT09', 'UE9JcnJGSDB1bUQwTWdocjAzOEVFUT09', '16ca374ef027f5f82a401567b7a3bf94d25a6a3b78d8a82b37c9c6b4e82ae5fc', '9f719a13ce6d0b50', '2026-02-22', '2026-02-22', '202602220321699a736101e87', 1),
(19, 'Pedro Sbardella', 'pedro.sbardella@elancoah.com', 'dDhEdlgyQ1Q4MEhXTUVRaW9XZkVpZz09', 'dDhEdlgyQ1Q4MEhXTUVRaW9XZkVpZz09', '21aae16a82377b09c35860c6768f44555e46bf39632c084c6244bdef4c04818a', 'd434a1cd25a41124', '2026-02-22', '2026-02-22', '202602220313699a75ed790fe', 1),
(20, 'Teste', 'teste@teste.com', 'cXVwSVdhOXhYaWFiWFJkZmtrcUlRZz09', 'cXVwSVdhOXhYaWFiWFJkZmtrcUlRZz09', '3eaaa9ace830be1f015135a17c249a44580a4f62d3a4e679baa7b5ab207a9348', 'f61595384470ca29', '2026-02-22', '2026-02-22', '202602220309699a7661b8226', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `go`
--
ALTER TABLE `go`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `home`
--
ALTER TABLE `home`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `input_types`
--
ALTER TABLE `input_types`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `update_time_control`
--
ALTER TABLE `update_time_control`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `go`
--
ALTER TABLE `go`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `home`
--
ALTER TABLE `home`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `input_types`
--
ALTER TABLE `input_types`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `items`
--
ALTER TABLE `items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT de tabela `people`
--
ALTER TABLE `people`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `update_time_control`
--
ALTER TABLE `update_time_control`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

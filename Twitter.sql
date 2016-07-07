-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 08 Lip 2016, 01:37
-- Wersja serwera: 5.5.44-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `Twitter`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_text` varchar(60) COLLATE utf8_polish_ci DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=15 ;

--
-- Zrzut danych tabeli `Comments`
--

INSERT INTO `Comments` (`id`, `post_id`, `user_id`, `comment_text`, `creation_date`) VALUES
(1, 4, 17, 'Komentarz do user:pyniok, text:Post nr.4', '2016-07-05'),
(2, 1, 17, 'Komentarz do user:pawel.zybura, text:Twit nr.1', '2016-07-05'),
(3, 2, 17, 'Komentarz do user:pyniok, text:Post nr.2', '2016-07-05'),
(4, 3, 17, 'Komentarz do user:pawel, text:Post nr.3', '2016-07-05'),
(5, 4, 17, 'Komentarz2 do user:pyniok, text:Post nr.4', '2016-07-05'),
(6, 5, 17, 'Komentarz do user:pyniok, text:Post nr.5', '2016-07-05'),
(7, 1, 17, 'Komentarz2 do user:pawel.zybura, text:Twit nr.1', '2016-07-05'),
(8, 2, 16, 'Komentarz2 do user:pyniok, text:Post nr.2', '2016-07-05'),
(9, 4, 16, 'Komentarz3 do user:pyniok, text:Post nr.4', '2016-07-05'),
(10, 4, 17, 'Komentarz4 do user:pyniok, text:Post nr.4', '2016-07-06'),
(11, 1, 17, 'Komentarz3 do user:pawel.zybura, text:Twit nr.1', '2016-07-06'),
(12, 6, 16, 'Komentarz4 do user:pawel.zybura, text:Tweet nr.6', '2016-07-07'),
(13, 6, 19, 'Komentarz do: Tweet nr.6, user: pawel.zybura', '2016-07-08'),
(14, 4, 19, 'Komentarz do: Post nr.4, user: pyniok', '2016-07-08');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Messages`
--

CREATE TABLE IF NOT EXISTS `Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `message_text` text COLLATE utf8_polish_ci,
  `is_read` tinyint(4) DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=10 ;

--
-- Zrzut danych tabeli `Messages`
--

INSERT INTO `Messages` (`id`, `sender_id`, `receiver_id`, `message_text`, `is_read`, `date`) VALUES
(2, 17, 16, 'CzeÅ›Ä‡, to ja, pyniok. WysyÅ‚am wiadomosc nr. 1 do pawel.zybura', 0, '2016-07-03'),
(3, 16, 17, 'Czesc, tu pawel.zybura. Wysylam wiadomosc nr.1 do pynioka', 0, '2016-07-03'),
(4, 16, 17, 'Wiadomosc nr.2 do pynioka', 0, '2016-07-03'),
(7, 17, 16, 'Wiadomosc nr. 3 do pawel.zybura', 0, '2016-07-03'),
(8, 16, 17, 'WiadomoÅ›Ä‡ nowa.', 1, '2016-07-07'),
(9, 16, 18, 'Czesc, to wiadomosc od pawel.zybura', 0, '2016-07-08');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Posts`
--

CREATE TABLE IF NOT EXISTS `Posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_text` varchar(140) COLLATE utf8_polish_ci DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `Posts`
--

INSERT INTO `Posts` (`id`, `user_id`, `post_text`, `creation_date`) VALUES
(1, 16, 'Twit nr.1', '2016-07-03'),
(2, 17, 'Post nr.2', '2016-07-02'),
(3, 18, 'Post nr.3', '2016-07-01'),
(4, 17, 'Post nr.4', '2016-07-05'),
(5, 17, 'Post nr.5', '2016-07-05'),
(6, 16, 'Tweet nr. 6, tym razem dÅ‚uÅ¼szy, Å¼eby zobaczyÄ‡ jak to naprawdÄ™ wyglÄ…da na stronie gÅ‚Ã³wnej. AÅ¼ jestem ciekawy jak to bÄ™dzie wyglÄ…da', '2016-07-07'),
(7, 19, 'Tweet nr.7 od user:zybura', '2016-07-08');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_polish_ci DEFAULT NULL,
  `hashed_password` char(60) COLLATE utf8_polish_ci NOT NULL,
  `user_description` text COLLATE utf8_polish_ci,
  `is_active` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=20 ;

--
-- Zrzut danych tabeli `Users`
--

INSERT INTO `Users` (`id`, `login`, `hashed_password`, `user_description`, `is_active`) VALUES
(16, 'pawel.zybura', '$2y$10$1UDrGZ/B7ZQDxWKAJdJE2.Z/w6PeQ41sQk/vmOnnb0qFmM8bTyWsa', 'Opis 5 dla pawel.zybura', 1),
(17, 'pyniok', '$2y$10$jX0xwMhm8hG.sFJqcvrFue7wbl8ZCY5Pz1PaSUEfhUDB6HcC/Q35O', 'Opis dla pyniok', 1),
(18, 'pawel', '$2y$10$Eqrkj1PVwDUSjjeN8Gkr8.XCCgXCfgDL2/QoZNpFXXOkWvBohF2Ia', '', 1),
(19, 'zybura', '$2y$10$HFR/A9/2m2v00s5fJ4ak0uKIqf1YoaZmCGYzmEIiMSHZE9dCMNjeO', 'Opis dla user:zybura', 1);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `Posts` (`id`);

--
-- Ograniczenia dla tabeli `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `Users` (`id`);

--
-- Ograniczenia dla tabeli `Posts`
--
ALTER TABLE `Posts`
  ADD CONSTRAINT `Posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

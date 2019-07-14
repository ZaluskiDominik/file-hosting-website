-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 14 Lip 2019, 13:16
-- Wersja serwera: 10.1.32-MariaDB
-- Wersja PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `test_file_upload`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `account_types`
--

CREATE TABLE `account_types` (
  `name` char(20) COLLATE utf8_polish_ci NOT NULL,
  `max_upload_file_size` bigint(16) DEFAULT NULL COMMENT 'GB',
  `max_num_uploads` int(11) NOT NULL,
  `max_storage_size` bigint(16) DEFAULT NULL COMMENT 'GB',
  `max_download_speed` int(11) DEFAULT NULL COMMENT 'Kb/s',
  `max_num_downloads` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `account_types`
--

INSERT INTO `account_types` (`name`, `max_upload_file_size`, `max_num_uploads`, `max_storage_size`, `max_download_speed`, `max_num_downloads`) VALUES
('guest', 1, 10, 10, 200, 1),
('premium', 20, 20, 50, NULL, NULL),
('regular', 4, 20, 15, 250, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `owner_ip` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `upload_id` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `downloads`
--

INSERT INTO `downloads` (`id`, `owner_id`, `owner_ip`, `upload_id`, `start_time`) VALUES
(48, 9, NULL, 204, '2019-07-13 11:28:07'),
(49, 9, NULL, 204, '2019-07-13 11:28:11'),
(50, NULL, '127.0.0.1', 204, '2019-07-13 11:28:44');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uploaded_files`
--

CREATE TABLE `uploaded_files` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `owner_ip` char(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `upload_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_filename` text COLLATE utf8_polish_ci NOT NULL,
  `path` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `uploaded_files`
--

INSERT INTO `uploaded_files` (`id`, `owner_id`, `owner_ip`, `upload_timestamp`, `client_filename`, `path`) VALUES
(204, 9, '127.0.0.1', '2019-07-13 11:27:44', 'rufus.ini', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/rufus.ini'),
(205, 9, '127.0.0.1', '2019-07-13 11:27:44', 'rufus-3.3p.exe', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/rufus-3.3p1.exe'),
(206, 9, '127.0.0.1', '2019-07-13 11:28:08', 'debian-9.8.0-amd64-netinst.iso', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/debian_9.8.0_amd64_netinst.iso'),
(207, NULL, '127.0.0.1', '2019-07-13 11:29:37', 'VirtualBox.exe', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/VirtualBox1.exe');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password_hash` text COLLATE utf8_polish_ci NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `surname` text COLLATE utf8_polish_ci NOT NULL,
  `email` char(100) COLLATE utf8_polish_ci NOT NULL,
  `account_type` char(20) COLLATE utf8_polish_ci NOT NULL,
  `ip` char(50) COLLATE utf8_polish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `password_hash`, `name`, `surname`, `email`, `account_type`, `ip`) VALUES
(8, '$2y$10$6CjsxzFVU0LjJODv2JDJBey.lwInmrIcVJNliQWjW.WAf07CjgGFK', 'Marek', 'Nowak', 'marek@gmail.com', 'regular', '127.0.0.1'),
(9, '$2y$10$UNCcNAWSLPJxwtQHELyhqOBT9ha5hZtDIhOojHV.t.ax9CYXKE8jO', 'Kamil', 'Kowalski', 'kamil.konieczny@wp.pl', 'regular', '127.0.0.1');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `account_types`
--
ALTER TABLE `account_types`
  ADD PRIMARY KEY (`name`);

--
-- Indeksy dla tabeli `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `upload_id` (`upload_id`);

--
-- Indeksy dla tabeli `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `account_type` (`account_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT dla tabeli `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`upload_id`) REFERENCES `uploaded_files` (`id`);

--
-- Ograniczenia dla tabeli `uploaded_files`
--
ALTER TABLE `uploaded_files`
  ADD CONSTRAINT `uploaded_files_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`account_type`) REFERENCES `account_types` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 04 Lip 2019, 18:19
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
-- Baza danych: `file_upload`
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
(33, NULL, '127.0.0.1', 193, '2019-07-01 15:31:43'),
(34, NULL, '127.0.0.1', 193, '2019-07-01 15:32:52'),
(35, NULL, '127.0.0.1', 193, '2019-07-01 15:33:54'),
(36, NULL, '127.0.0.1', 193, '2019-07-01 15:42:19'),
(37, NULL, '127.0.0.1', 193, '2019-07-01 15:43:20'),
(38, NULL, '127.0.0.1', 194, '2019-07-02 14:06:36'),
(39, NULL, '127.0.0.1', 194, '2019-07-02 15:26:19'),
(40, NULL, '127.0.0.1', 195, '2019-07-02 17:11:49'),
(41, 1, NULL, 195, '2019-07-02 17:14:24'),
(42, 1, NULL, 195, '2019-07-02 17:14:28'),
(43, 2, NULL, 197, '2019-07-04 11:30:52'),
(44, 2, NULL, 197, '2019-07-04 11:30:56'),
(45, NULL, '127.0.0.1', 197, '2019-07-04 11:31:11'),
(46, 3, NULL, 197, '2019-07-04 11:32:02'),
(47, 3, NULL, 197, '2019-07-04 11:32:06');

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
(193, NULL, '127.0.0.1', '2019-07-01 14:10:42', 'python-3.6.5.exe', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/python-3.6.51.exe'),
(194, NULL, '127.0.0.1', '2019-07-02 14:06:25', 'Sublime Text Build 3126 x64 Setup.exe', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/Sublime_Text_Build_3126_x64_Setup.exe'),
(195, 1, '127.0.0.1', '2019-07-02 17:11:42', 'codeblocks-17.12mingw-setup.exe', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/codeblocks_17.12mingw_setup.exe'),
(196, 2, '127.0.0.1', '2019-07-04 11:30:42', '.gitignore', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/.gitignore'),
(197, 2, '127.0.0.1', '2019-07-04 11:30:42', 'file_upload.sublime-project', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/file_upload.sublime_project'),
(198, 2, '127.0.0.1', '2019-07-04 11:30:42', 'file_upload.sublime-workspace', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/file_upload.sublime_workspace'),
(199, 2, '127.0.0.1', '2019-07-04 11:30:42', 'README.md', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/README.md'),
(200, NULL, '127.0.0.1', '2019-07-04 12:11:11', 'python-3.6.5.exe', 'C:/xampp/htdocs/file-hosting-website/public/../private/uploaded_files/python-3.6.52.exe');

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
(1, 'root', 'root', 'root', 'root@gmail.com', 'regular', NULL),
(2, '$2y$10$2LUiH3QTE/LGDtyN9ffw3e/MLM1fqbRMxmnTBxz484eAOaty7fM2W', 'Kamil', 'Nowy', 'email@a.com', 'regular', '127.0.0.1'),
(3, '$2y$10$M0iMR7gXbbTRXVdFhTdWJeP/d.x6dYkxryg4nGv/2UAwrxzgOzdAK', 'Marcin', 'Jakiś', 'marcin@gmail.com', 'regular', '127.0.0.1'),
(4, '$2y$10$HobWzXwWOQNElSxxKPniaOA2GaGwNXPVOfkmyWDEhVmShqVp4agou', 'sda', 'dsa', 'marek@gmail.com', 'regular', '127.0.0.1'),
(5, '$2y$10$O8CgGS/yqKCoxoS7/vwPGO3dpAgPrQAXaCjGJJlegnAySN37nY1om', 'dsa', 'dsa', 'marcin@gmail.co', 'regular', '127.0.0.1'),
(6, '$2y$10$ggLPMnCjtH3txqAmuGc8NeEUjZ8Y432u3YKDZsWv0DzoSXHbE4TTm', 'Kamil', 'Nowy', 'kamil@wp.pl', 'regular', '127.0.0.1');

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
  ADD KEY `account_type` (`account_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT dla tabeli `uploaded_files`
--
ALTER TABLE `uploaded_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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

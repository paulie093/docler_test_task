-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2018. Aug 13. 17:30
-- Kiszolgáló verziója: 10.1.33-MariaDB
-- PHP verzió: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `docler_test`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `confirm`
--

CREATE TABLE `confirm` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `hash` varchar(32) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `description` varchar(100) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(15) COLLATE utf8_hungarian_ci NOT NULL,
  `session_id` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_hungarian_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `confirm`
--
ALTER TABLE `confirm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- A tábla indexei `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `confirm`
--
ALTER TABLE `confirm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `confirm`
--
ALTER TABLE `confirm`
  ADD CONSTRAINT `confirm_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

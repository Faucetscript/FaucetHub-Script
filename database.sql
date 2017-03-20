-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Gegenereerd op: 20 mrt 2017 om 20:14
-- Serverversie: 10.1.13-MariaDB
-- PHP-versie: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `faucetscript`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faucet_banlist`
--

CREATE TABLE `faucet_banlist` (
  `id` int(32) UNSIGNED NOT NULL,
  `bitcoin_address` varchar(50) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `timestamp` int(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faucet_banned_address`
--

CREATE TABLE `faucet_banned_address` (
  `id` int(32) UNSIGNED NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faucet_banned_ip`
--

CREATE TABLE `faucet_banned_ip` (
  `id` int(32) UNSIGNED NOT NULL,
  `ip_address` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faucet_login_session`
--

CREATE TABLE `faucet_login_session` (
  `user_id` int(11) NOT NULL,
  `session_key` varchar(50) NOT NULL,
  `start_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faucet_pages`
--

CREATE TABLE `faucet_pages` (
  `id` int(32) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `timestamp_created` int(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faucet_settings`
--

CREATE TABLE `faucet_settings` (
  `id` int(32) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `faucet_settings`
--

INSERT INTO `faucet_settings` (`id`, `name`, `value`) VALUES
(1, 'faucet_name', 'FaucetScript'),
(2, 'faucet_slogan', 'A awesome open-source faucet script.'),
(3, 'space_top', 'Space on the top'),
(4, 'space_left', 'Space on the left side'),
(5, 'space_right', 'Space on the right side'),
(6, 'space_bottom', 'Space on the bottom'),
(7, 'timer', '60'),
(8, 'min_reward', '1'),
(9, 'max_reward', '100'),
(10, 'reCaptcha_privKey', ''),
(11, 'reCaptcha_pubKey', ''),
(12, 'faucethub_key', ''),
(13, 'referral_percent', '0'),
(14, 'withdraw_min', '0'),
(15, 'template', 'default');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faucet_transactions`
--

CREATE TABLE `faucet_transactions` (
  `id` int(32) UNSIGNED NOT NULL,
  `userid` int(32) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(10,8) NOT NULL,
  `timestamp` int(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `faucet_user_list`
--

CREATE TABLE `faucet_user_list` (
  `id` int(32) UNSIGNED NOT NULL,
  `address` varchar(75) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `balance` decimal(10,8) NOT NULL,
  `admin` int(1) NOT NULL DEFAULT '0',
  `joined` int(32) NOT NULL,
  `last_activity` int(32) NOT NULL,
  `referred_by` int(32) NOT NULL,
  `last_claim` int(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `faucet_banlist`
--
ALTER TABLE `faucet_banlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `faucet_banned_address`
--
ALTER TABLE `faucet_banned_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `faucet_banned_ip`
--
ALTER TABLE `faucet_banned_ip`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `faucet_login_session`
--
ALTER TABLE `faucet_login_session`
  ADD PRIMARY KEY (`session_key`);

--
-- Indexen voor tabel `faucet_pages`
--
ALTER TABLE `faucet_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `faucet_settings`
--
ALTER TABLE `faucet_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `faucet_transactions`
--
ALTER TABLE `faucet_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `faucet_user_list`
--
ALTER TABLE `faucet_user_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `faucet_banlist`
--
ALTER TABLE `faucet_banlist`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `faucet_banned_address`
--
ALTER TABLE `faucet_banned_address`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `faucet_banned_ip`
--
ALTER TABLE `faucet_banned_ip`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `faucet_pages`
--
ALTER TABLE `faucet_pages`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `faucet_settings`
--
ALTER TABLE `faucet_settings`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT voor een tabel `faucet_transactions`
--
ALTER TABLE `faucet_transactions`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `faucet_user_list`
--
ALTER TABLE `faucet_user_list`
  MODIFY `id` int(32) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

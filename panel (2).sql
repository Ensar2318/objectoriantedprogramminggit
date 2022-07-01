-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 01 Tem 2022, 14:56:38
-- Sunucu sürümü: 8.0.17
-- PHP Sürümü: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `panel`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admins`
--

CREATE TABLE `admins` (
  `admins_id` int(11) NOT NULL,
  `admins_namesurname` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `admins_file` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `admins_username` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `admins_pass` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `admin_status` enum('0','1') COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `admins`
--

INSERT INTO `admins` (`admins_id`, `admins_namesurname`, `admins_file`, `admins_username`, `admins_pass`, `admin_status`) VALUES
(1, 'Ensar s', '62be96b3c160c.png', 'ensar2318', '132132', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(11) NOT NULL,
  `settings_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `settings_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `settings_value` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `settings_type` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `settings_must` int(3) NOT NULL,
  `settings_delete` enum('0','1') COLLATE utf8_turkish_ci NOT NULL,
  `settings_status` enum('0','1') COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`settings_id`, `settings_description`, `settings_key`, `settings_value`, `settings_type`, `settings_must`, `settings_delete`, `settings_status`) VALUES
(1, 'Site Başlığı', 'title', 'MC CMS Yönetim Paneli', 'text', 0, '0', '1'),
(2, 'Site Açıklama', 'description', 'CMS Açıklama', 'text', 0, '0', '1'),
(3, 'Site Logo', 'logo', '', 'file', 0, '0', '1'),
(4, 'Fav Icon', 'icon', '', 'file', 0, '0', '1'),
(5, 'anahtar kelimeler', 'keywords', 'mc, cms, veniceler', 'text', 0, '0', '1'),
(6, 'Telefon Numarası', 'Phone', '5349190288', 'text', 0, '0', '1'),
(7, 'Mail Adresi', 'email', 'ensar@gmail.com', 'text', 0, '0', '1'),
(8, 'ilce', 'ilce', 'fatih', 'text', 0, '0', '1'),
(9, 'il', 'il', 'istanbul', 'text', 0, '0', '1'),
(10, 'açık adres', 'adres', 'Açık Adres ', 'textarea', 0, '0', '1'),
(11, 'Facebook Hesabı', 'facebook', 'www.facebook.com', 'text', 0, '0', '1'),
(12, 'instagram hesabı', 'instagram', 'www.instagram.com', 'text', 0, '0', '1'),
(13, 'Çalışma Saatleri', 'Work_hourse', 'Hafta içi 09:00 - 17:00', 'text', 0, '0', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `users_namesurname` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `users_file` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `users_mail` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `users_pass` varchar(100) COLLATE utf8_turkish_ci NOT NULL,
  `users_status` enum('0','1') COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`users_id`, `users_namesurname`, `users_file`, `users_mail`, `users_pass`, `users_status`) VALUES
(2, 'ensar', '62bdb2160e5f9.jpg', 'ensar@gmail.comss', '14', '1');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admins_id`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admins`
--
ALTER TABLE `admins`
  MODIFY `admins_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

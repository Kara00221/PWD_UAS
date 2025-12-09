-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Des 2025 pada 19.36
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafe_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `menu_items`
--

INSERT INTO `menu_items` (`id`, `name`, `description`, `price`, `category`, `is_available`, `created_at`, `updated_at`) VALUES
(14, 'teh hijau', 'bagi yang suka rumput', 15000.00, 'Tea', 1, '2025-12-08 18:11:57', '2025-12-08 18:11:57'),
(15, 'Klepon', 'hijiau', 18000.00, 'Snack', 1, '2025-12-08 18:12:15', '2025-12-08 18:12:15'),
(16, 'Americano', 'Bagi yang hidupnya pahit', 12000.00, 'Coffee', 1, '2025-12-08 18:12:41', '2025-12-08 18:23:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'pilat pilatan', 'pilat@gmail.com', '$2y$10$L94IZ4b.jiNm75w6hZWpoupRy.FRnbVsIIAVL.OHtKGUymGDgsFEi', '085212122121', '2025-12-01 14:30:59', '2025-12-01 15:29:58'),
(2, 'pap', 'pap@gmail.com', '$2y$10$vF7ioB6D3H6ATQcEj9.MHud1x/NnYDOWWe3pBo89/CQUJ2YmUzKtm', '1234567889', '2025-12-08 12:41:01', '2025-12-08 12:41:01'),
(3, 'iohi', 'haiohi@gmail.com', '$2y$10$hC4vjLLYMSTsPnAKsMMccuugbwM/GWjGY1EOsAAF8YrHYY4/hxqUi', '10492748912', '2025-12-08 12:53:42', '2025-12-08 12:53:42'),
(4, 'pq', 'pq@gmail.com', '$2y$10$11uVZjCfa2uG14.m64F2V.QqmsGnbJCpcdNZFGtM4mnW0DBRDxwEW', '1234123412', '2025-12-08 13:37:35', '2025-12-08 13:37:35'),
(5, 'asdfgh', 'asd@gmail.com', '$2y$10$NX9KjTHwQAf2B1i19EeVg.PuCTZhE0d7BVDHh2cDhBNBkdbKVasV.', '1234123412', '2025-12-08 13:50:05', '2025-12-08 13:50:37'),
(6, 'qwer', 'qwer@gmail.com', '$2y$10$GQf4Yjr85UeFr54GTHrKR.HOQ/19QQiUFOXpNXLBvJDqkXnq056TG', '1234123412', '2025-12-08 14:13:29', '2025-12-08 14:13:29'),
(7, 'lolo', 'lolok@gmail.com', '$2y$10$/D6LZ2dn8T59c9CYacMZ6O3hdmN.By2D2V0WZ8JaN0QW1SzbElgdW', '0987654321', '2025-12-08 16:13:58', '2025-12-08 16:15:30'),
(8, 'tes1', 'tes1@gmail.com', '$2y$10$XN4W4QHT.8dZngHW5tQJl.0k6A0/GuDp7qksdY.Gw40/gEU63IIqm', '0987654321', '2025-12-08 18:16:38', '2025-12-08 18:16:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE DATABASE user_auth_db;

/*! Válaszd ki az adatbázist*/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'Admin', 'Admin@gmail.com', '$2y$10$m3wtco7AWaNihxsRrRt3iuc2FhVl/.nvCJuTecrpbnPoDkdrKsrN.', '2025-04-05 11:56:23'),
(2, 'Test', 'Test@gmail.com', '$2y$10$jN/7aVDDiiZ4I5TZM.Wo8enRR9aHH8Wo.82AAYRo.g3R0OiIFvCca', '2025-04-05 11:56:49');

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

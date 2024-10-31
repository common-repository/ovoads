CREATE TABLE `{{prefix}}ovoads_advertise_sizes` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `name` varchar(40) NOT NULL,
  `type` varchar(40) NOT NULL,
  `width` varchar(40) NOT NULL,
  `height` varchar(40) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
INSERT INTO `{{prefix}}ovoads_advertise_sizes` (`id`, `name`, `type`, `width`, `height`,`created_at`, `updated_at`, `status`) VALUES
(1, 'Banner Ads', 'image', '970px', '270px', '2023-09-13 07:07:11', '2023-09-14 18:27:28', 1),
(2, 'Sidebar Ad', 'image', '728px', '90px', '2023-09-13 07:07:11', '2023-09-14 18:27:38', 1),
(3, 'Semi Square Ad', 'image', '300px', '250px', '2023-09-13 07:07:11', '2023-09-14 18:27:44', 1),
(4, 'Square Ad', 'image', '300px', '300px', '2023-09-13 07:07:11', '2023-09-14 18:27:48', 1),
(5, 'Inner Ad', 'image', '300px', '600px', '2023-09-13 07:07:11', '2023-09-14 18:27:53', 1),
(6, 'Wide Skyscaper Ad', 'image', '160px', '600px', '2023-09-13 07:07:11', '2023-09-14 18:27:59', 1);

CREATE TABLE `{{prefix}}ovoads_advertises` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `ad_code` varchar(40) NOT NULL,
  `ad_size_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `redirect_url` text NOT NULL,
  `ad_image` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `clicks` bigint(11) DEFAULT 0,
  `impressions` bigint(11) DEFAULT 0,
  `keywords` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `{{prefix}}ovoads_adreports` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `ad_id` int(11) NOT NULL,
  `type` varchar(40) DEFAULT NULL,
  `host` varchar(40) DEFAULT NULL,
  `browser` varchar(40) DEFAULT NULL,
  `country` varchar(40) DEFAULT NULL,
  `os` varchar(40) DEFAULT NULL,
  `ip` varchar(40) DEFAULT NULL,
  `ip_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `{{prefix}}ovoads_domain_lists` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `domain_name` varchar(40) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `{{prefix}}ovoads_keywords` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `keyword` varchar(40) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
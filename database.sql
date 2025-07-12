-- Table: users
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','asisten') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: praktikum
CREATE TABLE `praktikum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: modul
CREATE TABLE `modul` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `praktikum_id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `file_materi` varchar(255),
  PRIMARY KEY (`id`),
  KEY `praktikum_id` (`praktikum_id`),
  CONSTRAINT `modul_ibfk_1` FOREIGN KEY (`praktikum_id`) REFERENCES `praktikum` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: praktikum_mahasiswa (relasi mahasiswa daftar ke praktikum)
CREATE TABLE `praktikum_mahasiswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `praktikum_id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_relasi` (`praktikum_id`,`mahasiswa_id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  CONSTRAINT `pm_praktikum` FOREIGN KEY (`praktikum_id`) REFERENCES `praktikum` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pm_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: laporan (laporan yang diupload mahasiswa)
CREATE TABLE `laporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `modul_id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `file_laporan` varchar(255),
  `nilai` int(11) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_laporan` (`modul_id`,`mahasiswa_id`),
  KEY `mahasiswa_id` (`mahasiswa_id`),
  CONSTRAINT `laporan_modul` FOREIGN KEY (`modul_id`) REFERENCES `modul` (`id`) ON DELETE CASCADE,
  CONSTRAINT `laporan_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mahasiswa_id INT NOT NULL,
    praktikum_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY (mahasiswa_id, praktikum_id),
    FOREIGN KEY (mahasiswa_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (praktikum_id) REFERENCES praktikum(id) ON DELETE CASCADE
);

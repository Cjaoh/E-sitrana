CREATE DATABASE IF NOT EXISTS `E-sitrana_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `E-sitrana_db`;

-- Table pour les administrateurs
CREATE TABLE IF NOT EXISTS `admins` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(100) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les services
CREATE TABLE IF NOT EXISTS `services` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `description` text NOT NULL,
    `icon` varchar(100) DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les médecins
CREATE TABLE IF NOT EXISTS `doctors` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `first_name` varchar(50) NOT NULL,
    `last_name` varchar(50) NOT NULL,
    `speciality` varchar(100) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `email` varchar(100) NOT NULL,
    `photo` varchar(255) DEFAULT NULL,
    `description` text,
    `service_id` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `service_id` (`service_id`),
    CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les patients
CREATE TABLE IF NOT EXISTS `patients` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `first_name` varchar(50) NOT NULL,
    `last_name` varchar(50) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `email` varchar(100) NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table pour les rendez-vous
CREATE TABLE IF NOT EXISTS `appointments` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `patient_id` int(11) NOT NULL,
    `doctor_id` int(11) NOT NULL,
    `service_id` int(11) NOT NULL,
    `appointment_date` date NOT NULL,
    `appointment_time` time NOT NULL,
    `status` enum('en attente','confirmé','annulé','terminé') NOT NULL DEFAULT 'en attente',
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `patient_id` (`patient_id`),
    KEY `doctor_id` (`doctor_id`),
    KEY `service_id` (`service_id`),
    CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE,
    CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
    CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insérer un administrateur par défaut (mot de passe: admin123)
INSERT INTO `admins` (`username`, `password`, `email`) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@esitrana.com')
ON DUPLICATE KEY UPDATE username=username;

-- Insérer des services par défaut
INSERT INTO `services` (`name`, `description`, `icon`) VALUES 
('Médecine générale', 'Consultations générales pour tous les problèmes de santé courants', 'fa-user-md'),
('Pédiatrie', 'Soins médicaux spécialisés pour les enfants et les adolescents', 'fa-child'),
('Gynécologie', 'Santé féminine et soins gynécologiques complets', 'fa-female'),
('Cardiologie', 'Diagnostic et traitement des maladies cardiaques', 'fa-heartbeat'),
('Laboratoire', 'Analyses médicales et tests de laboratoire', 'fa-flask')
ON DUPLICATE KEY UPDATE name=name;

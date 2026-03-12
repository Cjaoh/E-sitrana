<?php
// Installation avec SQLite pour développement local

echo "=== Installation E-sitrana (SQLite) ===\n\n";

try {
    // Création de la base de données SQLite
    echo "1. Création de la base de données SQLite...\n";
    $pdo = new PDO('sqlite:E_sitrana.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Base de données SQLite créée\n";
    
    // Création des tables
    echo "\n2. Création des tables...\n";
    
    // Table admins
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admins (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Table services
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS services (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL,
            description TEXT NOT NULL,
            icon VARCHAR(100),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Table doctors
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS doctors (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            speciality VARCHAR(100) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL,
            photo VARCHAR(255),
            description TEXT,
            service_id INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (service_id) REFERENCES services(id)
        )
    ");
    
    // Table patients
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS patients (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            phone VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL,
            address VARCHAR(255),
            birth_date DATE,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Table appointments
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS appointments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            patient_id INTEGER NOT NULL,
            doctor_id INTEGER NOT NULL,
            service_id INTEGER NOT NULL,
            appointment_date DATE NOT NULL,
            appointment_time TIME NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'en attente',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (patient_id) REFERENCES patients(id),
            FOREIGN KEY (doctor_id) REFERENCES doctors(id),
            FOREIGN KEY (service_id) REFERENCES services(id)
        )
    ");
    
    echo "✓ Tables créées\n";
    
    // Insertion des données initiales
    echo "\n3. Insertion des données initiales...\n";
    
    // Admin par défaut
    $pdo->exec("
        INSERT OR IGNORE INTO admins (username, password, email) 
        VALUES ('admin', '\$2y\$10\$0KoHbKJIJTpzvGEcCA8t9ensIArFpS.X/R3/qeWHPmpCjIDg1nM8y', 'admin@esitrana.com')
    ");
    
    // Services
    $services = [
        ['Médecine générale', 'Consultations générales pour tous les problèmes de santé courants', 'fa-user-md'],
        ['Pédiatrie', 'Soins médicaux spécialisés pour les enfants et les adolescents', 'fa-child'],
        ['Gynécologie', 'Santé féminine et soins gynécologiques complets', 'fa-female'],
        ['Cardiologie', 'Diagnostic et traitement des maladies cardiaques', 'fa-heartbeat'],
        ['Laboratoire', 'Analyses médicales et tests de laboratoire', 'fa-flask']
    ];
    
    foreach ($services as $service) {
        $pdo->exec("
            INSERT OR IGNORE INTO services (name, description, icon) 
            VALUES ('".$service[0]."', '".$service[1]."', '".$service[2]."')
        ");
    }
    
    echo "✓ Données insérées\n";
    
    echo "\n=== Installation terminée avec succès! ===\n";
    echo "\nProchaines étapes:\n";
    echo "1. Modifiez config/database.php pour utiliser SQLite:\n";
    echo "   require_once 'database_sqlite.php';\n";
    echo "   \$database = new DatabaseSQLite();\n";
    echo "2. Démarrez le serveur: php -S localhost:8000 router.php\n";
    echo "3. Ouvrez votre navigateur: http://localhost:8000\n";
    echo "4. Administration: http://localhost:8000/admin\n";
    echo "5. Identifiant: admin / Mot de passe: admin123\n";
    
} catch (Exception $e) {
    echo "\n✗ Erreur: " . $e->getMessage() . "\n";
}
?>

<?php
echo "=== Test de connexion MySQL ===\n\n";

// Test avec différents identifiants
$tests = [
    ['root', ''],
    ['root', 'root'],
    ['root', 'root123'],
    ['root', 'mysql'],
    ['root', 'password'],
];

foreach ($tests as [$user, $pass]) {
    try {
        $pdo = new PDO("mysql:host=localhost", $user, $pass);
        echo "✓ Connexion réussie avec: $user / " . ($pass ? $pass : '(vide)') . "\n";
        
        // Si connexion réussie, créer la base de données
        $pdo->exec("CREATE DATABASE IF NOT EXISTS E_sitrana_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "  ✓ Base E_sitrana_db créée/vérifiée\n";
        
        // Importer les données
        $sql = file_get_contents('database_setup.sql');
        $pdo->exec("USE E_sitrana_db");
        
        // Séparer et exécuter les requêtes
        $statements = array_filter(array_map('trim', explode(';', $sql)));
        foreach ($statements as $statement) {
            if (!empty($statement) && !preg_match('/^--/', $statement)) {
                $pdo->exec($statement);
            }
        }
        echo "  ✓ Données importées\n";
        
        // Mettre à jour la configuration
        $config = "<?php\nclass Database {\n    private \$host = 'localhost';\n    private \$db_name = 'E_sitrana_db';\n    private \$username = '$user';\n    private \$password = '$pass';\n    public \$conn;\n\n    public function getConnection() {\n        \$this->conn = null;\n        \n        try {\n            \$this->conn = new PDO(\"mysql:host=\" . \$this->host . \";dbname=\" . \$this->db_name, \$this->username, \$this->password);\n            \$this->conn->exec(\"set names utf8\");\n            \$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);\n        } catch(PDOException \$exception) {\n            echo \"Connection error: \" . \$exception->getMessage();\n        }\n        \n        return \$this->conn;\n    }\n}\n?>";
        
        file_put_contents('config/database.php', $config);
        echo "  ✓ Configuration mise à jour\n";
        
        echo "\n=== MySQL configuré avec succès! ===\n";
        echo "Identifiants utilisés: $user / " . ($pass ? $pass : '(vide)') . "\n";
        echo "Base de données: E_sitrana_db\n";
        echo "\nProchaines étapes:\n";
        echo "1. php -S localhost:8000 router.php\n";
        echo "2. http://localhost:8000\n";
        echo "3. http://localhost:8000/admin\n";
        echo "4. Login: admin / admin123\n";
        
        exit(0);
        
    } catch (PDOException $e) {
        echo "✗ Échec avec: $user / " . ($pass ? $pass : '(vide)') . " - " . $e->getMessage() . "\n";
    }
}

echo "\n❌ Aucune connexion MySQL réussie\n";
echo "\nSolution manuelle:\n";
echo "1. sudo mysql_secure_installation\n";
echo "2. Ou: sudo mysql\n";
echo "3. ALTER USER 'root'@'localhost' IDENTIFIED BY 'votre_mot_de_passe';\n";
echo "4. FLUSH PRIVILEGES;\n";
?>

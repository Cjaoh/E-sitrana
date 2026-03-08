<?php
// Script d'installation simplifié pour E-sitrana

echo "=== Installation E-sitrana ===\n\n";

try {
    // Test de connexion à MySQL
    echo "1. Test de connexion à MySQL...\n";
    
    // Essai avec mot de passe vide
    try {
        $pdo = new PDO('mysql:host=localhost', 'root', '');
        echo "✓ Connexion réussie avec mot de passe vide\n";
    } catch (PDOException $e) {
        // Essai avec mot de passe par défaut 'root'
        try {
            $pdo = new PDO('mysql:host=localhost', 'root', 'root');
            echo "✓ Connexion réussie avec mot de passe 'root'\n";
        } catch (PDOException $e2) {
            echo "✗ Erreur de connexion: " . $e2->getMessage() . "\n";
            echo "\nVeuillez configurer manuellement MySQL:\n";
            echo "1. Connectez-vous à MySQL: mysql -u root -p\n";
            echo "2. Créez la base: CREATE DATABASE E_sitrana_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\n";
            echo "3. Importez: mysql -u root -p E_sitrana_db < database_setup.sql\n";
            exit(1);
        }
    }
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Création de la base de données
    echo "\n2. Création de la base de données...\n";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `E_sitrana_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Base de données 'E_sitrana_db' créée\n";
    
    // Sélection de la base de données
    $pdo->exec("USE `E_sitrana_db`");
    
    // Lecture et exécution du fichier SQL
    echo "\n3. Création des tables...\n";
    $sql = file_get_contents('database_setup.sql');
    
    // Séparation des requêtes SQL
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    foreach ($statements as $statement) {
        if (!empty($statement) && !preg_match('/^--/', $statement)) {
            $pdo->exec($statement);
        }
    }
    
    echo "✓ Tables créées avec succès\n";
    echo "✓ Données insérées\n";
    
    echo "\n=== Installation terminée avec succès! ===\n";
    echo "\nProchaines étapes:\n";
    echo "1. Démarrez le serveur: php -S localhost:8000 router.php\n";
    echo "2. Ouvrez votre navigateur: http://localhost:8000\n";
    echo "3. Administration: http://localhost:8000/admin\n";
    echo "4. Identifiant: admin / Mot de passe: admin123\n";
    
} catch (Exception $e) {
    echo "\n✗ Erreur: " . $e->getMessage() . "\n";
    echo "\nDépannage:\n";
    echo "- Vérifiez que MySQL est installé et actif\n";
    echo "- Vérifiez les permissions de l'utilisateur MySQL\n";
    echo "- Assurez-vous que le fichier database_setup.sql existe\n";
}
?>

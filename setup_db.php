<?php
try {
    // Connexion à MySQL sans spécifier de base de données
    $pdo = new PDO('mysql:host=localhost', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Créer la base de données
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `E_sitrana_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Base de données 'E_sitrana_db' créée avec succès!\n";
    
    // Se connecter à la base de données créée
    $pdo->exec("USE `E_sitrana_db`");
    
    // Importer le fichier SQL
    $sql = file_get_contents('database_setup.sql');
    $pdo->exec($sql);
    echo "Tables créées et données insérées avec succès!\n";
    
    echo "Installation terminée! Vous pouvez maintenant accéder à l'application.\n";
    
} catch (PDOException $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
    echo "Veuillez vérifier que MySQL est en cours d'exécution et que l'utilisateur 'root' a les droits nécessaires.\n";
}
?>

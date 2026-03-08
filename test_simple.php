<?php
// Test simple pour vérifier que tout fonctionne
require_once __DIR__ . '/config/database.php';

echo "=== Test E-sitrana ===\n\n";

try {
    $db = $database->getConnection();
    echo "✓ Connexion à la base de données réussie\n";
    
    // Test des services
    $stmt = $db->query("SELECT COUNT(*) as count FROM services");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Services trouvés: " . $result['count'] . "\n";
    
    // Test des médecins
    $stmt = $db->query("SELECT COUNT(*) as count FROM doctors");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Médecins trouvés: " . $result['count'] . "\n";
    
    // Test de l'admin
    $stmt = $db->query("SELECT COUNT(*) as count FROM admins");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✓ Admins trouvés: " . $result['count'] . "\n";
    
    echo "\n=== L'application fonctionne! ===\n";
    echo "Accédez à: http://localhost:8000\n";
    echo "Administration: http://localhost:8000/admin\n";
    echo "Login: admin / admin123\n";
    
} catch (Exception $e) {
    echo "✗ Erreur: " . $e->getMessage() . "\n";
}
?>

<?php
echo "=== Test Final MySQL E-sitrana ===\n\n";

require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();
    echo "✅ Connexion MySQL réussie!\n";
    
    // Test des services
    $stmt = $db->query("SELECT COUNT(*) as count FROM services");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Services trouvés: " . $result['count'] . "\n";
    
    // Test des médecins
    $stmt = $db->query("SELECT COUNT(*) as count FROM doctors");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Médecins trouvés: " . $result['count'] . "\n";
    
    // Test des admins
    $stmt = $db->query("SELECT COUNT(*) as count FROM admins");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Admins trouvés: " . $result['count'] . "\n";
    
    // Test des rendez-vous
    $stmt = $db->query("SELECT COUNT(*) as count FROM appointments");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Rendez-vous trouvés: " . $result['count'] . "\n";
    
    // Test des patients
    $stmt = $db->query("SELECT COUNT(*) as count FROM patients");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Patients trouvés: " . $result['count'] . "\n";
    
    echo "\n🎉 MySQL est parfaitement configuré!\n";
    echo "\n=== Configuration MySQL ===\n";
    echo "🔹 Base de données: E_sitrana_db\n";
    echo "🔹 Utilisateur: esitrana / E_sitrana@2024!\n";
    echo "🔹 Root MySQL: root / Root123456!\n";
    echo "\n=== Accès à l'application ===\n";
    echo "1. Démarrez le serveur: php -S localhost:8000 router.php\n";
    echo "2. Site public: http://localhost:8000\n";
    echo "3. Administration: http://localhost:8000/admin\n";
    echo "4. Login admin: admin / admin123\n";
    echo "\n🚀 L'application est prête!\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "\nDépannage:\n";
    echo "1. Vérifiez que MySQL fonctionne: sudo systemctl status mysql\n";
    echo "2. Redémarrez MySQL: sudo systemctl restart mysql\n";
    echo "3. Vérifiez les identifiants dans config/database_mysql.php\n";
}
?>

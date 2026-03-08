#!/bin/bash

echo "=== Configuration MySQL pour E-sitrana ==="

# Arrêter MySQL
sudo systemctl stop mysql

# Démarrer en mode sans mot de passe
sudo mysqld_safe --skip-grant-tables --skip-networking &
MYSQL_PID=$!

# Attendre que MySQL démarre
sleep 3

# Créer un nouveau script SQL
cat > reset_mysql.sql << EOF
USE mysql;

# Supprimer l'ancien utilisateur root s'il existe
DROP USER IF EXISTS 'root'@'localhost';

# Créer un nouvel utilisateur root avec mot de passe
CREATE USER 'root'@'localhost' IDENTIFIED BY 'root123';

# Donner tous les privilèges
GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' WITH GRANT OPTION;

# Créer la base de données E-sitrana
CREATE DATABASE IF NOT EXISTS E_sitrana_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Créer un utilisateur dédié pour l'application
CREATE USER IF NOT EXISTS 'esitrana'@'localhost' IDENTIFIED BY 'esitrana123';
GRANT ALL PRIVILEGES ON E_sitrana_db.* TO 'esitrana'@'localhost';

FLUSH PRIVILEGES;
EOF

# Exécuter le script
mysql -u root < reset_mysql.sql

# Arrêter MySQL en mode safe
sudo pkill mysqld
sleep 2

# Redémarrer MySQL normalement
sudo systemctl start mysql

# Attendre que MySQL redémarre
sleep 3

# Tester la connexion
mysql -u root -proot123 -e "SHOW DATABASES;"

if [ $? -eq 0 ]; then
    echo "✅ MySQL configuré avec succès!"
    echo "   - Utilisateur root: root / root123"
    echo "   - Base de données: E_sitrana_db"
    echo "   - Utilisateur app: esitrana / esitrana123"
    
    # Importer les données
    echo "Importation des données..."
    mysql -u root -proot123 E_sitrana_db < database_setup.sql
    
    if [ $? -eq 0 ]; then
        echo "✅ Données importées avec succès!"
    else
        echo "❌ Erreur lors de l'importation des données"
    fi
    
    # Mettre à jour la configuration
    cat > config/database.php << EOF
<?php
class Database {
    private \$host = 'localhost';
    private \$db_name = 'E_sitrana_db';
    private \$username = 'esitrana';
    private \$password = 'esitrana123';
    public \$conn;

    public function getConnection() {
        \$this->conn = null;
        
        try {
            \$this->conn = new PDO("mysql:host=" . \$this->host . ";dbname=" . \$this->db_name, \$this->username, \$this->password);
            \$this->conn->exec("set names utf8");
            \$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException \$exception) {
            echo "Connection error: " . \$exception->getMessage();
        }
        
        return \$this->conn;
    }
}
?>
EOF
    
    echo "✅ Configuration mise à jour!"
    echo ""
    echo "=== Installation terminée! ==="
    echo "1. Démarrez le serveur: php -S localhost:8000 router.php"
    echo "2. Accédez à: http://localhost:8000"
    echo "3. Administration: http://localhost:8000/admin"
    echo "4. Login: admin / admin123"
    
else
    echo "❌ Erreur de connexion à MySQL"
fi

# Nettoyer
rm -f reset_mysql.sql

# Lancement Manuel - E-sitrana

## 🚀 Commandes pour Démarrer le Projet

### Option 1: Serveur PHP intégré (Recommandé pour développement)

```bash
# Aller dans le dossier du projet
cd /home/cjaoh/Projet/E-sitrana

# Démarrer le serveur PHP sur le port 8000
php -S localhost:8000

# Ou sur le port 8080
php -S localhost:8080
```

**Accès:** http://localhost:8000 ou http://localhost:8080

---

### Option 2: Serveur PHP avec .htaccess support

```bash
# Démarrer avec support .htaccess (nécessite Apache)
cd /home/cjaoh/Projet/E-sitrana

# PHP 8.2+
php -S localhost:8000 -t . index.php

# Ou spécifier le router
php -S localhost:8000 index.php
```

---

### Option 3: Apache2 (Si installé)

```bash
# Créer un lien symbolique vers Apache
sudo ln -s /home/cjaoh/Projet/E-sitrana /var/www/html/esitrana

# Activer rewrite
sudo a2enmod rewrite

# Redémarrer Apache
sudo systemctl restart apache2

# Accès: http://localhost/esitrana
```

---

### Option 4: Nginx (Si installé)

```bash
# Configuration Nginx rapide
sudo nano /etc/nginx/sites-available/esitrana
```

**Contenu du fichier:**
```nginx
server {
    listen 80;
    server_name localhost;
    root /home/cjaoh/Projet/E-sitrana;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

```bash
# Activer le site
sudo ln -s /etc/nginx/sites-available/esitrana /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

---

## 📋 Prérequis

### 1. Base de Données MySQL

```bash
# Connexion MySQL
mysql -u root -p

# Créer la base de données
CREATE DATABASE E_sitrana_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Importer le schéma
mysql -u root -p E_sitrana_db < database_setup.sql

# Ou avec MySQL CLI
mysql -u root -p E_sitrana_db < database_setup.sql
```

### 2. Permissions

```bash
# Donner les permissions aux dossiers critiques
chmod 755 /home/cjaoh/Projet/E-sitrana/uploads
chmod 755 /home/cjaoh/Projet/E-sitrana/logs
chmod 644 /home/cjaoh/Projet/E-sitrana/uploads/.htaccess
```

### 3. Configuration

```bash
# Vérifier le fichier .env
cat /home/cjaoh/Projet/E-sitrana/.env

# Adapter si nécessaire
nano /home/cjaoh/Projet/E-sitrana/.env
```

---

## 🔧 Vérification

### Test de Syntaxe PHP

```bash
# Vérifier tous les fichiers PHP
find /home/cjaoh/Projet/E-sitrana -name "*.php" -exec php -l {} \;

# Ou vérifier fichier par fichier
php -l index.php
php -l api_router.php
```

### Test Base de Données

```bash
# Test de connexion
php -r "
require_once 'config/database.php';
\$db = new Database();
\$conn = \$db->getConnection();
echo \$conn ? 'DB OK' : 'DB ERROR';
"
```

---

## 🌐 Accès à l'Application

### URLs Principales
- **Accueil**: http://localhost:8000
- **Admin**: http://localhost:8000/admin
- **Login Admin**: http://localhost:8000/admin/login
- **API**: http://localhost:8000/api/

### Identifiants par Défaut
- **Username**: `admin`
- **Password**: `admin123`

---

## 🐛 Débogage

### Logs en Temps Réel

```bash
# Voir les logs applicatifs
tail -f /home/cjaoh/Projet/E-sitrana/logs/app_$(date +%Y-%m-%d).log

# Voir les logs du serveur PHP
php -S localhost:8000 2>&1 | tee server.log
```

### Mode Développement

```bash
# Activer le debug dans .env
echo "DEBUG=true" >> .env
echo "APP_ENV=development" >> .env
```

---

## 🚨 Problèmes Communs

### Erreur "Database connection failed"
```bash
# Vérifier MySQL
systemctl status mysql

# Vérifier les identifiants dans .env
grep DB_ /home/cjaoh/Projet/E-sitrana/.env
```

### Erreur "404 Not Found"
```bash
# Vérifier que .htaccess est activé
php -S localhost:8000 -t . index.php
```

### Erreur Permissions
```bash
# Corriger les permissions
chmod -R 755 /home/cjaoh/Projet/E-sitrana/uploads
chmod -R 755 /home/cjaoh/Projet/E-sitrana/logs
```

---

## 🎯 Commande Rapide (Recommandée)

```bash
# Lancement complet en une commande
cd /home/cjaoh/Projet/E-sitrana && \
chmod 755 uploads logs && \
php -S localhost:8000
```

Puis ouvrez: **http://localhost:8000**

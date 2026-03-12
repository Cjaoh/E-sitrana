# Guide d'Installation - E-sitrana Clinique Médicale

## Prérequis

- **PHP 8.0+** avec extensions :
  - PDO
  - PDO_MySQL
  - mbstring
  - json
  - curl

- **MySQL 5.7+** ou **MariaDB 10.2+**

- **Serveur web** (Apache avec mod_rewrite ou Nginx)

## Installation avec Docker (recommandé)

1. Démarrez l'application et la base MySQL :
   ```bash
   make up
   ```

2. Accédez à l'application :
   ```
   http://localhost:8080
   ```

3. Arrêter les services :
   ```bash
   make down
   ```

4. Si les uploads échouent :
   ```bash
   make perms
   ```

## Étape 1: Configuration de la base de données

1. Créez une base de données MySQL :
   ```sql
   CREATE DATABASE E_sitrana_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Importez le fichier SQL :
   ```bash
   mysql -u votre_utilisateur -p E_sitrana_db < database_setup.sql
   ```

3. Vérifiez que les tables ont été créées :
   ```sql
   USE E_sitrana_db;
   SHOW TABLES;
   ```

## Étape 2: Configuration du projet

1. Placez les fichiers du projet dans votre répertoire web (ex: `/var/www/html/E-sitrana/`)

2. Configurez les permissions :
   ```bash
   chmod -R 755 /var/www/html/E-sitrana/
   chmod -R 777 /var/www/html/E-sitrana/uploads/
   ```

3. Configurez la connexion à la base de données dans `config/database.php` si nécessaire :
   ```php
   private $host = 'localhost';
   private $db_name = 'E_sitrana_db';
   private $username = 'votre_utilisateur_mysql';
   private $password = 'votre_mot_de_passe_mysql';
   ```

## Étape 3: Configuration du serveur web

### Apache

1. Assurez-vous que `mod_rewrite` est activé :
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

2. Créez un fichier de configuration Apache :
   ```apache
   <VirtualHost *:80>
       ServerName votre-domaine.com
       DocumentRoot /var/www/html/E-sitrana
       
       <Directory /var/www/html/E-sitrana>
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/esitrana_error.log
       CustomLog ${APACHE_LOG_DIR}/esitrana_access.log combined
   </VirtualHost>
   ```

3. Activez le site et redémarrez Apache :
   ```bash
   sudo a2ensite esitrana.conf
   sudo systemctl reload apache2
   ```

### Nginx

1. Créez un fichier de configuration Nginx :
   ```nginx
   server {
       listen 80;
       server_name votre-domaine.com;
       root /var/www/html/E-sitrana;
       index router.php index.php;
       
       location / {
           try_files $uri $uri/ /router.php?$query_string;
       }
       
       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
           fastcgi_index router.php;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           include fastcgi_params;
       }
       
       location ~ /\.ht {
           deny all;
       }
   }
   ```

2. Testez et rechargez Nginx :
   ```bash
   sudo nginx -t
   sudo systemctl reload nginx
   ```

## Étape 4: Vérification de l'installation

1. Ouvrez votre navigateur et accédez à `http://votre-domaine.com`

2. Testez l'API en accédant à `http://votre-domaine.com/test_api.php`

3. Vérifiez que toutes les fonctionnalités sont opérationnelles

## Compte administrateur par défaut

- **Identifiant**: `admin`
- **Mot de passe**: `admin123`

**Important**: Changez ce mot de passe après la première connexion!

## Structure des dossiers

```
E-sitrana/
├── api/                    # Endpoints API
├── assets/                 # Fichiers statiques
│   ├── css/              # Styles CSS
│   ├── js/               # JavaScript
│   └── images/           # Images
├── config/                # Configuration
│   └── database.php      # Connexion BDD
├── models/                # Modèles PHP
├── uploads/               # Fichiers uploadés
│   ├── doctors/          # Photos des médecins
│   └── images/           # Images générales
├── views/                 # Vues
│   ├── admin/            # Pages admin
│   └── public/           # Pages publiques
├── .htaccess             # Configuration Apache
├── router.php            # Routeur principal
├── database_setup.sql    # Script BDD
├── test_api.php          # Test API
└── README.md             # Documentation
```

## Dépannage

### Problèmes courants

1. **Erreur 500 - Internal Server Error**
   - Vérifiez les logs d'erreur Apache/Nginx
   - Assurez-vous que les permissions sont correctes
   - Vérifiez la configuration PHP

2. **Erreur de connexion à la base de données**
   - Vérifiez les identifiants dans `config/database.php`
   - Assurez-vous que MySQL/MariaDB fonctionne
   - Vérifiez que la base de données existe

3. **URLs ne fonctionnent pas**
   - Assurez-vous que `mod_rewrite` est activé (Apache)
   - Vérifiez la configuration Nginx si applicable
   - Vérifiez le fichier `.htaccess`

4. **Upload de fichiers ne fonctionne pas**
   - Vérifiez les permissions du dossier `uploads/`
   - Assurez-vous que `upload_max_filesize` dans php.ini est suffisant

### Logs utiles

- **Apache**: `/var/log/apache2/error.log`
- **Nginx**: `/var/log/nginx/error.log`
- **PHP**: `/var/log/php_errors.log`

## Sécurité

1. **En production** :
   - Changez le mot de passe admin par défaut
   - Utilisez HTTPS (SSL/TLS)
   - Configurez un firewall
   - Mettez à jour régulièrement PHP et MySQL

2. **Permissions recommandées** :
   ```bash
   chmod 755 /var/www/html/E-sitrana/
   chmod 644 /var/www/html/E-sitrana/config/database.php
   chmod 777 /var/www/html/E-sitrana/uploads/
   ```

## Support

En cas de problème :
1. Consultez les logs d'erreur
2. Vérifiez la configuration PHP avec `phpinfo()`
3. Testez l'API avec `test_api.php`
4. Consultez la documentation dans `README.md`

## Mise à jour

Pour mettre à jour l'application :
1. Sauvegardez votre base de données
2. Remplacez les fichiers du projet
3. Exécutez les éventuels scripts de migration SQL
4. Testez toutes les fonctionnalités

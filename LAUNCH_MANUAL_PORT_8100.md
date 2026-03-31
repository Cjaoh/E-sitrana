# Lancement Manuel - E-sitrana (Port 8100)

## 🚀 Commandes pour Démarrer sur Port 8100

### Option 1: Serveur PHP intégré sur Port 8100

```bash
# Aller dans le dossier du projet
cd /home/cjaoh/Projet/E-sitrana

# Démarrer le serveur PHP sur le port 8100
php -S localhost:8100

# Ou avec IP spécifique (accessible depuis réseau)
php -S 0.0.0.0:8100
```

**Accès:** http://localhost:8100

---

## 🐳 Configuration Docker (Port 8100 déjà configuré!)

### Vérification Docker Compose
Le fichier `docker-compose.yml` est déjà configuré pour le port 8100:

```yaml
services:
  app:
    ports:
      - "8100:80"  # Port 8100 déjà configuré!
```

### Lancement avec Docker

```bash
# Lancer tous les services (app + base de données)
docker-compose up -d

# Vérifier les conteneurs
docker-compose ps

# Voir les logs
docker-compose logs -f app
```

**Accès Docker:** http://localhost:8100

---

## 🔧 Configuration Base de Données Docker

Le Docker utilise déjà les bonnes variables:
```yaml
environment:
  DB_HOST: db
  DB_NAME: E_sitrana_db
  DB_USER: esitrana
  DB_PASS: E_sitrana@2024!
```

**Note:** Le .env local utilise `DB_USERNAME` mais Docker utilise `DB_USER`

---

## 📋 Commandes Complètes

### Lancement Manuel (Port 8100)
```bash
cd /home/cjaoh/Projet/E-sitrana
chmod 755 uploads logs
php -S localhost:8100
```

### Lancement Docker (Port 8100)
```bash
cd /home/cjaoh/Projet/E-sitrana
docker-compose up -d
```

---

## 🌐 Accès Application (Port 8100)

### URLs Principales
- **Accueil**: http://localhost:8100
- **Admin**: http://localhost:8100/admin
- **Login Admin**: http://localhost:8100/admin/login
- **API**: http://localhost:8100/api/

### Identifiants par Défaut
- **Username**: `admin`
- **Password**: `admin123`

---

## 🐛 Débogage Port 8100

### Vérifier si le port est libre
```bash
# Vérifier l'utilisation du port
netstat -tlnp | grep :8100

# Ou avec ss
ss -tlnp | grep :8100
```

### Si port occupé
```bash
# Tuer le processus sur le port 8100
sudo fuser -k 8100/tcp

# Ou utiliser un autre port
php -S localhost:8101
```

---

## 🎯 Commande Recommandée

### Pour développement rapide:
```bash
cd /home/cjaoh/Projet/E-sitrana && php -S localhost:8100
```

### Pour production/Docker:
```bash
cd /home/cjaoh/Projet/E-sitrana && docker-compose up -d
```

---

## 📝 Résumé

**Oui, le port 8100 est déjà configuré pour Docker!**

- **Docker**: `docker-compose up -d` → http://localhost:8100
- **Manuel**: `php -S localhost:8100` → http://localhost:8100

Le Docker utilise le port 8100 pour l'application et gère automatiquement la base de données MySQL.

### Vérifier Docker Compose
<tool_call>read_file
<arg_key>file_path</arg_key>
<arg_value>/home/cjaoh/Projet/E-sitrana/docker-compose.yml

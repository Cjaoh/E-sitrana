# Améliorations de Sécurité - E-sitrana

## ✅ Points d'Attention Corrigés

### 1. CORS Sécurisé
- **Fichier**: `config/cors.php`
- **Fonctionnalité**: 
  - En développement: `Access-Control-Allow-Origin: *`
  - En production: Restriction au domaine `APP_URL`
  - Support des requêtes OPTIONS (pre-flight)

### 2. Sessions HTTPS Automatiques
- **Fichier**: `config/session.php`
- **Fonctionnalité**:
  - Détection automatique HTTPS
  - `session.cookie_secure` activé en production
  - `SameSite` adapté selon HTTPS

### 3. Dossiers Uploads Sécurisés
- **Dossiers créés**: `uploads/doctors/`, `uploads/images/`
- **Sécurité**: `.htaccess` avec interdiction d'exécution de scripts
- **Extensions autorisées**: Images et PDF uniquement

### 4. Rate Limiting Simple
- **Fichier**: `config/rate_limiter.php`
- **Limites**:
  - API Auth: 5 requêtes / 5 minutes
  - API Général: 100 requêtes / minute
- **Stockage**: Fichiers JSON dans `logs/`
- **Nettoyage**: Automatique après 1 heure

### 5. Système Email Basique
- **Fichier**: `config/email.php`
- **Fonctionnalités**:
  - Mode développement: Logging uniquement
  - Mode production: Envoi réel via `mail()`
  - Templates HTML pour notifications
- **Fonctions disponibles**:
  - `sendEmail()` - Email générique
  - `sendAppointmentConfirmation()` - Confirmation RDV
  - `sendAdminNotification()` - Notifications admin

## 🔧 Configuration

### Variables d'Environnement Ajoutées
```bash
# Email
ADMIN_EMAIL=admin@esitrana.mg

# Sécurité
APP_ENV=production  # ou development
APP_URL=https://votredomaine.com
```

### Utilisation Rate Limiting
```php
// Dans un endpoint API
if (!checkApiRateLimit()) {
    sendRateLimitResponse();
}
```

### Utilisation Email
```php
// Confirmation de rendez-vous
sendAppointmentConfirmation(
    $patient_email, 
    $patient_name, 
    $doctor_name, 
    $date, 
    $time
);

// Notification admin
sendAdminNotification(
    "Nouveau rendez-vous", 
    "Un patient a pris rendez-vous"
);
```

## 🚀 Déploiement en Production

### 1. Configuration
```bash
# .env
APP_ENV=production
APP_URL=https://votresite.com
DB_HOST=votre_host_mysql
DB_NAME=votre_db
DB_USERNAME=votre_user
DB_PASSWORD=votre_password
MAIL_HOST=votre_smtp
MAIL_PORT=587
MAIL_USERNAME=votre_email_smtp
MAIL_PASSWORD=votre_password_smtp
```

### 2. Permissions
```bash
chmod 755 uploads/
chmod 755 logs/
chmod 644 uploads/.htaccess
```

### 3. HTTPS
- Assurez-vous que votre serveur a un certificat SSL
- Les cookies seront automatiquement sécurisés
- CORS sera restreint à votre domaine

## 📊 Monitoring

### Logs Disponibles
- `logs/app_YYYY-MM-DD.log` - Logs applicatifs
- `logs/rate_limit_*.json` - Cache rate limiting (auto-nettoyé)
- `server.log` - Logs serveur web

### Types de Logs
- `INFO` - Requêtes API, connexions réussies
- `WARNING` - Tentatives échouées, rate limits
- `ERROR` - Erreurs base de données, envoi emails
- `DEBUG` - Informations de debug (si activé)

## 🎯 Sécurité

### Niveau Actuel: Élevé ✅
- ✅ Validation des entrées serveur
- ✅ Sessions sécurisées HTTPS
- ✅ Protection XSS
- ✅ Rate limiting
- ✅ CORS configuré
- ✅ Uploads sécurisés
- ✅ Logging des accès

### Recommandations Additionnelles
1. **Firewall applicatif** (WAF)
2. **Monitoring temps réel** des logs
3. **Sauvegardes automatiques** BDD
4. **Scanner vulnérabilités** régulier

## 📝 Maintenance

### Nettoyage Automatique
- Logs: 30 jours de rétention
- Rate limiting: 1 heure de rétention
- Sessions: 1 heure d'expiration

### Surveillance
- `tail -f logs/app_$(date +%Y-%m-%d).log`
- Vérifier les erreurs rate limiting
- Surveiller les tentatives d'accès frauduleuses

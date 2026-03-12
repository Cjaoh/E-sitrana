# E-sitrana - Clinique Médicale

Application web de gestion de clinique médicale avec système de prise de rendez-vous.

## Architecture

- **Backend**: PHP 8+
- **Base de données**: MySQL
- **Frontend**: HTML5 / CSS3 / Bootstrap / JavaScript

## Installation

### Démarrage rapide (Docker)

```bash
make up
```

Puis ouvrez `http://localhost:8080`.

### 1. Configuration de la base de données

1. Importez le fichier `database_setup.sql` dans votre base de données MySQL
2. Modifiez les informations de connexion dans `config/database.php` si nécessaire

### 2. Configuration du serveur web

Assurez-vous que votre serveur web supporte PHP et que le module Apache `mod_rewrite` est activé.

### 3. Permissions

Donnez les permissions d'écriture aux dossiers suivants:
- `uploads/doctors/`
- `uploads/images/`

## API Endpoints

### Services
- `GET /api/services` - Lister tous les services
- `GET /api/services?id={id}` - Obtenir un service spécifique
- `POST /api/services` - Créer un service
- `PUT /api/services?id={id}` - Mettre à jour un service
- `DELETE /api/services?id={id}` - Supprimer un service

### Médecins
- `GET /api/doctors` - Lister tous les médecins
- `GET /api/doctors?id={id}` - Obtenir un médecin spécifique
- `GET /api/doctors?service_id={id}` - Lister les médecins par service
- `POST /api/doctors` - Créer un médecin
- `PUT /api/doctors?id={id}` - Mettre à jour un médecin
- `DELETE /api/doctors?id={id}` - Supprimer un médecin

### Rendez-vous
- `GET /api/appointments` - Lister tous les rendez-vous
- `GET /api/appointments?id={id}` - Obtenir un rendez-vous spécifique
- `POST /api/appointments` - Créer un rendez-vous
- `PUT /api/appointments?id={id}` - Mettre à jour le statut d'un rendez-vous
- `DELETE /api/appointments?id={id}` - Supprimer un rendez-vous

### Authentification
- `POST /api/auth` - Connexion administrateur
- `GET /api/auth` - Vérifier l'état de connexion
- `DELETE /api/auth` - Déconnexion

### Dashboard
- `GET /api/dashboard` - Statistiques du tableau de bord (nécessite d'être connecté)

## Compte administrateur par défaut

- **Username**: admin
- **Password**: admin123

## Sécurité

- Mots de passe hashés avec bcrypt
- Protection contre les injections SQL avec PDO
- Validation des entrées
- Sessions PHP pour l'authentification

## Structure des dossiers

```
E-sitrana/
├── config/
│   └── database.php          # Configuration base de données
├── models/
│   ├── Admin.php            # Modèle administrateur
│   ├── Doctor.php           # Modèle médecin
│   ├── Patient.php          # Modèle patient
│   ├── Service.php          # Modèle service
│   └── Appointment.php      # Modèle rendez-vous
├── api/
│   ├── auth.php             # API authentification
│   ├── dashboard.php        # API dashboard
│   ├── doctors.php          # API médecins
│   ├── services.php         # API services
│   └── appointments.php     # API rendez-vous
├── uploads/
│   ├── doctors/             # Photos des médecins
│   └── images/              # Images générales
├── views/
│   ├── admin/               # Vues administrateur
│   └── public/              # Vues publiques
├── database_setup.sql       # Script de création BDD
├── index.php               # Routeur principal
├── .htaccess               # Configuration Apache
└── README.md               # Documentation
```

## Prochaines étapes

1. Développer le frontend avec les pages publiques
2. Créer l'interface administrateur
3. Ajouter le système d'upload de photos
4. Implémenter les notifications par email
5. Ajouter un système de paiement

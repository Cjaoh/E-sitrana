<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-sitrana - Clinique Médicale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-hospital-alt me-2"></i>E-sitrana
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/doctors">Médecins</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/appointment">Rendez-vous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light text-primary ms-2" href="/user-dashboard">
                            <i class="fas fa-user"></i> Mon Compte
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light" href="/admin/login">
                            <i class="fas fa-cog"></i> Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Bienvenue à E-sitrana</h1>
                    <p class="lead mb-4">Votre clinique de confiance pour des soins médicaux de qualité. Prenez rendez-vous facilement avec nos médecins spécialisés.</p>
                    <div class="d-flex gap-3">
                        <a href="/appointment" class="btn btn-light btn-lg">
                            <i class="fas fa-calendar-check me-2"></i>Prendre Rendez-vous
                        </a>
                        <a href="/doctors" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user-md me-2"></i>Voir nos Médecins
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-hospital-user display-1 opacity-75"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Preview -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Nos Services</h2>
                <p class="lead text-muted">Découvrez notre gamme de services médicaux</p>
            </div>
            <div class="row" id="services-preview">
                <div class="col-12 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/services" class="btn btn-outline-primary btn-lg">
                    Voir tous les services <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Doctors Preview -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Nos Médecins</h2>
                <p class="lead text-muted">Rencontrez notre équipe de professionnels de santé</p>
            </div>
            <div class="row" id="doctors-preview">
                <div class="col-12 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/doctors" class="btn btn-primary btn-lg">
                    Voir tous les médecins <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="feature-box p-4">
                        <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                        <h4>Disponibilité 24/7</h4>
                        <p class="text-muted">Service d'urgence disponible à tout moment</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-box p-4">
                        <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                        <h4>Médecins Expérimentés</h4>
                        <p class="text-muted">Équipe médicale hautement qualifiée</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-box p-4">
                        <i class="fas fa-heartbeat fa-3x text-primary mb-3"></i>
                        <h4>Soins de Qualité</h4>
                        <p class="text-muted">Équipements modernes et technologie avancée</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-hospital-alt me-2"></i>E-sitrana</h5>
                    <p class="text-muted">Votre santé est notre priorité</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="mb-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin"></i></a>
                    </div>
                    <p class="text-muted small mb-0">&copy; 2024 E-sitrana. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page d\'accueil E-sitrana chargée');
        
        // Fonction utilitaire pour extraire les données, qu'elles soient dans data.data ou data directement
        const getData = (json) => {
            console.log('Données API Services reçues:', json);
            return Array.isArray(json) ? json : (json.data && Array.isArray(json.data) ? json.data : json.records || []);
        };

        const getDoctorsData = (json) => {
            console.log('Données API Doctors reçues:', json);
            return Array.isArray(json) ? json : (json.data && Array.isArray(json.data) ? json.data : json.records || []);
        };

        // Charger les Services
        fetch('/api/services')
            .then(res => {
                console.log('Réponse API Services:', res.status);
                return res.json();
            })
            .then(json => {
                const data = getData(json);
                console.log('Services traités:', data);
                const container = document.getElementById('services-preview');
                if (!container) {
                    console.error('Container services-preview non trouvé');
                    return;
                }
                container.innerHTML = '';
                if (data.length === 0) {
                    container.innerHTML = '<p class="text-center">Aucun service disponible.</p>';
                    return;
                }
                
                data.slice(0, 3).forEach(s => {
                    container.innerHTML += `
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 text-center p-3">
                                <div class="card-body">
                                    <i class="fas ${s.icon || 'fa-stethoscope'} fa-3x text-primary mb-3"></i>
                                    <h4>${s.name || s.nom || 'Service'}</h4>
                                    <p class="text-muted">${s.description || ''}</p>
                                </div>
                            </div>
                        </div>`;
                });
                console.log('Services affichés:', data.length);
            }).catch(err => {
                console.error("Erreur API Services:", err);
                const container = document.getElementById('services-preview');
                if (container) {
                    container.innerHTML = '<p class="text-center text-danger">Erreur de chargement des services</p>';
                }
            });

        // Charger les Médecins
        fetch('/api/doctors')
            .then(res => {
                console.log('Réponse API Doctors:', res.status);
                return res.json();
            })
            .then(json => {
                const data = getDoctorsData(json);
                console.log('Doctors traités:', data);
                const container = document.getElementById('doctors-preview');
                if (!container) {
                    console.error('Container doctors-preview non trouvé');
                    return;
                }
                container.innerHTML = '';
                if (data.length === 0) {
                    container.innerHTML = '<p class="text-center">Aucun médecin disponible.</p>';
                    return;
                }

                data.slice(0, 3).forEach(d => {
                    const fullName = `${d.first_name || ''} ${d.last_name || ''}`.trim() || (d.name || 'Médecin');
                    container.innerHTML += `
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm border-0 text-center p-3">
                                <div class="card-body">
                                    <img src="${d.photo || 'https://via.placeholder.com/150'}" class="rounded-circle mb-3" width="100" height="100" style="object-fit:cover;">
                                    <h4>Dr. ${fullName}</h4>
                                    <p class="badge bg-info text-dark">${d.speciality || d.specialization || d.specialite || 'Généraliste'}</p>
                                </div>
                            </div>
                        </div>`;
                });
                console.log('Doctors affichés:', data.length);
            }).catch(err => {
                console.error("Erreur API Doctors:", err);
                const container = document.getElementById('doctors-preview');
                if (container) {
                    container.innerHTML = '<p class="text-center text-danger">Erreur de chargement des médecins</p>';
                }
            });
    });
    </script>
</body>
</html>

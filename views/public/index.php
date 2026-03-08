<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-sitrana - Clinique Médicale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Header Navigation -->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <i class="fas fa-hospital me-2"></i>E-sitrana
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="services.php">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="doctors.php">Médecins</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="appointment.php">Rendez-vous</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../views/admin/login.php">
                                <i class="fas fa-user-shield me-1"></i>Admin
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Bienvenue à la Clinique E-sitrana</h1>
            <p class="hero-subtitle">Votre santé, notre priorité - Des soins médicaux de qualité pour toute la famille</p>
            <a href="appointment.php" class="btn btn-primary btn-lg">
                <i class="fas fa-calendar-check me-2"></i>Prendre rendez-vous
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-4">À propos de E-sitrana</h2>
                    <p class="lead">La clinique E-sitrana est un établissement médical moderne dédié à offrir des soins de santé complets et personnalisés à tous nos patients.</p>
                    <p>Nous disposons d'une équipe de médecins expérimentés et dévoués, spécialisés dans divers domaines médicaux pour répondre à tous vos besoins de santé.</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i>Équipe médicale qualifiée</li>
                        <li><i class="fas fa-check text-success me-2"></i>Équipements modernes</li>
                        <li><i class="fas fa-check text-success me-2"></i>Service personnalisé</li>
                        <li><i class="fas fa-check text-success me-2"></i>Disponibilité 7j/7</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <img src="https://via.placeholder.com/600x400" alt="Clinique E-sitrana" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </section>

    <!-- Services Preview -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Nos Services</h2>
                <p class="lead">Découvrez notre gamme complète de services médicaux</p>
            </div>
            <div class="row g-4" id="services-preview">
                <!-- Services will be loaded dynamically -->
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="spinner"></div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="services.php" class="btn btn-outline-primary">
                    Voir tous les services <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Doctors Preview -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Notre Équipe Médicale</h2>
                <p class="lead">Des professionnels de santé à votre service</p>
            </div>
            <div class="row g-4" id="doctors-preview">
                <!-- Doctors will be loaded dynamically -->
                <div class="col-md-4">
                    <div class="doctor-card">
                        <div class="spinner"></div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="doctors.php" class="btn btn-outline-primary">
                    Voir tous les médecins <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Pourquoi nous choisir?</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>Disponibilité</h4>
                        <p>Service disponible 7 jours sur 7 avec des rendez-vous flexibles</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h4>Experts</h4>
                        <p>Équipe de médecins spécialisés et expérimentés</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h4>Soins complets</h4>
                        <p>Large gamme de services médicaux sous un même toit</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4>Support</h4>
                        <p>Assistance téléphonique et suivi personnalisé</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="mb-3">Témoignages</h2>
                <p class="lead">Ce que nos patients disent de nous</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"Excellent service médical! Le personnel est très professionnel et attentionné."</p>
                            <footer class="blockquote-footer mb-0">Marie K.</footer>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"Je recommande vivement cette clinique. Les médecins sont compétents et à l'écoute."</p>
                            <footer class="blockquote-footer mb-0">Jean-Pierre M.</footer>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <p class="card-text">"Service impeccable! Prise de rendez-vous en ligne très pratique."</p>
                            <footer class="blockquote-footer mb-0">Sophie L.</footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>E-sitrana</h5>
                    <p>Votre clinique de confiance pour des soins médicaux de qualité.</p>
                    <div class="mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>Services</h5>
                    <ul class="list-unstyled">
                        <li><a href="services.php" class="text-white">Médecine générale</a></li>
                        <li><a href="services.php" class="text-white">Pédiatrie</a></li>
                        <li><a href="services.php" class="text-white">Gynécologie</a></li>
                        <li><a href="services.php" class="text-white">Cardiologie</a></li>
                        <li><a href="services.php" class="text-white">Laboratoire</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i>Lot II J 23 Ter Antsirabe, Madagascar</li>
                        <li><i class="fas fa-phone me-2"></i>+261 34 78 23 45</li>
                        <li><i class="fas fa-envelope me-2"></i>contact@esitrana.mg</li>
                        <li><i class="fas fa-clock me-2"></i>Lun-Dim: 8h-20h</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-white">
            <div class="text-center">
                <p>&copy; 2024 E-sitrana. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        // Load services preview
        async function loadServicesPreview() {
            try {
                const services = await app.getServices();
                const container = document.getElementById('services-preview');
                container.innerHTML = '';
                
                services.slice(0, 3).forEach(service => {
                    const serviceCard = document.createElement('div');
                    serviceCard.className = 'col-md-4';
                    serviceCard.innerHTML = `
                        <div class="service-card">
                            <div class="service-icon">
                                ${app.getServiceIcon(service.icon)}
                            </div>
                            <h4 class="service-title">${service.name}</h4>
                            <p>${service.description.substring(0, 100)}...</p>
                        </div>
                    `;
                    container.appendChild(serviceCard);
                });
            } catch (error) {
                console.error('Error loading services:', error);
            }
        }

        // Load doctors preview
        async function loadDoctorsPreview() {
            try {
                const doctors = await app.getDoctors();
                const container = document.getElementById('doctors-preview');
                container.innerHTML = '';
                
                doctors.slice(0, 3).forEach(doctor => {
                    const doctorCard = document.createElement('div');
                    doctorCard.className = 'col-md-4';
                    doctorCard.innerHTML = `
                        <div class="doctor-card">
                            <div class="doctor-image">
                                ${doctor.photo ? `<img src="/uploads/doctors/${doctor.photo}" alt="${doctor.first_name} ${doctor.last_name}">` : '<i class="fas fa-user-md"></i>'}
                            </div>
                            <div class="doctor-info">
                                <h5 class="doctor-name">Dr ${doctor.first_name} ${doctor.last_name}</h5>
                                <p class="doctor-specialty">${doctor.speciality}</p>
                                <a href="appointment.php?doctor=${doctor.id}" class="btn btn-primary btn-sm">Prendre rendez-vous</a>
                            </div>
                        </div>
                    `;
                    container.appendChild(doctorCard);
                });
            } catch (error) {
                console.error('Error loading doctors:', error);
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadServicesPreview();
            loadDoctorsPreview();
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - E-sitrana Clinique Médicale</title>
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
                            <a class="nav-link active" href="services.php">Services</a>
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
                            <a class="nav-link" href="/views/admin/login.php">
                                <i class="fas fa-user-shield me-1"></i>Admin
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Header -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Nos Services Médicaux</h1>
            <p class="hero-subtitle">Découvrez notre gamme complète de services de santé</p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container">
            <div id="services-container">
                <div class="text-center py-5">
                    <div class="spinner"></div>
                    <p class="mt-3">Chargement des services...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Service Details Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalTitle">Détails du service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="serviceModalBody">
                    <!-- Service details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="redirectToAppointment()">
                        <i class="fas fa-calendar-check me-2"></i>Prendre rendez-vous
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                        <li><i class="fas fa-phone me-2"></i>+261 34 12 345 67</li>
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
        let currentServiceId = null;

        // Load all services
        async function loadServices() {
            try {
                const services = await app.getServices();
                const container = document.getElementById('services-container');
                
                if (services.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h3>Aucun service disponible</h3>
                            <p class="text-muted">Les services seront bientôt disponibles.</p>
                        </div>
                    `;
                    return;
                }

                container.innerHTML = `
                    <div class="row g-4">
                        ${services.map(service => `
                            <div class="col-md-6 col-lg-4">
                                <div class="service-card h-100" onclick="showServiceDetails(${service.id})" style="cursor: pointer;">
                                    <div class="service-icon">
                                        ${app.getServiceIcon(service.icon)}
                                    </div>
                                    <h4 class="service-title">${service.name}</h4>
                                    <p>${service.description}</p>
                                    <div class="mt-auto">
                                        <span class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-info-circle me-1"></i>En savoir plus
                                        </span>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            } catch (error) {
                console.error('Error loading services:', error);
                document.getElementById('services-container').innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <h3>Erreur de chargement</h3>
                        <p class="text-muted">Impossible de charger les services. Veuillez réessayer plus tard.</p>
                        <button class="btn btn-primary" onclick="loadServices()">
                            <i class="fas fa-sync me-2"></i>Réessayer
                        </button>
                    </div>
                `;
            }
        }

        // Show service details in modal
        async function showServiceDetails(serviceId) {
            try {
                const services = await app.getServices();
                const service = services.find(s => s.id === serviceId);
                
                if (!service) {
                    app.showAlert('Service non trouvé', 'danger');
                    return;
                }

                currentServiceId = serviceId;
                
                // Load doctors for this service
                const doctors = await app.getDoctors(serviceId);
                
                document.getElementById('serviceModalTitle').textContent = service.name;
                document.getElementById('serviceModalBody').innerHTML = `
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center mb-4">
                                <div class="service-icon" style="font-size: 4rem;">
                                    ${app.getServiceIcon(service.icon)}
                                </div>
                            </div>
                            <h5 class="mb-3">Description</h5>
                            <p>${service.description}</p>
                            
                            ${doctors.length > 0 ? `
                                <h5 class="mt-4 mb-3">Médecins disponibles</h5>
                                <div class="row g-3">
                                    ${doctors.map(doctor => `
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6 class="card-title">
                                                        <i class="fas fa-user-md me-2"></i>
                                                        Dr ${doctor.first_name} ${doctor.last_name}
                                                    </h6>
                                                    <p class="card-text text-muted">${doctor.speciality}</p>
                                                    <a href="appointment.php?doctor=${doctor.id}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-calendar me-1"></i>Prendre rendez-vous
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            ` : `
                                <div class="alert alert-info mt-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Aucun médecin n'est actuellement disponible pour ce service.
                                </div>
                            `}
                        </div>
                    </div>
                `;
                
                const modal = new bootstrap.Modal(document.getElementById('serviceModal'));
                modal.show();
            } catch (error) {
                console.error('Error loading service details:', error);
                app.showAlert('Impossible de charger les détails du service', 'danger');
            }
        }

        // Redirect to appointment page with selected service
        function redirectToAppointment() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('serviceModal'));
            modal.hide();
            
            if (currentServiceId) {
                window.location.href = `appointment.php?service=${currentServiceId}`;
            } else {
                window.location.href = 'appointment.php';
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadServices();
        });
    </script>
</body>
</html>

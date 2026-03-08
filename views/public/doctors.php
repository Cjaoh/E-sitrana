<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Médecins - E-sitrana Clinique Médicale</title>
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
                            <a class="nav-link active" href="doctors.php">Médecins</a>
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
            <h1 class="hero-title">Notre Équipe Médicale</h1>
            <p class="hero-subtitle">Des médecins expérimentés et dévoués à votre service</p>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">Filtrer par service:</h5>
                </div>
                <div class="col-md-6">
                    <select class="form-select" id="serviceFilter">
                        <option value="">Tous les services</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Doctors Section -->
    <section class="py-5">
        <div class="container">
            <div id="doctors-container">
                <div class="text-center py-5">
                    <div class="spinner"></div>
                    <p class="mt-3">Chargement des médecins...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Doctor Details Modal -->
    <div class="modal fade" id="doctorModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doctorModalTitle">Détails du médecin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="doctorModalBody">
                    <!-- Doctor details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" id="appointmentBtn">
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
        let currentDoctorId = null;
        let allDoctors = [];
        let allServices = [];

        // Load services for filter
        async function loadServices() {
            try {
                const services = await app.getServices();
                allServices = services;
                const filter = document.getElementById('serviceFilter');
                
                services.forEach(service => {
                    const option = document.createElement('option');
                    option.value = service.id;
                    option.textContent = service.name;
                    filter.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading services:', error);
            }
        }

        // Load doctors
        async function loadDoctors(serviceId = null) {
            try {
                const doctors = await app.getDoctors(serviceId);
                allDoctors = doctors;
                const container = document.getElementById('doctors-container');
                
                if (doctors.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-5">
                            <i class="fas fa-user-md fa-3x text-muted mb-3"></i>
                            <h3>Aucun médecin disponible</h3>
                            <p class="text-muted">${serviceId ? 'Aucun médecin trouvé pour ce service.' : 'Les médecins seront bientôt disponibles.'}</p>
                        </div>
                    `;
                    return;
                }

                container.innerHTML = `
                    <div class="row g-4">
                        ${doctors.map(doctor => `
                            <div class="col-md-6 col-lg-4">
                                <div class="doctor-card" onclick="showDoctorDetails(${doctor.id})" style="cursor: pointer;">
                                    <div class="doctor-image">
                                        ${doctor.photo ? `<img src="/uploads/doctors/${doctor.photo}" alt="${doctor.first_name} ${doctor.last_name}" style="width: 100%; height: 100%; object-fit: cover;">` : '<i class="fas fa-user-md"></i>'}
                                    </div>
                                    <div class="doctor-info">
                                        <h5 class="doctor-name">Dr ${doctor.first_name} ${doctor.last_name}</h5>
                                        <p class="doctor-specialty">${doctor.speciality}</p>
                                        <p class="text-muted small mb-2">
                                            <i class="fas fa-hospital me-1"></i>${doctor.service_name || 'Service non spécifié'}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-info-circle me-1"></i>Détails
                                            </span>
                                            <a href="appointment.php?doctor=${doctor.id}" class="btn btn-primary btn-sm" onclick="event.stopPropagation()">
                                                <i class="fas fa-calendar me-1"></i>RDV
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            } catch (error) {
                console.error('Error loading doctors:', error);
                document.getElementById('doctors-container').innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <h3>Erreur de chargement</h3>
                        <p class="text-muted">Impossible de charger les médecins. Veuillez réessayer plus tard.</p>
                        <button class="btn btn-primary" onclick="loadDoctors()">
                            <i class="fas fa-sync me-2"></i>Réessayer
                        </button>
                    </div>
                `;
            }
        }

        // Show doctor details in modal
        function showDoctorDetails(doctorId) {
            const doctor = allDoctors.find(d => d.id === doctorId);
            
            if (!doctor) {
                app.showAlert('Médecin non trouvé', 'danger');
                return;
            }

            currentDoctorId = doctorId;
            
            document.getElementById('doctorModalTitle').textContent = `Dr ${doctor.first_name} ${doctor.last_name}`;
            document.getElementById('doctorModalBody').innerHTML = `
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="doctor-image mb-3" style="height: 200px;">
                            ${doctor.photo ? `<img src="/uploads/doctors/${doctor.photo}" alt="${doctor.first_name} ${doctor.last_name}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">` : '<i class="fas fa-user-md" style="font-size: 5rem;"></i>'}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h5>Informations professionnelles</h5>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Spécialité:</strong></td>
                                <td>${doctor.speciality}</td>
                            </tr>
                            <tr>
                                <td><strong>Service:</strong></td>
                                <td>${doctor.service_name || 'Non spécifié'}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>${doctor.email}</td>
                            </tr>
                            <tr>
                                <td><strong>Téléphone:</strong></td>
                                <td>${doctor.phone}</td>
                            </tr>
                        </table>
                        
                        ${doctor.description ? `
                            <h5 class="mt-4">Biographie</h5>
                            <p>${doctor.description}</p>
                        ` : ''}
                    </div>
                </div>
            `;
            
            // Update appointment button
            document.getElementById('appointmentBtn').onclick = function() {
                window.location.href = `appointment.php?doctor=${doctorId}`;
            };
            
            const modal = new bootstrap.Modal(document.getElementById('doctorModal'));
            modal.show();
        }

        // Service filter change handler
        document.getElementById('serviceFilter').addEventListener('change', function() {
            const serviceId = this.value ? parseInt(this.value) : null;
            loadDoctors(serviceId);
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadServices();
            loadDoctors();
        });
    </script>
</body>
</html>

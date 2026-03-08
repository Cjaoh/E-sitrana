<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prise de Rendez-vous - E-sitrana Clinique Médicale</title>
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
                            <a class="nav-link active" href="appointment.php">Rendez-vous</a>
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
            <h1 class="hero-title">Prise de Rendez-vous</h1>
            <p class="hero-subtitle">Réservez votre consultation en quelques clics</p>
        </div>
    </section>

    <!-- Appointment Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="appointment-form">
                        <h3 class="mb-4 text-center">
                            <i class="fas fa-calendar-check me-2"></i>Formulaire de rendez-vous
                        </h3>
                        
                        <form id="appointmentForm" novalidate>
                            <!-- Patient Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="mb-3">
                                        <i class="fas fa-user me-2"></i>Informations du patient
                                    </h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">Nom *</label>
                                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                                    <div class="invalid-feedback">Veuillez entrer votre nom</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Prénom *</label>
                                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                                    <div class="invalid-feedback">Veuillez entrer votre prénom</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Téléphone *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                    <div class="invalid-feedback">Veuillez entrer un numéro de téléphone valide</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">Veuillez entrer une adresse email valide</div>
                                </div>
                            </div>

                            <!-- Appointment Details -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="mb-3">
                                        <i class="fas fa-calendar-alt me-2"></i>Détails du rendez-vous
                                    </h5>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="service" class="form-label">Service *</label>
                                    <select class="form-select" id="service" name="service_id" required>
                                        <option value="">Sélectionnez un service</option>
                                    </select>
                                    <div class="invalid-feedback">Veuillez sélectionner un service</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="doctor" class="form-label">Médecin *</label>
                                    <select class="form-select" id="doctor" name="doctor_id" required>
                                        <option value="">Sélectionnez d'abord un service</option>
                                    </select>
                                    <div class="invalid-feedback">Veuillez sélectionner un médecin</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="appointmentDate" class="form-label">Date du rendez-vous *</label>
                                    <input type="date" class="form-control" id="appointmentDate" name="appointment_date" required>
                                    <div class="invalid-feedback">Veuillez sélectionner une date</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="appointmentTime" class="form-label">Heure du rendez-vous *</label>
                                    <select class="form-select" id="appointmentTime" name="appointment_time" required>
                                        <option value="">Sélectionnez une heure</option>
                                    </select>
                                    <div class="invalid-feedback">Veuillez sélectionner une heure</div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <i class="fas fa-check-circle me-2"></i>Confirmer le rendez-vous
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-check-circle me-2"></i>Rendez-vous confirmé!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-calendar-check fa-3x text-success mb-3"></i>
                    <h5>Votre rendez-vous a été enregistré avec succès</h5>
                    <p class="text-muted">Nous vous contacterons bientôt pour confirmer les détails.</p>
                    <div id="appointmentSummary"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
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
                        <li><i class="fas fa-phone me-2"></i>+261 34 123 45 67</li>
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
        let allServices = [];
        let allDoctors = [];

        // Initialize time slots
        function initializeTimeSlots() {
            const timeSelect = document.getElementById('appointmentTime');
            const times = [
                '08:00', '08:30', '09:00', '09:30', '10:00', '10:30',
                '11:00', '11:30', '14:00', '14:30', '15:00', '15:30',
                '16:00', '16:30', '17:00', '17:30', '18:00', '18:30'
            ];

            times.forEach(time => {
                const option = document.createElement('option');
                option.value = time;
                option.textContent = time;
                timeSelect.appendChild(option);
            });
        }

        // Set minimum date to today
        function setMinDate() {
            const dateInput = document.getElementById('appointmentDate');
            const today = new Date().toISOString().split('T')[0];
            dateInput.min = today;
        }

        // Load services
        async function loadServices() {
            try {
                const services = await app.getServices();
                allServices = services;
                const serviceSelect = document.getElementById('service');
                
                services.forEach(service => {
                    const option = document.createElement('option');
                    option.value = service.id;
                    option.textContent = service.name;
                    serviceSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading services:', error);
                app.showAlert('Impossible de charger les services', 'danger');
            }
        }

        // Load doctors based on selected service
        async function loadDoctors(serviceId) {
            try {
                const doctors = await app.getDoctors(serviceId);
                allDoctors = doctors;
                const doctorSelect = document.getElementById('doctor');
                
                doctorSelect.innerHTML = '<option value="">Sélectionnez un médecin</option>';
                
                doctors.forEach(doctor => {
                    const option = document.createElement('option');
                    option.value = doctor.id;
                    option.textContent = `Dr ${doctor.first_name} ${doctor.last_name} - ${doctor.speciality}`;
                    doctorSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading doctors:', error);
                app.showAlert('Impossible de charger les médecins', 'danger');
            }
        }

        // Handle service change
        document.getElementById('service').addEventListener('change', function() {
            const serviceId = this.value;
            if (serviceId) {
                loadDoctors(serviceId);
            } else {
                document.getElementById('doctor').innerHTML = '<option value="">Sélectionnez d\'abord un service</option>';
            }
        });

        // Handle form submission
        document.getElementById('appointmentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!app.validateForm(this)) {
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            app.showLoading(submitBtn);

            try {
                const formData = new FormData(this);
                const appointmentData = {
                    first_name: formData.get('first_name'),
                    last_name: formData.get('last_name'),
                    phone: formData.get('phone'),
                    email: formData.get('email'),
                    service_id: parseInt(formData.get('service_id')),
                    doctor_id: parseInt(formData.get('doctor_id')),
                    appointment_date: formData.get('appointment_date'),
                    appointment_time: formData.get('appointment_time')
                };

                await app.createAppointment(appointmentData);
                
                // Show success modal with appointment details
                const service = allServices.find(s => s.id === appointmentData.service_id);
                const doctor = allDoctors.find(d => d.id === appointmentData.doctor_id);
                
                document.getElementById('appointmentSummary').innerHTML = `
                    <div class="text-start mt-3">
                        <p><strong>Patient:</strong> ${appointmentData.first_name} ${appointmentData.last_name}</p>
                        <p><strong>Service:</strong> ${service ? service.name : 'N/A'}</p>
                        <p><strong>Médecin:</strong> Dr ${doctor ? doctor.first_name + ' ' + doctor.last_name : 'N/A'}</p>
                        <p><strong>Date:</strong> ${app.formatDate(appointmentData.appointment_date)}</p>
                        <p><strong>Heure:</strong> ${appointmentData.appointment_time}</p>
                    </div>
                `;
                
                const modal = new bootstrap.Modal(document.getElementById('successModal'));
                modal.show();
                
                // Reset form
                this.reset();
                document.getElementById('doctor').innerHTML = '<option value="">Sélectionnez d\'abord un service</option>';
                
            } catch (error) {
                console.error('Error creating appointment:', error);
            } finally {
                app.hideLoading(submitBtn, originalText);
            }
        });

        // Check URL parameters for pre-filled values
        function checkUrlParameters() {
            const urlParams = new URLSearchParams(window.location.search);
            
            if (urlParams.has('service')) {
                const serviceId = urlParams.get('service');
                document.getElementById('service').value = serviceId;
                loadDoctors(serviceId);
            }
            
            if (urlParams.has('doctor')) {
                const doctorId = urlParams.get('doctor');
                // We need to load all doctors first to find the service
                setTimeout(() => {
                    const doctor = allDoctors.find(d => d.id === parseInt(doctorId));
                    if (doctor) {
                        document.getElementById('service').value = doctor.service_id;
                        loadDoctors(doctor.service_id).then(() => {
                            document.getElementById('doctor').value = doctorId;
                        });
                    }
                }, 1000);
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            initializeTimeSlots();
            setMinDate();
            loadServices();
            checkUrlParameters();
        });
    </script>
</body>
</html>

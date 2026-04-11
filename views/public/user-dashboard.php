<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace - E-sitrana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-heartbeat me-2"></i>E-sitrana
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Accueil</a>
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
                        <a class="nav-link active" href="/user-dashboard">
                            <i class="fas fa-user me-1"></i>Mon Espace
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

    <!-- Dashboard Section -->
    <section class="py-5">
        <div class="container">
            <!-- User Info Card -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4><i class="fas fa-user-circle me-2"></i>Bienvenue !</h4>
                                    <p id="userInfo" class="mb-0">Chargement de vos informations...</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <button onclick="logout()" class="btn btn-light">
                                        <i class="fas fa-sign-out-alt me-1"></i>Déconnexion
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 id="totalAppointments">0</h4>
                                    <p class="mb-0">Total Rendez-vous</p>
                                </div>
                                <i class="fas fa-calendar fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 id="upcomingAppointments">0</h4>
                                    <p class="mb-0">À venir</p>
                                </div>
                                <i class="fas fa-clock fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 id="completedAppointments">0</h4>
                                    <p class="mb-0">Terminés</p>
                                </div>
                                <i class="fas fa-check-circle fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments Table -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Mes Rendez-vous
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Médecin</th>
                                    <th>Service</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="appointmentsTable">
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Chargement...</span>
                                        </div>
                                        <p class="mt-2">Chargement de vos rendez-vous...</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>Actions Rapides
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="/appointment" class="btn btn-primary w-100">
                                        <i class="fas fa-plus me-2"></i>Nouveau Rendez-vous
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <button onclick="refreshAppointments()" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-sync me-2"></i>Actualiser
                                    </button>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <button onclick="printAppointments()" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-print me-2"></i>Imprimer
                                    </button>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="/contact" class="btn btn-outline-info w-100">
                                        <i class="fas fa-phone me-2"></i>Nous contacter
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>E-sitrana</h5>
                    <p>Plateforme de prise de rendez-vous médical en ligne.</p>
                </div>
                <div class="col-md-4">
                    <h5>Services</h5>
                    <ul class="list-unstyled">
                        <li><a href="/services" class="text-white">Médecine générale</a></li>
                        <li><a href="/services" class="text-white">Pédiatrie</a></li>
                        <li><a href="/services" class="text-white">Gynécologie</a></li>
                        <li><a href="/services" class="text-white">Cardiologie</a></li>
                        <li><a href="/services" class="text-white">Laboratoire</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2"></i>Lot II J 23 Ter Antsirabe, Madagascar</li>
                        <li><i class="fas fa-phone me-2"></i>+261 34 78 90 12 34</li>
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
        let currentUser = null;
        let appointments = [];

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            checkAuth();
        });

        function checkAuth() {
            // Si pas de patient en localStorage, afficher le sélecteur
            const patientData = localStorage.getItem('patient');
            if (!patientData) {
                showPatientSelector();
                return;
            }

            currentUser = JSON.parse(patientData);
            displayUserInfo();
            loadAppointments();
        }

        async function showPatientSelector() {
            try {
                const response = await fetch('/api/patients');
                const data = await response.json();
                
                if (data.records && data.records.length > 0) {
                    const patientList = data.records.map(patient => 
                        `<option value="${patient.id}">${patient.first_name} ${patient.last_name} - ${patient.email}</option>`
                    ).join('');
                    
                    document.getElementById('userInfo').innerHTML = `
                        <div class="row">
                            <div class="col-md-8">
                                <select id="patientSelect" class="form-select" onchange="selectPatient()">
                                    <option value="">Choisissez votre profil...</option>
                                    ${patientList}
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button onclick="showPatientSelector()" class="btn btn-light btn-sm">
                                    <i class="fas fa-sync"></i>
                                </button>
                            </div>
                        </div>
                    `;
                } else {
                    document.getElementById('userInfo').innerHTML = `
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Aucun patient trouvé. <a href="/appointment" class="btn btn-sm btn-primary ms-2">Prendre un rendez-vous</a>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error loading patients:', error);
                document.getElementById('userInfo').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Erreur de chargement des patients
                    </div>
                `;
            }
        }

        async function selectPatient() {
            const select = document.getElementById('patientSelect');
            const patientId = select.value;
            
            if (!patientId) return;
            
            try {
                const response = await fetch(`/api/patients?id=${patientId}`);
                const data = await response.json();
                
                if (data.id) {
                    currentUser = data;
                    localStorage.setItem('patient', JSON.stringify(data));
                    displayUserInfo();
                    loadAppointments();
                }
            } catch (error) {
                console.error('Error selecting patient:', error);
                alert('Erreur lors de la sélection du patient');
            }
        }

        function displayUserInfo() {
            if (currentUser) {
                document.getElementById('userInfo').innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <strong>${currentUser.first_name} ${currentUser.last_name}</strong><br>
                            <small>${currentUser.email} | ${currentUser.phone}</small>
                        </div>
                        <div class="col-md-4 text-end">
                            <button onclick="changePatient()" class="btn btn-light btn-sm">
                                <i class="fas fa-user-edit me-1"></i>Changer
                            </button>
                        </div>
                    </div>
                `;
            }
        }

        function changePatient() {
            localStorage.removeItem('patient');
            currentUser = null;
            showPatientSelector();
        }

        async function loadAppointments() {
            try {
                const response = await fetch(`/api/appointments?patient_id=${currentUser.id}`);
                const data = await response.json();
                
                if (data.records) {
                    appointments = data.records;
                    displayAppointments();
                    updateStats();
                }
            } catch (error) {
                console.error('Error loading appointments:', error);
                document.getElementById('appointmentsTable').innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4 text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p>Erreur de chargement des rendez-vous</p>
                        </td>
                    </tr>
                `;
            }
        }

        function displayAppointments() {
            const tbody = document.getElementById('appointmentsTable');
            
            if (appointments.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <p>Vous n'avez aucun rendez-vous</p>
                            <a href="/appointment" class="btn btn-primary mt-2">
                                <i class="fas fa-plus me-1"></i>Prendre un rendez-vous
                            </a>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = appointments.map(apt => `
                <tr>
                    <td>${formatDate(apt.appointment_date)}</td>
                    <td>${formatTime(apt.appointment_time)}</td>
                    <td>Dr ${apt.doctor_first_name} ${apt.doctor_last_name}</td>
                    <td>${apt.service_name}</td>
                    <td>${getStatusBadge(apt.status)}</td>
                    <td>
                        ${apt.status === 'en attente' ? `
                            <button onclick="cancelAppointment(${apt.id})" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                        ` : '-'}
                    </td>
                </tr>
            `).join('');
        }

        function updateStats() {
            const total = appointments.length;
            const upcoming = appointments.filter(apt => apt.status === 'en attente' || apt.status === 'confirmé').length;
            const completed = appointments.filter(apt => apt.status && apt.status.includes('termin')).length;

            document.getElementById('totalAppointments').textContent = total;
            document.getElementById('upcomingAppointments').textContent = upcoming;
            document.getElementById('completedAppointments').textContent = completed;
        }

        function getStatusBadge(status) {
            const badges = {
                'en attente': '<span class="badge bg-warning">En attente</span>',
                'confirmé': '<span class="badge bg-success">Confirmé</span>',
                'annulé': '<span class="badge bg-danger">Annulé</span>',
                'terminé': '<span class="badge bg-info">Terminé</span>',
                'terminÃ': '<span class="badge bg-info">Terminé</span>',
                'en suivi': '<span class="badge bg-primary">En suivi</span>'
            };
            return badges[status] || (status && status.includes('termin') ? '<span class="badge bg-info">Terminé</span>' : status);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
        }

        function formatTime(timeString) {
            return timeString.substring(0, 5);
        }

        async function cancelAppointment(id) {
            if (!confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')) {
                return;
            }

            try {
                const response = await fetch(`/api/appointments?id=${id}`, {
                    method: 'DELETE'
                });
                
                if (response.ok) {
                    alert('Rendez-vous annulé avec succès');
                    loadAppointments();
                } else {
                    alert('Erreur lors de l\'annulation');
                }
            } catch (error) {
                console.error('Error cancelling appointment:', error);
                alert('Erreur lors de l\'annulation');
            }
        }

        function refreshAppointments() {
            loadAppointments();
        }

        function printAppointments() {
            window.print();
        }

        function logout() {
            localStorage.removeItem('patient');
            window.location.href = '/';
        }
    </script>
</body>
</html>

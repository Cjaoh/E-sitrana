<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Patients - E-sitrana Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }
        .sidebar .nav-link {
            color: var(--white);
            padding: 1rem 1.5rem;
            transition: background 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: var(--white);
        }
        .main-content {
            background-color: var(--light-bg);
            min-height: 100vh;
        }
        .top-navbar {
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">
                            <i class="fas fa-hospital me-2"></i>E-sitrana
                        </h4>
                        <small class="text-white-50">Administration</small>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="doctors.php">
                                <i class="fas fa-user-md me-2"></i>Médecins
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="services.php">
                                <i class="fas fa-hospital me-2"></i>Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="appointments.php">
                                <i class="fas fa-calendar-check me-2"></i>Rendez-vous
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="patients.php">
                                <i class="fas fa-users me-2"></i>Patients
                            </a>
                        </li>
                        <li class="nav-item mt-4">
                            <a class="nav-link text-danger" href="#" onclick="logout()">
                                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Navbar -->
                <div class="top-navbar d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h1 class="h2">Gestion des Patients</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshPatients()">
                                <i class="fas fa-sync me-1"></i>Actualiser
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportPatients()">
                                <i class="fas fa-download me-1"></i>Exporter
                            </button>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?php echo $_SESSION['admin_username']; ?>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Profil</a></li>
                                <li><a class="dropdown-item" href="#">Paramètres</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="logout()">Déconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Recherche</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="Rechercher par nom, email, téléphone...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date d'inscription</label>
                                <select class="form-select" id="dateFilter">
                                    <option value="">Toutes les dates</option>
                                    <option value="today">Aujourd'hui</option>
                                    <option value="week">Cette semaine</option>
                                    <option value="month">Ce mois</option>
                                    <option value="year">Cette année</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number" id="totalPatients">-</div>
                            <div class="stat-label">Total patients</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number" id="newPatients">-</div>
                            <div class="stat-label">Nouveaux ce mois</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number" id="activePatients">-</div>
                            <div class="stat-label">Patients actifs</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number" id="avgAppointments">-</div>
                            <div class="stat-label">Moy. RDV/patient</div>
                        </div>
                    </div>
                </div>

                <!-- Patients Table -->
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-users me-2"></i>Liste des patients
                        </h5>
                        <span class="badge bg-light text-dark" id="totalCount">0 patients</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom complet</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Date d'inscription</th>
                                        <th>Nombre de RDV</th>
                                        <th>Dernier RDV</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="patients-tbody">
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <div class="spinner"></div>
                                            <p class="mt-2 mb-0">Chargement des patients...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Patient Details Modal -->
    <div class="modal fade" id="patientModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Détails du patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="patientDetails">
                    <!-- Patient details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="viewPatientAppointments()">
                        <i class="fas fa-calendar me-2"></i>Voir les rendez-vous
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Appointments Modal -->
    <div class="modal fade" id="appointmentsModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rendez-vous du patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Médecin</th>
                                    <th>Service</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody id="patient-appointments-tbody">
                                <!-- Appointments will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        let allPatients = [];
        let allAppointments = [];
        let filteredPatients = [];
        let currentPatientId = null;

        // Load data
        async function loadData() {
            try {
                const [patients, appointments] = await Promise.all([
                    app.getPatients(),
                    app.getAppointments()
                ]);
                
                allPatients = patients;
                allAppointments = appointments;
                filteredPatients = patients;
                
                updateStatistics();
                displayPatients(patients);
            } catch (error) {
                console.error('Error loading data:', error);
                document.getElementById('patients-tbody').innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="alert alert-danger">
                                Impossible de charger les patients. Veuillez réessayer.
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        // Update statistics
        function updateStatistics() {
            const now = new Date();
            const currentMonth = now.getMonth();
            const currentYear = now.getFullYear();
            
            const newPatients = allPatients.filter(patient => {
                const createdDate = new Date(patient.created_at);
                return createdDate.getMonth() === currentMonth && createdDate.getFullYear() === currentYear;
            });

            const activePatients = allPatients.filter(patient => {
                const patientAppointments = allAppointments.filter(a => a.patient_id === patient.id);
                const lastAppointment = patientAppointments.sort((a, b) => new Date(b.appointment_date) - new Date(a.appointment_date))[0];
                if (!lastAppointment) return false;
                
                const lastDate = new Date(lastAppointment.appointment_date);
                const daysDiff = (now - lastDate) / (1000 * 60 * 60 * 24);
                return daysDiff <= 90; // Active if last appointment within 90 days
            });

            const totalAppointments = allAppointments.length;
            const avgAppointments = allPatients.length > 0 ? (totalAppointments / allPatients.length).toFixed(1) : 0;

            document.getElementById('totalPatients').textContent = allPatients.length;
            document.getElementById('newPatients').textContent = newPatients.length;
            document.getElementById('activePatients').textContent = activePatients.length;
            document.getElementById('avgAppointments').textContent = avgAppointments;
            document.getElementById('totalCount').textContent = `${filteredPatients.length} patients`;
        }

        // Display patients in table
        function displayPatients(patients) {
            const tbody = document.getElementById('patients-tbody');
            
            if (patients.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <p>Aucun patient trouvé</p>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = patients.map(patient => {
                const patientAppointments = allAppointments.filter(a => a.patient_id === patient.id);
                const appointmentCount = patientAppointments.length;
                const lastAppointment = patientAppointments.sort((a, b) => new Date(b.appointment_date) - new Date(a.appointment_date))[0];
                
                return `
                    <tr>
                        <td>#${patient.id}</td>
                        <td><strong>${patient.first_name} ${patient.last_name}</strong></td>
                        <td>${patient.email}</td>
                        <td>${patient.phone}</td>
                        <td>${app.formatDate(patient.created_at)}</td>
                        <td>
                            <span class="badge bg-info">${appointmentCount}</span>
                        </td>
                        <td>${lastAppointment ? app.formatDate(lastAppointment.appointment_date) : '-'}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-info" onclick="viewPatient(${patient.id})" title="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-primary" onclick="viewPatientAppointmentsOnly(${patient.id})" title="Voir les rendez-vous">
                                    <i class="fas fa-calendar"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // View patient details
        function viewPatient(id) {
            const patient = allPatients.find(p => p.id === id);
            if (!patient) return;

            currentPatientId = id;
            const patientAppointments = allAppointments.filter(a => a.patient_id === patient.id);
            
            document.getElementById('patientDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-user me-2"></i>Informations personnelles</h6>
                        <table class="table table-sm">
                            <tr><td><strong>ID:</strong></td><td>#${patient.id}</td></tr>
                            <tr><td><strong>Nom:</strong></td><td>${patient.first_name} ${patient.last_name}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${patient.email}</td></tr>
                            <tr><td><strong>Téléphone:</strong></td><td>${patient.phone}</td></tr>
                            <tr><td><strong>Date d'inscription:</strong></td><td>${app.formatDate(patient.created_at)}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-chart-line me-2"></i>Statistiques</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Total rendez-vous:</strong></td><td>${patientAppointments.length}</td></tr>
                            <tr><td><strong>Rendez-vous confirmés:</strong></td><td>${patientAppointments.filter(a => a.status === 'confirmé').length}</td></tr>
                            <tr><td><strong>Rendez-vous terminés:</strong></td><td>${patientAppointments.filter(a => a.status === 'terminé').length}</td></tr>
                            <tr><td><strong>Rendez-vous annulés:</strong></td><td>${patientAppointments.filter(a => a.status === 'annulé').length}</td></tr>
                        </table>
                    </div>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('patientModal'));
            modal.show();
        }

        // View patient appointments
        function viewPatientAppointments() {
            if (!currentPatientId) return;
            bootstrap.Modal.getInstance(document.getElementById('patientModal')).hide();
            viewPatientAppointmentsOnly(currentPatientId);
        }

        // View patient appointments only
        function viewPatientAppointmentsOnly(patientId) {
            const patient = allPatients.find(p => p.id === patientId);
            const patientAppointments = allAppointments.filter(a => a.patient_id === patientId);
            
            document.querySelector('#appointmentsModal .modal-title').textContent = 
                `Rendez-vous de ${patient.first_name} ${patient.last_name}`;
            
            const tbody = document.getElementById('patient-appointments-tbody');
            
            if (patientAppointments.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <p>Aucun rendez-vous trouvé</p>
                        </td>
                    </tr>
                `;
            } else {
                tbody.innerHTML = patientAppointments
                    .sort((a, b) => new Date(b.appointment_date) - new Date(a.appointment_date))
                    .map(appointment => `
                        <tr>
                            <td>${app.formatDate(appointment.appointment_date)}</td>
                            <td>${app.formatTime(appointment.appointment_time)}</td>
                            <td>Dr ${appointment.doctor_first_name} ${appointment.doctor_last_name}</td>
                            <td>${appointment.service_name}</td>
                            <td>${app.getStatusBadge(appointment.status)}</td>
                        </tr>
                    `).join('');
            }

            const modal = new bootstrap.Modal(document.getElementById('appointmentsModal'));
            modal.show();
        }

        // Apply filters
        function applyFilters() {
            const searchFilter = document.getElementById('searchInput').value.toLowerCase();
            const dateFilter = document.getElementById('dateFilter').value;

            filteredPatients = allPatients.filter(patient => {
                let matchSearch = !searchFilter || 
                    patient.first_name.toLowerCase().includes(searchFilter) ||
                    patient.last_name.toLowerCase().includes(searchFilter) ||
                    patient.email.toLowerCase().includes(searchFilter) ||
                    patient.phone.includes(searchFilter);

                let matchDate = true;
                if (dateFilter) {
                    const createdDate = new Date(patient.created_at);
                    const now = new Date();
                    
                    switch(dateFilter) {
                        case 'today':
                            matchDate = createdDate.toDateString() === now.toDateString();
                            break;
                        case 'week':
                            const weekAgo = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                            matchDate = createdDate >= weekAgo;
                            break;
                        case 'month':
                            matchDate = createdDate.getMonth() === now.getMonth() && 
                                       createdDate.getFullYear() === now.getFullYear();
                            break;
                        case 'year':
                            matchDate = createdDate.getFullYear() === now.getFullYear();
                            break;
                    }
                }

                return matchSearch && matchDate;
            });

            updateStatistics();
            displayPatients(filteredPatients);
        }

        // Refresh patients
        function refreshPatients() {
            loadData();
        }

        // Export patients (placeholder)
        function exportPatients() {
            app.showAlert('Fonction d\'exportation bientôt disponible', 'info');
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', app.debounce(applyFilters, 300));
        document.getElementById('dateFilter').addEventListener('change', applyFilters);

        // Logout function
        async function logout() {
            try {
                await app.logout();
                window.location.href = 'login.php';
            } catch (error) {
                console.error('Logout error:', error);
                window.location.href = 'login.php';
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadData();
        });
    </script>
</body>
</html>

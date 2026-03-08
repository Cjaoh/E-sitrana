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
    <title>Gestion des Rendez-vous - E-sitrana Administration</title>
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
                            <a class="nav-link active" href="appointments.php">
                                <i class="fas fa-calendar-check me-2"></i>Rendez-vous
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="patients.php">
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
                    <h1 class="h2">Gestion des Rendez-vous</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshAppointments()">
                                <i class="fas fa-sync me-1"></i>Actualiser
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportAppointments()">
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

                <!-- Filters -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Statut</label>
                                <select class="form-select" id="statusFilter">
                                    <option value="">Tous les statuts</option>
                                    <option value="en attente">En attente</option>
                                    <option value="confirmé">Confirmé</option>
                                    <option value="annulé">Annulé</option>
                                    <option value="terminé">Terminé</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" id="dateFilter">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Recherche</label>
                                <input type="text" class="form-control" id="searchInput" placeholder="Patient, médecin, service...">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-primary w-100" onclick="applyFilters()">
                                    <i class="fas fa-filter me-1"></i>Filtrer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number text-warning" id="pendingCount">-</div>
                            <div class="stat-label">En attente</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number text-success" id="confirmedCount">-</div>
                            <div class="stat-label">Confirmés</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number text-danger" id="cancelledCount">-</div>
                            <div class="stat-label">Annulés</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card">
                            <div class="stat-number text-secondary" id="completedCount">-</div>
                            <div class="stat-label">Terminés</div>
                        </div>
                    </div>
                </div>

                <!-- Appointments Table -->
                <div class="card">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-check me-2"></i>Liste des rendez-vous
                        </h5>
                        <span class="badge bg-light text-dark" id="totalCount">0 rendez-vous</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Patient</th>
                                        <th>Contact</th>
                                        <th>Médecin</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Heure</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="appointments-tbody">
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="spinner"></div>
                                            <p class="mt-2 mb-0">Chargement des rendez-vous...</p>
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

    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mettre à jour le statut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="appointmentId">
                    <div class="mb-3">
                        <label for="newStatus" class="form-label">Nouveau statut</label>
                        <select class="form-select" id="newStatus">
                            <option value="en attente">En attente</option>
                            <option value="confirmé">Confirmé</option>
                            <option value="annulé">Annulé</option>
                            <option value="terminé">Terminé</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="statusNote" class="form-label">Note (optionnel)</label>
                        <textarea class="form-control" id="statusNote" rows="3" placeholder="Ajoutez une note concernant ce changement..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="updateAppointmentStatus()">
                        <i class="fas fa-save me-2"></i>Mettre à jour
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Détails du rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="appointmentDetails">
                    <!-- Details will be loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="button" class="btn btn-primary" onclick="editAppointmentFromDetails()">
                        <i class="fas fa-edit me-2"></i>Modifier le statut
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        let allAppointments = [];
        let filteredAppointments = [];
        let currentAppointmentId = null;

        // Load appointments
        async function loadAppointments() {
            try {
                const appointments = await app.getAppointments();
                allAppointments = appointments;
                filteredAppointments = appointments;
                
                updateStatistics();
                displayAppointments(appointments);
            } catch (error) {
                console.error('Error loading appointments:', error);
                document.getElementById('appointments-tbody').innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <div class="alert alert-danger">
                                Impossible de charger les rendez-vous. Veuillez réessayer.
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        // Update statistics
        function updateStatistics() {
            const stats = {
                pending: filteredAppointments.filter(a => a.status === 'en attente').length,
                confirmed: filteredAppointments.filter(a => a.status === 'confirmé').length,
                cancelled: filteredAppointments.filter(a => a.status === 'annulé').length,
                completed: filteredAppointments.filter(a => a.status === 'terminé').length
            };

            document.getElementById('pendingCount').textContent = stats.pending;
            document.getElementById('confirmedCount').textContent = stats.confirmed;
            document.getElementById('cancelledCount').textContent = stats.cancelled;
            document.getElementById('completedCount').textContent = stats.completed;
            document.getElementById('totalCount').textContent = `${filteredAppointments.length} rendez-vous`;
        }

        // Display appointments in table
        function displayAppointments(appointments) {
            const tbody = document.getElementById('appointments-tbody');
            
            if (appointments.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <p>Aucun rendez-vous trouvé</p>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = appointments.map(appointment => `
                <tr>
                    <td>#${appointment.id}</td>
                    <td><strong>${appointment.patient_first_name} ${appointment.patient_last_name}</strong></td>
                    <td>
                        <small>${appointment.patient_email}<br>${appointment.patient_phone}</small>
                    </td>
                    <td>Dr ${appointment.doctor_first_name} ${appointment.doctor_last_name}</td>
                    <td>${appointment.service_name}</td>
                    <td>${app.formatDate(appointment.appointment_date)}</td>
                    <td>${app.formatTime(appointment.appointment_time)}</td>
                    <td>${app.getStatusBadge(appointment.status)}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-info" onclick="viewAppointment(${appointment.id})" title="Voir les détails">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-primary" onclick="editAppointment(${appointment.id})" title="Modifier le statut">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteAppointment(${appointment.id})" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Apply filters
        function applyFilters() {
            const statusFilter = document.getElementById('statusFilter').value;
            const dateFilter = document.getElementById('dateFilter').value;
            const searchFilter = document.getElementById('searchInput').value.toLowerCase();

            filteredAppointments = allAppointments.filter(appointment => {
                let matchStatus = !statusFilter || appointment.status === statusFilter;
                let matchDate = !dateFilter || appointment.appointment_date === dateFilter;
                let matchSearch = !searchFilter || 
                    appointment.patient_first_name.toLowerCase().includes(searchFilter) ||
                    appointment.patient_last_name.toLowerCase().includes(searchFilter) ||
                    appointment.doctor_first_name.toLowerCase().includes(searchFilter) ||
                    appointment.doctor_last_name.toLowerCase().includes(searchFilter) ||
                    appointment.service_name.toLowerCase().includes(searchFilter) ||
                    appointment.patient_email.toLowerCase().includes(searchFilter);

                return matchStatus && matchDate && matchSearch;
            });

            updateStatistics();
            displayAppointments(filteredAppointments);
        }

        // View appointment details
        function viewAppointment(id) {
            const appointment = allAppointments.find(a => a.id === id);
            if (!appointment) return;

            currentAppointmentId = id;
            
            document.getElementById('appointmentDetails').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-user me-2"></i>Informations patient</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Nom:</strong></td><td>${appointment.patient_first_name} ${appointment.patient_last_name}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${appointment.patient_email}</td></tr>
                            <tr><td><strong>Téléphone:</strong></td><td>${appointment.patient_phone}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-user-md me-2"></i>Informations médecin</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Médecin:</strong></td><td>Dr ${appointment.doctor_first_name} ${appointment.doctor_last_name}</td></tr>
                            <tr><td><strong>Spécialité:</strong></td><td>${appointment.doctor_speciality}</td></tr>
                            <tr><td><strong>Service:</strong></td><td>${appointment.service_name}</td></tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar me-2"></i>Détails rendez-vous</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Date:</strong></td><td>${app.formatDate(appointment.appointment_date)}</td></tr>
                            <tr><td><strong>Heure:</strong></td><td>${app.formatTime(appointment.appointment_time)}</td></tr>
                            <tr><td><strong>Statut:</strong></td><td>${app.getStatusBadge(appointment.status)}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-info-circle me-2"></i>Informations système</h6>
                        <table class="table table-sm">
                            <tr><td><strong>ID:</strong></td><td>#${appointment.id}</td></tr>
                            <tr><td><strong>Créé le:</strong></td><td>${app.formatDate(appointment.created_at)}</td></tr>
                        </table>
                    </div>
                </div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
            modal.show();
        }

        // Edit appointment status
        function editAppointment(id) {
            const appointment = allAppointments.find(a => a.id === id);
            if (!appointment) return;

            currentAppointmentId = id;
            document.getElementById('appointmentId').value = id;
            document.getElementById('newStatus').value = appointment.status;
            document.getElementById('statusNote').value = '';

            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }

        // Edit appointment from details modal
        function editAppointmentFromDetails() {
            bootstrap.Modal.getInstance(document.getElementById('detailsModal')).hide();
            editAppointment(currentAppointmentId);
        }

        // Update appointment status
        async function updateAppointmentStatus() {
            if (!currentAppointmentId) return;

            const newStatus = document.getElementById('newStatus').value;
            
            try {
                await app.updateAppointmentStatus(currentAppointmentId, newStatus);
                app.showAlert('Statut mis à jour avec succès', 'success');
                
                bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
                loadAppointments();
            } catch (error) {
                console.error('Error updating appointment status:', error);
            }
        }

        // Delete appointment
        async function deleteAppointment(id) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer ce rendez-vous?')) {
                return;
            }

            try {
                await app.deleteAppointment(id);
                app.showAlert('Rendez-vous supprimé avec succès', 'success');
                loadAppointments();
            } catch (error) {
                console.error('Error deleting appointment:', error);
            }
        }

        // Refresh appointments
        function refreshAppointments() {
            loadAppointments();
        }

        // Export appointments (placeholder)
        function exportAppointments() {
            app.showAlert('Fonction d\'exportation bientôt disponible', 'info');
        }

        // Event listeners for filters
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('dateFilter').addEventListener('change', applyFilters);
        document.getElementById('searchInput').addEventListener('input', app.debounce(applyFilters, 300));

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
            loadAppointments();
            
            // Set today's date as default filter
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('dateFilter').value = today;
        });
    </script>
</body>
</html>

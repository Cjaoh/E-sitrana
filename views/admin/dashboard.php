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
    <title>Dashboard - E-sitrana Administration</title>
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
                            <a class="nav-link active" href="dashboard.php">
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
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">
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

                <!-- Statistics Cards -->
                <div class="dashboard-stats" id="stats-container">
                    <div class="stat-card">
                        <div class="spinner"></div>
                    </div>
                </div>

                <!-- Recent Appointments -->
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>Rendez-vous récents
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
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
                                        <td colspan="7" class="text-center py-4">
                                            <div class="spinner"></div>
                                            <p class="mt-2 mb-0">Chargement des rendez-vous...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-plus-circle me-2"></i>Actions rapides
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="doctors.php?action=add" class="btn btn-outline-primary">
                                        <i class="fas fa-user-plus me-2"></i>Ajouter un médecin
                                    </a>
                                    <a href="services.php?action=add" class="btn btn-outline-success">
                                        <i class="fas fa-plus-square me-2"></i>Ajouter un service
                                    </a>
                                    <a href="appointments.php" class="btn btn-outline-info">
                                        <i class="fas fa-calendar-plus me-2"></i>Voir tous les rendez-vous
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informations système
                                </h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-clock text-primary me-2"></i>
                                        Dernière connexion: <?php echo date('d/m/Y H:i'); ?>
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-database text-success me-2"></i>
                                        Base de données: Connectée
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-server text-info me-2"></i>
                                        Version: PHP <?php echo PHP_VERSION; ?>
                                    </li>
                                    <li>
                                        <i class="fas fa-shield-alt text-warning me-2"></i>
                                        Sécurité: Activée
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        let dashboardData = {};

        // Load dashboard statistics
        async function loadDashboardStats() {
            try {
                const stats = await app.getDashboardStats();
                dashboardData = stats;
                
                const container = document.getElementById('stats-container');
                container.innerHTML = `
                    <div class="stat-card">
                        <div class="stat-number">${stats.total_doctors}</div>
                        <div class="stat-label">Médecins</div>
                        <i class="fas fa-user-md fa-2x text-primary mt-2"></i>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${stats.total_patients}</div>
                        <div class="stat-label">Patients</div>
                        <i class="fas fa-users fa-2x text-success mt-2"></i>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${stats.today_appointments}</div>
                        <div class="stat-label">Rendez-vous aujourd'hui</div>
                        <i class="fas fa-calendar-day fa-2x text-warning mt-2"></i>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">${stats.total_appointments}</div>
                        <div class="stat-label">Total rendez-vous</div>
                        <i class="fas fa-calendar-check fa-2x text-info mt-2"></i>
                    </div>
                `;
            } catch (error) {
                console.error('Error loading dashboard stats:', error);
                document.getElementById('stats-container').innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Impossible de charger les statistiques. Veuillez réessayer.
                        </div>
                    </div>
                `;
            }
        }

        // Load recent appointments
        async function loadRecentAppointments() {
            try {
                const appointments = dashboardData.recent_appointments_list || [];
                const tbody = document.getElementById('appointments-tbody');
                
                if (appointments.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-calendar-times fa-2x mb-2"></i>
                                <p>Aucun rendez-vous récent</p>
                            </td>
                        </tr>
                    `;
                    return;
                }

                tbody.innerHTML = appointments.map(appointment => `
                    <tr>
                        <td>${appointment.patient_name}</td>
                        <td>${appointment.doctor_name}</td>
                        <td>${appointment.service_name}</td>
                        <td>${app.formatDate(appointment.appointment_date)}</td>
                        <td>${app.formatTime(appointment.appointment_time)}</td>
                        <td>${app.getStatusBadge(appointment.status)}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" onclick="viewAppointment(${appointment.id})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-secondary" onclick="editAppointment(${appointment.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error('Error loading recent appointments:', error);
                document.getElementById('appointments-tbody').innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="alert alert-danger">
                                Impossible de charger les rendez-vous récents.
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        // View appointment details
        function viewAppointment(id) {
            window.location.href = `appointments.php?action=view&id=${id}`;
        }

        // Edit appointment
        function editAppointment(id) {
            window.location.href = `appointments.php?action=edit&id=${id}`;
        }

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

        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            loadDashboardStats().then(() => {
                loadRecentAppointments();
            });

            // Auto-refresh every 5 minutes
            setInterval(() => {
                loadDashboardStats().then(() => {
                    loadRecentAppointments();
                });
            }, 300000);
        });
    </script>
</body>
</html>

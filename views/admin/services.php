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
    <title>Gestion des Services - E-sitrana Administration</title>
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
                            <a class="nav-link active" href="services.php">
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
                    <h1 class="h2">Gestion des Services</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshServices()">
                                <i class="fas fa-sync me-1"></i>Actualiser
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

                <!-- Add Service Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <button type="button" class="btn btn-primary" onclick="showAddServiceModal()">
                            <i class="fas fa-plus-circle me-2"></i>Ajouter un service
                        </button>
                    </div>
                    <div>
                        <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un service..." style="width: 250px;">
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="row g-4" id="services-container">
                    <div class="col-12 text-center py-5">
                        <div class="spinner"></div>
                        <p class="mt-2 mb-0">Chargement des services...</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add/Edit Service Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="serviceModalTitle">Ajouter un service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="serviceForm" novalidate>
                        <input type="hidden" id="serviceId">
                        <div class="mb-3">
                            <label for="serviceName" class="form-label">Nom du service *</label>
                            <input type="text" class="form-control" id="serviceName" name="name" required>
                            <div class="invalid-feedback">Veuillez entrer le nom du service</div>
                        </div>
                        <div class="mb-3">
                            <label for="serviceDescription" class="form-label">Description *</label>
                            <textarea class="form-control" id="serviceDescription" name="description" rows="4" required></textarea>
                            <div class="invalid-feedback">Veuillez entrer la description</div>
                        </div>
                        <div class="mb-3">
                            <label for="serviceIcon" class="form-label">Icône</label>
                            <select class="form-select" id="serviceIcon" name="icon">
                                <option value="fa-user-md">Médecin général</option>
                                <option value="fa-child">Pédiatrie</option>
                                <option value="fa-female">Gynécologie</option>
                                <option value="fa-heartbeat">Cardiologie</option>
                                <option value="fa-flask">Laboratoire</option>
                                <option value="fa-tooth">Dentisterie</option>
                                <option value="fa-brain">Neurologie</option>
                                <option value="fa-eye">Ophtalmologie</option>
                                <option value="fa-x-ray">Radiologie</option>
                                <option value="fa-pills">Pharmacie</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <small class="text-muted">Aperçu de l'icône:</small>
                            <div class="mt-2">
                                <i id="iconPreview" class="fas fa-user-md fa-2x text-primary"></i>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="saveService()">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmation de suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer ce service?</p>
                    <p class="text-warning"><small>Cette action est irréversible et supprimera également tous les médecins et rendez-vous associés.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        let allServices = [];
        let deleteServiceId = null;

        // Load services
        async function loadServices() {
            try {
                const services = await app.getServices();
                allServices = services;
                displayServices(services);
            } catch (error) {
                console.error('Error loading services:', error);
                document.getElementById('services-container').innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Impossible de charger les services. Veuillez réessayer.
                        </div>
                    </div>
                `;
            }
        }

        // Display services in grid
        function displayServices(services) {
            const container = document.getElementById('services-container');
            
            if (services.length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="fas fa-hospital fa-3x mb-3"></i>
                        <h4>Aucun service trouvé</h4>
                        <p>Cliquez sur "Ajouter un service" pour commencer.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = services.map(service => `
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas ${service.icon} fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">${service.name}</h5>
                            <p class="card-text text-muted">${service.description.substring(0, 100)}${service.description.length > 100 ? '...' : ''}</p>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="editService(${service.id})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteService(${service.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Show add service modal
        function showAddServiceModal() {
            document.getElementById('serviceModalTitle').textContent = 'Ajouter un service';
            document.getElementById('serviceForm').reset();
            document.getElementById('serviceId').value = '';
            updateIconPreview();
            
            const modal = new bootstrap.Modal(document.getElementById('serviceModal'));
            modal.show();
        }

        // Edit service
        function editService(id) {
            const service = allServices.find(s => s.id === id);
            if (!service) return;

            document.getElementById('serviceModalTitle').textContent = 'Modifier un service';
            document.getElementById('serviceId').value = service.id;
            document.getElementById('serviceName').value = service.name;
            document.getElementById('serviceDescription').value = service.description;
            document.getElementById('serviceIcon').value = service.icon;
            updateIconPreview();

            const modal = new bootstrap.Modal(document.getElementById('serviceModal'));
            modal.show();
        }

        // Update icon preview
        function updateIconPreview() {
            const iconValue = document.getElementById('serviceIcon').value;
            document.getElementById('iconPreview').className = `fas ${iconValue} fa-2x text-primary`;
        }

        // Save service
        async function saveService() {
            const form = document.getElementById('serviceForm');
            if (!app.validateForm(form)) {
                return;
            }

            const formData = new FormData(form);
            const serviceData = {
                name: formData.get('name'),
                description: formData.get('description'),
                icon: formData.get('icon')
            };

            try {
                const serviceId = document.getElementById('serviceId').value;
                
                if (serviceId) {
                    await app.updateService(serviceId, serviceData);
                    app.showAlert('Service modifié avec succès', 'success');
                } else {
                    await app.createService(serviceData);
                    app.showAlert('Service ajouté avec succès', 'success');
                }

                bootstrap.Modal.getInstance(document.getElementById('serviceModal')).hide();
                loadServices();
            } catch (error) {
                console.error('Error saving service:', error);
            }
        }

        // Delete service
        function deleteService(id) {
            deleteServiceId = id;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Confirm delete
        async function confirmDelete() {
            if (!deleteServiceId) return;

            try {
                await app.deleteService(deleteServiceId);
                app.showAlert('Service supprimé avec succès', 'success');
                bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                loadServices();
            } catch (error) {
                console.error('Error deleting service:', error);
            }
        }

        // Refresh services
        function refreshServices() {
            loadServices();
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', app.debounce(function() {
            const searchTerm = this.value.toLowerCase();
            const filtered = allServices.filter(service => 
                service.name.toLowerCase().includes(searchTerm) ||
                service.description.toLowerCase().includes(searchTerm)
            );
            displayServices(filtered);
        }, 300));

        // Icon change handler
        document.getElementById('serviceIcon').addEventListener('change', updateIconPreview);

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
            loadServices();
        });
    </script>
</body>
</html>

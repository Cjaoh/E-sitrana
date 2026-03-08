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
    <title>Gestion des Médecins - E-sitrana Administration</title>
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
                            <a class="nav-link active" href="doctors.php">
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
                    <h1 class="h2">Gestion des Médecins</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="refreshDoctors()">
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

                <!-- Add Doctor Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <button type="button" class="btn btn-primary" onclick="showAddDoctorModal()">
                            <i class="fas fa-plus-circle me-2"></i>Ajouter un médecin
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un médecin..." style="width: 250px;">
                        <select class="form-select" id="serviceFilter" style="width: 200px;">
                            <option value="">Tous les services</option>
                        </select>
                    </div>
                </div>

                <!-- Doctors Table -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-user-md me-2"></i>Liste des médecins
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Nom</th>
                                        <th>Spécialité</th>
                                        <th>Service</th>
                                        <th>Email</th>
                                        <th>Téléphone</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="doctors-tbody">
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="spinner"></div>
                                            <p class="mt-2 mb-0">Chargement des médecins...</p>
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

    <!-- Add/Edit Doctor Modal -->
    <div class="modal fade" id="doctorModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doctorModalTitle">Ajouter un médecin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="doctorForm" novalidate>
                        <input type="hidden" id="doctorId">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">Nom *</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" required>
                                <div class="invalid-feedback">Veuillez entrer le nom</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Prénom *</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" required>
                                <div class="invalid-feedback">Veuillez entrer le prénom</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="speciality" class="form-label">Spécialité *</label>
                                <input type="text" class="form-control" id="speciality" name="speciality" required>
                                <div class="invalid-feedback">Veuillez entrer la spécialité</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="serviceId" class="form-label">Service *</label>
                                <select class="form-select" id="serviceId" name="service_id" required>
                                    <option value="">Sélectionnez un service</option>
                                </select>
                                <div class="invalid-feedback">Veuillez sélectionner un service</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Veuillez entrer un email valide</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Téléphone *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                                <div class="invalid-feedback">Veuillez entrer un numéro de téléphone</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo URL</label>
                            <input type="text" class="form-control" id="photo" name="photo" placeholder="URL de la photo ou nom du fichier">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="saveDoctor()">
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
                    <p>Êtes-vous sûr de vouloir supprimer ce médecin?</p>
                    <p class="text-warning"><small>Cette action est irréversible et supprimera également tous les rendez-vous associés.</small></p>
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
        let allDoctors = [];
        let allServices = [];
        let deleteDoctorId = null;

        // Load services for dropdowns
        async function loadServices() {
            try {
                const services = await app.getServices();
                allServices = services;
                
                const serviceSelect = document.getElementById('serviceId');
                const filterSelect = document.getElementById('serviceFilter');
                
                services.forEach(service => {
                    const option1 = document.createElement('option');
                    option1.value = service.id;
                    option1.textContent = service.name;
                    serviceSelect.appendChild(option1);
                    
                    const option2 = document.createElement('option');
                    option2.value = service.id;
                    option2.textContent = service.name;
                    filterSelect.appendChild(option2);
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
                displayDoctors(doctors);
            } catch (error) {
                console.error('Error loading doctors:', error);
                document.getElementById('doctors-tbody').innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="alert alert-danger">
                                Impossible de charger les médecins. Veuillez réessayer.
                            </div>
                        </td>
                    </tr>
                `;
            }
        }

        // Display doctors in table
        function displayDoctors(doctors) {
            const tbody = document.getElementById('doctors-tbody');
            
            if (doctors.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-user-md fa-2x mb-2"></i>
                            <p>Aucun médecin trouvé</p>
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = doctors.map(doctor => `
                <tr>
                    <td>
                        ${doctor.photo ? 
                            `<img src="/uploads/doctors/${doctor.photo}" alt="${doctor.first_name} ${doctor.last_name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">` :
                            `<div class="bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px;">
                                <i class="fas fa-user-md"></i>
                            </div>`
                        }
                    </td>
                    <td><strong>Dr ${doctor.first_name} ${doctor.last_name}</strong></td>
                    <td>${doctor.speciality}</td>
                    <td>${doctor.service_name || '-'}</td>
                    <td>${doctor.email}</td>
                    <td>${doctor.phone}</td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary" onclick="editDoctor(${doctor.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteDoctor(${doctor.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Show add doctor modal
        function showAddDoctorModal() {
            document.getElementById('doctorModalTitle').textContent = 'Ajouter un médecin';
            document.getElementById('doctorForm').reset();
            document.getElementById('doctorId').value = '';
            
            const modal = new bootstrap.Modal(document.getElementById('doctorModal'));
            modal.show();
        }

        // Edit doctor
        function editDoctor(id) {
            const doctor = allDoctors.find(d => d.id === id);
            if (!doctor) return;

            document.getElementById('doctorModalTitle').textContent = 'Modifier un médecin';
            document.getElementById('doctorId').value = doctor.id;
            document.getElementById('firstName').value = doctor.first_name;
            document.getElementById('lastName').value = doctor.last_name;
            document.getElementById('speciality').value = doctor.speciality;
            document.getElementById('serviceId').value = doctor.service_id;
            document.getElementById('email').value = doctor.email;
            document.getElementById('phone').value = doctor.phone;
            document.getElementById('description').value = doctor.description || '';
            document.getElementById('photo').value = doctor.photo || '';

            const modal = new bootstrap.Modal(document.getElementById('doctorModal'));
            modal.show();
        }

        // Save doctor
        async function saveDoctor() {
            const form = document.getElementById('doctorForm');
            if (!app.validateForm(form)) {
                return;
            }

            const formData = new FormData(form);
            const doctorData = {
                first_name: formData.get('first_name'),
                last_name: formData.get('last_name'),
                speciality: formData.get('speciality'),
                service_id: parseInt(formData.get('service_id')),
                email: formData.get('email'),
                phone: formData.get('phone'),
                description: formData.get('description'),
                photo: formData.get('photo')
            };

            try {
                const doctorId = document.getElementById('doctorId').value;
                
                if (doctorId) {
                    await app.updateDoctor(doctorId, doctorData);
                    app.showAlert('Médecin modifié avec succès', 'success');
                } else {
                    await app.createDoctor(doctorData);
                    app.showAlert('Médecin ajouté avec succès', 'success');
                }

                bootstrap.Modal.getInstance(document.getElementById('doctorModal')).hide();
                loadDoctors();
            } catch (error) {
                console.error('Error saving doctor:', error);
            }
        }

        // Delete doctor
        function deleteDoctor(id) {
            deleteDoctorId = id;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Confirm delete
        async function confirmDelete() {
            if (!deleteDoctorId) return;

            try {
                await app.deleteDoctor(deleteDoctorId);
                app.showAlert('Médecin supprimé avec succès', 'success');
                bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
                loadDoctors();
            } catch (error) {
                console.error('Error deleting doctor:', error);
            }
        }

        // Refresh doctors
        function refreshDoctors() {
            loadDoctors();
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', app.debounce(function() {
            const searchTerm = this.value.toLowerCase();
            const filtered = allDoctors.filter(doctor => 
                doctor.first_name.toLowerCase().includes(searchTerm) ||
                doctor.last_name.toLowerCase().includes(searchTerm) ||
                doctor.speciality.toLowerCase().includes(searchTerm) ||
                doctor.email.toLowerCase().includes(searchTerm)
            );
            displayDoctors(filtered);
        }, 300));

        // Service filter
        document.getElementById('serviceFilter').addEventListener('change', function() {
            const serviceId = this.value;
            loadDoctors(serviceId ? parseInt(serviceId) : null);
        });

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
            loadDoctors();
        });
    </script>
</body>
</html>

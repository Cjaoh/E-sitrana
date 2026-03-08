<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Patient - E-sitrana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-heartbeat me-2"></i>E-sitrana
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
                        <a class="nav-link active" href="/views/admin/login.php">
                            <i class="fas fa-user-shield me-1"></i>Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <i class="fas fa-user-circle fa-3x text-primary mb-3"></i>
                                <h3>Connexion Patient</h3>
                                <p class="text-muted">Accédez à votre espace personnel</p>
                            </div>

                            <form id="userLoginForm">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Téléphone</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="tel" class="form-control" id="phone" name="phone" required>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    Pas encore de compte ? 
                                    <a href="appointment.php">Prendre un rendez-vous</a>
                                </small>
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
        document.getElementById('userLoginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            
            try {
                // Find patient by email and phone
                const response = await fetch(`/api.php?endpoint=patients&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}`);
                const data = await response.json();
                
                if (data.records && data.records.length > 0) {
                    const patient = data.records[0];
                    localStorage.setItem('patient', JSON.stringify(patient));
                    window.location.href = 'user-dashboard.php';
                } else {
                    alert('Identifiants incorrects. Veuillez vérifier votre email et téléphone.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Erreur de connexion. Veuillez réessayer.');
            }
        });
    </script>
</body>
</html>

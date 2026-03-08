<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - E-sitrana Clinique Médicale</title>
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
                            <a class="nav-link" href="appointment.php">Rendez-vous</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="contact.php">Contact</a>
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
            <h1 class="hero-title">Contactez-nous</h1>
            <p class="hero-subtitle">Nous sommes à votre écoute pour toutes vos questions</p>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Adresse</h4>
                        <p>123 Rue de la Santé<br>Dakar, Sénégal</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h4>Téléphone</h4>
                        <p>+221 33 123 45 67<br>+221 77 890 12 34</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h4>Email</h4>
                        <p>contact@esitrana.com<br>info@esitrana.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form and Map Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="appointment-form">
                        <h3 class="mb-4">
                            <i class="fas fa-paper-plane me-2"></i>Envoyez-nous un message
                        </h3>
                        <form id="contactForm" novalidate>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contactName" class="form-label">Nom complet *</label>
                                    <input type="text" class="form-control" id="contactName" name="name" required>
                                    <div class="invalid-feedback">Veuillez entrer votre nom</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contactEmail" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="contactEmail" name="email" required>
                                    <div class="invalid-feedback">Veuillez entrer une adresse email valide</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="contactPhone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" id="contactPhone" name="phone">
                            </div>
                            <div class="mb-3">
                                <label for="contactSubject" class="form-label">Sujet *</label>
                                <select class="form-select" id="contactSubject" name="subject" required>
                                    <option value="">Sélectionnez un sujet</option>
                                    <option value="rendez-vous">Demande de rendez-vous</option>
                                    <option value="information">Demande d'information</option>
                                    <option value="urgence">Urgence médicale</option>
                                    <option value="reclamation">Réclamation</option>
                                    <option value="autre">Autre</option>
                                </select>
                                <div class="invalid-feedback">Veuillez sélectionner un sujet</div>
                            </div>
                            <div class="mb-3">
                                <label for="contactMessage" class="form-label">Message *</label>
                                <textarea class="form-control" id="contactMessage" name="message" rows="5" required></textarea>
                                <div class="invalid-feedback">Veuillez entrer votre message</div>
                            </div>
                            <button type="submit" class="btn btn-primary" id="contactSubmitBtn">
                                <i class="fas fa-paper-plane me-2"></i>Envoyer le message
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 mb-4">
                    <div class="appointment-form h-100">
                        <h3 class="mb-4">
                            <i class="fas fa-clock me-2"></i>Heures d'ouverture
                        </h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Jour</th>
                                        <th>Heures</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Lundi</td>
                                        <td>8h - 20h</td>
                                    </tr>
                                    <tr>
                                        <td>Mardi</td>
                                        <td>8h - 20h</td>
                                    </tr>
                                    <tr>
                                        <td>Mercredi</td>
                                        <td>8h - 20h</td>
                                    </tr>
                                    <tr>
                                        <td>Jeudi</td>
                                        <td>8h - 20h</td>
                                    </tr>
                                    <tr>
                                        <td>Vendredi</td>
                                        <td>8h - 20h</td>
                                    </tr>
                                    <tr>
                                        <td>Samedi</td>
                                        <td>8h - 18h</td>
                                    </tr>
                                    <tr>
                                        <td>Dimanche</td>
                                        <td>8h - 14h</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <h5>
                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                Urgences
                            </h5>
                            <p>Pour toute urgence médicale, veuillez nous appeler directement au:</p>
                            <p class="h4 text-danger">
                                <i class="fas fa-phone-alt me-2"></i>+221 77 890 12 34
                            </p>
                            <p class="text-muted">Disponible 24h/24 et 7j/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5">
        <div class="container">
            <h3 class="text-center mb-4">
                <i class="fas fa-map me-2"></i>Nous localiser
            </h3>
            <div class="ratio ratio-16x9">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.123456789!2d-17.444067!3d14.692770!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTTCsDQxJzM0LjAiTiAxN8KwMjYnMzguNiJF!5e0!3m2!1sen!2ssn!4v1234567890"
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="text-center mb-4">
                <i class="fas fa-question-circle me-2"></i>Questions fréquentes
            </h3>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Comment prendre rendez-vous?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Vous pouvez prendre rendez-vous directement sur notre site via la section "Rendez-vous", par téléphone au +221 33 123 45 67, ou en vous rendant directement à la clinique.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Quels sont les modes de paiement acceptés?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Nous acceptons les paiements en espèces, par carte bancaire, mobile money (Orange Money, Wave, Wari) et nous travaillons également avec plusieurs mutuelles de santé.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    La clinique est-elle accessible aux personnes à mobilité réduite?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Oui, notre clinique est entièrement accessible aux personnes à mobilité réduite avec des rampes, des ascenseurs et des toilettes adaptées.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    Faut-il un rendez-vous pour les urgences?
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Non, pour les urgences vous pouvez vous présenter directement à la clinique 24h/24 et 7j/7. Nous vous recommandons cependant d'appeler avant votre arrivée pour que nous puissions nous préparer.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
        // Handle contact form submission
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!app.validateForm(this)) {
                return;
            }

            const submitBtn = document.getElementById('contactSubmitBtn');
            const originalText = submitBtn.innerHTML;
            app.showLoading(submitBtn);

            // Simulate form submission (in real app, this would send to backend)
            setTimeout(() => {
                app.hideLoading(submitBtn, originalText);
                app.showAlert('Votre message a été envoyé avec succès! Nous vous répondrons dans les plus brefs délais.', 'success');
                this.reset();
            }, 2000);
        });
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - E-sitrana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-container {
            background: var(--white);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            padding: 2rem;
            text-align: center;
        }
        .login-form {
            padding: 3rem 2rem;
        }
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        .btn-login {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 0.75rem;
            font-weight: 500;
            transition: transform 0.3s ease;
        }
        .btn-login:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-container">
                    <div class="login-header">
                        <i class="fas fa-hospital fa-3x mb-3"></i>
                        <h3>E-sitrana</h3>
                        <p class="mb-0">Espace Administrateur</p>
                    </div>
                    <div class="login-form">
                        <form id="loginForm" novalidate>
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="fas fa-user me-2"></i>Nom d'utilisateur
                                </label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur</div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Mot de passe
                                </label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback">Veuillez entrer votre mot de passe</div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-login" id="loginBtn">
                                    <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Contactez l'administrateur système en cas de problème
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/app.js"></script>
    <script>
        // Check if already logged in
        document.addEventListener('DOMContentLoaded', async function() {
            try {
                const admin = await app.checkAuthStatus();
                if (admin) {
                    window.location.href = '/admin/dashboard';
                }
            } catch (error) {
                // Not logged in, continue with login form
            }
        });

        // Handle login form submission
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!app.validateForm(this)) {
                return;
            }

            const loginBtn = document.getElementById('loginBtn');
            const originalText = loginBtn.innerHTML;
            app.showLoading(loginBtn);

            try {
                const formData = new FormData(this);
                const result = await app.login(
                    formData.get('username'),
                    formData.get('password')
                );

                if (result.admin) {
                    app.showAlert('Connexion réussie! Redirection...', 'success');
                    setTimeout(() => {
                        window.location.href = '/admin/dashboard';
                    }, 1000);
                }
            } catch (error) {
                console.error('Login error:', error);
            } finally {
                app.hideLoading(loginBtn, originalText);
            }
        });

        // Add Enter key support for form submission
        document.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('loginForm').requestSubmit();
            }
        });
    </script>
</body>
</html>

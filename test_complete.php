<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏥 Test Complet E-sitrana (MySQL)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        .success { color: #27ae60; font-weight: bold; }
        .error { color: #e74c3c; font-weight: bold; }
        .result { background: #f8f9fa; padding: 10px; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="text-center mb-4">
            <h1>🏥 E-sitrana - Test Complet (MySQL)</h1>
            <p class="lead">Application de gestion de clinique médicale</p>
        </div>
        
        <div class="test-section">
            <h3>📊 Configuration MySQL</h3>
            <div id="mysql-config" class="result">
                <strong>Base de données:</strong> E_sitrana_db<br>
                <strong>Utilisateur:</strong> esitrana<br>
                <strong>Hôte:</strong> localhost<br>
                <strong>Port:</strong> 3306
            </div>
        </div>
        
        <div class="test-section">
            <h3>🔌 Test API Services</h3>
            <button class="btn btn-primary" onclick="testServices()">Tester Services API</button>
            <div id="services-result" class="result mt-2"></div>
        </div>
        
        <div class="test-section">
            <h3>👤 Test Authentification</h3>
            <button class="btn btn-success" onclick="testAuth()">Tester Login Admin</button>
            <div id="auth-result" class="result mt-2"></div>
        </div>
        
        <div class="test-section">
            <h3>📋 Test Rendez-vous</h3>
            <button class="btn btn-info" onclick="testAppointments()">Tester Appointments API</button>
            <div id="appointments-result" class="result mt-2"></div>
        </div>
        
        <div class="test-section">
            <h3>🔗 Accès à l'application</h3>
            <div class="row">
                <div class="col-md-6">
                    <h5>Pages publiques:</h5>
                    <ul>
                        <li><a href="views/public/index.php" target="_blank">🏠 Accueil</a></li>
                        <li><a href="views/public/services.php" target="_blank">🏥 Services</a></li>
                        <li><a href="views/public/doctors.php" target="_blank">👨‍⚕️ Médecins</a></li>
                        <li><a href="views/public/appointment.php" target="_blank">📅 Rendez-vous</a></li>
                        <li><a href="views/public/contact.php" target="_blank">📞 Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h5>Administration:</h5>
                    <ul>
                        <li><a href="views/admin/login.php" target="_blank">🔐 Login Admin</a></li>
                        <li><a href="views/admin/dashboard.php" target="_blank">📊 Dashboard</a></li>
                        <li><a href="views/admin/doctors.php" target="_blank">👨‍⚕️ Gestion Médecins</a></li>
                        <li><a href="views/admin/services.php" target="_blank">🏥 Gestion Services</a></li>
                        <li><a href="views/admin/appointments.php" target="_blank">📅 Gestion RDV</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="test-section bg-success text-white">
            <h3>✅ Identifiants de connexion</h3>
            <div class="row">
                <div class="col-md-6">
                    <h5>Administration:</h5>
                    <p><strong>Login:</strong> admin<br><strong>Mot de passe:</strong> admin123</p>
                </div>
                <div class="col-md-6">
                    <h5>MySQL:</h5>
                    <p><strong>Root:</strong> root / Root123456!<br>
                    <strong>App:</strong> esitrana / E_sitrana@2024!</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Test Services API
        async function testServices() {
            const result = document.getElementById('services-result');
            result.innerHTML = '<div class="spinner-border text-primary" role="status"></div> Test en cours...';
            
            try {
                const response = await fetch('api/services.php', {
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json' }
                });
                
                const data = await response.json();
                result.innerHTML = `
                    <span class="success">✅ API Services fonctionne!</span><br>
                    <strong>Services trouvés:</strong> ${data.records.length}<br>
                    <strong>Exemple:</strong> ${data.records[0].name}
                `;
            } catch (error) {
                result.innerHTML = `<span class="error">❌ Erreur: ${error.message}</span>`;
            }
        }

        // Test Authentification
        async function testAuth() {
            const result = document.getElementById('auth-result');
            result.innerHTML = '<div class="spinner-border text-success" role="status"></div> Test en cours...';
            
            try {
                const response = await fetch('api/auth.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        username: 'admin',
                        password: 'admin123'
                    })
                });
                
                const data = await response.json();
                if (data.admin) {
                    result.innerHTML = `
                        <span class="success">✅ Authentification réussie!</span><br>
                        <strong>Utilisateur:</strong> ${data.admin.username}<br>
                        <strong>Email:</strong> ${data.admin.email}
                    `;
                } else {
                    result.innerHTML = '<span class="error">❌ Authentification échouée</span>';
                }
            } catch (error) {
                result.innerHTML = `<span class="error">❌ Erreur: ${error.message}</span>`;
            }
        }

        // Test Appointments API
        async function testAppointments() {
            const result = document.getElementById('appointments-result');
            result.innerHTML = '<div class="spinner-border text-info" role="status"></div> Test en cours...';
            
            try {
                const response = await fetch('api/appointments.php', {
                    method: 'GET',
                    headers: { 'Content-Type': 'application/json' }
                });
                
                const data = await response.json();
                result.innerHTML = `
                    <span class="success">✅ API Appointments fonctionne!</span><br>
                    <strong>Rendez-vous trouvés:</strong> ${data.records.length}<br>
                    <strong>Statuts disponibles:</strong> en attente, confirmé, annulé, terminé
                `;
            } catch (error) {
                result.innerHTML = `<span class="error">❌ Erreur: ${error.message}</span>`;
            }
        }

        // Test automatique au chargement
        window.onload = function() {
            setTimeout(() => testServices(), 500);
            setTimeout(() => testAuth(), 1000);
            setTimeout(() => testAppointments(), 1500);
        };
    </script>
</body>
</html>

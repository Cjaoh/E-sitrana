<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test E-sitrana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .test-section { margin: 20px 0; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>🏥 Test E-sitrana</h1>
        <p>Cette page vérifie que tous les composants fonctionnent correctement.</p>
        
        <div class="test-section">
            <h3>📊 Base de données</h3>
            <div id="db-test">Test en cours...</div>
        </div>
        
        <div class="test-section">
            <h3>🔌 API Services</h3>
            <div id="api-test">Test en cours...</div>
        </div>
        
        <div class="test-section">
            <h3>👤 Authentification</h3>
            <div id="auth-test">
                <button class="btn btn-primary" onclick="testAuth()">Tester login admin</button>
                <div id="auth-result"></div>
            </div>
        </div>
        
        <div class="test-section">
            <h3>🔗 Liens utiles</h3>
            <ul>
                <li><a href="views/public/index.php">Page d'accueil publique</a></li>
                <li><a href="views/admin/login.php">Page d'administration</a></li>
                <li><a href="test_api.php">Test API complet</a></li>
            </ul>
        </div>
    </div>

    <script>
        // Test base de données
        fetch('test_simple.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('db-test').innerHTML = 
                    '<pre class="success">' + data + '</pre>';
            })
            .catch(error => {
                document.getElementById('db-test').innerHTML = 
                    '<span class="error">Erreur: ' + error.message + '</span>';
            });

        // Test API
        fetch('api/services.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('api-test').innerHTML = 
                '<span class="success">✓ API fonctionne! Services trouvés: ' + data.records.length + '</span>';
        })
        .catch(error => {
            document.getElementById('api-test').innerHTML = 
                '<span class="error">Erreur API: ' + error.message + '</span>';
        });

        // Test authentification
        function testAuth() {
            fetch('api/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    username: 'admin',
                    password: 'admin123'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.admin) {
                    document.getElementById('auth-result').innerHTML = 
                        '<span class="success">✓ Authentification réussie!</span>';
                } else {
                    document.getElementById('auth-result').innerHTML = 
                        '<span class="error">✗ Authentification échouée</span>';
                }
            })
            .catch(error => {
                document.getElementById('auth-result').innerHTML = 
                    '<span class="error">Erreur: ' + error.message + '</span>';
            });
        }
    </script>
</body>
</html>

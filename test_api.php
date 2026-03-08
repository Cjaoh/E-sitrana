<?php
// Simple test script to check if API is working
echo "<h1>E-sitrana API Test</h1>";

// Test database connection
require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

if($db) {
    echo "<p style='color: green;'>✓ Database connection successful</p>";
} else {
    echo "<p style='color: red;'>✗ Database connection failed</p>";
}

// Test API endpoints
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);

echo "<h2>Testing API Endpoints:</h2>";

// Test services endpoint
echo "<h3>Services API:</h3>";
$services_json = file_get_contents($base_url . '/api/services');
$services = json_decode($services_json, true);
if($services) {
    echo "<p style='color: green;'>✓ Services API working</p>";
    echo "<p>Found " . count($services['records']) . " services</p>";
} else {
    echo "<p style='color: red;'>✗ Services API failed</p>";
}

// Test doctors endpoint
echo "<h3>Doctors API:</h3>";
$doctors_json = file_get_contents($base_url . '/api/doctors');
$doctors = json_decode($doctors_json, true);
if($doctors) {
    echo "<p style='color: green;'>✓ Doctors API working</p>";
    echo "<p>Found " . count($doctors['records']) . " doctors</p>";
} else {
    echo "<p style='color: red;'>✗ Doctors API failed</p>";
}

// Test appointments endpoint
echo "<h3>Appointments API:</h3>";
$appointments_json = file_get_contents($base_url . '/api/appointments');
$appointments = json_decode($appointments_json, true);
if($appointments) {
    echo "<p style='color: green;'>✓ Appointments API working</p>";
    echo "<p>Found " . count($appointments['records']) . " appointments</p>";
} else {
    echo "<p style='color: red;'>✗ Appointments API failed</p>";
}

echo "<h2>Next Steps:</h2>";
echo "<ul>";
echo "<li>Import database_setup.sql into your MySQL database</li>";
echo "<li>Test admin login with username: admin, password: admin123</li>";
echo "<li>Start building the frontend interface</li>";
echo "</ul>";
?>

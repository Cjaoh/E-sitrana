<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/Patient.php';
require_once __DIR__ . '/models/Appointment.php';

$database = new Database();
$db = $database->getConnection();

// Données de test pour 24 patients
$patients_data = [
    // Patients pour Médecine Générale
    ['first_name' => 'Rakoto', 'last_name' => 'Rabe', 'phone' => '+261 34 12 34 56', 'email' => 'rakoto.rabe@email.com', 'address' => 'Antananarivo', 'birth_date' => '1990-05-15'],
    ['first_name' => 'Soa', 'last_name' => 'Rasolo', 'phone' => '+261 34 23 45 67', 'email' => 'soa.rasolo@email.com', 'address' => 'Toamasina', 'birth_date' => '1985-08-22'],
    ['first_name' => 'Miarisoa', 'last_name' => 'Rakotondrabe', 'phone' => '+261 34 34 56 78', 'email' => 'miarisoa@email.com', 'address' => 'Fianarantsoa', 'birth_date' => '1992-12-10'],
    
    // Patients pour Pédiatrie
    ['first_name' => 'Feno', 'last_name' => 'Razafy', 'phone' => '+261 34 45 67 89', 'email' => 'feno.razafy@email.com', 'address' => 'Antsirabe', 'birth_date' => '2018-03-25'],
    ['first_name' => 'Tahina', 'last_name' => 'Ravelonarivo', 'phone' => '+261 34 56 78 90', 'email' => 'tahina@email.com', 'address' => 'Mahajanga', 'birth_date' => '2020-07-14'],
    ['first_name' => 'Mpela', 'last_name' => 'Rakoto', 'phone' => '+261 34 67 89 01', 'email' => 'mpela@email.com', 'address' => 'Toamasina', 'birth_date' => '2019-11-30'],
    
    // Patients pour Gynécologie
    ['first_name' => 'Voahangy', 'last_name' => 'Rasoanaivo', 'phone' => '+261 34 78 90 12', 'email' => 'voahangy@email.com', 'address' => 'Antananarivo', 'birth_date' => '1988-06-18'],
    ['first_name' => 'Nirina', 'last_name' => 'Rabe', 'phone' => '+261 34 89 01 23', 'email' => 'nirina@email.com', 'address' => 'Fianarantsoa', 'birth_date' => '1995-09-08'],
    ['first_name' => 'Hanitra', 'last_name' => 'Razafimandimby', 'phone' => '+261 34 12 34 56', 'email' => 'hanitra@email.com', 'address' => 'Mahajanga', 'birth_date' => '1993-04-12'],
    
    // Patients pour Cardiologie
    ['first_name' => 'Jean', 'last_name' => 'Rakoto', 'phone' => '+261 34 23 45 67', 'email' => 'jean.rakoto@email.com', 'address' => 'Antananarivo', 'birth_date' => '1975-11-20'],
    ['first_name' => 'Marie', 'last_name' => 'Razafindrakoto', 'phone' => '+261 34 56 78 90', 'email' => 'marie@email.com', 'address' => 'Toamasina', 'birth_date' => '1980-02-14'],
    ['first_name' => 'Pierre', 'last_name' => 'Ravelonarivo', 'phone' => '+261 34 89 01 23', 'email' => 'pierre@email.com', 'address' => 'Antsirabe', 'birth_date' => '1968-07-25'],
    
    // Patients pour Laboratoire
    ['first_name' => 'Sitraka', 'last_name' => 'Razafy', 'phone' => '+261 34 45 67 89', 'email' => 'sitraka@email.com', 'address' => 'Mahajanga', 'birth_date' => '1991-10-30'],
    ['first_name' => 'Hery', 'last_name' => 'Rakotondrabe', 'phone' => '+261 34 78 90 12', 'email' => 'hery@email.com', 'address' => 'Fianarantsoa', 'birth_date' => '1987-03-18'],
    ['first_name' => 'Lalaina', 'last_name' => 'Rabe', 'phone' => '+261 34 12 34 56', 'email' => 'lalaina@email.com', 'address' => 'Toamasina', 'birth_date' => '1994-08-05'],
    
    // Patients supplémentaires divers services
    ['first_name' => 'Andry', 'last_name' => 'Rajaona', 'phone' => '+261 34 67 89 01', 'email' => 'andry@email.com', 'address' => 'Antananarivo', 'birth_date' => '1989-12-03'],
    ['first_name' => 'Nathalie', 'last_name' => 'Raveloson', 'phone' => '+261 34 23 45 78', 'email' => 'nathalie@email.com', 'address' => 'Mahajanga', 'birth_date' => '1992-05-28'],
    ['first_name' => 'Michel', 'last_name' => 'Rakoto', 'phone' => '+261 34 56 78 90', 'email' => 'michel@email.com', 'address' => 'Antsirabe', 'birth_date' => '1978-09-15'],
    ['first_name' => 'Cécile', 'last_name' => 'Razafindrakoto', 'phone' => '+261 34 89 01 23', 'email' => 'cecile@email.com', 'address' => 'Fianarantsoa', 'birth_date' => '1986-04-22'],
    ['first_name' => 'Brice', 'last_name' => 'Ravelonarivo', 'phone' => '+261 34 45 67 89', 'email' => 'brice@email.com', 'address' => 'Toamasina', 'birth_date' => '1993-11-08'],
    ['first_name' => 'José', 'last_name' => 'Rasolo', 'phone' => '+261 34 78 90 12', 'email' => 'jose@email.com', 'address' => 'Mahajanga', 'birth_date' => '1984-06-30'],
    ['first_name' => 'Ariane', 'last_name' => 'Rabe', 'phone' => '+261 34 12 34 56', 'email' => 'ariane@email.com', 'address' => 'Antananarivo', 'birth_date' => '1990-08-17'],
    ['first_name' => 'Claude', 'last_name' => 'Rakoto', 'phone' => '+261 34 67 89 01', 'email' => 'claude@email.com', 'address' => 'Fianarantsoa', 'birth_date' => '1977-02-25'],
    ['first_name' => 'Fanny', 'last_name' => 'Razafy', 'phone' => '+261 34 23 45 78', 'email' => 'fanny@email.com', 'address' => 'Mahajanga', 'birth_date' => '1995-03-12']
];

echo "Création des 24 patients de test...\n";

$patient = new Patient($db);
$created_patients = [];

foreach ($patients_data as $index => $patient_data) {
    $patient->first_name = $patient_data['first_name'];
    $patient->last_name = $patient_data['last_name'];
    $patient->phone = $patient_data['phone'];
    $patient->email = $patient_data['email'];
    $patient->address = $patient_data['address'];
    $patient->birth_date = $patient_data['birth_date'];
    
    if ($patient->create()) {
        $patient_id = $db->lastInsertId();
        $created_patients[] = $patient_id;
        echo "Patient " . ($index + 1) . ": " . $patient_data['first_name'] . " " . $patient_data['last_name'] . " (ID: $patient_id)\n";
        
        // Créer un rendez-vous pour chaque patient
        create_test_appointment($db, $patient_id, $index + 1);
    } else {
        echo "ERREUR: Impossible de créer le patient " . $patient_data['first_name'] . " " . $patient_data['last_name'] . "\n";
    }
}

echo "\nTotal patients créés: " . count($created_patients) . "\n";
echo "Total rendez-vous créés: " . (count($created_patients) * 2) . "\n";

function create_test_appointment($db, $patient_id, $patient_num) {
    $appointment = new Appointment($db);
    
    // Déterminer le service et médecin aléatoirement
    $service_id = (($patient_num - 1) % 5) + 1; // Services 1-5
    $doctor_id = (($patient_num - 1) % 10) + 1; // Médecins 1-10
    
    // Dates aléatoires dans les 30 prochains jours
    $future_date = date('Y-m-d', strtotime('+' . rand(1, 30) . ' days'));
    $times = ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00'];
    $appointment_time = $times[array_rand($times)];
    
    // Statuts variés (valeurs valides de l'enum)
    $statuses = ['en attente', 'confirmé', 'annulé', 'terminé'];
    $status = $statuses[array_rand($statuses)];
    
    $appointment->patient_id = $patient_id;
    $appointment->doctor_id = $doctor_id;
    $appointment->service_id = $service_id;
    $appointment->appointment_date = $future_date;
    $appointment->appointment_time = $appointment_time;
    $appointment->status = $status;
    $appointment->notes = "Rendez-vous de test pour patient #$patient_num";
    
    if ($appointment->create()) {
        echo "  -> Rendez-vous créé: $future_date à $appointment_time (Service: $service_id, Médecin: $doctor_id, Statut: $status)\n";
    } else {
        echo "  -> ERREUR: Impossible de créer le rendez-vous pour patient #$patient_num\n";
    }
}
?>

-- =========================
-- Générer des services
-- =========================
INSERT INTO services (name, description, icon)
VALUES 
('Laboratoire', 'Analyses médicales et tests de laboratoire', 'fa-flask'),
('Cardiologie', 'Diagnostic et traitement des maladies cardiaques', 'fa-heartbeat'),
('Gynécologie', 'Santé féminine et soins gynécologiques complets', 'fa-female'),
('Pédiatrie', 'Soins médicaux spécialisés pour les enfants et adolescents', 'fa-child'),
('Médecine générale', 'Consultations générales pour tous les problèmes de santé courants', 'fa-user-md');

-- =========================
-- Générer des docteurs aléatoires
-- =========================
INSERT INTO doctors (first_name, last_name, speciality, phone, email, photo, description, service_id)
SELECT 
    'Doctor_' || abs(random() % 1000),
    'Surname_' || abs(random() % 1000),
    speciality,
    '034' || abs(random() % 10000000),
    'doctor' || abs(random() % 1000) || '@clinic.com',
    '',
    'Médecin expérimenté dans sa spécialité',
    (1 + abs(random() % 5))
FROM (SELECT 'Cardiologie' as speciality UNION ALL SELECT 'Dentist' UNION ALL SELECT 'Dermatologie' UNION ALL SELECT 'Pédiatrie' UNION ALL SELECT 'Médecine générale')
LIMIT 50;

-- =========================
-- Générer des patients aléatoires
-- =========================
INSERT INTO patients (first_name, last_name, phone, email)
SELECT 
    'Patient_' || abs(random() % 10000),
    'Surname_' || abs(random() % 10000),
    '032' || abs(random() % 10000000),
    'patient' || abs(random() % 10000) || '@mail.com'
FROM sqlite_master
LIMIT 200;

-- =========================
-- Générer des rendez-vous aléatoires
-- =========================
INSERT INTO appointments (patient_id, doctor_id, service_id, appointment_date, appointment_time, status)
SELECT
    (1 + abs(random() % 200)),  -- patient_id
    (1 + abs(random() % 50)),   -- doctor_id
    (1 + abs(random() % 5)),    -- service_id
    date('now', '+' || abs(random() % 30) || ' days'),  -- date aléatoire dans les 30 prochains jours
    time(abs(random() % 8 + 9) || ':00'),               -- horaire aléatoire entre 9h et 17h
    CASE abs(random() % 3)
        WHEN 0 THEN 'en attente'
        WHEN 1 THEN 'confirmé'
        ELSE 'annulé'
    END
FROM sqlite_master
LIMIT 500;

-- =========================
-- Générer un compte admin supplémentaire (facultatif)
-- =========================
INSERT INTO admins (username, password, email)
VALUES ('admin2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin2@esitrana.com');

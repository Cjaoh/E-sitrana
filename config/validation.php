<?php
// Validation centralisée des entrées pour E-sitrana

/**
 * Valide un email
 * @param string $email
 * @return bool
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Valide un numéro de téléphone (format français/malgache)
 * @param string $phone
 * @return bool
 */
function validatePhone($phone) {
    // Accepte les formats: +261..., 034..., 032..., etc.
    return preg_match('/^(\+?\d{1,3}[- ]?)?\d{9,10}$/', $phone);
}

/**
 * Valide une date au format YYYY-MM-DD
 * @param string $date
 * @return bool
 */
function validateDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/**
 * Valide une heure au format HH:MM
 * @param string $time
 * @return bool
 */
function validateTime($time) {
    return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $time);
}

/**
 * Valide un nom ou prénom (lettres, espaces, tirets)
 * @param string $name
 * @param int $min_length
 * @param int $max_length
 * @return bool
 */
function validateName($name, $min_length = 2, $max_length = 50) {
    return preg_match('/^[a-zA-Zàâäéèêëïîôöùûüÿç\s\-]{'.$min_length.','.$max_length.'}$/', $name);
}

/**
 * Valide la longueur d'un champ
 * @param string $value
 * @param int $min
 * @param int $max
 * @return bool
 */
function validateLength($value, $min = 1, $max = 255) {
    $length = strlen(trim($value));
    return $length >= $min && $length <= $max;
}

/**
 * Valide un ID numérique
 * @param mixed $id
 * @return bool
 */
function validateId($id) {
    return filter_var($id, FILTER_VALIDATE_INT) !== false && $id > 0;
}

/**
 * Nettoie et sécurise une entrée
 * @param string $input
 * @return string
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Valide les données d'un médecin
 * @param object $data
 * @return array
 */
function validateDoctorData($data) {
    $errors = [];
    
    if (empty($data->first_name) || !validateName($data->first_name)) {
        $errors[] = "Prénom invalide";
    }
    
    if (empty($data->last_name) || !validateName($data->last_name)) {
        $errors[] = "Nom invalide";
    }
    
    if (empty($data->speciality) || !validateLength($data->speciality, 2, 100)) {
        $errors[] = "Spécialité invalide";
    }
    
    if (empty($data->phone) || !validatePhone($data->phone)) {
        $errors[] = "Téléphone invalide";
    }
    
    if (empty($data->email) || !validateEmail($data->email)) {
        $errors[] = "Email invalide";
    }
    
    if (!validateId($data->service_id)) {
        $errors[] = "ID de service invalide";
    }
    
    return $errors;
}

/**
 * Valide les données d'un patient
 * @param object $data
 * @return array
 */
function validatePatientData($data) {
    $errors = [];
    
    if (empty($data->first_name) || !validateName($data->first_name)) {
        $errors[] = "Prénom invalide";
    }
    
    if (empty($data->last_name) || !validateName($data->last_name)) {
        $errors[] = "Nom invalide";
    }
    
    if (empty($data->phone) || !validatePhone($data->phone)) {
        $errors[] = "Téléphone invalide";
    }
    
    if (empty($data->email) || !validateEmail($data->email)) {
        $errors[] = "Email invalide";
    }
    
    if (!empty($data->birth_date) && !validateDate($data->birth_date)) {
        $errors[] = "Date de naissance invalide";
    }
    
    return $errors;
}

/**
 * Valide les données d'un rendez-vous
 * @param object $data
 * @return array
 */
function validateAppointmentData($data) {
    $errors = [];
    
    if (!validateId($data->patient_id)) {
        $errors[] = "ID patient invalide";
    }
    
    if (!validateId($data->doctor_id)) {
        $errors[] = "ID médecin invalide";
    }
    
    if (!validateId($data->service_id)) {
        $errors[] = "ID service invalide";
    }
    
    if (empty($data->appointment_date) || !validateDate($data->appointment_date)) {
        $errors[] = "Date de rendez-vous invalide";
    }
    
    if (empty($data->appointment_time) || !validateTime($data->appointment_time)) {
        $errors[] = "Heure de rendez-vous invalide";
    }
    
    return $errors;
}

/**
 * Valide les données d'un service
 * @param object $data
 * @return array
 */
function validateServiceData($data) {
    $errors = [];
    
    if (empty($data->name) || !validateLength($data->name, 2, 100)) {
        $errors[] = "Nom de service invalide";
    }
    
    if (empty($data->description) || !validateLength($data->description, 10, 1000)) {
        $errors[] = "Description invalide (minimum 10 caractères)";
    }
    
    return $errors;
}
?>

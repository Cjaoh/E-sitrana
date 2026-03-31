<?php
// Système d'email simple pour E-sitrana

/**
 * Envoie un email basique
 * @param string $to - Destinataire
 * @param string $subject - Sujet
 * @param string $message - Message HTML
 * @param string $from - Expéditeur (optionnel)
 * @return bool - true si envoyé, false sinon
 */
function sendEmail($to, $subject, $message, $from = null) {
    $app_env = getenv('APP_ENV') ?: 'development';
    
    // En développement, juste logger l'email
    if ($app_env === 'development') {
        logInfo('Email (development mode)', [
            'to' => $to,
            'subject' => $subject,
            'from' => $from ?: getenv('MAIL_FROM')
        ]);
        return true; // Simuler l'envoi en dev
    }
    
    // Configuration depuis .env
    $mail_host = getenv('MAIL_HOST') ?: 'localhost';
    $mail_port = getenv('MAIL_PORT') ?: 587;
    $mail_username = getenv('MAIL_USERNAME') ?: '';
    $mail_password = getenv('MAIL_PASSWORD') ?: '';
    $default_from = getenv('MAIL_FROM') ?: 'noreply@esitrana.mg';
    
    $from = $from ?: $default_from;
    
    // Headers email
    $headers = [
        'From' => $from,
        'Reply-To' => $from,
        'MIME-Version' => '1.0',
        'Content-Type' => 'text/html; charset=UTF-8',
        'X-Mailer' => 'PHP/' . phpversion()
    ];
    
    // Construction des headers
    $header_string = '';
    foreach ($headers as $key => $value) {
        $header_string .= "$key: $value\r\n";
    }
    
    // Envoi avec mail() PHP (basique mais simple)
    try {
        $success = mail($to, $subject, $message, $header_string);
        
        if ($success) {
            logInfo('Email sent successfully', [
                'to' => $to,
                'subject' => $subject
            ]);
        } else {
            logError('Email sending failed', [
                'to' => $to,
                'subject' => $subject
            ]);
        }
        
        return $success;
        
    } catch (Exception $e) {
        logError('Email exception', [
            'to' => $to,
            'subject' => $subject,
            'error' => $e->getMessage()
        ]);
        return false;
    }
}

/**
 * Envoie un email de confirmation de rendez-vous
 */
function sendAppointmentConfirmation($patient_email, $patient_name, $doctor_name, $appointment_date, $appointment_time) {
    $subject = "Confirmation de rendez-vous - E-sitrana";
    
    $message = "
    <html>
    <head>
        <title>Confirmation de rendez-vous</title>
    </head>
    <body style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <div style='background: #f8f9fa; padding: 20px; border-radius: 5px;'>
            <h2 style='color: #007bff;'>Confirmation de rendez-vous</h2>
            <p>Bonjour <strong>$patient_name</strong>,</p>
            <p>Votre rendez-vous a été confirmé avec les détails suivants :</p>
            
            <div style='background: white; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0;'>
                <p><strong>Médecin:</strong> Dr. $doctor_name</p>
                <p><strong>Date:</strong> $appointment_date</p>
                <p><strong>Heure:</strong> $appointment_time</p>
            </div>
            
            <p>Merci de votre confiance.</p>
            <p style='color: #6c757d; font-size: 14px;'>Cordialement,<br>L'équipe E-sitrana</p>
        </div>
    </body>
    </html>";
    
    return sendEmail($patient_email, $subject, $message);
}

/**
 * Envoie un email de notification admin
 */
function sendAdminNotification($subject, $message) {
    $admin_email = getenv('ADMIN_EMAIL') ?: 'admin@esitrana.mg';
    
    $html_message = "
    <html>
    <body style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
        <div style='background: #f8f9fa; padding: 20px; border-radius: 5px;'>
            <h2 style='color: #dc3545;'>Notification Admin</h2>
            <p>$message</p>
            <p style='color: #6c757d; font-size: 12px;'>Envoyé depuis E-sitrana</p>
        </div>
    </body>
    </html>";
    
    return sendEmail($admin_email, $subject, $html_message);
}
?>

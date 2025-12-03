<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

// Generate OTP
$otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);


$microserviceUrl = 'https://senior-dev-otpt1.webdev.gccis.rit.edu/otp/create';
$microserviceApiKey = '123123123';

$payload = json_encode([
    'email' => $email,
    'code' => $otp
]);

$ch = curl_init($microserviceUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-API-Key: ' . $microserviceApiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($httpCode !== 200) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Failed to store OTP',
        'debug' => [
            'httpCode' => $httpCode,
            'response' => $response,
            'error' => $curlError
        ]
    ]);
    exit;
}

// Now send email via SendGrid
$sendgridApiKey = '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';
$url = 'https://api.sendgrid.com/v3/mail/send';

$emailPayload = [
    'personalizations' => [
        [
            'to' => [['email' => $email]],
            'subject' => 'Your Login OTP'
        ]
    ],
    'from' => ['email' => 'jw3437@g.rit.edu', 'name' => 'One Time Passcode - Senior Dev Portal'],
    'content' => [
        [
            'type' => 'text/html',
            'value' => "
                <html>
                    <body style='font-family: Arial, sans-serif;'>
                        <h2>Your Login OTP</h2>
                        <p>Your one-time password is:</p>
                        <h1 style='color: #007bff; letter-spacing: 5px;'>$otp</h1>
                        <p>This code will expire in 5 minutes.</p>
                        <p>If you didn't request this, please ignore this email.</p>
                    </body>
                </html>
            "
        ]
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $sendgridApiKey,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($emailPayload));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 202) {
    echo json_encode(['success' => true, 'message' => 'OTP sent successfully']);
} else {
    http_response_code($httpCode);
    echo json_encode(['success' => false, 'message' => 'Failed to send OTP']);
}
?>
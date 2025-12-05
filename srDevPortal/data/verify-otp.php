<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$otp = $data['otp'] ?? '';
$email = $data['email'] ?? '';

if (!$email || !$otp) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Email and OTP required']);
    exit;
}

$microserviceUrl = 'https://senior-dev-otpt1.webdev.gccis.rit.edu/otp/verify';
$apiKey = '123123123';

$payload = json_encode([
    'email' => $email,
    'code' => $otp
]);

$ch = curl_init($microserviceUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-API-Key: ' . $apiKey
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
        'message' => 'Verification service error',
        'debug' => [
            'httpCode' => $httpCode,
            'response' => $response,
            'error' => $curlError
        ]
    ]);
    exit;
}

$result = json_decode($response, true);

if ($result['valid']) {
    session_start();
    $_SESSION['logged_in'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['id'] = strstr($email, "@", true);
    
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'redirect' => 'index.php'
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $result['reason'] === 'expired' ? 'OTP expired' : 'Invalid OTP'
    ]);
}
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once __DIR__ . '/../classes/QueryBuilder.class.php';
require_once __DIR__ . '/../data/DB.class.php';

try {
    // read filters from the JS request
    $filters = json_decode(file_get_contents('php://input'), true);
    if (!is_array($filters)) {
        $filters = [];
    }

    // connect to the database
    $db = new DB();
    $pdo = $db->getConnection();

    // build and run the query
    $queryBuilder = new QueryBuilder();
    $data = $queryBuilder->getFilteredData($filters, $pdo);

    // return
    echo json_encode($data);

    $db->close();

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
}

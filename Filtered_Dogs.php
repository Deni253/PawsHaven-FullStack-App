<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "postgres";
$password = "postgres";
$dbname = "Shelter";
$port = "5432";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);

    
    $input = json_decode(file_get_contents('php://input'), true);
    $breeds = $input['breeds'] ?? [];
    $trained = $input['trained'] ?? false;
    $medicalRecord = $input['medicalRecord'] ?? false;

    
    $query = 'SELECT * FROM "Dog" WHERE 1=1';
    $params = [];

    if (!empty($breeds)) {
        $query .= ' AND "Breed" IN (' . implode(',', array_fill(0, count($breeds), '?')) . ')';
        $params = array_merge($params, $breeds);
    }

    if ($trained) {
        $query .= ' AND "IsTrained" = TRUE';
    }

    if ($medicalRecord) {
        $query .= ' AND "HasMedicalRecord" = TRUE';
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $dogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($dogs);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
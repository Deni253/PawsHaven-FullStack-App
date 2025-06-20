<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "postgres";
$password = "postgres";
$dbname = "Shelter";
$port = "5432";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $stmt = $pdo->query('SELECT DISTINCT "Breed" FROM "Dog"');
    $breeds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($breeds);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
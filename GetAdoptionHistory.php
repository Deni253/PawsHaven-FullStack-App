<?php
session_start();

$host = "localhost";
$user = "postgres";
$password = "postgres";
$dbname = "Shelter";
$port = "5432";


if (!isset($_SESSION['user_id'])) {
    http_response_code(401); 
    echo json_encode(['error' => 'You must be logged in to view adoption history.']);
    exit;
}

$UserId = $_SESSION['user_id'];

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $stmt = $pdo->prepare(
        'SELECT d."Id" AS "DogId", d."Name", d."Age", d."Breed", d."FurColor", d."IsTrained", d."Image", d."Medical_Records"
         FROM "Adoption" a 
         JOIN "Dog" d ON a."Dog_id" = d."Id" 
         WHERE a."Owner_id" = :id'
    );
    $stmt->execute([':id' => $UserId]);
    $dogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    echo json_encode($dogs);
    error_log(print_r($dogs, true));
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
?>
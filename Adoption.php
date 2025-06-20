<?php 

$host = "localhost";
$dbname = "Shelter";
$port = "5432";
$user = "postgres";
$password = "postgres";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);

    
    if (!isset($data['dogId']) || !isset($data['userId'])) {
        http_response_code(400); 
        echo json_encode(['error' => 'Missing dogId or userId']);
        exit;
    }

    
    $check = $pdo->prepare('SELECT * FROM "Adoption" WHERE "Dog_id" = :dog_id');
    $check->execute([':dog_id' => $data['dogId']]);
    $checks = $check->fetch(PDO::FETCH_ASSOC); //ako nema vratiti će false da nije uspio naći nijedan row na taj upit

    if ($checks) { 
        http_response_code(400);
        echo json_encode(['error' => 'This dog is already adopted']);// ovo će ostat ovdje nepotrebno jer ću ih micati iz liste
        exit;
    }

    
    $stmt = $pdo->prepare('INSERT INTO "Adoption" ("Dog_id", "Owner_id") 
                           VALUES (:dog_id, :owner_id)');
    $stmt->execute([':dog_id' => $data['dogId'], ':owner_id' => $data['userId']]);

    
    http_response_code(200); 
    echo json_encode(['success' => true, 'message' => 'Logged User adopted dog successfully']);

} catch (PDOException $e) {
    error_log($e->getMessage()); 
    http_response_code(500); 
    echo json_encode(['error' => 'An error occurred while processing the adoption']);
}
?>
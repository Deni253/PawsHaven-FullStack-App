<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "postgres";
$password = "postgres";
$dbname = "Shelter";
$port = "5432";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $stmt = $pdo->prepare(
        'SELECT * 
         FROM "Dog" d
         WHERE NOT EXISTS (
             SELECT 1 
             FROM "Adoption" a 
             WHERE a."Dog_id" = d."Id"
         )'
    );
    $stmt->execute();
    $dogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($dogs);

} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => $e->getMessage()]);
}
?>

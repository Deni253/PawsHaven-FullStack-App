<?php 

session_start(); 

$host = "localhost";
$dbname = "Shelter";
$port = "5432";
$user = "postgres";
$password = "postgres";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents('php://input'), true);
    $dog_UUID = $data['dogId'];
    $owner_UUID = $_SESSION['user_id'];

    
    $stmt = $pdo->prepare('SELECT * FROM "Dog" WHERE "Id" = :id');
    $stmt->execute(['id' => $dog_UUID]);
    $dog = $stmt->fetch(PDO::FETCH_ASSOC);

    
    $dog['Medical_Records'] = $dog['Medical_Records'] ?: 'Dog is completely healthy';

    $response = [
        'dog' => $dog,
        'user' => $owner_UUID
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(['error' => $e->getMessage()]);
}
?>

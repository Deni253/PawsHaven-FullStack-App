<?php
session_start();

session_regenerate_id(true);


$host = 'localhost';
$port = '5432'; 
$dbname = 'Shelter';
$user = 'postgres';
$pass = 'postgres';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $input = json_decode(file_get_contents('php://input'), true);// ovo hvata od JS i onda pretvara u php associjativni array da se može s njima radit u php-u

    
    if (!isset($input['username']) || !isset($input['password']) || empty($input['username']) || empty($input['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Username and password are required']);
        exit;
    }

    $username = trim($input['username']); 
    $password = $input['password'];

    
    $stmt = $pdo->prepare('SELECT "Id", "Username", "Password", "Name" FROM "Owner" WHERE "Username" = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid username or password']);
        exit;
    }

    
    if (password_verify($password, $user['Password'])) {
        
        $_SESSION['user_id'] = $user['Id'];
        $_SESSION['username'] = $user['Username'];
        $_SESSION['name'] = $user['Name']; 

        http_response_code(200);
        echo json_encode(['message' => 'Login successful', 'username' => $user['Username'], 'name' => $user['Name']]);
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid username or password']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
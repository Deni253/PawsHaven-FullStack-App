<?php
session_start();
header('Content-Type: application/json');


if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'You must be logged in to put up a dog for adoption.']);
    exit;
}


$dogName = $_POST['dogname'] ?? '';
$dogAge = $_POST['dogage'] ?? '';
$dogBreed = $_POST['dogbreed'] ?? '';
$dogFurColor = $_POST['dogfurcolor'] ?? '';
$isTrained = isset($_POST['isTrained']) ? true : false;
$medicalIssues = $_POST['medicalIssues'] ?? '';


if (empty(trim($medicalIssues))) {
    $medicalIssues = 'Dog is completely healthy';
}


$fileUrl = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = basename($_FILES['file']['name']); 
    $uploadDir = 'assets/';
    $destPath = $uploadDir . $fileName;

   
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); 
    }

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $fileUrl = $destPath;
    } else {
        echo json_encode(['error' => 'File upload failed.']);
        exit;
    }
}

try {
    
    $pdo = new PDO("pgsql:host=localhost;port=5432;dbname=Shelter", "postgres", "postgres");

    
    $stmt = $pdo->prepare('
        INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
        VALUES (:name, :age, :breed, :furcolor, :istrained, :image, :medical_records)
    ');
    $stmt->execute([
        ':name' => $dogName,
        ':age' => $dogAge,
        ':breed' => $dogBreed,
        ':furcolor' => $dogFurColor,
        ':istrained' => $isTrained,
        ':image' => $fileUrl,
        ':medical_records' => $medicalIssues
    ]);

    echo json_encode(['message' => 'Dog successfully uploaded for adoption!']);
} catch (PDOException $e) {
    
    if ($e->getCode() === '23505') { 
        echo json_encode(['error' => 'A dog with the same name, age, fur color, and image already exists.']);
    } else {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
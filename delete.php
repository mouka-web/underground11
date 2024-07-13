<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "underground";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer les données JSON envoyées par la requête
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

if ($id) {
    // Préparer la requête de suppression
    $stmt = $conn->prepare("DELETE FROM abonnements WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "ID manquant"]);
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>

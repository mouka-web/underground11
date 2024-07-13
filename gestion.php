<?php
// Informations de connexion à la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "underground";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Préparez la requête SQL pour récupérer les abonnements
$sql = "SELECT id, cin, nom, prenom, telephone, abonnement, prix, created_at, photo FROM abonnements ORDER BY created_at ASC";
$result = $conn->query($sql);

if (!$result) {
    echo "Erreur lors de la requête: " . $conn->error;
} elseif ($result->num_rows > 0) {
    // Sortie des données
    while ($row = $result->fetch_assoc()) {
        echo "{$row['cin']}, {$row['nom']}, {$row['prenom']}, {$row['telephone']}, {$row['abonnement']}, {$row['prix']}, {$row['created_at']}, {$row['id']}, " . base64_encode($row['photo']) . "\n";
    }
} else {
    echo "Aucune donnée disponible";
}

$conn->close();
?>

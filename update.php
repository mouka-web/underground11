<?php
$servername = "127.0.0.1";
$username = "root";
$password = ""; // Votre mot de passe MySQL
$dbname = "underground";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $cin = $_POST['cin'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $abonnement = $_POST['abonnement'];
    $prix = $_POST['prix'];
    
    // Date actuelle au format 'Y-m-d H:i:s'
    $created_at = date('Y-m-d H:i:s');

    // Gérer l'upload de l'image
    $photo = null;
    if (!empty($_FILES['photo']['tmp_name'])) {
        $photo = file_get_contents($_FILES['photo']['tmp_name']);
    } else {
        // Si aucune nouvelle photo, ne pas changer la photo
        $sql = "SELECT photo FROM abonnements WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($photo);
        $stmt->fetch();
        $stmt->close();
    }

    // Préparez la requête SQL pour mettre à jour l'abonnement
    $sql = "UPDATE abonnements SET cin=?, nom=?, prenom=?, telephone=?, abonnement=?, prix=?, photo=?, created_at=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssissi", $cin, $nom, $prenom, $telephone, $abonnement, $prix, $photo, $created_at, $id);

    if ($stmt->execute()) {
        echo "Abonnement mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour : " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

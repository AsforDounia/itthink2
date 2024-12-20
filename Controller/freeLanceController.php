<?php

session_start();
require_once '../config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['Ajouter_FreeLance'])){
        
        $query = "INSERT INTO freelances (competences, id_utilisateur) VALUES (:competences, :id_utilisateur)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':competences', $_POST['competences']);
        $stmt->bindParam(':id_utilisateur', $_POST['user_select']);
        $stmt->execute();
        
        $queryFreeLances = "SELECT * FROM freelances INNER JOIN utilisateurs ON freelances.id_utilisateur = utilisateurs.id_utilisateur ";
        $stmtp = $pdo->prepare($queryFreeLances);
        $stmtp->execute();
        $FreeLances = $stmtp->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION['FreeLances'] = $FreeLances;
        
        header('Location: ../admin.php?page=freelances');
    }
    if(isset($_POST['id_freelance'])){
        $id_freelance = $_POST['id_freelance'];

        if(isset($_POST['supprimerFreelance'])){
            $stmDeleteProjet = $pdo->prepare("DELETE FROM freelances WHERE id_freelance = :id");
            $stmDeleteProjet->execute(['id' => $id_freelance]);

            $queryFreelances = "SELECT * FROM Freelances INNER JOIN utilisateurs ON freelances.id_utilisateur = utilisateurs.id_utilisateur ";
            $stmt = $pdo->prepare($queryFreelances);
            $stmt->execute();
            $Freelances = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['FreeLances'] = $Freelances;
            header('Location: ../admin.php?page=freelances');
        }

    }

}
?>



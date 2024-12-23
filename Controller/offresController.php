<?php

session_start();
require_once '../config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['Soumettre_Offre'])){
        $mantant = (float)$_POST['montant'];
        $Soumettre_Offre = "INSERT INTO Offres (montant,delai, id_freelance,id_projet) VALUES (:montant, :delai, :id_freelance, :id_projet)";

        $stmt = $pdo->prepare($Soumettre_Offre);
        $stmt->bindParam(':montant', $mantant );
        $stmt->bindParam(':delai', $_POST['delai']);
        $stmt->bindParam(':id_freelance', $_SESSION['id_freelance']);
        $stmt->bindParam(':id_projet', $_POST['id_projet']);
        $stmt->execute();
        
        // $queryFreeLances = "SELECT * FROM freelances INNER JOIN utilisateurs ON freelances.id_utilisateur = utilisateurs.id_utilisateur ";
        // $stmtp = $pdo->prepare($queryFreeLances);
        // $stmtp->execute();
        // $FreeLances = $stmtp->fetchAll(PDO::FETCH_ASSOC);
        // $_SESSION['FreeLances'] = $FreeLances;
        
        header('Location: ../freelance.php?page=freelances');
    }


    if(isset($_POST['id_Offre'])){
        $id_Offre = $_POST['id_Offre'];
        
        if(isset($_POST['supprimerOffre'])){
            $stmDeleteProjet = $pdo->prepare("DELETE FROM Offres WHERE id_Offre = :id");
            $stmDeleteProjet->execute(['id' => $id_Offre]);

            $queryOffres = "SELECT * FROM Offres INNER JOIN utilisateurs ON Offres.id_utilisateur = utilisateurs.id_utilisateur ";
            $stmt = $pdo->prepare($queryOffres);
            $stmt->execute();
            $Offres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['Offres'] = $Offres;
            header('Location: ../admin.php?page=Offres');
        }

    }

}
?>



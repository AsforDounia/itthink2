<?php

session_start();
require_once '../config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['id_temoignage'])){
        $id_temoignage = $_POST['id_temoignage'];

        if(isset($_POST['supprimerTemoignage'])){
            $stmDeleteProjet = $pdo->prepare("DELETE FROM temoignages WHERE id_temoignage = :id");
            $stmDeleteProjet->execute(['id' => $id_temoignage]);

            $queryTemoignages = "SELECT * FROM temoignages INNER JOIN utilisateurs ON temoignages.id_utilisateur = utilisateurs.id_utilisateur ";
            $stmt = $pdo->prepare($queryTemoignages);
            $stmt->execute();
            $Temoignages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $_SESSION['temoignages'] = $Temoignages;
            header('Location: ../admin.php?page=temoignages');
        }

    }

}
?>



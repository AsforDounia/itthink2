<?php
require_once 'config.php';

 session_start();

 $stmt = $pdo->prepare("SELECT * FROM freelances WHERE id_utilisateur = :id_utilisateur");
 $stmt->execute(['id_utilisateur' => $_SESSION['user_id']]);

 $freeLance = $stmt->fetch(PDO::FETCH_ASSOC); 

if (!$freeLance) {
     header("Location: user.php");
     exit;
}
else{
    $_SESSION['id_freelance'] = $freeLance['id_freelance'];

    $stmt = $pdo->prepare("SELECT * FROM Projets WHERE statut = :statut");
    $stmt->execute(['statut' => 'En attend']);
    $projetsEnAttend = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['projets_en_attend'] = $projetsEnAttend;


    $stmt = $pdo->prepare("SELECT * FROM Projets INNER JOIN offres on projets.id_projet = offres.id_projet INNER JOIN freelances on offres.id_freelance = freelances.id_freelance WHERE statut = :statut and offres.id_freelance = :id_freelance");
    $stmt->execute(['statut' => 'En Cours' , 'id_freelance' => $_SESSION['id_freelance'] ]);
    $projetsEnAttend = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['projets_en_cours'] = $projetsEnAttend;

    $stmt = $pdo->prepare("SELECT * FROM Projets INNER JOIN offres on projets.id_projet = offres.id_projet INNER JOIN freelances on offres.id_freelance = freelances.id_freelance WHERE statut = :statut and offres.id_freelance = :id_freelance");
    $stmt->execute(['statut' => 'Fini' , 'id_freelance' => $_SESSION['id_freelance'] ]);
    $projetsEnAttend = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['fini'] = $projetsEnAttend;





    // header('Location: user.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Learnify Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- <script src="js/script.js"></script> -->
  
</head>
<body class="bg-black h-screen">
<section class="m-5">

  <!-- Container principal -->
  <div class="flex border-2 border-white rounded-xl overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-20 bg-gray-800 flex flex-col items-center space-y-8 py-28 relative">
        <div onclick="window.location.href = 'user.php'" class="h-10 w-10 rounded-full bg-gray-300 flex flex-col items-center justify-center absolute top-8 cursor-pointer">
        <!-- <i class="fas fa-user"></i> -->
         <img src="img/profile.png" alt="">
        <!-- <i class="fas fa-sign-out-alt"></i> -->
        </div>
      <div class="h-10 w-10 bg-white rounded-md"></div>
      <div class="h-10 w-10 bg-gray-400 rounded-md"></div>
      <div class="h-10 w-10 bg-gray-400 rounded-md"></div>
      <div class="h-10 w-10 bg-gray-400 rounded-md"></div>
      <div class="h-10 w-10 bg-gray-400 rounded-md"></div>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 p-8 bg-gray-100 ">
      <!-- Header -->
      <header class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div>
            <div class="flex justify-end">
                <button class="bg-red-500 p-2 px-4 m-3 rounded-md mr-0 -mt-3">Deconnetion</button>
            </div>
            <div class="flex items-center space-x-4">
                <input type="text" placeholder="Search" class="border rounded-lg py-2 px-4">
                <div class="h-10 w-10 rounded-full bg-gray-300 flex flex-col items-center justify-center">
                    <?php
                if (isset($_SESSION['notification'])) {
                    echo '<i class="fas fa-bell text-red-500 cursor-pointer" onclick="return showSection(\'notification\', \'\')"></i>';
                } else {
                    echo '<i class="fas fa-bell text-gray-400 cursor-pointer" onclick="return showSection(\'notification\', \'\')"></i>';
                }
                ?>

<!-- <i class="fas fa-bell"></i> -->
</div>
</div>
        </div>
      </header>

      <!-- Section des cartes -->
      <section class="grid grid-cols-4 gap-6 mb-8 ">
        <div class="bg-purple-300 py-4 p-4 rounded-lg text-center flex flex-col items-center cursor-pointer relative group">
          <h2 class="text-xl font-semibold mb-4">Nombre total des projets En attend</h2>
          <div class="font-bold text-3xl"><?php echo count($_SESSION['projets_en_attend']) ; ?></div>
          <button onclick="return gestion('projets')" class="bg-purple-300 p-2 rounded-md absolute w-full h-full top-0 hidden group-hover:block text-black text-xl font-bold">Gestion des Projets</button>
        </div>
        <div class="bg-purple-300 py-4 p-4 rounded-lg text-center flex flex-col items-center cursor-pointer relative group">
          <h2 class="text-xl font-semibold mb-4">Nombre total des projets En Cours</h2>
          <div class="font-bold text-3xl"><?php echo count($_SESSION['projets_en_cours']) ; ?></div>
          <button onclick="return gestion('projets')" class="bg-purple-300 p-2 rounded-md absolute w-full h-full top-0 hidden group-hover:block text-black text-xl font-bold">Gestion des Projets</button>
        </div>
        <div class="bg-purple-300 py-4 p-4 rounded-lg text-center flex flex-col items-center cursor-pointer relative group">
          <h2 class="text-xl font-semibold mb-4">Nombre total des projets Fini</h2>
          <div class="font-bold text-3xl"><?php echo count($_SESSION['fini']) ; ?></div>
          <button onclick="return gestion('projets')" class="bg-purple-300 p-2 rounded-md absolute w-full h-full top-0 hidden group-hover:block text-black text-xl font-bold">Gestion des Projets</button>
        </div>

      </section>



      <section id="projets" class="bg-white p-4 rounded-lg  cartSection overflow-auto h-72">
    <div  class="flex justify-between">
      <h2 class="text-xl font-semibold mb-4">Tous les Projets</h2>
      <button onclick="return addprojetForm()" class="text-sm mb-4 p-2 font-semibold rounded-lg bg-yellow-400 text-gray-800   hover:underline">Ajouter Projet</button>
    </div>
    <div class="overflow-auto h-60">
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="py-2 text-left">ID</th>
                <th class="py-2 text-left">Titre</th>
                <th class="py-2 text-left">Description</th>
                <th class="py-2 text-left">Nom Utilisateur</th>
                <th class="py-2 text-left">Date De Creation</th>
                <th class="py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $projets = $_SESSION['projets'];
            if (!empty($projets)): ?>
                <?php foreach ($projets as $projet): 
                    if($projet['statut'] == "En attend") :
                    ?>
                    <tr class="border-b">
                        <td class="py-2"><?= htmlspecialchars($projet['titre_projet']); ?></td>
                        
                        <?php 
                            $desc = $projet['description'] ;
                            $shortDesc = mb_strimwidth($projet['description'], 0, 10, '...');
                        ?>
                        <td class="py-2 hover:text-blue-500 hover:underline cursor-pointer"><div onclick="return showSection('description','<?= $desc ?>')"><?= htmlspecialchars($shortDesc); ?></div></td>
                        <?php $cat = $projet['id_categorie'] ;?>
                        <td class="py-2"><?= htmlspecialchars($projet['nom_utilisateur']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($projet['date_creation']); ?></td>
                        <td class="py-2"><?= htmlspecialchars($projet['statut']); ?></td>

                        <td class="py-2 text-center">
                            <div class="flex justify-center">
                                <button onclick="Soumettre_Offre(<?php echo $projet['id_projet']; ?>)" type="submit" name="" value="modifier" class=" text-blue-500 hover:underline">Soumettre un Offre </button>
                            </div>

                        </td>
                    </tr>
                    

                
                <?php 
                    endif;
                    endforeach; 
                ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="py-4 text-center">Aucun Projet trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</section>











  </main>
  </div>
</section>










<section id="Soumettre_Offre"  class="fixed hidden flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95 text-white">
    <div class="card-container flex justify-end w-1/3 absolute top-8">
            <button name="hideElement" onclick="return hideSection('Soumettre_Offre')" class="text-white font-bold">✖</button>
        </div>
    <div class="flex flex-col justify-end w-1/3 top-8">
        <div class="flex flex-col items-center">
            <img src="img/ItThinkBrain.png" alt="" class="w-1/5">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"><span class="text-slate-400">Soumettre un Offre</h2>
        </div>
        <form action="Controller/offresController.php" method="POST">
            <input type="hidden" name="id_projet" id="id_projet" value="">
            <label class="block text-white font-medium mb-2" for="user">Montant</label>
            <input type="text" id="montant" name="montant" class="text-black w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
            
            <label class="block text-white font-medium mb-2" for="competences">delai (jours)</label>
            <input type="number" id="delai" name="delai" class="text-black w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">


            <div class="flex justify-center">
            <button name="Soumettre_Offre" type="submit" class="bg-fuchsia-400 font-bold px-4 py-2 rounded-md hover:bg-slate-400 mt-4">Ajouter</button>
            </div>
        </form>
    </div>
</section>


















<section id="sectionX" class="fixed hidden flex flex-col w-full h-full top-0 items-center justify-center bg-black bg-opacity-95">
        <div class="w-1/2 mx-auto bg-purple-400">
            <div class="card-container flex justify-end">
                <button name="hideElement" onclick="return hideSection('sectionX')">✖</button>
            </div>
        </div>
</section>








<script>
    function new_user_form(){
        document.getElementById('new_user').classList.remove('hidden');
    }
    function addprojetForm(){
        document.getElementById('addprojet').classList.remove('hidden');
    }
    function addFreeLance(){
        document.getElementById('addFreeLance').classList.remove('hidden');
    }
    function Soumettre_Offre(projetId){
        document.getElementById('Soumettre_Offre').classList.remove('hidden');
        document.getElementById('id_projet').value = projetId;
    }
    function addCategorieForm(){
        document.getElementById('addCategorie').classList.remove('hidden');
    }
    function addSousCategory(){
        document.getElementById('addSousCategory').classList.remove('hidden');
    }
    function hideSection(sec){
        const section = document.getElementById(sec);
        section.classList.add("hidden");
        if(sec == "new_user"){
            window.location.href = "admin.php";
        }
        if(sec == "addprojet"){
            gestion('projets');
        }
    }

    function showSection(element, info) {
    const section = document.getElementById("sectionX");
    let container = "";

    section.classList.remove("hidden");

    if (element === "description") {
        container = `<div class="w-1/2 mx-auto pb-4">${info}</div>`;
    }
    else if(element = "notification"){
        container = `<div class="w-1/2 mx-auto pb-4">${info}</div>`
    }
    section.innerHTML = `
        <div class="w-1/2 mx-auto bg-transparent ">
            <div class="text-white border-2 border-gray-700 p-4 rounded-lg w-full">
                <div class="card-container flex justify-end">
                    <button name="hideElement" onclick="return hideSection('sectionX')" class="text-white font-bold">✖</button>
                </div>
                ${container}
            </div>
        </div>
    `;
}



function validateLoginForm() {
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    let isValid = true;
    emailError.classList.add("hidden");
    passwordError.classList.add("hidden");

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!email.value.trim() || !emailPattern.test(email.value)) {
        emailError.classList.remove("hidden");
        isValid = false;
    }

    if (!password.value.trim()) {
        passwordError.classList.remove("hidden");
        isValid = false;
    }

    return isValid;
}

function validateInscriptionForm() {
    // Récupérer les champs du formulaire
    const fullName = document.getElementById("full_name");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirm_password");

    // Récupérer les messages d'erreur
    const nameError = document.getElementById("nameError");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");
    const confirmPasswordError = document.getElementById("confirmPasswordError");

    let isValid = true;

    // Réinitialiser les messages d'erreur
    nameError.classList.add("hidden");
    emailError.classList.add("hidden");
    passwordError.classList.add("hidden");
    confirmPasswordError.classList.add("hidden");

    // Validation du nom complet
    if (!fullName.value.trim()) {
        nameError.classList.remove("hidden");
        isValid = false;
    }

    // Validation de l'email
    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    if (!email.value.trim() || !emailPattern.test(email.value)) {
        emailError.classList.remove("hidden");
        isValid = false;
    }

    // Validation du mot de passe
    if (!password.value.trim() || password.value.length < 8) {
        passwordError.classList.remove("hidden");
        isValid = false;
    }

    // Validation de la confirmation du mot de passe
    if (password.value !== confirmPassword.value) {
        confirmPasswordError.classList.remove("hidden");
        isValid = false;
    }

    return isValid; // Empêche la soumission si le formulaire n'est pas valide
}



function gestion(ele){
    // const element = document.getElementById(ele);
    // const allElements = document.getElementsByClassName("cartSection");
    // for (let i = 0; i < allElements.length; i++) {
    //     allElements[i].classList.add("hidden");
    // }
    // element.classList.remove("hidden");

    window.location.href = `freelance.php?page=${ele}`;

}



</script>
</body>
</html>

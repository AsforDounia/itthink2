<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/script.js"></script>
    <title>Inscription</title>
</head>
<body class="bg-gray-100">
    <section  class="flex flex items-center justify-center h-screen">
        <div id="" class="h-[93%] max-w-md bg-white shadow-l-md rounded-l-lg relative">
            <img src="img/Background2.png" class="w-full h-full  z-0 object-cover" alt="background">
            <div class="w-full h-full flex flex-col items-end absolute top-0 z-10  justify-center gap-1 left-[0.1%]">
                <div class="text-white h-[10%] w-1/3 rounded-l-2xl flex flex-col items-center justify-center font-bold hover:bg-slate-400 cursor-pointer" onclick="window.location.href='index.php'" >Connexion</div>
                <div class="bg-fuchsia-400  h-[10%] w-1/3 rounded-l-2xl flex flex-col items-center justify-center font-bold hover:bg-slate-400 cursor-pointer" onclick="window.location.href='inscription.php'">Inscription</div>
            </div>
        </div>




        <div id="register-form" class="container h-[93%] max-w-lg p-6 pl-16 bg-white shadow-r-md rounded-r-lg flex flex-col  justify-center ">
        <div class="flex flex-col items-center">
                <img src="img/ItThinkBrain.png" alt="" class="w-1/5">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6"><span class="text-slate-400">welcome to </span><span class="text-[#FF5743]">It</span>Think</h2>
            </div>


            <?php if (isset($_GET['error'])): ?>
                <div id="error-message" class="text-red-500 mb-4">
                    <?php
                        if ($_GET['error'] === 'email_deja_enregistre') {
                            echo "Cet email est déjà enregistré.";
                        } elseif ($_GET['error'] === 'une_erreur_est_survenue') {
                            echo "Une erreur est survenue, veuillez réessayer.";
                        }
                    ?>
                </div>
            <?php endif; ?>

            <form id="registerForm" action="register.php" method="POST" onsubmit="return validateInscriptionForm()">
                <div class="mb-4">
                    <label for="user_name" class="block text-gray-700 font-medium mb-2">Nom complet :</label>
                    <input type="text" id="user_name" name="user_name" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="nameError" class="text-red-500 text-sm hidden">Veuillez entrer votre nom complet.</span>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email :</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="emailError" class="text-red-500 text-sm hidden">Veuillez entrer une adresse email valide.</span>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="passwordError" class="text-red-500 text-sm hidden">Veuillez entrer un mot de passe (minimum 8 caractères).</span>
                </div>
                <div class="mb-4">
                    <label for="confirm_password" class="block text-gray-700 font-medium mb-2">Confirmer le mot de passe :</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="confirmPasswordError" class="text-red-500 text-sm hidden">Les mots de passe ne correspondent pas.</span>
                </div>
                <div class="flex justify-center">
                    <button type="submit" name="register" class="bg-fuchsia-400 font-bold px-4 py-2 rounded-md hover:bg-slate-400 ">Inscription</button>
                </div>
            </form>
            <div class="text-center mt-4">
                <a href="index.php" class="text-slate-400 hover:text-fuchsia-400 hover:underline">Retour à la connexion</a>
            </div>
        </div>
    </section>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="js/script.js"></script>
</head>
<body class="bg-gray-100">
    <section class="flex flex-col items-center justify-center h-screen">
        <div id="login-form" class="container mx-auto mt-10 max-w-md p-6 bg-white shadow-md rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Connexion</h2>
            <?php if (isset($_GET['message'])):
                        if ($_GET['message'] === 'identifiants_incorrects') {
                            ?>
                            <div id="error-message" class="text-red-500 mb-4">
                            <?php
                            echo "Identifiants incorrects.";
                        }
                        else if ($_GET['message'] === 'inscription_reussie') {
                            ?>
                            <div id="error-message" class="text-green-500 mb-4">
                            <?php
                            echo "Inscription réussie. Vous pouvez vous connecter.";
                        }
                    ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" action="login.php" method="POST" onsubmit="return validateLoginForm()">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email :</label>
                    <input type="email" id="email" name="email" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="emailError" class="text-red-500 text-sm hidden">Veuillez entrer une adresse email valide.</span>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Mot de passe :</label>
                    <input type="password" id="password" name="password" class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-300">
                    <span id="passwordError" class="text-red-500 text-sm hidden">Veuillez entrer un mot de passe.</span>
                </div>
                <div class="flex justify-center">
                    <button type="submit" name="login" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Connexion</button>
                </div>
            </form>
            <div class="text-center mt-4">
                <a href="inscription.php" class="text-indigo-500 hover:underline">Créer un compte</a>
            </div>
        </div>
    </section>

</body>
</html>

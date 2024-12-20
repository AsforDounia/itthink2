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
    const element = document.getElementById(ele);
    const allElements = document.getElementsByClassName("cartSection");
    for (let i = 0; i < allElements.length; i++) {
        allElements[i].classList.add("hidden");
    }
    element.classList.remove("hidden");


}





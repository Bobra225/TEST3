<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = htmlspecialchars($_POST["nom"]);
    $email = htmlspecialchars($_POST["email"]);
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

    // Vous pouvez maintenant traiter les données, par exemple, les enregistrer dans un fichier ou une base de données
    // Dans un environnement de production, assurez-vous de mettre en œuvre des mesures de sécurité appropriées.

    // Enregistrement dans un fichier texte (ajustez le chemin selon votre besoin)
    $file = 'enregistrements.txt';

    $data = "Nom: $nom\nEmail: $email\nMot de passe: $mot_de_passe\n\n";

    // Écriture dans le fichier
    file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

    echo "Inscription réussie! Les informations ont été enregistrées.";
}
?>
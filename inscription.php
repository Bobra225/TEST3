<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = htmlspecialchars($_POST["nom"]);
    $email = htmlspecialchars($_POST["email"]);
    $mot_de_passe = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

    // Vous pouvez maintenant traiter les données, par exemple, les enregistrer dans une base de données
    // Dans un environnement de production, assurez-vous de mettre en œuvre des mesures de sécurité appropriées.

    // Exemple de connexion à une base de données MySQL (à adapter selon votre configuration)
    $servername = "localhost";
    $username = "votre_nom_utilisateur";
    $password = "votre_mot_de_passe";
    $dbname = "votre_base_de_donnees";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES ('$nom', '$email', '$mot_de_passe')";

    if ($conn->query($sql) === TRUE) {
        // Envoi d'un e-mail
        $destinataire = "czabo@outlook.fr";
        $sujet = "Nouvelle inscription";
        $message = "Nom: $nom\nEmail: $email\nMot de passe: *** (haché pour des raisons de sécurité)";

        // Utilisez la fonction mail() pour envoyer l'e-mail
        mail($destinataire, $sujet, $message);

        echo "Inscription réussie! Un e-mail a été envoyé à $destinataire avec les informations.";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<?php
require 'vendor/autoload.php';

use SendGrid\Mail\From;
use SendGrid\Mail\To;
use SendGrid\Mail\Mail;
use SendGrid\Mail\Subject;
use SendGrid\Mail\PlainTextContent;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Récupérer les données du formulaire
    $nom = isset($_GET["nom"]) ? htmlspecialchars($_GET["nom"]) : "";
    $email = isset($_GET["email"]) ? htmlspecialchars($_GET["email"]) : "";
    $mot_de_passe = isset($_GET["mot_de_passe"]) ? password_hash($_GET["mot_de_passe"], PASSWORD_DEFAULT) : "";

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
        // Envoi d'un e-mail avec SendGrid
        $sendgridApiKey = 'VOTRE_CLE_API_SENDGRID'; // Remplacez par votre clé API SendGrid

        $email = new Mail();
        $email->setFrom(new From("christianzabo225@gmail.com", "Votre Nom"));
        $email->addTo(new To("czabo@outlook.fr", "Destinataire"));
        $email->setSubject(new Subject("Nouvelle inscription"));
        $email->addContent(new PlainTextContent("Nom: $nom\nEmail: $email\nMot de passe: *** (haché pour des raisons de sécurité)"));

        $sendgrid = new \SendGrid($sendgridApiKey);

        try {
            $response = $sendgrid->send($email);
            echo "Inscription réussie! Les informations ont été envoyées par e-mail.";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'e-mail : {$e->getMessage()}";
        }
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
        // Envoi d'un e-mail avec PHPMailer
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'christianzabo225@gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'christianzabo225@gmail.com';
            $mail->Password = 'theBIGBOSS17';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('christianzabo225@gmail.com', 'Votre Nom');
            $mail->addAddress('czabo@outlook.fr'); // Adresse à laquelle vous souhaitez envoyer l'e-mail
            $mail->Subject = 'Nouvelle inscription';
            $mail->Body = "Nom: $nom\nEmail: $email\nMot de passe: *** (haché pour des raisons de sécurité)";

            $mail->send();

            echo "Inscription réussie! Un e-mail a été envoyé avec les informations.";
        } catch (Exception $e) {
            echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
        }
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
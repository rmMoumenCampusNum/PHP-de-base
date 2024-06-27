<?php $title="Miles Morales"; include ('header.php'); ?>

<main class="mainMiles">
    <h1>Miles Morales</h1>
    <form action="index.php?page=MilesMorales" method="POST">
            <label for="civilite">Civilité :</label>
        <select name="civilite" id="civilite">
            <option value="Monsieur">Monsieur</option>
            <option value="Madame">Madame</option>
            <option value="Mademoiselle">Mademoiselle</option>
        </select>
        <br><br>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom">
        <?php echo $errorNom ?>
        <br><br>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom">
        <?php echo $errorPrenom ?>
        <br><br>
        
        <label for="email">Email :</label>
        <input type="email" id="email" name="email">
        <?php echo $errorMail;
        ?>
        <br><br>
        <div class="raison">
            <label>Raison du message :</label><br>
            <input type="radio" id="raison1" name="raison" value="$_SESSION = $POST(nom)">
            <label for="raison1">Fan</label><br>
            
            <input type="radio" id="raison2" name="raison" value="Hyper Fan">
            <label for="raison2">Hyper Fan</label><br>
            
            <input type="radio" id="raison3" name="raison" value="Ultra Fan">
            <label for="raison3">Ultra Fan</label><br>
            
            <input type="radio" id="raison4" name="raison" value="Autre">
            <label for="raison4">Mécontent</label>
            <br><br>
            
            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="4" cols="50"></textarea>
            <br><br>
            
        </div>
        
        <button id="submit" type="submit">Envoyer</button>
        <?php echo $errors[1]; ?>
    </form>
</main>


<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = trim($_POST['nom']);
        $errors = array();

        // Récupération des données du formulaire
        $civilite = $_POST['civilite'] ?? '';
        // Récupère la valeur de 'civilite' dans le formulaire ou une chaîne vide si elle n'est pas définie
        $nom = $_POST['nom'] ?? '';
        // Récupère la valeur de 'nom' dans le formulaire ou une chaîne vide si elle n'est pas définie
        $prenom = $_POST['prenom'] ?? '';
        // Récupère la valeur de 'prenom' dans le formulaire ou une chaîne vide si elle n'est pas définie
        $email = $_POST['email'] ?? '';
        // Récupère la valeur de 'email' dans le formulaire ou une chaîne vide si elle n'est pas définie
        $raison_contact = $_POST['raison'] ?? '';
        // Récupère la valeur de 'raison' dans le formulaire ou une chaîne vide si elle n'est pas définie
        $message = $_POST['message'] ?? '';
        // Récupère la valeur de 'message' dans le formulaire ou une chaîne vide si elle n'est pas définie
        
        if (empty($nom)) {
            $errors['nom'] = "Le champ Nom est requis."; // Vérifie si le champ 'nom' est vide et ajoute une erreur si c'est le cas
            //$errorNom = "<p style='color: red;'> Ce champ doit être rempli</p>";
        } 
        
        if (empty($prenom)) {
            $errors['prenom'] = "Le champ Prénom est requis."; // Vérifie si le champ 'prenom' est vide et ajoute une erreur si c'est le cas
            // $errorPrenom = "<p style='color: red;'> Ce champ doit être rempli</p>";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'adresse email n'est pas valide."; // Vérifie si le champ 'email' est vide ou si l'email n'est pas valide et ajoute une erreur si c'est le cas
        }

        $raisons_contact_possibles = ['Fan', 'Hyper Fan', 'Ultra Fan','Mécontent'];
        // Définition des raisons de contact valides
        if (empty($raison_contact) || !in_array($raison_contact, $raisons_contact_possibles)) {
            $errors['raison'] = "Veuillez choisir une raison de contact valide.";
            // Vérifie si le champ 'raison' est vide ou si la raison n'est pas valide et ajoute une erreur si c'est le cas
        }

        if (empty($message) || strlen($message) < 5) {
            $errors['message'] = "Le champ Message doit contenir au moins 5 caractères.";
            // Vérifie si le champ 'message' est vide ou si le message a moins de 5 caractères et ajoute une erreur si c'est le cas
        }

        // Si aucune erreur, enregistrement des données dans un fichier


        if (empty($errors)) {
            $file = 'form_data.txt';
            // Nom du fichier où les données seront enregistrées
            $data = "Civilité : $civilite\n";
            // Prépare les données à enregistrer : civilité
            $data .= "Nom : $nom\n";
            // Ajoute le nom aux données
            $data .= "Prénom : $prenom\n";
            // Ajoute le prénom aux données
            $data .= "Email : $email\n";
            // Ajoute l'email aux données
            $data .= "Raison du contact : $raison_contact\n";
            // Ajoute la raison du contact aux données
            $data .= "Message :\n$message\n\n";
            // Ajoute le message aux données
    
            if (file_put_contents($file, $data, FILE_APPEND | LOCK_EX) === false) {
                $errors['file'] = "Erreur lors de l'enregistrement des données.";
                // Vérifie si l'enregistrement des données dans le fichier a échoué et ajoute une erreur si c'est le cas
            } else {
                $_SESSION['success'] = "Merci ! Vos données ont été enregistrées avec succès.";
                // Ajoute un message de succès dans la session
                // Réinitialiser les valeurs de session
                unset($_SESSION['form_data']);
                // Supprime les données du formulaire de la session
                header("Location: index.php?page=MilesMorales");
                // Redirige l'utilisateur vers la page de contact
                exit;
                // Termine le script pour éviter toute exécution supplémentaire
            }
        } else {
            // Sauvegarder les données du formulaire dans la session
            $_SESSION['form_data'] = $_POST;
            // Enregistre les données du formulaire dans la session
            $_SESSION['form_errors'] = $errors;
            // Enregistre les erreurs du formulaire dans la session
            header("Location: index.php?page=MilesMorales");
            // Redirige l'utilisateur vers la page de contact
            exit;
            // Termine le script pour éviter toute exécution supplémentaire
        }
    }    
?>


<?php include ('footer.php');?>


<?php $title = "Miles Morales";
include('header.php'); ?>

<?php
// Démarrage de la session PHP pour pouvoir utiliser $_SESSION
session_start();

// Récupération des erreurs stockées dans la session ($_SESSION['form_errors']) ou initialisation d'un tableau vide si non défini
$errors = $_SESSION['form_errors'] ?? [];

// Récupération des données du formulaire stockées dans la session ($_SESSION['form_data']) ou initialisation d'un tableau vide si non défini
$form_data = $_SESSION['form_data'] ?? [];

// Récupération du message de succès stocké dans la session ($_SESSION['success']) ou initialisation d'une chaîne vide si non défini
$success_message = $_SESSION['success'] ?? '';


// Effacer les anciennes erreurs et messages de succès
unset($_SESSION['form_errors']);
unset($_SESSION['form_data']);
unset($_SESSION['success']);

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $civilite = $_POST['civilite'] ?? '';
    $nom = ($_POST['nom'] ?? '');
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $raison_contact = $_POST['raison'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validation des données
    if (empty($nom)) {
        $errors['nom'] = "Le champ Nom est requis.";
    }

    if (empty($prenom)) {
        $errors['prenom'] = "Le champ Prénom est requis.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email n'est pas valide.";
    }

    $raisons_contact_possibles = ['Fan', 'Hyper Fan', 'Ultra Fan', 'Mécontent'];
    if (empty($raison_contact) || !in_array($raison_contact, $raisons_contact_possibles)) {
        $errors['raison'] = "Veuillez choisir une raison de contact valide.";
    }

    if (empty($message) || strlen($message) < 5) {
        $errors['message'] = "Le champ Message doit contenir au moins 5 caractères.";
    }

    // Si aucune erreur, enregistrement des données dans un fichier
    if (empty($errors)) {
        $file = 'form_data.txt';
        $data = "Civilité : $civilite\n";
        $data .= "Nom : $nom\n";
        $data .= "Prénom : $prenom\n";
        $data .= "Email : $email\n";
        $data .= "Raison du contact : $raison_contact\n";
        $data .= "Message :\n$message\n\n";

        if (file_put_contents($file, $data, FILE_APPEND | LOCK_EX) === false) {
            $errors['file'] = "Erreur lors de l'enregistrement des données.";
        } else {
            $_SESSION['success'] = "Merci ! Vos données ont été enregistrées avec succès.";
            header("Location: index.php?page=MilesMorales");
            exit;
        }
    } else {
        // Sauvegarder les données du formulaire et les erreurs dans la session
        $_SESSION['form_data'] = $_POST;
        $_SESSION['form_errors'] = $errors;
        header("Location: index.php?page=MilesMorales");
        exit;
    }
}
?>

<main class="mainMiles">
    <h1>Miles Morales</h1>
    <form action="index.php?page=MilesMorales" method="POST">
        <label for="civilite">Civilité :</label>
        <select name="civilite" id="civilite">
            <option value="Monsieur" <?php if (($form_data['civilite'] ?? '') == 'Monsieur') echo 'selected'; ?>>Monsieur</option>
            <option value="Madame" <?php if (($form_data['civilite'] ?? '') == 'Madame') echo 'selected'; ?>>Madame</option>
            <option value="Mademoiselle" <?php if (($form_data['civilite'] ?? '') == 'Mademoiselle') echo 'selected'; ?>>Mademoiselle</option>
        </select>
        <br><br>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($form_data['nom'] ?? '', ENT_QUOTES); ?>">
        <?php if (isset($errors['nom'])) echo '<p style="color:red;">' . $errors['nom'] . '</p>'; ?>
        <br><br>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($form_data['prenom'] ?? '', ENT_QUOTES); ?>">
        <?php if (isset($errors['prenom'])) echo '<p style="color:red;">' . $errors['prenom'] . '</p>'; ?>
        <br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($form_data['email'] ?? '', ENT_QUOTES); ?>">
        <?php if (isset($errors['email'])) echo '<p style="color:red;">' . $errors['email'] . '</p>'; ?>
        <br><br>
        <div class="raison">
            <label>Raison du message :</label><br>
            <input type="radio" id="raison1" name="raison" value="Fan" <?php if (($form_data['raison'] ?? '') == 'Fan') echo 'checked'; ?>>
            <label for="raison1">Fan</label><br>
            <input type="radio" id="raison2" name="raison" value="Hyper Fan" <?php if (($form_data['raison'] ?? '') == 'Hyper Fan') echo 'checked'; ?>>
            <label for="raison2">Hyper Fan</label><br>
            <input type="radio" id="raison3" name="raison" value="Ultra Fan" <?php if (($form_data['raison'] ?? '') == 'Ultra Fan') echo 'checked'; ?>>
            <label for="raison3">Ultra Fan</label><br>
            <input type="radio" id="raison4" name="raison" value="Mécontent" <?php if (($form_data['raison'] ?? '') == 'Mécontent') echo 'checked'; ?>>
            <label for="raison4">Mécontent</label><br>
            <?php if (isset($errors['raison'])) echo '<p style="color:red;">' . $errors['raison'] . '</p>'; ?>
            <br><br>
            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="4" cols="50"><?php echo htmlspecialchars($form_data['message'] ?? '', ENT_QUOTES); ?></textarea>
            <?php if (isset($errors['message'])) echo '<p style="color:red;">' . $errors['message'] . '</p>'; ?>
            <br><br>
        </div>
        <button id="submit" type="submit">Envoyer</button>
        <?php if (!empty($success_message)) echo '<p style="color:green;">' . $success_message . '</p>'; ?>
    </form>


</main>



<?php include('footer.php'); ?>
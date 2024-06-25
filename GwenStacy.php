<?php $title="Gwen Stacy"; include ('header.php'); ?>

<main>
    <h1>Gwen Stacy</h1>
    <form action="index.php?page=GwenStacy" method="POST">
                <label for="civilite">Civilité :</label>
                <select name="civilite" id="civilite">
                    <option value="Monsieur">Monsieur</option>
                    <option value="Madame">Madame</option>
                    <option value="Mademoiselle">Mademoiselle</option>
                </select>
                <br><br>
                
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom">
                <br><br>
                
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom">
                <br><br>
                
                <label for="email">Email :</label>
                <input type="email" id="email" name="email">
                <br><br>
                <div class="raison">
                    <label>Raison du message :</label><br>
                    <input type="radio" id="raison1" name="raison" value="Service comptable">
                    <label for="raison1">Fan</label><br>
                    
                    <input type="radio" id="raison2" name="raison" value="Support technique">
                    <label for="raison2">Hyper Fan</label><br>
                    
                    <input type="radio" id="raison3" name="raison" value="Service commercial">
                    <label for="raison3">Ultra Fan</label><br>
                    
                    <input type="radio" id="raison4" name="raison" value="Autre">
                    <label for="raison4">Mécontent</label>
                    <br><br>
                    
                    <label for="message">Message :</label>
                    <textarea id="message" name="message" rows="4" cols="50"></textarea>
                    <br><br>
                    </div>
                
                <button type="submit">Envoyer</button>
            </form>
</main>

<?php include ('footer.php');?>
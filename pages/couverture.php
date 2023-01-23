<?php 

    include_once('../include.php');

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    if ($_SESSION['couverture'][1] = 'oui' || $_SESSION['couverture'][2] = 'oui') {
        $oui = "selected";
        $non = "";
    }
    else if  ($_SESSION['couverture'][1] = 'non' || $_SESSION['couverture'][2] = 'non'){
        $oui = "";
        $non = "selected";
    }
    else {
        $oui = "";
        $non = "";
    }

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {
            $_SESSION['couverture'] = array(
                $orga_secu, //0
                $assure, //1
                $ALD, //2
                $nom_mutuelle, //3
                $num_adherent, //4
                $chambre); //5

            header('Location: docs');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php require_once('../include/link.php') ?>

    <link rel="stylesheet" href="../css/panel.css">
    <link rel="stylesheet" href="../css/sidebar.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />

    <title>Bon retour <?= $_SESSION['personnel'][1]?> 🖐</title>
</head>
<body> 

    <?php

        include_once ('src/sidebar.php');

    ?>

    <section class="global">

        <div class="level">
            <div class="lvl1">
                <div class="bulle bulle-passe"><p>1</p></div>
                <div class="bulle-texte texte-passe"><p>PATIENT</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl2">
                <div class="bulle bulle-passe"><p>2</p></div>
                <div class="bulle-texte texte-passe"><p>HOSPITALISATION</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl3">
                <div class="bulle active-bulle"><p>3</p></div>
                <div class="bulle-texte active-texte"><p>COUVERTURE SOCIALE</p></div>
            </div>

            <div class="ligne"></div>

            <div class="lvl4">
                <div class="bulle 4"><p>4</p></div>
                <div class="bulle-texte"><p>DOCUMENTS</p></div>
            </div>
        </div>

        <form action="" method="post">
            <label for="orga-secu">Organisme de sécurité sociale :</label>
            <input class="grand" value="<?= $_SESSION['couverture'][0]?>" type="text" name="orga_secu" id="orga-secu" required="required"><br>

            <label for="assuré">Le patient est-il assuré ?</label>
            <select class="petit" name="assure" id="assure" required="required">
                <option value="Vide" hidden>Choisir une réponse</option>
                <option value="oui" <?= $oui?> >Oui</option>
                <option value="non" <?= $non?> >Non</option>
            </select><br>

            <label for="ALD">Le patient est-il en ALD ?</label>
            <select class="petit" name="ALD" id="ALD" required="required">
                <option value="Vide" hidden>Choisir une réponse</option>
                <option value="oui" <?= $oui?> >Oui</option>
                <option value="non" <?= $non?> >Non</option>
            </select><br>

            <label for="nom-mutuelle">Nom de la mutuelle ou l'assurance:</label>
            <input class="grand" value="<?= $_SESSION['couverture'][3]?>" type="text" name="nom_mutuelle" id="nom_mutuelle" required="required"><br>
                            
            <label for="num-adherent">Numéro d'adhérent :</label>
            <input class="moyen" value="<?= $_SESSION['couverture'][4]?>" type="text" name="num_adherent" id="num_adherent" required="required"><br>

            <label for="chambre">Chambre :</label>
            <select class="petit" name="chambre" id="chambre" required="required">
                <optgroup label="Avec équipements">
                    <option value=1>Individuelle</option>
                    <option value=2>Partagée</option>
                </optgroup>
                <optgroup label="Sans équipements">
                    <option value=3>Individuelle</option>
                    <option value=4>Partagée</option>
                </optgroup>
            </select>

            <input class="btn-envoi" type="submit" value="Suivant" name="submit">
        </form>
    </section>
    
</body>
</html>
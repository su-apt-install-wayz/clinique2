<?php 

    include_once('../include.php');

    $_SESSION['patient'] = array();
    $_SESSION['prevenir'] = array();
    $_SESSION['confiance'] = array();
    $_SESSION['couverture'] = array();

    if(!isset($_SESSION['personnel'][0])) {
        header('Location: ../index');
        exit;
    }

    require_once('./src/info_user.php');

    if(!empty($_POST)) {
        extract($_POST);
        if(isset($_POST['submit'])) {
            $patient = $DB->prepare("SELECT * FROM patient WHERE Num_secu = ?");
            $patient->execute(array($num_secu));
            $patient = $patient->fetch();

            if(isset($patient['Num_secu'])) {
                $_SESSION['patient'] = array(
                    $patient['Num_secu'], //0
                    $patient['Civilité'], //1
                    $patient['Nom_Naissance'], //2
                    $patient['Nom_Epouse'], //3
                    $patient['Prenom'], //4
                    $patient['Date_naissance'], //5
                    $patient['Adresse'], //6
                    $patient['Code_postal'], //7
                    $patient['Téléphone'], //8
                    $patient['Ville'], //9
                    $patient['Email'], //10
                    $patient['Mineur'], //11
                    $patient['code_prevenir'], //12
                    $patient['code_confiance'],
                    $patient_existant = true); //13

                $code_prevenir = $DB->prepare("SELECT * FROM contact WHERE code_contact = ?");
                $code_prevenir->execute(array($patient['code_prevenir']));
                $code_prevenir = $code_prevenir->fetch();

                if(isset($prevenir['code_contact'])) {
                    $_SESSION['prevenir'] = array(
                        $prevenir['code_contact'], //0
                        $prevenir['Nom'], //1
                        $prevenir['Prenom'], //2
                        $prevenir['Téléphone'], //3
                        $prevenir['Adresse']); //4
                }
                else {
                    $_SESSION['prevenir'] = array("", "", "", "", "");
                }

                $code_confiance = $DB->prepare("SELECT * FROM contact WHERE code_contact = ?");
                $code_confiance->execute(array($patient['code_confiance']));
                $code_confiance = $code_confiance->fetch();

                if(isset($confiance['code_contact'])) {
                    $_SESSION['confiance'] = array(
                        $confiance['code_contact'], //0
                        $confiance['Nom'], //1
                        $confiance['Prenom'], //2
                        $confiance['Téléphone'], //3
                        $confiance['Adresse']); //4
                }
                else {
                    $_SESSION['confiance'] = array("", "", "", "", "");
                }

                header('Location: patient');
                exit;                
            }
            else {
                $_SESSION['patient'] = array($num_secu, "", "", "", "", "", "", "", "", "", "", "", "", "", $patient_existant = false);
                header('Location: patient');
                exit; 
            }
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
        <form style="margin:auto; width: 100%; max-width: 500px;" action="" method="post">
            <label style="margin:auto;" for="num_secu">Numéro de sécurité sociale :</label><br>
            <input style="margin:auto;" class="moyen" type="text" name="num_secu" id="num_secu" maxlength="15" required="required"><br>

            <input style="margin:auto;" class="btn-envoi moyen" type="submit" value="Rechercher" name="submit">
        </form>
    </section>
    
</body>
</html>
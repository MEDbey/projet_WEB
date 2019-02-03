<?php

    require('../model/connectDb.php');


    $idModule = $_POST['id_mod'];
    $nomMatiere = $_POST['nom_matiere'];
    $color = $_POST['color_mat'];
    $label = $_POST['lab_matiere'];
    

    $db = connectDb::dbConnect();
    
    $sql = 'INSERT INTO matiere(id_ue, id_mod, id_period, nom, label, couleur) VALUES(2, ' . $idModule . ', 2, "' . $nomMatiere . '", "' . $label . '", "' . $color . '")';
    $stmt= $db->prepare($sql);
    $stmt->execute();
    echo $sql;
    header('location:..');
?>
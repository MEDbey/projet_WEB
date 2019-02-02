<?php

    require('../model/connectDb.php');

    $nomModule = $_POST['nom_module'];

    $label;
    
    $db = connectDb::dbConnect();
    

    $select= $db->prepare('SELECT label+1 as nb FROM `uemodule` order by label desc limit 1');
    $select->execute();
    while ($slct = $select->fetch()){
        $label = $slct['nb'];
    }


    $sql = 'INSERT INTO uemodule(id_form, classif, nom, label) VALUES(1, "module", "' . $nomModule . '", "' . $label . '")';
    $stmt= $db->prepare($sql);
    $stmt->execute();

    header('location:..');
?>
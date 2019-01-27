<?php

    try{
        $pdo = new PDO("mysql:server=localhost; dbname=edt", "root", "");
    }
    catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }

    $nomModule = $_POST['nom_module'];

    $label;
 
    $select= $pdo->prepare('SELECT label+1 as nb FROM `uemodule` order by label desc limit 1');
    $select->execute();
    while ($slct = $select->fetch()){
        $label = $slct['nb'];
    }


    $sql = 'INSERT INTO uemodule(id_form, classif, nom, label) VALUES(1, "module", "' . $nomModule . '", "' . $label . '")';
    $stmt= $pdo->prepare($sql);
    $stmt->execute();

    header('location:..');
?>
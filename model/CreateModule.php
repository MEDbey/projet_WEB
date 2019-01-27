<?php

    require '../model/connectDb.php';
    class Matiere extends connectDb{
        public static function createModule($nomModule)
        {
          $db = connectDb::dbConnect();
          $modules = $db->prepare('INSERT INTO uemodule(id_form, classif, nom, label) VALUES(1, "module", "' . $nomModule . '", (SELECT label+1 FROM `uemodule` order by label desc limit 1)');
          $modules->execute();
        }
    }
    

?>
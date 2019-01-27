<?php
require("../model/CreateModule.php");
$nom_module =  $_POST['nom_module'];
echo $nom_module;
class CreateModulteController{
    public function index(){
        CreateModule::createModule($nom_module);
        echo $nom_module;
    }
}
// header ('Location:..');
?>
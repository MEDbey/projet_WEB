<?php
require("./model/Prof.php");

class ProfController{

  //Retourne tous les profs
  public function showProf(){
    $profs = Prof::getAllProfs();
    $array_json = array();

    while ($prof = $profs->fetch()){
      $obj_json = array('id' => utf8_encode($prof['id_prof']),
      'nom' => utf8_encode($prof['nom']),
      'prenom' => utf8_encode($prof['prenom']));
      array_push($array_json,$obj_json);
    }
    echo json_encode($array_json);
  }
}
?>
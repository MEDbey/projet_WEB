<?php
    $start_view = 'edt_edit';
    $view = (isset($_GET['view'])) ? $_GET['view'] : "";
    if(!empty($view)){
      $controller = explode("_", $view)[0];
      $action = explode("_", $view)[1];
        header('localhost/projet_web_1/controller/'.$controller.'.php?action='.$action);
    } else {
     // $controller = explode("_", $start_view)[0];
     // $action = explode("_", $start_view)[1];
     // require("./vue/edit.php");

        header('Location: controller/edt.php?action=EDT_vue');
    }

?>
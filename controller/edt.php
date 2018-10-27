<?php

    namespace controller;


    include_once("../modele/edt.php");
    include_once('../dao/factory.php');


    use modele\edt;
    use dao\factory;

    if(isset($_GET['action'])){
        $action = $_GET['action'];
        require('../vue/'.$action.'.php');
       // edt::$action($_GET);
    }
    
    if(isset($_POST['action'])){
        $action = $_POST['action'];
        require('../vue/'.$action.'.php');
        //edt::$action($_POST);
    }

    class EdtController{
        public static function search($req){
            $et = new edt();
            $facto = new factory();
            $list = serialize($facto->search($et, ""));
            View::show('edt_search', array('data' => urlencode($list)));
        }
        
        public static function create($req){
            $id_edth = $req['id_edth'];
            $tDeb = $req['tDeb'];
        
            $et = new edt();
            $facto = new factory();
        
            $id_edth->set_id_edth($id_edth);
            $tDeb->set_tDeb($tDeb);
        
            $facto->create($id_edth);
        
            header('localhost/projet_web_1/index.php?action=search');
        }
        
        public static function read($req){
            $id_edth = new edt();
            $id_edth->set_id($req['id_edth']);
            $facto = new factory();
            $found = $facto->read($id_edth);
            View::show('edt_read', array('id' => $found->get_id(), 'tDeb' => $found->get_nb_vendu()));
        }
        
        public static function update($req){
        
        }
        
        public static function delete($req){
        
        }
    }
?>
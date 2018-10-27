<?php

    namespace modele;



    class edt{
        private $id_edth;
        private $tDeb;
      
        // getters
      
        public function get_id_edth(){ return $this->id_edth; }
        public function get_tDeb(){ return $this->tDeb; }
      
        // setters
      
        public function set_id_edth($value){ $this->id_edth = $value; }
        public function set_tDeb($value){ $this->tDeb = $value; }
      
      
        public function properties(){ return get_object_vars($this); }
        public function properties_names(){ return array_keys(get_object_vars($this)); }
        public function to_string() { return "id_edth : $this->id_edth, tDeb : $this->tDeb"; }
    }

?>
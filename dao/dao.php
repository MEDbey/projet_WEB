<?php
    define('MYSQL','mysql');
    $GLOBALS['database_type']=MYSQL;

    class Database
    {
        private $_connection;

    public function load(){
        switch ($GLOBALS['database_type']) {
            case MYSQL:
                $this->_load_mysql();
            break;
            default:
            break;
        }
    }

        private function _load_mysql()
        {
            $user = "root";
            $password = "";

            try {
                $dbh = new PDO('mysql:host=localhost;dbname=projet_web_1', $user, $password);
                foreach($dbh->query('SELECT * from FOO') as $row) {
                    print_r($row);
                }
                $dbh = null;
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br/>";
                die();
            } 
        }

        public function get_connection()
        {
        return $this->_connection;
        } 
        public function close() 
        {
            switch ($GLOBALS['database_type']) {
            case MYSQL:
                mysqli_close($this->_connection);
            break;
            default:
            break;
            }
        }
    }

?>
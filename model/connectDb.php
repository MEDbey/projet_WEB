<?php
class connectDb{
    public static function dbConnect()
    {
        try
        {
            $db = new PDO("mysql:server=localhost; dbname=edt", "root", "");
            return $db;
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
    }
}

?>

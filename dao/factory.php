<?php

    namespace dao;
    define('ACTION_SEARCH', 'search');
    define('ACTION_CREATE', 'create');
    define('ACTION_READ', 'read');
    define('ACTION_UPDATE', 'update');
    define('ACTION_DELETE', 'delete');
    class factory{
        private $_database;
        private $_data;
    
    public function __construct(){
        $this->_database = new database();
        $this->_database->load();
    }

    private function _generate_query($action, $criteria)
    {
        $entity = strtolower(end(explode('\\',get_class($this->_object))));        
        $attributes = "";         
        $properties = $this->_object->properties();        
        $properties_names = $this->_object->properties_names();        
        $nb_attribute = count($properties_names);        
        foreach ($properties_names as $key => $value) 
        {
            if($key != 'id')
            $attributes .= ($key < $nb_attribute - 1) ? $value . ", " : $value;
        }
        
        $values = "";
        $settings = "";
        $where = "";
        $object_id = "";
        
        foreach ($properties as $key => $value) 
        {
            if($key == 'id') $object_id = $value;       
            if($key != 'id')
            {
            $values .= ($key != end($properties_names)) 
            ? "'".$value."', " : "'".$value."'";      

            $settings .= ($key != end($properties_names)) 
            ? $key."='".$value."', " : $key."='".$value."'";  

            $where .= ($key != end($properties_names)) 
            ? $key." LIKE '%".$criteria."%' OR " : $key." LIKE '%".$criteria."%' ";
            }
        }
        
        switch ($action) 
        {
            case ACTION_CREATE:
            return  "INSERT INTO $entity ($attributes) VALUES ($values) ";
            break;
            case ACTION_READ:
            return  "SELECT * FROM $entity WHERE id = '$object_id' ";
            break;             
            case ACTION_UPDATE:
            return  "UPDATE $entity SET $settings WHERE id = '$object_id' ";
            break;         
            case ACTION_DELETE:
            return  "DELETE FROM $entity WHERE id = $object_id ";
            break;        
            case ACTION_SEARCH:
            return  "SELECT * FROM $entity WHERE $where ";
            break;        
            default:
            return "";
            break;
        }
    }

    private function _execute_query($query, $action)
    {
        $con = $this->_database->get_connection();
        $result = null;
        
        if ($succes = mysqli_query($con, $query)) 
        {
            if($action == ACTION_CREATE) 
            $result = mysqli_insert_id($con);
        
            if($action == ACTION_READ) 
            $result = $this->_get_result($succes, ACTION_READ);
            
            if($action == ACTION_SEARCH) 
            $result = $this->_get_result($succes, ACTION_SEARCH);
        } 
        else 
        {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        } 
        
        $this->_database->close();
        return $result;
    }
    private function _get_result($result, $action)
    { 
        $properties_names = $this->_object->properties_names();
        
        $nb_attribute = count($properties_names); 
        
        $list = array();
        while($row = $result->fetch_assoc()) 
        { 
            $object = null;
            $values = array(); 
            $index = 0;
            foreach ($row as $key => $value) 
            {
                array_push($values, $value);
            
                if($index ++ == $nb_attribute-1) 
                {
                    $index = 0;
                    $object = $this->_set_object($values);
                }
            }
                array_push($list, $object);
        
        }
        mysqli_free_result($result);
        
        if($action == ACTION_READ)
            return $object;
        else 
            return $list;
    }
}
?>
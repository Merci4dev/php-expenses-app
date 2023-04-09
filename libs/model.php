<?php

    #  Database Implementation . Here we cann use other databases like MongoDB
    # The Mode class will use as default basic functionality but the implementation will use the imodel interface
    # ====================================================
    include_once 'libs/imodel.php';
    
    class Model{
        
        function __construct(){
            $this->db = new Database();
        }
        
        # This function actracts the database connection syntax 
        # ====================================================
        function query($query){
            return $this->db->connect()->query($query);
        }
        
        # This function actracts the database prepare syntax 
        # ====================================================
        function prepare($query){
            return $this->db->connect()->prepare($query);
        }
    }

?>
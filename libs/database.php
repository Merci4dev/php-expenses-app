<?php

class Database{

        private $host;
        private $db;
        private $user;
        private $password;
        private $charset;
        
        public function __construct(){
            $this->host = constant('HOST');
            $this->db = constant('DB');
            $this->user = constant('USER');
            $this->password = constant('PASSWORD');
            $this->charset = constant('CHARSET');
        }
        
        function connect(){
            try{
                $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                
                $pdo = new PDO($connection, $this->user, $this->password, $options);
                return $pdo;
            }catch(PDOException $e){
                print_r('Error connection: ' . $e->getMessage());
            }
        }
        
    }
    
    
    /*===============================================================
    This Connection creates a new database and a connection as soon we run the application
    =============================================================== */
    
    // require_once 'config/config.php';
    // class Database{
    //     private $host;
    //     private $db;
    //     private $user;
    //     private $password;
    //     private $charset;

    //     public function __construct(){
    //         $this->host = constant('HOST');
    //         $this->db = constant('DB');
    //         $this->user = constant('USER');
    //         $this->password = constant('PASSWORD');
    //         $this->charset = constant('CHARSET');
    //     }

    //     # Create a new database
    //     function create_db(){
    //         try{
    //             $connection = "mysql:host=" . $this->host . ";charset=" . $this->charset;
    //             $options = [
    //                 PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //                 PDO::ATTR_EMULATE_PREPARES   => false,
    //             ];
                
    //             $pdo = new PDO($connection, $this->user, $this->password, $options);
    //             # Crear la base de datos si no existe
    //             $pdo->exec("CREATE DATABASE IF NOT EXISTS " . $this->db); 

    //             # Seleccionar la base de datos
    //             $pdo->exec("USE " . $this->db); 
    //             return $pdo;

    //         }catch(PDOException $e){
    //             print_r('Error:  Could not create the DB ' . $e->getMessage());
    //         }
    //     }

    //     # Connection to the database
    //     public function connect() {
    //         try {
    //             $connection = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
    //             $pdo = new PDO($connection, $this->user, $this->password);
    //             $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //             return $pdo;

    //         } catch(PDOException $e) {
    //             throw new Exception('Failed to connect to database: ' . $e->getMessage());
    //         }
    //     }
    // }

    // # Create an instance of the Database class and connect to the database
    // try {
    // $database = new Database();
    // $pdo = $database->create_db();
    // $pdo = $database->connect();

    // # Execute the SQL query stored in the query.sql file
    // $query = file_get_contents('db/expenses.sql');
    // $stmt = $pdo->prepare($query);
    // $stmt->execute();

    // # Close the database connection
    // $pdo = null; 

    // } catch (Exception $e) {
    //     echo 'Error: ' . $e->getMessage();
    // }




    
    

?>
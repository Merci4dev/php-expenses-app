<?php
    
    # Process to log the user into the database. This class will inherit from Model class which use the imodel interface
    # ====================================================
    class LoginModel extends Model{
        
        public function __construct(){
            parent::__construct();
        }
        
        # Insert the data into the BD
        # ====================================================
        public function login($username, $password){
            error_log(" 0 '/'Model loginmodle::login -> Login the user into the database '/'");

            try{
                //$query = $this->db->connect()->prepare('SELECT * FROM users WHERE username = :username');
                $query = $this->prepare('SELECT * FROM users WHERE username = :username');
                $query->execute(['username' => $username]);
                
                # verify if the user exists into the database. it can't be more than once
                if($query->rowCount() == 1){
                    $item = $query->fetch(PDO::FETCH_ASSOC); 

                    $user = new UserModel();
                    $user->from($item);

                    error_log(" 0 '/'Model loginmodle::login ->  user id '/'");

                    # Validate that the passwor is the same as the passwd stored into the database
                    if(password_verify($password, $user->getPassword())){

                        error_log('login: success');
                        return $user;
                    }else{
                        error_log(" 0 '/'Model loginmodle::login -> PASSWORD DO NOT MUCHT '/'");
                        return NULL;
                    }
                }
            }catch(PDOException $e){
                error_log(" 0 '/'Model loginmodle::login -> Exeption  '/'".$e->getMessage());
                return NULL;
            }
        }
    }

?>
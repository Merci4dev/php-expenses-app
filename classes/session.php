<?php

class Session{

    private $sessionName = 'user';

    # Validate if no exist a session wer start a session
    # ====================================================
    public function __construct(){

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    # Method to set the current session user. Asign the session to the current user
    # ====================================================
    public function setCurrentUser($user){
        $_SESSION[$this->sessionName] = $user;
    }

    # Method to get the current session
    # ====================================================
    public function getCurrentUser(){
        return $_SESSION[$this->sessionName];
    }

    # Method to destroid the current session
    # ====================================================
    public function closeSession(){
        session_unset();
        session_destroy();
    }

    # Method which return if exist or not a session
    # ====================================================
    public function exists(){
        return isset($_SESSION[$this->sessionName]);
    }
}

?>
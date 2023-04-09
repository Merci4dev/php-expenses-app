<?php

    # Controller to handle the error page. When the user want to access to a page which does not exist display the 404 error page. 
    # ====================================================
    class Errors extends Controller{

        function __construct(){
            parent::__construct();
            $this->view->render('errors/index');

            error_log(" 1 '/' Errors::construct ->: Start Errors '/'");
        }
    }

?>
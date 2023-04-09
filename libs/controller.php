<?php

    # Base controller which all other controllers will inherit. This will load the controller and the view which we will need to load
    # This controller functionality will be extended through other controllers which will inherit from this base controller
    # ====================================================
    class Controller{

        function __construct(){
            # Load the view which we want to present
            $this->view = new View();
        }

        # Load the model files for the asociete controller 
        # ====================================================
        function loadModel($model){
            error_log(" ? '/'App Controller::loadModel -> Model' $model ' Loaded' '/'");

            $url = 'models/'.$model.'model.php';
            if(file_exists($url)){
                require_once $url;

                $modelName = $model.'Model';
                $this->model = new $modelName();
            }
        }

        # This function validate the variable or params existence and automatizare the isset fuction when we need to inject date into the database.
        # ====================================================
        function existPOST($params){
            foreach ($params as $param) {
                if(!isset($_POST[$param])){

                    error_log(" ? '/'App Controller::ExistPOST ->  Do not exist Param $param '/'");
                    return false;
                }
            }

          
            error_log(" ? '/'App Controller::ExistPOST ->  Present Params $param '/'");
            return true;
        }

        # This function validate the variable existence. Avoid the isset fuction
        # ====================================================
        function existGET($params){
            foreach ($params as $param) {
                if(!isset($_GET[$param])){
                    error_log(" ? '/'App Controller::existGET ->  Do not exist Param $param '/'");
                    return false;
                }
            }
            error_log(" ? '/'App Controller::existGET ->  Present Params $param '/'");
            return true;
        }

        # Funtion to call the the GET sintax values (attraction)
        # ====================================================
        function getGet($name){
            return $_GET[$name];
        }

        function getPost($name){
            return $_POST[$name];
        }

        # Funtion to redirect the user to the desired page after a successful process. This function build the url structure
        # ====================================================
        function redirect($route, $mensajes = []){
            error_log(" ? '/'App Controller::redirect ->   Redirecting the user to '/'");
            
            $data = [];
            $params = '';
            
            foreach ($mensajes as $key => $value) {
                array_push($data, $key . '=' . $value);
            }
            $params = join('&', $data);
            
            if($params != ''){
                $params = '?' . $params;
            }
            header('location: ' . constant('URL') . '/' . $route . $params);
        }
    }

?>
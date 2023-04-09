<?php

    require_once 'controllers/errors.php';

    # En resumen, la clase App maneja las rutas del sitio web y carga los controladores y métodos correspondientes según lo especificado en la URL. Si hay algún error en la URL o en el proceso de carga del controlador o método, se carga la clase de errores para manejar la situación.

    # Base routes logic to send all requests to the specified controller. if we no specified controller, we will call the  default controller which will be used signin 
    # Modified the form to make requests to the routes into the app 
    # ====================================================
    class App{

        # validate tha the url exists. if the url exists we add to the variables the value the vaue from this fiels otherwise we return null. We divide the url in / and asings every part of the url their values and parameters
        # ====================================================
        function __construct(){

            # This delete the first part from the url jus cut the parameters after the / . 
            # We will take as base ulr the user or the controller method and the controller method  (user/updatePhoto). 
            # The 'url' parameter is indicated by the htaccess file 
            $url = isset($_GET['url']) ? $_GET['url']: null;
            $url = rtrim($url, '/');
            $url = explode('/', $url);

            // cuando se ingresa sin definir controlador
            #  Validate  if into the url array do not exists a defined controller) index redirect the user to the login page which will be the default controller
            # ====================================================
            if(empty($url[0])){
                error_log(" 2 '/' APP::construct -> Not Specified Controller '/' ");
                
                # Set the controller name in a variable. Call the controller. Create a new controller instance. Load it model. And render the view
                $archivoController = 'controllers/login.php';
                require_once $archivoController;
                $controller = new Login();
                $controller->loadModel('login');
                $controller->render();
                
                return false;
            }

            # If the variable url bring the especified controller
            $archivoController = 'controllers/' . $url[0] . '.php';

            # validate if the controller exists. if exists we mamke a new instance of the controller
            # ====================================================
            if(file_exists($archivoController)){
                require_once $archivoController;

                // inicializar controlador
                $controller = new $url[0];
                $controller->loadModel($url[0]);
                
                # Validate if there are required method to load. if there is no method to load we load a default method
                if(isset($url[1])){

                    # If the method exists we validate that the method exists into de class
                    if(method_exists($controller, $url[1])){

                        # validate if exist more parameters and how many are. if there are more we inject it into the method
                        if(isset($url[2])){
                            
                            # Store the array url parameters
                            $nparam = sizeof($url) - 2;
                            # Crear un arreglo con los parametros
                            $params = [];
                            # Loop through array parameters
                            for($i = 0; $i < $nparam; $i++){
                                array_push($params, $url[$i + 2]);
                            }

                            # Passing params to the method
                            $controller->{$url[1]}($params);

                        }else{
                            # if there is not parameters we call the the method self
                            $controller->{$url[1]}();    
                        }
                    }else{
                        # throw an error if the method does not exist
                        $controller = new Errors(); 
                    }
                }else{
                    #  If there is not method to load we load a default method
                    $controller->render();
                }
            }else{
                $controller = new Errors();
            }
        }
    }

?>
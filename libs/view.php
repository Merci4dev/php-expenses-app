<?php

    # This class set the views bases logic
    # ====================================================
    class View{

        function __construct(){
            # Implementate the db connection
        }

        # The render function take tow parameters name and data. Name make reference to the view location file
        # Data id an array which includes all the data we want to render in the view
        # In this function we pass the data thoroug the d variable to he view object
        # ====================================================
        function render($nombre, $data = []){
            error_log(" ? '/'View::render -> Render function Loaded  '/'");

            $this->d = $data;
            $this->handleMessages();

            require 'views/' . $nombre . '.php';
        }
        
        # The handles functionn are used to handle the messages from the view. Show the error or the success message  when we make a new a new transaction
        # ====================================================
        private function handleMessages(){
            error_log(" ? '/'View::handleMessages -> Function HandleMessages Loaded '/'");
            
            if(isset($_GET['success']) && isset($_GET['error'])){
                # nothing is displayed because there can't be an error and success at the same time
                
            }else if(isset($_GET['success'])){
                $this->handleSuccess();
            
            }else if(isset($_GET['error'])){
                $this->handleError();
            }
        }

        # Handle the error messages
        # ====================================================
        private function handleError(){
            if(isset($_GET['error'])){
                $hash = $_GET['error'];
                $errors = new ErrorsMsg();

                if($errors->existsKey($hash)){
                    error_log(" ? '/'View::handleError -> existsKey'/'" . $errors->get($hash));

                    $this->d['error'] = $errors->get($hash);
                }else{

                    $this->d['error'] = NULL;
                }
            }
        }

        # Handle the success message
        # ====================================================
        private function handleSuccess(){
            if(isset($_GET['success'])){
                $hash = $_GET['success'];
                $success = new Success();

                if($success->existsKey($hash)){
                    error_log(" ? '/'View::handleSuccess -> existsKey'/'" . $success->get($hash));

                    $this->d['success'] = $success->get($hash);
                
                }else{
                    $this->d['success'] = NULL;
                }
            }
        }

        # Function to show the  message in the view
        # ====================================================
        public function showMessages(){
            $this->showError();
            $this->showSuccess();
        }

        # Function which set a html div into the documeent to show the error message in the view
        # ====================================================
        public function showError(){
            if(array_key_exists('error', $this->d)){
                echo '<div class="error">'.$this->d['error'].'</div>';
            }
        }

        #  Function which set a html div into the documeent to show the success message in the view
        # ====================================================
        public function showSuccess(){
            if(array_key_exists('success', $this->d)){
                echo '<div class="success">'.$this->d['success'].'</div>';
            }
        }
    }

?>
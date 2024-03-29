
<?php

    #  Set the user controller to actulized the budget, password etc... 
    # ====================================================
    class User extends SessionController{

        private $user;

        function __construct(){
            parent::__construct();

            # Get the user information to send it through the view controller
            $this->user = $this->getUserSessionData();
            error_log("user " . $this->user->getName());
        }

        # Render the view we want to display for the logged in user
        # ====================================================
        function render(){
            $this->view->render('user/index', [
                "user" => $this->user
            ]);
        }

        # To update the user budget 
        # ====================================================
        function updateBudget(){
            if(!$this->existPOST('budget')){
                $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEBUDGET]);
                return;
            }

            $budget = $this->getPost('budget');

            if(empty($budget) || $budget === 0 || $budget < 0){
                $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEBUDGET_EMPTY]);
                return;
            }
            
            # assign the budget to the user
            $this->user->setBudget($budget);
            if($this->user->update()){
                $this->redirect('user', ['success' => Success::SUCCESS_USER_UPDATEBUDGET]);
            }else{
                //error
            }
        }

        # To update the user name
        # ====================================================
        function updateName(){
            if(!$this->existPOST('name')){
                $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEBUDGET]);
                return;
            }

            $name = $this->getPost('name');

            if(empty($name)){
                $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEBUDGET]);
                return;
            }
            
            $this->user->setName($name);
            if($this->user->update()){
                $this->redirect('user', ['success' => Success::SUCCESS_USER_UPDATEBUDGET]);
            }else{
                //error
                # TODO 
            }
        }

        # To update the user password
        # ====================================================
        function updatePassword(){

            if(!$this->existPOST(['current_password', 'new_password'])){
                $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEPASSWORD]);
                return;
            }

            $current = $this->getPost('current_password');
            $new  = $this->getPost('new_password');

            if(empty($current) || empty($new)){
                $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEPASSWORD_EMPTY]);
                return;
            }

            if($current === $new){
                $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEPASSWORD_ISNOTTHESAME]);
                return;
            }

            # validate that the current password is the same as the one saved in the database
            $newHash = $this->model->comparePasswords($current, $this->user->getId());
            if($newHash != NULL){
                # if it is update with the new
                $this->user->setPassword($new, true);
                
                if($this->user->update()){
                    $this->redirect('user', ['success' => ErrorsMsg::SUCCESS_USER_UPDATEPASSWORD]);
                }else{
                    //error
                    $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEPASSWORD]);
                }
            }else{
                $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEPASSWORD]);
                return;
            }
        }

        # To update the user photo
        # ====================================================
        function updatePhoto(){
            if(!isset($_FILES['photo'])){
                $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPHOTO]);
                return;
            }
            $photo = $_FILES['photo'];

            $target_dir = "public/img/photos/";
            $extarr = explode('.',$photo["name"]);
            $filename = $extarr[sizeof($extarr)-2];
            $ext = $extarr[sizeof($extarr)-1];
            # to asociate a hash to the photo name (uuid coul be usefull too)
            $hash = md5(Date('Ymdgi') . $filename) . '.' . $ext;
            $target_file = $target_dir . $hash;
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            
            $check = getimagesize($photo["tmp_name"]);
            if($check !== false) {
                //echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                //echo "File is not an image.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                //echo "Sorry, your file was not uploaded.";
                $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEPHOTO_FORMAT]);
            // if everything is ok, try to upload file

            } else {
                if (move_uploaded_file($photo["tmp_name"], $target_file)) {
                    $this->model->updatePhoto($hash, $this->user->getId());
                    $this->redirect('user', ['success' => Success::SUCCESS_USER_UPDATEPHOTO]);
                } else {
                    $this->redirect('user', ['error' => ErrorsMsg::ERROR_USER_UPDATEPHOTO]);
                }
            }
            
        }
    }

?>
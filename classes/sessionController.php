<?php

    # This class inherits from the base controller class. This class read a file (json file) which allow how to define the permissions to give authorization to the users. This controller handles the session too. Set if a user can or not access to a controller.
    # ====================================================
    class SessionController extends Controller{
        
        private $userSession;
        private $username;
        private $userid;

        private $session;
        private $sites;

        private $user;
    
        function __construct(){
            parent::__construct();

            $this->init();
        }

        public function getUserSession(){
            return $this->userSession;
        }

        public function getUsername(){
            return $this->username;
        }

        public function getUserId(){
            return $this->userid;
        }

        # [x] 1 Initializing the parser to read the jsom file.
        # ====================================================
        private function init(){
            # Create a new session
            $this->session = new Session();
            # json file with access configuration is loaded
            $json = $this->getJSONFileConfig();
            # assign the sites
            $this->sites = $json['sites'];
            # default sites are assigned, which any role has access to
            $this->defaultSites = $json['default-sites'];
            # starts the validation flow to determine the type of role and permissions
            $this->validateSession();
        }
        
        #  [x] 2 Load the json configuration file and decode it into an object
        # ====================================================
        private function getJSONFileConfig(){
            $string = file_get_contents("config/access.json");
            $json = json_decode($string, true);

            return $json;
        }

        # Implements the authorization flow to enter the pages
        # ====================================================
        function validateSession(){
            error_log('SessionController::validateSession()');
            # If the session exists
            if($this->existsSession()){
                $role = $this->getUserSessionData()->getRole();

                error_log("sessionController::validateSession(): username:" . $this->user->getUsername() . " - role: " . $this->user->getRole());
                if($this->isPublic()){

                    $this->redirectDefaultSiteByRole($role);
                    error_log( "SessionController::validateSession() => sitio público, redirige al main de cada rol" );
                }else{
                    if($this->isAuthorized($role)){

                        error_log( "SessionController::validateSession() => autorizado, lo deja pasar" );
                        # if the user is on a page according to their permissions the flow ends
                    }else{
                        error_log( "SessionController::validateSession() => no autorizado, redirige al main de cada rol" );

                        # If the user does not have permission to be on that page, I redirect him to the home page
                        $this->redirectDefaultSiteByRole($role);
                    }
                }
            }else{
                # If the session do not exists
                # Validate if the access is public
                if($this->isPublic()){

                    error_log('SessionController::validateSession() public page');
                    # The page is public, nothing happens
                }else{
                    # The page is not public
                    # Redirect the user to the login
                    error_log('SessionController::validateSession() redirect al login');
                    header('location: '. constant('URL') . '');
                }
            }
        }
        
        #  [x] 4 validate if there is an open session 
        # ====================================================
        function existsSession(){
            if(!$this->session->exists()) return false;
            if($this->session->getCurrentUser() == NULL) return false;

            $userid = $this->session->getCurrentUser();

            if($userid) return true;

            return false;
        }

        #  [x] 7 Get the user session data and allow to create a new model from the user and use the properties from  the user model
        # ====================================================
        function getUserSessionData(){
            $id = $this->session->getCurrentUser();
            $this->user = new UserModel();
            $this->user->get($id);
            error_log("sessionController::getUserSessionData(): " . $this->user->getUsername());
            return $this->user;
        }
    
        #  [x] 5 To determine if page is public or not
        # ====================================================
        private function isPublic(){
            $currentURL = $this->getCurrentPage();
            error_log("sessionController::isPublic(): currentURL => " . $currentURL);
            $currentURL = preg_replace( "/\?.*/", "", $currentURL); //omitir get info
            for($i = 0; $i < sizeof($this->sites); $i++){
                if($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['access'] === 'public'){
                    return true;
                }
            }
            return false;
        }

        # [x] 7  To determinate to which page we redirect the user depending of his role
        # ====================================================
        private function redirectDefaultSiteByRole($role){
            $url = '';
            for($i = 0; $i < sizeof($this->sites); $i++){
                if($this->sites[$i]['role'] === $role){
                    $url = '/expenses/'.$this->sites[$i]['site'];
                break;
                }
            }
            header('location: '.$url);
            
        }

        # Validate if the user is authorized to access the page
        # ====================================================
        private function isAuthorized($role){
            $currentURL = $this->getCurrentPage();
            $currentURL = preg_replace( "/\?.*/", "", $currentURL); # avoid get info
            
            for($i = 0; $i < sizeof($this->sites); $i++){
                if($currentURL === $this->sites[$i]['site'] && $this->sites[$i]['role'] === $role){
                    return true;
                }
            }
            return false;
        }

        # [x] 6 Method to get the current page
        # ====================================================
        private function getCurrentPage(){
            
            $actual_link = trim("$_SERVER[REQUEST_URI]");
            $url = explode('/', $actual_link);
            // echo '<pre>'; print_r($url); echo '</pre>';
            // return;

            error_log("sessionController::getCurrentPage(): actualLink =>" . $actual_link . ", url => " . $url[2]);

            return $url[2];
        }

        /* ====================================================
            Scenario for when the user log in.
            User process authorization to access to a specific page otherwise redirect the user to their page or session where h should be redirected.
        ==================================================== */

        # Function to initialize the authorization
        # ====================================================
        public function initialize($user){
            error_log("sessionController::initialize(): user: " . $user->getUsername());
            $this->session->setCurrentUser($user->getId());
            $this->authorizeAccess($user->getRole());
        }

        # To the users authorization
        # ====================================================
        function authorizeAccess($role){
            error_log("sessionController::authorizeAccess(): role: $role");
            switch($role){
                case 'user':
                    $this->redirect($this->defaultSites['user']);
                break;
                case 'admin':
                    $this->redirect($this->defaultSites['admin']);
                break;
                default:
            }
        }

        # LogOut user function 
        # ======================
        function logout(){
            $this->session->closeSession();
        }
    }

?>
<?php

    # This class handdle the error message from the request. 
    # OJO: whe we make a transaction in a url we have nomaly something like this /?use=userName&last_name=lastName.
    # Wiht this error message handler we replace the translation value in the url for a hash, like 1f8f0ae8963b16403c3ec9ebb851f156 
    # Each hash corresponds to a different asigned message
    # Ej: when we make a transaction to insert a new user we will have something like this http://localhost/expenses/?success=8281e04ed52ccfc13820d0f6acb0985a

    # Note: we could meke this proccess bether with encryption (encrypt the message and send it to the viw and the view desencrypt the message etc...)
    # ====================================================
    class ErrorsMsg{
        //ERROR|SUCCESS
        //Controller
        //method
        //operation
        
        //const ERROR_ADMIN_NEWCATEGORY_EXISTS = "El nombre de la categoría ya existe, intenta otra";
        const ERROR_ADMIN_NEWCATEGORY_EXISTS        = "1f8f0ae8963b16403c3ec9ebb851f156";
        const ERROR_EXPENSES_DELETE                 = "8f48a0845b4f8704cb7e8b00d4981233";
        const ERROR_EXPENSES_NEWEXPENSE             = "8f48a0845b4f8704cb7e8b00d4981233";
        const ERROR_EXPENSES_NEWEXPENSE_EMPTY       = "a5bcd7089d83f45e17e989fbc86003ed";
        const ERROR_USER_UPDATEBUDGET               = "e99ab11bbeec9f63fb16f46133de85ec";
        const ERROR_USER_UPDATEBUDGET_EMPTY         = "807f75bf7acec5aa86993423b6841407";
        const ERROR_USER_UPDATENAME_EMPTY           = "0f0735f8603324a7bca482debdf088fa";
        const ERROR_USER_UPDATENAME                 = "98217b0c263b136bf14925994ca7a0aa";
        const ERROR_USER_UPDATEPASSWORD             = "365009a3644ef5d3cf7a229a09b4d690";
        const ERROR_USER_UPDATEPASSWORD_EMPTY       = "0f0735f8603324a7bca482debdf088fa";
        const ERROR_USER_UPDATEPASSWORD_ISNOTTHESAME = "27731b37e286a3c6429a1b8e44ef3ff6";
        const ERROR_USER_UPDATEPHOTO                 = "dfb4dc6544b0dae81ea132de667b2a5d";
        const ERROR_USER_UPDATEPHOTO_FORMAT          = "53f3554f0533aa9f20fbf46bd5328430";
        const ERROR_LOGIN_AUTHENTICATE               = "11c37cfab311fbe28652f4947a9523c4";
        const ERROR_LOGIN_AUTHENTICATE_EMPTY         = "2194ac064912be67fc164539dc435a42";
        const ERROR_LOGIN_AUTHENTICATE_DATA          = "bcbe63ed8464684af6945ad8a89f76f8";
        const ERROR_SIGNUP_NEWUSER                   = "1fdce6bbf47d6b26a9cd809ea1910222";
        const ERROR_SIGNUP_NEWUSER_EMPTY             = "a5bcd7089d83f45e17e989fbc86003ed";
        const ERROR_SIGNUP_NEWUSER_EXISTS            = "a74accfd26e06d012266810952678cf3";


        private $errorsList = [];

        # Id asociated with the error
        # ====================================================
        public function __construct()
        {
            $this->errorsList = [
                ErrorsMsg::ERROR_ADMIN_NEWCATEGORY_EXISTS => 'Category name already exists, please try another',
                ErrorsMsg::ERROR_EXPENSES_DELETE           => 'There was a problem deleting the expense, please try again',
                ErrorsMsg::ERROR_EXPENSES_NEWEXPENSE       => 'There was a problem creating the expense, please try again',
                ErrorsMsg::ERROR_EXPENSES_NEWEXPENSE_EMPTY => 'All Fields are required',
                ErrorsMsg::ERROR_USER_UPDATEBUDGET         => "Can't update budget",
                ErrorsMsg::ERROR_USER_UPDATEBUDGET_EMPTY   => 'The budget can not be empty or negative',
                ErrorsMsg::ERROR_USER_UPDATENAME_EMPTY     => 'The name cannot be empty or negative.',
                ErrorsMsg::ERROR_USER_UPDATENAME           => "Can't update name",
                ErrorsMsg::ERROR_USER_UPDATEPASSWORD       => "Can't update password",
                ErrorsMsg::ERROR_USER_UPDATEPASSWORD_EMPTY => 'The name cannot be empty or negative.',
                ErrorsMsg::ERROR_USER_UPDATEPASSWORD_ISNOTTHESAME => 'The passwords are not the same',
                ErrorsMsg::ERROR_USER_UPDATEPHOTO          => 'There was an error updating the photo',
                ErrorsMsg::ERROR_USER_UPDATEPHOTO_FORMAT   => 'The file is not an image',
                ErrorsMsg::ERROR_LOGIN_AUTHENTICATE        => 'There was a problem authenticating',
                ErrorsMsg::ERROR_LOGIN_AUTHENTICATE_EMPTY  => 'Parameters to authenticate cannot be empty',
                ErrorsMsg::ERROR_LOGIN_AUTHENTICATE_DATA   => 'Wrong username and/or password',
                ErrorsMsg::ERROR_SIGNUP_NEWUSER            => 'There was an error trying to register. Try again',
                ErrorsMsg::ERROR_SIGNUP_NEWUSER_EMPTY      => 'Fields cannot be empty',
                ErrorsMsg::ERROR_SIGNUP_NEWUSER_EXISTS     => 'Username already exists, select another',
            ];
        }

        # Function to retourn the text message from the given hash 
        # ====================================================
        function get($hash){
            error_log(" 0 '/'Classes errors::get ->: Hash Value '/'". $hash);
            return $this->errorsList[$hash];
        }
        
        # Function take a key and return if exists or not
        # ====================================================
        function existsKey($key){
            error_log(" 0 '/'Classes errors::existsKey ->: Key Value '/'". $key);

            if(array_key_exists($key, $this->errorsList)){
                return true;
            }else{
                return false;
            }
        }
    }

?>
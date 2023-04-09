<?php

    # This class handdle the success message from the request. 
    # OJO: whe we make a transaction in a url we have nomaly something like this /?use=userName&last_name=lastName.
    # Wiht this error message handler we replace the translation value in the url for a hash, like 1f8f0ae8963b16403c3ec9ebb851f156 
    # Each hash corresponds to a different asigned message
    # Ej: when we make a transaction to insert a new user we will have something like this http://localhost/expenses/?success=8281e04ed52ccfc13820d0f6acb0985a

    # Note: we could meke this proccess bether with encryption (encrypt the message and send it to the viw and the view desencrypt the message etc...)
    # ====================================================
    class Success{
        
        const SUCCESS_ADMIN_NEWCATEGORY     = "f52228665c4f14c8695b194f670b0ef1";
        const SUCCESS_EXPENSES_DELETE       = "fcd919285d5759328b143801573ec47d";
        const SUCCESS_EXPENSES_NEWEXPENSE   = "fbbd0f23184e820e1df466abe6102955";
        const SUCCESS_USER_UPDATEBUDGET     = "2ee085ac8828407f4908e4d134195e5c";
        const SUCCESS_USER_UPDATENAME       = "6fb34a5e4118fb823636ca24a1d21669";
        const SUCCESS_USER_UPDATEPASSWORD       = "6fb34a5e4118fb823636ca24a1d21669";
        const SUCCESS_USER_UPDATEPHOTO       = "edabc9e4581fee3f0056fff4685ee9a8";
        const SUCCESS_SIGNUP_NEWUSER       = "8281e04ed52ccfc13820d0f6acb0985a";
        
        private $successList = [];

        public function __construct()
        {
            $this->successList = [
                Success::SUCCESS_ADMIN_NEWCATEGORY => "New category created successfully",
                Success::SUCCESS_EXPENSES_DELETE => "Expense successfully removed",
                Success::SUCCESS_EXPENSES_NEWEXPENSE => "New expense registered successfully",
                Success::SUCCESS_USER_UPDATEBUDGET => "Budget updated successfully",
                Success::SUCCESS_USER_UPDATENAME => "Name updated successfully",
                Success::SUCCESS_USER_UPDATEPASSWORD => "Password updated successfully",
                Success::SUCCESS_USER_UPDATEPHOTO => "User image updated successfully",
                Success::SUCCESS_SIGNUP_NEWUSER => "User successfully registered"
            ];
        }

        # Function to retourn the text message from the given hash 
        # ====================================================
        function get($hash){
            error_log(" 0 '/'Classes errors::get ->: Hash Value '/'". $hash);
            return $this->successList[$hash];
        }

        # Function take a key and return if exists or not
        # ====================================================
        function existsKey($key){
            if(array_key_exists($key, $this->successList)){
                error_log(" 0 '/'Classes errors::existsKey ->: Key Value '/'". $key);
                return true;
            }else{
                return false;
            }
        }
    }
?>
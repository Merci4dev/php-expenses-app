<?php

   # Error message handler for the  application errors.
    # ====================================================
    ini_set("ignore_repeated_errors", TRUE);
    error_reporting(E_ALL);
    # display errors at the browser
    ini_set("display_errors", FALSE);
    # To create the error file on this project
    ini_set("log_errors", TRUE);
    ini_set("error_log", "/opt/lampp/htdocs/expenses/php_error.log");
    ini_set("error_log", "/opt/lampp/htdocs/expenses/php_access.log");
    error_log(" 0 '/' Index ->: App Initialization '/'");
    
    # Loading the diferent require modules for the properly funtionality of the application
    # ====================================================
    //tail -f /tmp/php-error.log
    require_once 'libs/database.php';
    require_once 'libs/messages.php';

    require_once 'libs/controller.php';
    require_once 'libs/view.php';
    require_once 'libs/model.php';
    require_once 'libs/app.php';

    require_once 'classes/session.php';
    require_once 'classes/sessionController.php';
    require_once 'classes/errors.php';
    require_once 'classes/success.php';

    require_once 'config/config.php';

    include_once 'models/usermodel.php';
    include_once 'models/expensesmodel.php';
    include_once "models/categoriesmodel.php";
    include_once "models/joinexpensescategoriesmodel.php";

    # execute the app constructor
    $app = new App();

?>
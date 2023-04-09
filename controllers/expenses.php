
<?php

    # Set the expenses class. This extend from SessionController
    # ====================================================
    class Expenses extends SessionController{

        # this storage the current user information to make the operations
        private $user;
        
        function __construct(){
            parent::__construct();
            
            # get the user session information
            $this->user = $this->getUserSessionData();
            error_log("Expenses::constructor() ");
        }
        
        # # This render the view we want to display
        # ====================================================
        function render(){
            error_log("Expenses::RENDER() ");
            
            $this->view->render('expenses/index', [
                'user' => $this->user,
                'dates' => $this->getDateList(),
                'categories' => $this->getCategoryList()
            ]);
        }
        
        # Function is properly from this controller. This validate that exist the necessary information to create a new expense
        # ====================================================
        function newExpense(){
            error_log('Expenses::newExpense()');
            if(!$this->existPOST(['title', 'amount', 'category', 'date'])){
                $this->redirect('dashboard', ['error' => Errors::ERROR_EXPENSES_NEWEXPENSE_EMPTY]);
                return;
            }
            
            if($this->user == NULL){
                $this->redirect('dashboard', ['error' => Errors::ERROR_EXPENSES_NEWEXPENSE]);
                return;
            }
            
            $expense = new ExpensesModel();
            
            # adding the category to the expense object
            $expense->setTitle($this->getPost('title'));
            $expense->setAmount((float)$this->getPost('amount'));
            $expense->setCategoryId($this->getPost('category'));
            $expense->setDate($this->getPost('date'));
            $expense->setUserId($this->user->getId());
            
            $expense->save();
            $this->redirect('dashboard', ['success' => Success::SUCCESS_EXPENSES_NEWEXPENSE]);
        }
        
        # New expense UI to insert the data to create a new expense
        # ====================================================
        function create(){
            $categories = new CategoriesModel();
            
            $this->view->render('/expenses/create', [
                "categories" => $categories->getAll(),
                "user" => $this->user
            ]);
        } 
        
        # Get all the category id expense
        # ====================================================
        function getCategoryIds(){
            $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
            $categories = $joinExpensesCategoriesModel->getAll($this->user->getId());

            $res = [];
            foreach ($categories as $cat) {
                array_push($res, $cat->getCategoryId());
            }
            $res = array_values(array_unique($res));
            return $res;
        }

        # Create a list with the months where there are expenses
        # ====================================================
        private function getDateList(){
            $months = [];
            $res = [];
            $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
            $expenses = $joinExpensesCategoriesModel->getAll($this->user->getId());
            
            foreach ($expenses as $expense) {
                array_push($months, substr($expense->getDate(),0, 7 ));
            }

            $months = array_values(array_unique($months));

            foreach ($months as $month) {
                array_push($res, $month);
            }


            //mostrar los últimos 3 meses
            // if(count($months) >3){
            //     array_push($res, array_pop($months));
            //     array_push($res, array_pop($months));
            //     array_push($res, array_pop($months));
            // }

            return $res;
        }

        // crea una lista con las categorias donde hay expenses
        # ====================================================
        private function getCategoryList(){
            $res = [];
            $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
            $expenses = $joinExpensesCategoriesModel->getAll($this->user->getId());

            foreach ($expenses as $expense) {
                array_push($res, $expense->getNameCategory());
            }
            $res = array_values(array_unique($res));

            return $res;
        }

        # Create a list with the colors depending on the categories
        # ====================================================
        private function getCategoryColorList(){
            $res = [];
            $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
            $expenses = $joinExpensesCategoriesModel->getAll($this->user->getId());

            foreach ($expenses as $expense) {
                array_push($res, $expense->getColor());
            }
            $res = array_unique($res);
            $res = array_values(array_unique($res));

            return $res;
        }

        #  Returns the JSON for AJAX calls. This controller have all information to receive the AJAX request .This is like a small api which responses to this route.
        # ====================================================
        function getHistoryJSON(){
            header('Content-Type: application/json');
            $res = [];
            $joinExpensesCategories = new JoinExpensesCategoriesModel();
            $expenses = $joinExpensesCategories->getAll($this->user->getId());

            foreach ($expenses as $expense) {
                array_push($res, $expense->toArray());
            }
            
            echo json_encode($res);

        }

        # Get the expenses json. Here we sentralize all the previous method implementation
        # ====================================================
        function getExpensesJSON(){
            header('Content-Type: application/json');

            $res = [];
            $categoryIds     = $this->getCategoryIds();
            $categoryNames  = $this->getCategoryList();
            $categoryColors = $this->getCategoryColorList();

            array_unshift($categoryNames, 'mes');
            array_unshift($categoryColors, 'categorias');
            /* array_unshift($categoryNames, 'categorias');
            array_unshift($categoryColors, NULL); */

            $months = $this->getDateList();

            for($i = 0; $i < count($months); $i++){
                $item = array($months[$i]);
                for($j = 0; $j < count($categoryIds); $j++){
                    $total = $this->getTotalByMonthAndCategory( $months[$i], $categoryIds[$j]);
                    array_push( $item, $total );
                }   
                array_push($res, $item);
            }

            array_unshift($res, $categoryNames);
            array_unshift($res, $categoryColors);
            
            echo json_encode($res);
        }

        # Handle the total category mont count
        # ====================================================
        function getTotalByMonthAndCategory($date, $categoryid){
            $iduser = $this->user->getId();
            $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();

            $total = $joinExpensesCategoriesModel->getTotalByMonthAndCategory($date, $categoryid, $iduser);
            if($total == NULL) $total = 0;
            return $total;
        }

        # Delete a category
        # ====================================================
        function delete($params){
            error_log("Expenses::delete()");
            
            if($params === NULL) $this->redirect('expenses', ['error' => Errors::ERROR_ADMIN_NEWCATEGORY_EXISTS]);
            $id = $params[0];
            error_log("Expenses::delete() id = " . $id);
            $res = $this->model->delete($id);

            if($res){
                $this->redirect('expenses', ['success' => Success::SUCCESS_EXPENSES_DELETE]);
            }else{
                $this->redirect('expenses', ['error' => Errors::ERROR_ADMIN_NEWCATEGORY_EXISTS]);
            }
        }

    }

?>
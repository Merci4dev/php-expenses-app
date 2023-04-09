
<?php

    # Tis dashboard centralize the information
    # ====================================================
    class Dashboard extends SessionController{

        private $user;

        function __construct(){
            parent::__construct();

            # Get the user asociate to the session
            $this->user = $this->getUserSessionData();
            error_log("Dashboard::constructor() ");
        }

        # Render the expenses dashboard view 
        # ====================================================
        function render(){
            error_log("Dashboard::RENDER() ");
            $expensesModel          = new ExpensesModel();
            $expenses               = $this->getExpenses(5);
            $totalThisMonth         = $expensesModel->getTotalAmountThisMonth($this->user->getId());
            $maxExpensesThisMonth   = $expensesModel->getMaxExpensesThisMonth($this->user->getId());
            $categories             = $this->getCategories();

            $this->view->render('dashboard/index', [
                'user'                 => $this->user,
                'expenses'             => $expenses,
                'totalAmountThisMonth' => $totalThisMonth,
                'maxExpensesThisMonth' => $maxExpensesThisMonth,
                'categories'           => $categories
            ]);
        }
        
        # gets the list of expenses and the number of expenses per transaction to display it on the dashboard
        # ====================================================
        private function getExpenses($n = 0){
            if($n < 0) return NULL;
            error_log("Dashboard::getExpenses() id = " . $this->user->getId());
            $expenses = new ExpensesModel();
            return $expenses->getByUserIdAndLimit($this->user->getId(), $n);   
        }

        # Bring the category expenses to show in the  
        # ====================================================
        function getCategories(){
            $res = [];
            $categoriesModel = new CategoriesModel();
            $expensesModel = new ExpensesModel();

            $categories = $categoriesModel->getAll();

            foreach ($categories as $category) {
                $categoryArray = [];
                # we obtain the sum of amount of expenses by category
                $total = $expensesModel->getTotalByCategoryThisMonth($category->getId(), $this->user->getId());
                # we obtain the number of expenses per category per month
                $numberOfExpenses = $expensesModel->getNumberOfExpensesByCategoryThisMonth($category->getId(), $this->user->getId());
                
                if($numberOfExpenses > 0){
                    $categoryArray['total'] = $total;
                    $categoryArray['count'] = $numberOfExpenses;
                    $categoryArray['category'] = $category;
                    array_push($res, $categoryArray);
                }
            }
            return $res;
        }
    }

?>
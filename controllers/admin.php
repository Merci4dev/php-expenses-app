<?php

    # Admin controller. Allow to create categories and ger a view from the application behavior 
    # ====================================================
    class Admin extends SessionController{

        function __construct(){
            parent::__construct();
        }

        # Rener the view data for the statics
        # ====================================================
        function render(){
            $stats = $this->getStatistics();

            $this->view->render('admin/index', [
                "stats" => $stats
            ]);
        }

        # Funtion to create a new category
        # ====================================================
        function createCategory(){
            $this->view->render('admin/create-category');
        }

        # Funtion to create a new category
        # ====================================================
        function newCategory(){
            error_log('Admin::newCategory()');
            if($this->existPOST(['name', 'color'])){
                $name = $this->getPost('name');
                $color = $this->getPost('color');

                $categoriesModel = new CategoriesModel();

                # Validate if exis a category with the same name
                if(!$categoriesModel->exists($name)){
                    $categoriesModel->setName($name);
                    $categoriesModel->setColor($color);
                    $categoriesModel->save();
                    error_log('Admin::newCategory() => new category created');
                    $this->redirect('admin', ['success' => Success::SUCCESS_ADMIN_NEWCATEGORY]);

                }else{
                    $this->redirect('admin', ['error' => Errors::ERROR_ADMIN_NEWCATEGORY_EXISTS]);
                }
            }
        }

        # Store multiple extras functionality to display specific point for the admin. Centralize the methods iformations. 
        # ====================================================
        private function getStatistics(){
            $res = [];

            $userModel = new UserModel();
            $users = $userModel->getAll();
            
            $expenseModel = new ExpensesModel();
            $expenses = $expenseModel->getAll();

            $categoriesModel = new CategoriesModel();
            $categories = $categoriesModel->getAll();

            $res['count-users'] = count($users);
            $res['count-expenses'] = count($expenses);
            $res['max-expenses'] = $this->getMaxAmount($expenses);
            $res['min-expenses'] = $this->getMinAmount($expenses);
            $res['avg-expenses'] = $this->getAverageAmount($expenses);
            $res['count-categories'] = count($categories);
            $res['mostused-category'] = $this->getCategoryMostUsed($expenses);
            $res['lessused-category'] = $this->getCategoryLessUsed($expenses);
            return $res;
        }

        # Functions to get the max statistics amount
        # ====================================================
        private function getMaxAmount($expenses){
            $max = 0;
            foreach ($expenses as $expense) {
                $max = max($max, $expense->getAmount());
            }

            return $max;
        }

        # Functions to get the min statistics amount
        # ====================================================
        private function getMinAmount($expenses){
            $min = $this->getMaxAmount($expenses);

            foreach ($expenses as $expense) {
                $min = min($min, $expense->getAmount());
            }

            return $min;
        }

        # Functions to get average statistics amount
        # ====================================================
        private function getAverageAmount($expenses){
            $sum = 0;
            foreach ($expenses as $expense) {
                $sum += $expense->getAmount();
            }

            return ($sum / count($expenses));
        }

        # Functions to get the most used categories
        # ====================================================
        private function getCategoryMostUsed($expenses){
            $repeat = [];

            foreach ($expenses as $expense) {
                if(!array_key_exists($expense->getCategoryId(), $repeat)){
                    $repeat[$expense->getCategoryId()] = 0;    
                }
                $repeat[$expense->getCategoryId()]++;
            }

            // $categoryMostUsed = max($repeat);
            $categoryMostUsed = 0;
            $maxCategory = max($repeat);
            foreach ($repeat as $index => $category) {
                if($category == $maxCategory){
                    $categoryMostUsed = $index;
                }
            }

            $categoryModel = new CategoriesModel();
            $categoryModel->get($categoryMostUsed);

            $category = $categoryModel->getName();

            return $category;
        }

        # Functions to get the less used categories
        # ====================================================
        private function getCategoryLessUsed($expenses){
            $repeat = [];

            foreach ($expenses as $expense) {
                if(!array_key_exists($expense->getCategoryId(), $repeat)){
                    $repeat[$expense->getCategoryId()] = 0;    
                }
                $repeat[$expense->getCategoryId()]++;
            }

            // $categoryMostUsed = min($repeat);
            $categoryMostUsed = 0;
            $maxCategory = min($repeat);
            foreach ($repeat as $index => $category) {
                if($category == $maxCategory){
                    $categoryMostUsed = $index;
                }
            }
            $categoryModel = new CategoriesModel();
            $categoryModel->get($categoryMostUsed);

            $category = $categoryModel->getName();

            return $category;
        }
    }

?>
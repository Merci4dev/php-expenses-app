# Expenses PHP MVC App  V_0.1.
    This application is for expense control. In this you can define a budget and from there you can record the expenses that are made month by month. You can see a graph of the different expenses that have been made.
    1 The user can define a budget and from there be able to record the expenses that month by month.
    2 See the expenses separated by category
    3 See a graph of expenses.
    4 Valance general de cuanto se ha gastado este mes.
    5 See the remaining budget
    6 View the largest expense of the month.
    7 See previous expenses
    8 See all the expenses made over time made in the account
    9 Customize the budget
    10 Customize the user profile


# Application Structure
    - MVC Design Pattern
    - Queries with MySQL
    - User authentication and registration
    - Role Authorization
    - Graphics Integration
    - Session Usage

# Project installation
    The first thing is to clone the project to your local computer

    ```git clone https://github.com/marcosrivasr/expense-app.git```

# Importar base de datos
    Create the database schema.

    1. Let's login to our MySQL console (replace username with the username of your connection)

    2. We create a new database called **expenses**
        DROP DATABASE IF  EXISTS `expenses`;
        CREATE DATABASE IF NOT EXISTS `expenses`;
        USE `expenses`;

    3. import the `expense.sql` file Into the db


# Configuración de proyecto
   To update the connections to the database it is important to change the data found in `/config/config.php`

    Additionally in `public/js/dashboard.js` it is necessary to verify that the URLs used to make asynchronous requests are also pointing correctly according to your server.

    async function getContent(){
    const html = await fetch('http://localhost:8080/expense-app/expenses/create').then(res => res.text());
    return html;
    }

    async function drawChart() {
            const http = await fetch('http://localhost:8080/expense-app/expenses/getExpensesJSON')
            .then(json => json.json())
            .then(res => res);
    ```
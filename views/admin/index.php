<!-- Render the admin dasboard -->
<!-- ==================================================== -->
<?php
    $stats = $this->d['stats'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <?php require 'header.php'; ?>

    <div id="main-container">
        <?php
            $this->showMessages();
         ?>
        <div id="dashboard-container" class="container">
            <div id="left-container">
                <div id="panels-container">
                    <div class="panel">
                        <div class="title">USER</div>
                        <div class="datum"><?php echo $stats['count-users']; ?></div>
                        <div class="description">Registered users</div>
                    </div>
                    <div class="panel">
                        <div class="title">Spenses</div>
                        <div class="datum"><?php echo $stats['count-expenses']; ?></div>
                        <div class="description">Transactions</div>
                    </div>
                    <div class="panel">
                        <div class="title">Spenses</div>
                        <div class="datum">$<?php echo number_format($stats['max-expenses'], 2); ?></div>
                        <div class="description">Max Spenses</div>
                    </div>
                    <div class="panel">
                        <div class="title">Spenses</div>
                        <div class="datum">$<?php echo number_format($stats['avg-expenses'], 2); ?></div>
                        <div class="description">Average Spending</div>
                    </div>
                    <div class="panel">
                        <div class="title">Spenses</div>
                        <div class="datum">$<?php echo number_format($stats['min-expenses'], 2); ?></div>
                        <div class="description">Min Spenses</div>
                    </div>
                    <div class="panel">
                        <div class="title">Categoríes</div>
                        <div class="datum"><?php echo $stats['count-categories']; ?></div>
                        <div class="description">Created Categories</div>
                    </div>
                    <div class="panel">
                        <div class="title">Categoríes</div>
                        <div class="datum"><?php echo $stats['mostused-category']; ?></div>
                        <div class="description">Mosr used Categories</div>
                    </div>
                    <div class="panel">
                        <div class="title">Categoríes</div>
                        <div class="datum"><?php echo $stats['lessused-category']; ?></div>
                        <div class="description">Lesss used Categorias</div>
                    </div>
                </div>
            </div>
            <div id="right-container">
                <div class="transactions-container">
                    <section class="operations-container">
                        <h2>Operations</h2>  
                        
                        <button class="btn-main" id="new-category">
                            <i class="material-icons">add</i>
                            <span>Register new Category</span>
                        </button>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script src="public/js/admin.js"></script>
</body>
</html>
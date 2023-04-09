<!-- Display the User update page  -->
<!-- ==================================================== -->
<?php
    $user = $this->d['user'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense App - Dashboard</title>
    <link rel="stylesheet" href="<?php echo constant('URL') ?>public/css/user.css">
</head>
<body>
    <?php require_once 'views/dashboard/header.php'; ?>

    <div id="main-container">
        <!-- display the message  -->
        <?php $this->showMessages();?>

        <div id="user-container" class="container">
            <div id="user-header">
                <div id="user-info-container">
                    <div id="user-photo">
                        
                    <?php if($user->getPhoto() != ''){?>
                        <img src="public/img/photos/<?php echo $user->getPhoto(); ?>" width="200" />
                    <?php }
                    ?>
                    </div>
                    <div id="user-info">
                        <h2><?php echo ($user->getName() != '')? $user->getName(): $user->getUsername(); ?></h2>
                    </div>
                </div>
            </div>
            <div id="side-menu">
                <ul>
                    <li><a href="#info-user-container">Customize User</a></li>
                    <li><a href="#password-user-container">Update Password</a></li>
                    <li><a href="#budget-user-container">Update Budget</a></li>
                </ul>
            </div>

            <div id="user-section-container">
                <!-- Form to customize the user information -->
                <!-- ==================================================== -->
                <section id="info-user-container">
                    <form action=<?php echo constant('URL'). 'user/updateName' ?> method="POST">
                        <div class="section">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" autocomplete="off" required value="<?php echo $user->getName() ?>">
                            <div><input type="submit" value="Change Name" /></div>
                        </div>
                    </form>

                    <form action="<?php echo constant('URL'). 'user/updatePhoto' ?>" method="POST" enctype="multipart/form-data">
                        <div class="section">
                            <label for="photo">Profile User</label>
                            
                            <?php
                                if(!empty($user->getPhoto())){
                            ?>
                                <img src="<?php echo constant('URL') ?>public/img/photos/<?php echo $user->getPhoto() ?>" width="50" height="50" />
                            <?php
                                }
                            ?>
                            <input type="file" name="photo" id="photo" autocomplete="off" required>
                            <div><input type="submit" value="Change Profile User" /></div>
                        </div>
                    </form>
                </section>
                
                <!-- Form to customize the user password -->
                <!-- ==================================================== -->
                <section id="password-user-container">
                    <form action="<?php echo constant('URL'). 'user/updatePassword' ?>" method="POST">
                        <div class="section">
                            <label for="current_password">Actual Password</label>
                            <input type="password" name="current_password" id="current_password" autocomplete="off" required>

                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" id="new_password" autocomplete="off" required>
                            <div><input type="submit" value="Change Password" /></div>
                        </div>
                    </form>
                </section>
                
                <!-- Form to customize the budget -->
                <!-- ==================================================== -->
                <section id="budget-user-container">
                    <form action="user/updateBudget" method="POST">
                        <div class="section">
                            <label for="budget">Define Budget</label>
                            <div><input type="number" name="budget" id="budget" autocomplete="off" required value="<?php echo $user->getBudget() ?>"></div>
                            <div><input type="submit" value="Update Budget" /></div>
                        </div>
                    </form>
                </section>

            </div>
        </div>
        
    </div>

    <script>
        
        const url = location.href;
        const indexAnchor = url.indexOf('#');

        closeSections();

        if(indexAnchor > 0){
            const anchor = url.substring(indexAnchor);
            document.querySelector(anchor).style.display = 'block';

            document.querySelectorAll('#side-menu a').forEach(item =>{
                if(item.getAttribute('href') === anchor){
                    item.classList.add('option-active');
                }
            });
        }else{
            document.querySelector('#info-user-container').style.display = 'block';
            document.querySelectorAll('#side-menu a')[0].classList.add('option-active');
        }

        document.querySelectorAll('#side-menu a').forEach(item =>{
            item.addEventListener('click', e =>{
                closeSections();
                const anchor = e.target.getAttribute('href');
                document.querySelector(anchor).style.display = 'block';
                //e.target.setAttribute('class', 'option-active');
                e.target.classList.add('option-active');
            });
        });

        function closeSections(){
            const sections = document.querySelectorAll('section');
            sections.forEach(item =>{
                item.style.display="none";
            });
            document.querySelectorAll('.option-active').forEach(item =>{
                item.classList.remove('option-active');
            });
        }
        
    </script>
</body>
</html>
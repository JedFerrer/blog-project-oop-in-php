<!DOCTYPE html>
<html>
    <head>
        <title>JEDIDIAH Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
        <link href="js/bootstrap.min.js" rel="stylesheet" media="screen">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!--[if IE]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Main Stylesheet File -->
        <link href="css/style.css" rel="stylesheet" media="screen">

        <!-- Import Google Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,500' rel='stylesheet' type='text/css'>
    </head>

    <body>
        <div class="structure-container">
   
        <div class="header-container">
            <div class="main-content-centered">
                
                <div class="logo-container">
                    <h1>Jedidiah L. Ferrer  <small>Web Developer</small></h1>
                    <h5>Loves to write code using the following: #HTML #CSS #JS #JQUERY #PHP</h5>
                </div>
                <div class="link-top-container">
                <?php 
                $user = new User();
                if($user->isLoggedIn()) {
                ?>
                    <p>Hello <a href="#"><?php echo escape($user->data()->author_name); ?></a>!</p>
                    <p><a href="logout.php">Log out</a></li></p>
                    
                <?php
                } else {
                    echo '<p>You need to <a href="login.php">Log In</a> or <a href="register.php">Register</a></p>';
                }
                ?>
                </div>
                <div class="clear"></div>

            </div>
        </div>

      
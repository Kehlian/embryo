<?php

    // First we execute our common code to connection to the database and start the session
//    require("common.php");
    
    // At the top of the page we check to see whether the user is logged in or not
    if(empty($_SESSION['user']))
    {
        // If they are not, we redirect them to the login page.
//        header("Location: login.php");
        
        // Remember that this die statement is absolutely critical.  Without it, people can view your members-only content without logging in.
//        die("Redirecting to login.php");
    }
    
    // Everything below this point in the file is secured by the login system.
?>
<html>
<head>
        <title>Posts | EMBRYO</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="_style/normalize.css" />
        <link rel="stylesheet" href="_style/style.css" />
		
		<meta property="og:site_name" content="Cl�ment Schmouker, web developper" />
		<meta property="fb:admins" content="10205717113545595" />
		<meta property="og:type" content="website" />
		<meta property="og:image" content="_img/logo.png" />
		<meta property="og:url" content="http://clementschmouker.be" />
		<meta property="og:title" content="Cl�ment Schmouker - Web Developper" />
		<meta property="og:description" content="Clement Schmouker shows his dev skills" />
        
        <link rel="shortcut icon" href="_img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="_img/favicon.ico" type="image/x-icon">
	
	
	
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
        <!-- Font Insertion -->
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>
</head>
<body>
        <!-- inspiration : Exercice fait avec Christian Delfosse, merci !
             R�alis� par Cl�ment SCHMOUKER -->
        <!-- Navigation -->
        <nav>
			<ul class="mainNav">
				<li><a class="navElement logo" href="index.php">Embryo</a></li>
				<li class="navElement empty"></li>
				<li><a class="navElement navLink" href="index.php">Accueil</a></li>
				<li><a href="private.php" class="navElement navLink onPage">Posts</a></li>
				<li>
					<a href="edit_account.php" class="navElement navLink">
						<?php 
					if(empty($_SESSION['user']))
					{
							echo"Login";
						}
					else
					{
						echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); //protect script injection via name
					} 
				?>
					</a>
				</li>
				<?php                 
                        if(empty($_SESSION['user']))
                        {
                                echo" ";
                            
                            }   
                        else
                        {
							if ($_SESSION['user']['admin'] == 1) {
                            echo"<li><a href='admin.php' class='navElement navLink'>Admin</a></li>";
                        }  
                            echo"<li><a href='logout.php' class='navElement navLink'>Logout</a></li>";
                        }
                    ?>
			</ul>
		</nav>
		<!-- Main Content -->
		<main>
			<h1>Ce que l'on dit...</h1>
            <a href="post.php" class="button button--onWhite">Poster un message</a>
			<?php
			include("get.php");
			?>
			<a href="post.php" class="button button--onWhite">Poster un message</a>
		</main>
        <!-- JQuery / JS Insertion -->
<!--
<script src="_js/jquery-1.11.2.min.js"></script>
<script src="_js/main.js"></script>-->
    </body>
</html>
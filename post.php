<?php

    // First we execute our common code to connection to the database and start the session
    require("common.php");
    
    // At the top of the page we check to see whether the user is logged in or not
    if(empty($_SESSION['user']))
    {
        // If they are not, we redirect them to the login page.
        header("Location: login.php");
        
        // Remember that this die statement is absolutely critical.  Without it,
        // people can view your members-only content without logging in.
        die("Redirecting to login.php");
    }
    
    // Everything below this point in the file is secured by the login system
    
    // We can display the user's username to them by reading it from the session array.  Remember that because
    // a username is user submitted content we must use htmlentities on it before displaying it to the user.
?>
	<!DOCTYPE html>
	<html lang="fr">

	<head>
		<title>Nouveau Post | EMBRYO</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="_style/style.css" />

		<meta property="og:site_name" content="Clément Schmouker, web developper" />
		<meta property="fb:admins" content="10205717113545595" />
		<meta property="og:type" content="website" />
		<meta property="og:image" content="_img/logo.png" />
		<meta property="og:url" content="http://clementschmouker.be" />
		<meta property="og:title" content="Clément Schmouker - Web Developper" />
		<meta property="og:description" content="Clement Schmouker shows his dev skills" />

		<link rel="shortcut icon" href="_img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="_img/favicon.ico" type="image/x-icon">



		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, minimal-ui">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	</head>

	<body>
		<!-- Navigation -->
		<nav>
			<ul>
				<li><a class="nav__element nav__element--logo" href="index.php">Embryo</a></li>
				<li class="nav__element nav__element--empty"></li>
				<li><a class="nav__element nav__element--link" href="index.php">Accueil</a></li>
				<li><a href="private.php" class="nav__element nav__element--link">Posts</a></li>
				<li>
					<a href="edit_account.php" class="nav__element nav__element--link">
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
                            echo"<li><a href='admin.php' class='nav__element nav__element--link'>Admin</a></li>";
                        	}  
                        	echo"<li><a href='logout.php' class='nav__element nav__element--link'>Logout</a></li>";
                        }
                    ?>
			</ul>
		</nav>
		<!-- Main Content -->
		<main>
			<form action="sendNeeds.php" method="POST">
				<h1>Dis nous tout...</h1>
				<fieldset>
					<label for="class_name">Cours</label>
					<input type="text" name="class_name" id="class_name" maxlength="50" required placeholder="Intitulé du cours">
				</fieldset>

				<fieldset>
					<label for="exercice">Explication
						<br/><small>max. 500 caractères</small> </label>
					<textarea name="exercice" class="explication" id="exercice" maxlength="500" required placeholder="Explique nous ton problème"></textarea>
				</fieldset>

				<input type="submit" id="sendButton" class="button button--input" value="Envoyer">
				<div class="cf"></div>
			</form>
			<a href="index.php" class="link--underForm link--underForm--left">Retour à l'accueil</a>
		</main>
		<!-- Footer -->
		<footer class="footerForceBottom">
			<p>Réalisé par Clément Schmouker et Robin Devouge</p>
		</footer>

		<!-- JQuery / JS Insertion -->
<!--
		<script src="_js/jquery-1.11.2.min.js"></script>
		<script src="_js/main.js"></script>
-->
	</body>

	</html>
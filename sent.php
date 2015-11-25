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
		<title>Groupe Database Form</title>
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

		<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="user-scalable=no, initial-scale=1.0, minimal-ui">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	</head>

	<body>

		<div class="sorry">
			<p>Désolé ! Cette application ne tourne pas encore sur smartphone :(</p>
		</div>
		<!-- Navigation -->
		<nav>
			<ul>
				<li>
					<a class="logo" href="index.php"><img src="_img/logo.svg" alt="logo" />
						<p>Embryo</p>
					</a>
				</li>
				<?php
                        if ($_SESSION['user']['admin'] == 1) {
                            echo"<li><a href='admin.php'>Admin</a></li>";
                        }  
                        if(empty($_SESSION['user']))
                        {
                                echo" ";
                            
                            }
                        else
                        {
                            echo"<li><a href='logout.php'>Logout</a></li>";
                        } 
                    ?>
					<li>
						<a href="edit_account.php">
							<?php 
                        if(empty($_SESSION['user']))
                        {
                                echo"Log in";
                            }
                        else
                        {
                            echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8');
                        } 
                    ?>
						</a>
					</li>
					<li><a href="index.php">Accueil</a></li>
					<li><a href="private.php">Posts</a></li>
			</ul>
		</nav>
		<div class="mainContent__Sent">
			<h1>Envoyé avec succès</h1>
			<a id="send_click" href="private.php">
				<p style="text-align:center">Vous allez être redirigé</p>
				<img class="checkMark" src="_img/checked.svg" alt="checked" />
			</a>
		</div>


		<script>
			setTimeout(function () {
				document.getElementById("send_click").click();
			}, 3000)
		</script>
	</body>

	</html>
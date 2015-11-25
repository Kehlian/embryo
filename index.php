<!DOCTYPE html>

<?php
    // First we execute our common code to connection to the database and start the session
//    require("common.php");
?>
	<html>

	<head>
		<title>EMBRYO</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="_style/style.css" />

		<meta property="og:site_name" content="Embryo" />
		<meta property="fb:admins" content="10205717113545595" />
		<meta property="og:type" content="website" />
		<meta property="og:image" content="_img/logo.png" />
		<meta property="og:url" content="http://clementschmouker.be" />
		<meta property="og:title" content="Embryo" />
		<meta property="og:description" content="Developpons-nous ensemble" />

		<link rel="shortcut icon" href="_img/favicon.ico" type="image/x-icon">
		<link rel="icon" href="_img/favicon.ico" type="image/x-icon">



		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	</head>

	<body>
		<!-- Navigation -->
		<nav>
	<ul>
		<li><a class="nav__element nav__element--logo" href="index.php">Embryo</a></li>
		<li class="nav__element nav__element--empty"></li>
		<li><a class="nav__element nav__element--link onPage" href="index.php">Accueil</a></li>
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
		<!-- Header -->
		<header class="header">
			<div class="container">
				<h1 class="header__title">Embryo</h1>
				<h2 class="header__sub">Développons-nous ensemble</h2>
				<ul class="header__schedule">
					<li>Prochain atelier :</li>
					<li>Mardi 17/10</li>
					<li>8h40 - 9h40</li>
					<li><a href="#" class="presenceValidation">Je viens</a></li>
				</ul>
				<ul class="header__buttons">
					<li><a href="https://www.dropbox.com/sh/lvzqi7jit7i40iy/AACpwZ2Pz1VJxyP1y9vfxSYra?dl=0" class="button button--light">Dossier Dropbox</a></li>
					<li><a href="post.php" class="button button--light">Poster un message</a></li>
				</ul>

			</div>
		</header>
		<!-- Main Content -->
		<main class="mainContent">
			<?php 
//				include("news.php"); 
			?>
				<div class="post">
					<h3 class="post__title">Bienvenue</h3>
					<small class="post__date">21/10/2015</small>
					<p class="post__content">Salit salut ! Bienvenue sur Embryo. Nous allons Planifier ensembles notre première session.</p>

					<p class="post__content">Premièrement, il va vous faloir vous inscrire sur le site. Vous pouvez prendre n'importe quel pseudo, mais ce sera plus facile si vous utilisez votre vrai nom. Pour ma part j'utilise mon prénom suivit de la première lettre de mon nom de famille et d'un point: "Clément S." Ensuite, postez les soucis que vous avez rencontré. N'ayez pas peur des doublons, ils nous aident justement à définir ce qui doit être vu en priorité. Les posts sont anonymes pour faciliter l'ouverture. Ni moi, ni Robin n'avons de trace de qui à posté quoi. Vous pouvez donc tout dire sans tabou, je compte sur vous pour ne pas faire n'importe quoi. La création de compte sera utile pour des fonctionnalités futures de l'application que vous nous aiderez sûrement à réaliser :)</p>

					<p class="post__content">La première session aura donc lieu le vendredi 30 octobre, au soir. D'ici là, nous communiquerons avec vous via slack. N'hésitez pas à contacter Robin ou moi-même si vous avez des questions.</p>

					<p class="post__content">A bientôt !</p>

					<small class="post__signature">Clément S.</small>

				</div>
		</main>
		<!-- Footer -->
		<footer>
			<p>Réalisé par Clément Schmouker et Robin Devouge</p>
		</footer>

		<!-- Script Insertion -->
<!--
		<script src="_js/jquery-1.11.2.min.js"></script>
		<script src="_js/main.js"></script>
-->

	</body>

	</html>
<!DOCTYPE html>

<?php
    // First we execute our common code to connection to the database and start the session
    require("common.php");
?>
<html>
    <head>
        <title>Embryo</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="_style/normalize.css" />
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
		
        <!-- Font Insertion -->
        <link href='http://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <!-- Navigation -->
        <nav>
            <ul>
                <li><a class="logo" href="index.php"><img src="_img/logo.svg" alt="logo" /><p>Embryo</p></a></li>
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
                <li><a href="edit_account.php">
                    <?php 
                        if(empty($_SESSION['user']))
                        {
                                echo"Log in / S'enregistrer";
                            }
                        else
                        {
                            echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); //protect script injection via name
                        } 
                    ?>
                    </a>
                </li>
                <li><a class="onPage" href="index.php">Accueil</a></li>
                <li><a href="private.php">Posts</a></li>
            </ul>
        </nav>
        <!-- Header -->
        <header id="header">
            <h1>Embryo</h1>
            <p>Développons-nous ensemble</p>
            <a href="post.php" class="postButton">
                <img src="_img/message31.svg" alt="message" />
                <p>Poster un message</p>
            </a>
        </header>
        <!-- Main Content -->
        <div id ="main" class="mainContent">
            <?php
                  include("news.php");  
            ?>
            <div class="newsPost">
                <p class="newsDate">Posté le: 21/10/2015 - 15:22</p>
                <h1 class="newsTitle">Bienvenue</h1>
                <p class="newsContent">
                    Salit salut ! Bienvenue sur Embryo. Nous allons Planifier ensembles notre première session.
                    </p><p class="newsContent">
                     Premièrement, il va vous faloir vous inscrire sur le site. Vous pouvez prendre n'importe quel pseudo, mais ce sera plus facile si vous utilisez votre vrai nom. Pour ma part j'utilise mon prénom suivit de la première lettre de mon nom de famille et d'un point: "Clément S."
                     Ensuite, postez les soucis que vous avez rencontré. N'ayez pas peur des doublons, ils nous aident justement à définir ce qui doit être vu en priorité. Les posts sont anonymes pour faciliter l'ouverture. Ni moi, ni Robin n'avons de trace de qui à posté quoi. Vous pouvez donc tout dire sans tabou, je compte sur vous pour ne pas faire n'importe quoi.
                     La création de compte sera utile pour des fonctionnalités futures de l'application que vous nous aiderez sûrement à réaliser :)
                    </p><p class="newsContent">
                     La première session aura donc lieu le vendredi 30 octobre, au soir. D'ici là, nous communiquerons avec vous via slack. N'hésitez pas à contacter Robin ou moi-même si vous avez des questions.
                    </p><p class="newsContent">A bientôt !
                </p>
                <p class="newsSignature">Clément S.</p>
                <div class="newsFooter">

                </div>
            </div>

        </div>
        <!-- Footer -->
        <footer>
            <p>Réalisé par Clément Schmouker</p>
        </footer>

        <!-- Script Insertion -->
        <script src="_js/jquery-1.11.2.min.js"></script>
        <script src="_js/main.js"></script>
    
    </body>
</html>
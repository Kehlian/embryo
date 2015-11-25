<head>
	<title>Admin | EMBRYO</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="_style/style.css" />

	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<link rel="shortcut icon" href="_img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="_img/favicon.ico" type="image/x-icon">

</head>

<body>
	<?php


    require("common.php");


    if(empty($_SESSION['user']))
    {

        header("Location: login.php");

        die("Redirecting to login.php");
    }
    if($_SESSION['user']['admin'] == 0) {
        echo " <p class='triche'>Vil petit tricheur, tu n'as pas accès à cette section !</p> ";
        echo "<style>nav, header, .mainContent__Post {display:none;}
                     .triche {text-align:center;padding-top:200px;}
                     a {text-align:center; margin:0 auto;display:block}
              </style>";
    }

    $query = "
        SELECT
            id,
            username,
            email
        FROM users
    ";
    
    try
    {

        $stmt = $db->prepare($query);
        $stmt->execute();
    }
    catch(PDOException $ex)
    {

        die("Failed to run query: " . $ex->getMessage());
    }
        

    $rows = $stmt->fetchAll();
?>

		<!-- Navigation -->
		<nav>
			<ul>
				<li><a class="nav__element nav__element--logo" href="index.php">Embryo</a></li>
				<li class="nav__element nav__element--empty"></li>
				<li><a class="nav__element nav__element--link " href="index.php">Accueil</a></li>
				<li><a href="private.php" class="nav__element nav__element--link">Posts</a></li>
				<li>
					<a href="edit_account.php" class="nav__element nav__element--link ">
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
                            echo"<li><a href='admin.php' class='nav__element nav__element--link onPage'>Admin</a></li>";
                        	}  
                        	echo"<li><a href='logout.php' class='nav__element nav__element--link'>Logout</a></li>";
                        }
                    ?>
			</ul>
		</nav>

		<main>
			<h1>Memberlist</h1>
			<table>
				<tr>
					<th>ID</th>
					<th>Username</th>
					<th>E-Mail Address</th>
				</tr>
				<?php foreach($rows as $row): ?>
					<tr>
						<td>
							<?php echo $row['id']; ?>
						</td>
						<!-- htmlentities is not needed here because $row['id'] is always an integer -->
						<td>
							<?php echo htmlentities($row['username'], ENT_QUOTES, 'UTF-8'); ?>
						</td>
						<td>
							<?php echo htmlentities($row['email'], ENT_QUOTES, 'UTF-8'); ?>
						</td>
					</tr>
					<?php endforeach; ?>
			</table>

			<div class="post">
				<h1>Poster une news</h1>
				<form id="news" action="sendnews.php" method="POST">
					<fieldset>
						<label for="title">Titre: </label>
						<input type="text" name="title" id="title" maxlength="50" required placeholder="Titre de la news">
					</fieldset>

					<fieldset>
						<label for="content">Contenu de la news: </label>
						<textarea name="content" id="content" maxlength="2000" required placeholder="Quoi de neuf ? (2000 caract. max)"></textarea>
					</fieldset>

					<input type="submit" id="sendButton" class="button button--input" value="Envoyer">
					<div class="cf"></div>
				</form>
				<a href="index.php" class="link--underForm link--underForm--left">Accueil</a>
				<div class="cf"></div>
			</div>
		</main>
		<footer>
			<p>Réalisé par Clément Schmouker et Robin Devouge</p>
		</footer>

		<!-- JQuery / JS Insertion -->
		<!--
		<script src="_js/jquery-1.11.2.min.js"></script>
		<script src="_js/main.js"></script>
-->

</body>
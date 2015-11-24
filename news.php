<!DOCTYPE html>

<html>

	<head>
		<title>Posts - Embryo</title>
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

		<nav>
			<ul class="mainNav">
				<li><a class="navElement logo" href="index.php">Embryo</a></li>
				<li class="navElement empty"></li>
				<li><a class="navElement navLink" href="index.php">Accueil</a></li>
				<li><a href="private.php" class="navElement navLink onPage">Posts</a></li>
				<?php              

							if ($_SESSION['user']['admin'] == 1) {
								echo"<li><a href='admin.php' class='navElement navLink'>Admin</a></li>";
							}        
							if(empty($_SESSION['user']))
							{
									echo" ";

								}
							else
							{
								echo"<li><a href='logout.php' class='navElement navLink'>Logout</a></li>";
							} 
						?>
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
			</ul>
		</nav>

		<?php

		header ('Content-type: text/html; charset=utf-8');

	   $servername = "clementsjwdata.mysql.db";
	   $username = "clementsjwdata";
	   $password = file_get_contents("../password.txt");

	   // Create connection
	   $conn = new PDO("mysql:host=$servername;dbname=clementsjwdata;charset=utf8", $username, $password);
	   // Check connection
	   if ($conn->connect_error) {
	   die("Connection failed: " . $conn->connect_error);
	   }

	   $sql = "SELECT * FROM News ORDER BY id DESC";
	   $result = $conn->query($sql);

	   //if ($result->num_rows > 0) { /!\ variable num_rows for $result does not exist for PDO queries
			   // output data of each row
		   while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		   echo "
		   <div class='post'>
			   <h3 class='postTitle'>".$row["title"]."</h3>
			   <small class='postDate'>Posté le: ".$row["date"]."</small>
			   <p class='postContent'>".$row["content"]."</p>
			   <small class='postSignature'>".$row["signature"]."</small>
		  </div>
	";
		   };


	?>
		<footer>
			<p>Réalisé par Clément Schmouker et Robin Devouge</p>
		</footer>
	</body>

</html>